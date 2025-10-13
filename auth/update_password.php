<?php
session_start();
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPass = $_POST['old_pass'] ?? '';
    $newPass = $_POST['new_pass'] ?? '';
    $confirmPass = $_POST['confirm_pass'] ?? '';

    if (empty($oldPass) || empty($newPass) || empty($confirmPass)) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit;
    }

    if ($newPass !== $confirmPass) {
        echo json_encode(["success" => false, "message" => "New password and confirm password do not match."]);
        exit;
    }

    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
        echo json_encode(["success" => false, "message" => "Unauthorized access."]);
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($oldPass, $user['password'])) {
            echo json_encode(["success" => false, "message" => "Old password is incorrect."]);
            exit;
        }

        $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update->execute([$hashedPass, $userId]);

        echo json_encode(["success" => true, "message" => "Password updated successfully."]);
    } catch (Exception $e) {
        error_log("Password Update Error: " . $e->getMessage());
        echo json_encode(["success" => false, "message" => "Server error. Please try again later."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}