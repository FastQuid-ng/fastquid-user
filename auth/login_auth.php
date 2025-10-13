<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../utils/mailer.php'; // sendMail($to, $subject, $html)

// Utility: Get IP, device, and rough location
function getClientInfo() {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown IP';
    $device = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown Device';
    $location = 'Unknown Location';

    try {
        $json = @file_get_contents("https://ipapi.co/{$ip}/json/");
        if ($json) {
            $data = json_decode($json, true);
            if (!empty($data['city']) && !empty($data['country_name'])) {
                $location = "{$data['city']}, {$data['country_name']}";
            }
        }
    } catch (Exception $e) {
        // fail silently
    }

    return [
        'ip' => $ip,
        'device' => $device,
        'location' => $location,
    ];
}

// Helper: log every attempt
function logAttempt($pdo, $email, $user_id, $ip, $device, $location, $status) {
    $stmt = $pdo->prepare("
        INSERT INTO login_logs (email, user_id, ip_address, device_info, location, status)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$email, $user_id, $ip, $device, $location, $status]);
}

try {
    // Only allow POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(["success" => false, "message" => "Invalid request method."]);
        exit;
    }

    // Input validation
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        echo json_encode(["success" => false, "message" => "Email and password are required."]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "Invalid email address."]);
        exit;
    }

    // Fetch user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $info = getClientInfo();
    $ip = htmlspecialchars($info['ip']);
    $device = htmlspecialchars($info['device']);
    $location = htmlspecialchars($info['location']);
    $time = date('l, jS F Y \a\t g:i A');

    // Invalid user
    if (!$user) {
        logAttempt($pdo, $email, null, $ip, $device, $location, 'failed');
        echo json_encode(["success" => false, "message" => "No account found with that email."]);
        exit;
    }

    // Wrong password
    if (!password_verify($password, $user['password'])) {
        logAttempt($pdo, $email, $user['id'], $ip, $device, $location, 'failed');
        echo json_encode(["success" => false, "message" => "Incorrect password."]);
        exit;
    }

    // Inactive or unverified
    if ((int)$user['is_verified'] === 0) {
        $_SESSION['pending_email'] = $user['email'];
        logAttempt($pdo, $email, $user['id'], $ip, $device, $location, 'failed');
        echo json_encode([
            "success" => false,
            "redirect" => "verify-account",
            "message" => "Please verify your account before logging in."
        ]);
        exit;
    }

    // Check incomplete KYC
    $kycFields = ['date_of_birth', 'gender', 'state', 'lga', 'residential_address', 'picture'];
    $missingKYC = false;
    foreach ($kycFields as $field) {
        if (empty($user[$field])) {
            $missingKYC = true;
            break;
        }
    }

    // Create session
    $_SESSION['user_id']    = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_name']  = $user['first_name'] . ' ' . $user['last_name'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['last_name']  = $user['last_name'];
    $_SESSION['user_phone'] = $user['phone'];
    $_SESSION['avatar'] = $user['picture'];

    // Log successful login
    logAttempt($pdo, $email, $user['id'], $ip, $device, $location, 'success');

    // Build retained HTML email template
    $subject = "Login Notification";
    $message = "
    <table class='email-wraper' style='width:100%;background:#f5f6fa;font-family:Arial,sans-serif;padding:20px;'>
        <tbody>
            <tr>
                <td>
                    <table class='email-body' style='margin:0 auto;max-width:600px;background:#fff;'>
                        <tbody>
                            <tr>
                                <td style='text-align:center;padding-top:30px;'>
                                    <a href='https://my.fastquid.ng'>
                                        <img src='https://i.imgur.com/fy55xbW.png' alt='FastQuid' width='200'>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding:40px 30px 20px 30px;font-size:14px;color:#666;'>
                                    <p>Hi {$user['first_name']},</p>
                                    <p>This is to notify that we noticed you have just logged in to your FastQuid account. Here are the login details:</p>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding:0 30px 30px 30px;'>
                                    <p>Time: <b>{$time}</b></p>
                                    <p>IP: <b>{$ip}</b></p>
                                    <p>Location: <b>{$location}</b></p>
                                    <p>Device: <b>{$device}</b></p>
                                    <p>If this was you, no action is needed. If you didn’t initiate this login, please change your password immediately.</p>
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align:center;padding:20px 30px;'>
                                    <p style='font-size:12px;color:#aaa;'>If you didn’t sign in, please reset your password or contact support@fastquid.ng immediately.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class='email-footer' style='margin:0 auto;max-width:600px;text-align:center;padding:20px;'>
                        <tbody>
                            <tr>
                                <td>
                                    <p style='font-size:12px;color:#aaa;margin:0;'>&copy; " . date('Y') . " FastQuid. All rights reserved.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>";

    // Send email alert
    @sendMail($user['email'], $subject, $message);

    // Redirect based on KYC
    $redirect = $missingKYC ? "kyc" : "dashboard";
    $msg = $missingKYC ? "Please complete your KYC details." : "Login successful! Redirecting...";

    echo json_encode([
        "success" => true,
        "redirect" => $redirect,
        "message" => $msg
    ]);
    exit;

} catch (Exception $e) {
    error_log("Login Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Server error. Please try again later."]);
    exit;
}