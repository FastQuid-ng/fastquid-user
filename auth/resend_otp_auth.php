<?php
session_start();
ob_start();
header('Content-Type: application/json');
error_reporting(0);

require_once __DIR__ . '/../config/db.php';     // PDO instance ($pdo)
require_once __DIR__ . '/../utils/mailer.php';  // sendMail($to, $subject, $html)

define('OTP_TTL_SECONDS', 10 * 60);    // 10 minutes expiry
define('RESEND_COOLDOWN', 60);         // 60 seconds before user can resend again

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        exit;
    }

    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid or missing email.']);
        exit;
    }

    // Prevent OTP spam via session cooldown
    if (isset($_SESSION['last_otp_resend']) && (time() - $_SESSION['last_otp_resend']) < RESEND_COOLDOWN) {
        $wait = RESEND_COOLDOWN - (time() - $_SESSION['last_otp_resend']);
        echo json_encode(['success' => false, 'message' => "Please wait {$wait}s before resending another OTP."]);
        exit;
    }

    // Fetch user
    $stmt = $pdo->prepare("SELECT id, first_name, status, is_verified FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'No account found with this email.']);
        exit;
    }

    if ((int)$user['is_verified'] === 1 || $user['status'] === 'active') {
        echo json_encode(['success' => false, 'message' => 'Account is already verified. Please log in.']);
        exit;
    }

    // Generate new 6-digit OTP
    $otp = random_int(100000, 999999);
    $expires_at = date('Y-m-d H:i:s', time() + OTP_TTL_SECONDS);

    // Update user record
    $update = $pdo->prepare("UPDATE users SET otp_code = ?, otp_expires_at = ? WHERE id = ?");
    $update->execute([$otp, $expires_at, $user['id']]);

    // Set cooldown
    $_SESSION['last_otp_resend'] = time();
    $_SESSION['pending_email'] = $email;

    // Send OTP email
    $first_name = htmlspecialchars($user['first_name'], ENT_QUOTES);
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
                                        <img src='https://i.imgur.com/fy55xbW.png' alt='FastQuid' width='200'>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align:center;padding:30px 30px 20px 30px;'>
                                    <h2 style='font-size:22px;color:#333;margin:0;'>FastQuid Account Verification</h2>
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align:center;padding:0 30px 20px 30px;'>
                                    <p style='font-size:14px;color:#666;'>Hi {$first_name},</p>
                                    <p style='font-size:14px;color:#666;'>Use the verification code below to complete your account setup:</p>
                                    <div style='font-size:32px;font-weight:bold;color:#000;margin:20px 0;'>{$otp}</div>
                                    <p style='font-size:13px;color:#888;'>This code will expire in 10 minutes.</p>
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align:center;padding:0 30px 40px 30px;'>
                                    <p style='font-size:12px;color:#aaa;'>Didn’t request this code? Please ignore this email or contact support@fastquid.ng.</p>
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

    // Best effort send
    @sendMail($email, $subject, $message);

    echo json_encode([
        'success' => true,
        'message' => 'A new OTP has been sent to your email address.'
    ]);
    exit;

} catch (Exception $e) {
    error_log("resend_otp.php error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Something went wrong. Please try again later.']);
    exit;
}