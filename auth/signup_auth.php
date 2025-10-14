<?php
session_start();
ob_start();
header('Content-Type: application/json');
error_reporting(0);

require_once __DIR__ . '/../config/db.php';  // defines $pdo
require_once __DIR__ . '/../utils/mailer.php'; // sendMail()

// Collect & sanitize input
$first_name = trim($_POST['first_name'] ?? '');
$last_name  = trim($_POST['last_name'] ?? '');
$email      = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$phone      = trim($_POST['phone'] ?? '');
$password   = $_POST['password'] ?? '';
$referee    = trim($_POST['referee'] ?? '');

// Basic validation
if (!$first_name || !$last_name || !$email || !$phone || !$password || !$referee) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email address."]);
    exit;
}

if (!preg_match('/^\+?[0-9]{7,15}$/', $phone)) {
    echo json_encode(["success" => false, "message" => "Invalid phone number."]);
    exit;
}

if (strlen($password) < 8) {
    echo json_encode(["success" => false, "message" => "Password must be at least 8 characters long."]);
    exit;
}

// Check if email already exists
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->fetch()) {
    echo json_encode(["success" => false, "message" => "An account with this email already registered."]);
    exit;
}

// Generate OTP (6 digits)
$otp = random_int(100000, 999999);
$otp_expires_at = date("Y-m-d H:i:s", strtotime("+10 minutes"));

// Hash password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

try {
    // Insert new user with inactive status and not verified
    $stmt = $pdo->prepare("INSERT INTO users 
        (first_name, last_name, email, phone, password, referee, status, otp_code, otp_expires_at, is_verified) 
        VALUES (?, ?, ?, ?, ?, ?, 'inactive', ?, ?, 0)");
    $stmt->execute([$first_name, $last_name, $email, $phone, $hashed_password, $referee, $otp, $otp_expires_at]);

    // Store user email in session for OTP verification page
    $_SESSION['pending_email'] = $email;

    // Detect environment
    $env = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) ? 'development' : 'production';

    $verify_link = $env === 'development'
        ? "http://localhost/fastquid-user/verify-account"
        : "https://my.fastquid.ng/verify-account";

    // Send OTP email
    $subject = "FastQuid Verification";
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
                                        <img class='email-logo' src='https://res.cloudinary.com/dzow7ui7e/image/upload/v1760400813/fastquidLogo_1_guuxoe.png' alt='FastQuid' width='200'>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td style='text-align:center;padding:30px 30px 20px 30px;'>
                                    <h2 class='email-heading' style='font-size:22px;color:#333;margin:0;'>FastQuid Account Verification</h2>
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align:center;padding:0 30px 0px 30px;'>
                                    <p style='font-size:14px;color:#666;margin:0 0 15px 0;'>Hello $first_name,</p>
                                    <p style='font-size:14px;color:#666;margin:0 0 25px 0;'>Thank you for signing up with FastQuid.</p>
                                    <p style='font-size:14px;color:#666;margin:0 0 25px 0;'>To complete your account verification, please use the One-Time Password (OTP) below. This code is valid for the next 10 minutes:</p>
                                    <div style='font-size:32px;font-weight:bold;color:#000;margin:20px 0;'>{$otp}</div>
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align:center;padding:20px 30px 40px 30px;'>
                                    <p style='font-size:13px;color:#888;margin-bottom:15px;'>If you did not request this, please ignore this email. <br />For your security, do not share this code with anyone.</p>
                                    <p style='font-size:12px;color:#aaa;'>Need help? Reach out to our support team anytime at <b>support@fastquid.ng</b></p>
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
    </table>
    ";

    if (!sendMail($email, $subject, $message)) {
        echo json_encode([
            "success" => false,
            "message" => "Account created but failed to send OTP. Please check your email later."
        ]);
        exit;
    }

    echo json_encode([
        "success" => true,
        "message" => "Account created successfully! We've sent a 6-digit OTP to your email for verification.",
        "redirect" => $verify_link
    ]);
    exit;

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database error. Please try again later."
    ]);
    exit;
}