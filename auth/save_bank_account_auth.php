<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../config/db.php'; // Ensure you're including db.php for the PDO connection
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

// Make sure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => false, "message" => "User not authenticated"]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if necessary fields are set
if (!isset($_POST['bank_code'], $_POST['account_number'], $_POST['account_name'], $_POST['bank_name'])) {
    echo json_encode(["status" => false, "message" => "All fields are required"]);
    exit;
}

$bank_code      = $_POST['bank_code'];
$bank_name      = $_POST['bank_name'];  // Getting the bank name from the form
$account_number = $_POST['account_number'];
$account_name   = $_POST['account_name'];
$is_primary     = isset($_POST['is_primary']) && $_POST['is_primary'] == "1" ? 1 : 0;

// Optional validation
if (!preg_match('/^\d{10}$/', $account_number)) {
    echo json_encode(["status" => false, "message" => "Invalid account number"]);
    exit;
}

try {
    // Prevent duplicates
    $check = $pdo->prepare("SELECT id FROM user_bank_accounts WHERE user_id = ? AND account_number = ?");
    $check->execute([$user_id, $account_number]);
    if ($check->rowCount() > 0) {
        echo json_encode(["status" => false, "message" => "This bank account already exists"]);
        exit;
    }

    // If primary, unset previous primary accounts
    if ($is_primary) {
        $pdo->query("UPDATE user_bank_accounts SET is_primary = 0 WHERE user_id = $user_id");
    }

    // Insert new bank account
    $stmt = $pdo->prepare("
        INSERT INTO user_bank_accounts (user_id, bank_code, bank_name, account_number, account_name, is_primary)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$user_id, $bank_code, $bank_name, $account_number, $account_name, $is_primary]);

    echo json_encode(["status" => true, "message" => "Bank account added successfully"]);
} catch (PDOException $e) {
    echo json_encode(["status" => false, "message" => "Database error: " . $e->getMessage()]);
}