<?php
// auth/kyc_auth.php
session_start();
ob_start();
header('Content-Type: application/json');

error_reporting(0);

require_once __DIR__ . '/../config/db.php';     
require_once __DIR__ . '/../utils/mailer.php';  

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        exit;
    }

    // Ensure user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized. Please log in again.']);
        exit;
    }

    $userId = (int)$_SESSION['user_id'];

    // Collect POST data and sanitize
    $gender = filter_var($_POST['gender'] ?? '', FILTER_SANITIZE_STRING);
    $dob = $_POST['date_of_birth'] ?? '';
    $maritalStatus = filter_var($_POST['marital_status'] ?? '', FILTER_SANITIZE_STRING);
    $state = filter_var($_POST['state'] ?? '', FILTER_SANITIZE_STRING);
    $lga = filter_var($_POST['lga'] ?? '', FILTER_SANITIZE_STRING);
    $address = filter_var($_POST['residential_address'] ?? '', FILTER_SANITIZE_STRING);

    // Validate required fields
    if (!$gender || !$dob || !$maritalStatus || !$state || !$lga || !$address) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Determine avatar based on gender
    $avatar = ($gender === 'Male') ? 'assets/img/male-avatar.png' : 'assets/img/female-avatar.png';

    // Update KYC in DB within a transaction
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        UPDATE users
        SET gender = ?, date_of_birth = ?, marital_status = ?, state = ?, lga = ?, residential_address = ?, status = 'active', picture = ?, updated_at = NOW()
        WHERE id = ?
    ");
    $stmt->execute([$gender, $dob, $maritalStatus, $state, $lga, $address, $avatar, $userId]);

    $pdo->commit();

    // Fetch updated user info for email
    $userStmt = $pdo->prepare("SELECT first_name, email FROM users WHERE id = ? LIMIT 1");
    $userStmt->execute([$userId]);
    $user = $userStmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $firstName = htmlspecialchars($user['first_name'] ?? '', ENT_QUOTES);
        $email = $user['email'];

        // Email template
        $subject = "KYC Completed";
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
                                    <td style='text-align:center;padding:40px 30px 0 30px;'>
                                        <p style='font-size:14px;color:#666;margin:0 0 15px 0;'>Hello {$firstName},</p>
                                        <p style='font-size:14px;color:#666;margin:0 0 25px 0;'>Your KYC information has been successfully updated.</p>
                                        <p style='font-size:14px;color:#666;'>You can now enjoy the full features of FastQuid.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style='text-align:center;padding:20px 30px 40px 30px;'>
                                        <a href='https://my.fastquid.ng/dashboard' style='display:inline-block;background:#0e0e0e;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;font-size:14px;'>Go to Dashboard</a>
                                        <p style='font-size:12px;color:#aaa;margin-top:15px;'>If you didn’t perform this action, please contact support immediately.</p>
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
    }

    echo json_encode([
        'success' => true,
        'message' => 'KYC completed successfully! Redirecting...',
        'redirect' => './dashboard'
    ]);
    exit;

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("kyc_auth.php error: " . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => 'Something went wrong. Please try again later.'
    ]);
    exit;
}