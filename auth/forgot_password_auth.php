<?php
ob_start();
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/../config/db.php';    // $pdo
require_once __DIR__ . '/../utils/mailer.php'; // sendMail()

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method.");
    }

    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);

    if (!$email) {
        echo json_encode(["success" => false, "message" => "Email is required."]);
        ob_end_flush();
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "Invalid email address."]);
        ob_end_flush();
        exit;
    }

    // Check if user exists
    $stmt = $pdo->prepare("SELECT id, first_name FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(["success" => false, "message" => "No account found with that email."]);
        ob_end_flush();
        exit;
    }

    // Generate reset token
    $token = bin2hex(random_bytes(32));
    $expiresAt = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // Store or update token in database
    $insert = $pdo->prepare("
        INSERT INTO password_resets (user_id, token, expires_at)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)
    ");
    $insert->execute([$user['id'], $token, $expiresAt]);

    // Detect environment
    $env = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) ? 'development' : 'production';
    $resetLink = $env === 'development'
        ? "http://localhost/fastquid-user/reset-password?token=$token"
        : "https://my.fastquid.ng/reset-password?token=$token";

    // Prepare email
    $firstName = htmlspecialchars($user['first_name'] ?? '', ENT_QUOTES);
    $subject = "Password Reset Request";
    $bodyHtml = "
    <table class='email-wraper' style='width:100%;background:#f5f6fa;font-family:Arial,sans-serif;padding:20px;'>
        <tbody>
            <tr>
                <td>
                    <table class='email-body' style='margin:0 auto;max-width:600px;background:#fff;border-radius:8px;overflow:hidden;'>
                        <tbody>
                            <tr>
                                <td style='text-align:center;padding-top:30px;'>
                                    <a href='https://my.fastquid.ng'>
                                        <img src='https://res.cloudinary.com/dzow7ui7e/image/upload/v1760400813/fastquidLogo_1_guuxoe.png' alt='FastQuid' width='200'>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align:center;padding:30px;'>
                                    <h2 style='color:#0E0E0E;font-size:20px;margin:0 0 10px;'>Password Reset Request</h2>
                                    <p style='font-size:14px;color:#666;margin:0 0 15px;'>Hello {$firstName},</p>
                                    <p style='font-size:14px;color:#666;margin:0 0 25px;'>We received a request to reset your FastQuid password. If you made this request, click the button below to reset your password.</p>
                                    <a href='$resetLink' style='background:#0E0E0E;color:#fff;text-decoration:none;padding:12px 25px;border-radius:6px;font-size:14px;display:inline-block;'>Reset Password</a>
                                    <p style='margin-top:20px;font-size:13px;color:#666;'>Or copy this link:</p>
                                    <p style='font-size:13px;color:#0E0E0E;word-break:break-all;'>$resetLink</p>
                                    <p style='font-size:12px;color:#aaa;margin-top:25px;'>If you did not request this, please ignore this email.</p>
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align:center;padding:20px;background:#f9f9f9;'>
                                    <p style='font-size:12px;color:#aaa;margin:0;'>&copy; " . date('Y') . " FastQuid. All rights reserved.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>";

    if (!sendMail($email, $subject, $bodyHtml)) {
        throw new Exception("Failed to send email. Please try again later.");
    }

    $response = [
        "success" => true,
        "message" => "We’ve sent a password reset link to your email."
    ];

    if ($env === 'development') {
        $response["debug_link"] = $resetLink; // visible only in dev
    }

    echo json_encode($response);
    ob_end_flush();
    exit;

} catch (Throwable $e) {
    error_log("FastQuid Forgot Password Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Something went wrong. Please try again later."]);
    ob_end_flush();
    exit;
}