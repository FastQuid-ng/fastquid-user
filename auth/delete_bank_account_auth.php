<?php
while (ob_get_level()) { ob_end_clean(); }
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../config/db.php';

$response = ["status" => false, "message" => "Unknown error"];

try {
    // --- Validate user ---
    if (empty($_SESSION['user_id'])) {
        throw new Exception("Unauthorized");
    }

    if (empty($_POST['bank_id']) || !is_numeric($_POST['bank_id'])) {
        throw new Exception("Invalid or missing bank ID");
    }

    $user_id = (int)$_SESSION['user_id'];
    $bank_id = (int)$_POST['bank_id'];

    // --- Start transaction ---
    $pdo->beginTransaction();

    // Fetch bank info
    $stmt = $pdo->prepare("SELECT is_primary FROM user_bank_accounts WHERE id = ? AND user_id = ?");
    $stmt->execute([$bank_id, $user_id]);
    $bank = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$bank) {
        throw new Exception("Bank account not found");
    }

    $isPrimary = (int)$bank['is_primary'];

    // Delete bank account
    $del = $pdo->prepare("DELETE FROM user_bank_accounts WHERE id = ? AND user_id = ?");
    $del->execute([$bank_id, $user_id]);
    if ($del->rowCount() === 0) {
        throw new Exception("Deletion failed");
    }

    $response = [
        "status" => true,
        "refresh" => false,
        "message" => "Bank account deleted."
    ];

    // Promote another account if primary was deleted
    if ($isPrimary === 1) {
        $next = $pdo->prepare("SELECT id FROM user_bank_accounts WHERE user_id = ? LIMIT 1");
        $next->execute([$user_id]);
        $nextBank = $next->fetch(PDO::FETCH_ASSOC);

        if ($nextBank) {
            $update = $pdo->prepare("UPDATE user_bank_accounts SET is_primary = 1 WHERE id = ?");
            $update->execute([$nextBank['id']]);
            if ($update->rowCount() === 0) {
                throw new Exception("Failed to set new primary account");
            }

            $response["refresh"] = true;
            $response["message"] = "Primary account deleted. A new primary has been set.";
            $response["new_primary_id"] = (int)$nextBank['id'];
        }
    }

    // Commit transaction
    $pdo->commit();

} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    $response = ["status" => false, "message" => $e->getMessage()];
}

// --- Only JSON output ---
echo json_encode($response);
exit;