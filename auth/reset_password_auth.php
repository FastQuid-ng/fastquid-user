<?php
ob_start();
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../utils/mailer.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request");
    }

    $token = trim($_POST['token'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['confirm_password'] ?? '');

    if (!$token || !$password || !$confirm) {
        throw new Exception("All fields are required");
    }

    if ($password !== $confirm) {
        throw new Exception("Passwords do not match");
    }

    if (strlen($password) < 6) {
        throw new Exception("Password must be at least 6 characters");
    }

    // Verify token and get user info
    $stmt = $pdo->prepare("
        SELECT pr.user_id, pr.expires_at, u.first_name, u.email 
        FROM password_resets pr 
        JOIN users u ON u.id = pr.user_id 
        WHERE pr.token = ?
        LIMIT 1
    ");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("Invalid or expired token.");
    }

    if (strtotime($user['expires_at']) < time()) {
        throw new Exception("Token has expired.");
    }

    // Hash and update password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $update = $pdo->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?");
    $update->execute([$hashedPassword, $user['user_id']]);

    // Delete token after successful reset
    $pdo->prepare("DELETE FROM password_resets WHERE token = ?")->execute([$token]);

    // Prepare email details
    $firstName = htmlspecialchars($user['first_name'] ?? '', ENT_QUOTES);
    $email = $user['email'];

    $subject = "Password Changed";
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
                            <tr>
                                <td style='text-align:center;padding:40px 30px 0 30px;'>
                                    <p style='font-size:14px;color:#666;margin:0 0 15px 0;'>Hello {$firstName},</p>
                                    <p style='font-size:14px;color:#666;margin:0 0 25px 0;'>Your FastQuid password has been changed successfully.</p>
                                    <p style='font-size:14px;color:#666;'>Login now and start enjoying fast and low interest loans from FastQuid.</p>
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align:center;padding:20px 30px 40px 30px;'>
                                    <a href='https://my.fastquid.ng' style='display:inline-block;background:#0e0e0e;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;font-size:14px;'>Login Now</a>
                                    <p style='font-size:12px;color:#aaa;margin-top:15px;'>If you didn’t perform this action, please contact support immediately at support@fastquid.ng.</p>
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

    @sendMail($email, $subject, $message);

    echo json_encode([
        "success" => true,
        "message" => "Password reset successful! Redirecting..."
    ]);
    ob_end_flush();
    exit;

} catch (Throwable $e) {
    error_log("Reset password error: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
    ob_end_flush();
    exit;
}
