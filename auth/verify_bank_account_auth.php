<?php
require_once __DIR__ . '/../config.php';
header("Content-Type: application/json");

if (!isset($_GET['account_number'], $_GET['bank_code'])) {
    http_response_code(400);
    echo json_encode(["status" => false, "message" => "Missing fields"]);
    exit;
}

$account = $_GET['account_number'];
$bank = $_GET['bank_code'];

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.paystack.co/bank/resolve?account_number=$account&bank_code=$bank",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer " . $PAYSTACK_KEY
    ]
]);

$response = curl_exec($curl);

if ($response === false) {
    http_response_code(500);
    echo json_encode(["status" => false, "message" => "Failed to connect to Paystack"]);
    exit;
}

curl_close($curl);

// Forward Paystack response
echo $response;