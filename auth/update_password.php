<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../utils/mailer.php'; // sendMail($to, $subject, $html)

// Utility: Get IP, device, and location
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

try {
    // Only allow POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(["success" => false, "message" => "Invalid request method."]);
        exit;
    }

    // Must be logged in
    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
        echo json_encode(["success" => false, "message" => "Unauthorized access."]);
        exit;
    }

    // Input fields
    $oldPass = $_POST['old_pass'] ?? '';
    $newPass = $_POST['new_pass'] ?? '';
    $confirmPass = $_POST['confirm_pass'] ?? '';

    if (empty($oldPass) || empty($newPass) || empty($confirmPass)) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit;
    }

    if ($newPass !== $confirmPass) {
        echo json_encode(["success" => false, "message" => "New password and confirmation do not match."]);
        exit;
    }

    if (strlen($newPass) < 8) {
        echo json_encode(["success" => false, "message" => "Password must be at least 8 characters long."]);
        exit;
    }

    // Fetch user
    $stmt = $pdo->prepare("SELECT id, email, first_name, last_name, password FROM users WHERE id = ? LIMIT 1");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($oldPass, $user['password'])) {
        echo json_encode(["success" => false, "message" => "Old password is incorrect."]);
        exit;
    }

    // Hash new password
    $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
    $update = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $update->execute([$hashedPass, $userId]);

    // Gather session + device info
    $info = getClientInfo();
    $ip = htmlspecialchars($info['ip']);
    $device = htmlspecialchars($info['device']);
    $location = htmlspecialchars($info['location']);
    $time = date('l, jS F Y \a\t g:i A');

    // Build notification email
    $subject = "Password Change Notification";
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
                                        <img src='https://res.cloudinary.com/dzow7ui7e/image/upload/v1760400813/fastquidLogo_1_guuxoe.png' alt='FastQuid' width='200'>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding:40px 30px 20px 30px;font-size:14px;color:#666;'>
                                    <p>Hi {$user['first_name']},</p>
                                    <p>This is to notify you that your FastQuid account password was recently changed.</p>
                                    <p>Here are the details of the activity:</p>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding:0 30px 30px 30px;'>
                                    <p>Time: <b>{$time}</b></p>
                                    <p>IP: <b>{$ip}</b></p>
                                    <p>Location: <b>{$location}</b></p>
                                    <p>Device: <b>{$device}</b></p>
                                    <p>If this was you, no action is needed. If you did not initiate this change, please reset your password immediately.</p>
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align:center;padding:20px 30px;'>
                                    <p style='font-size:12px;color:#aaa;'>If this wasn’t you, contact support@fastquid.ng immediately.</p>
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

    echo json_encode(["success" => true, "message" => "Password changed successfully."]);
    exit;

} catch (Exception $e) {
    error_log("Password Change Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Server error. Please try again later."]);
    exit;
}