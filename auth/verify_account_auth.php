<?php
// auth/verify_account.php
session_start();
ob_start();
header('Content-Type: application/json');

// for production: keep error_reporting(0). During dev set to E_ALL.
error_reporting(0);

require_once __DIR__ . '/../config/db.php';     // defines $pdo (PDO instance)
require_once __DIR__ . '/../utils/mailer.php';  // sendMail($to, $subject, $html, $alt = '')

// Configuration
define('OTP_TTL_SECONDS', 10 * 60);      // 10 minutes
define('MAX_OTP_ATTEMPTS', 5);
define('OTP_ATTEMPT_WINDOW', 10 * 60);   // 10 minutes window for attempts
$loginRedirect = '/';                    // adjust as needed

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        exit;
    }

    // Merge possible OTP inputs: either otp or otp1..otp6
    $otp = '';
    if (!empty($_POST['otp'])) {
        $otp = trim($_POST['otp']);
    } else {
        for ($i = 1; $i <= 6; $i++) {
            $otp .= isset($_POST["otp{$i}"]) ? trim($_POST["otp{$i}"]) : '';
        }
    }

    // Email may come from POST or from session pending email
    $email = filter_var($_POST['email'] ?? ($_SESSION['pending_email'] ?? ''), FILTER_SANITIZE_EMAIL);

    // Basic validations
    if (!$email || !$otp) {
        echo json_encode(['success' => false, 'message' => 'Please provide your registered email and the 6-digit OTP.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
        exit;
    }

    if (!preg_match('/^[0-9]{6}$/', $otp)) {
        echo json_encode(['success' => false, 'message' => 'Invalid OTP format. Please enter 6 digits.']);
        exit;
    }

    // Simple rate limiting using session (stateless servers: replace with store like Redis)
    if (!isset($_SESSION['otp_attempts'])) {
        $_SESSION['otp_attempts'] = [];
    }

    // Clean old entries
    $_SESSION['otp_attempts'] = array_filter($_SESSION['otp_attempts'], function($ts) {
        return ($ts + OTP_ATTEMPT_WINDOW) >= time();
    });

    if (count($_SESSION['otp_attempts']) >= MAX_OTP_ATTEMPTS) {
        echo json_encode(['success' => false, 'message' => 'Too many incorrect attempts. Please try again later or request a new OTP.']);
        exit;
    }

    // Fetch user
    $stmt = $pdo->prepare("SELECT id, first_name, otp_code, otp_expires_at, status, is_verified FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'No account found with this email.']);
        exit;
    }

    if ((int)$user['is_verified'] === 1 || $user['status'] === 'active') {
        // Clean pending session
        unset($_SESSION['pending_email']);
        echo json_encode(['success' => false, 'message' => 'This account is already verified. Please log in.', 'redirect' => $loginRedirect]);
        exit;
    }

    // Ensure OTP exists in DB
    if (empty($user['otp_code']) || empty($user['otp_expires_at'])) {
        echo json_encode(['success' => false, 'message' => 'No OTP found for this account. Please request a new code.']);
        exit;
    }

    // Check expiry
    if (strtotime($user['otp_expires_at']) < time()) {
        echo json_encode(['success' => false, 'message' => 'Your OTP has expired. Please request a new one.']);
        exit;
    }

    // Validate OTP
    if (!hash_equals((string)$user['otp_code'], (string)$otp)) {
        // record attempt timestamp
        $_SESSION['otp_attempts'][] = time();
        echo json_encode(['success' => false, 'message' => 'Incorrect OTP. Please check and try again.']);
        exit;
    }

    // At this point OTP is valid. Proceed to activate the account within a transaction.
    $pdo->beginTransaction();

    $update = $pdo->prepare("
        UPDATE users
        SET is_verified = 1,
            otp_code = NULL,
            otp_expires_at = NULL,
            updated_at = NOW()
        WHERE id = ?
    ");
    $update->execute([$user['id']]);

    $pdo->commit();

    // Clear session pending email and attempts
    unset($_SESSION['pending_email']);
    unset($_SESSION['otp_attempts']);

    // Send confirmation email (best-effort — do not block success if sending fails)
    try {
        $first_name = htmlspecialchars($user['first_name'] ?? '', ENT_QUOTES);
        $subject = "FastQuid Account Verified";
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
                                            <img class='email-logo' src='https://i.imgur.com/fy55xbW.png' alt='FastQuid' width='200'>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style='text-align:center;padding:30px 30px 20px 30px;'>
                                        <h2 class='email-heading' style='font-size:22px;color:#333;margin:0;'>Account Verified Successfully</h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td style='text-align:center;padding:0 30px 0px 30px;'>
                                        <p style='font-size:14px;color:#666;margin:0 0 15px 0;'>Hello {$first_name},</p>
                                        <p style='font-size:14px;color:#666;margin:0 0 25px 0;'>Your FastQuid account has been successfully verified.</p>
                                        <p style='font-size:14px;color:#666;'>You can now log in to complete KYC.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style='text-align:center;padding:20px 30px 40px 30px;'>
                                        <a href='https://my.fastquid.ng/login' style='display:inline-block;background:#0e0e0e;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;font-size:14px;'>Complete KYC</a>
                                        <p style='font-size:13px;color:#888;margin-top:15px;'>If you didn’t verify this account, please contact our support immediately.</p>
                                        <p style='font-size:12px;color:#aaa;'>Need help? Reach out to our support team anytime. support@fastquid.ng</p>
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

        // best-effort send, don't break flow if it fails
        @sendMail($email, $subject, $message);
    } catch (Exception $mailEx) {
        error_log("verify_account.php: confirmation email failed for {$email} - " . $mailEx->getMessage());
    }

    echo json_encode([
        'success' => true,
        'message' => 'Account verified successfully! Redirecting...',
        'redirect' => $loginRedirect
    ]);
    exit;

} catch (Exception $e) {
    // Rollback if a transaction is active
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    // Log the real error server-side
    error_log("verify_account.php error: " . $e->getMessage());

    // Return generic message to client
    echo json_encode([
        'success' => false,
        'message' => 'Something went wrong. Please try again later.'
    ]);
    exit;
}