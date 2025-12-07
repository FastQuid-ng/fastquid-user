<?php
require_once __DIR__ . '/../config.php';
header("Content-Type: application/json");

$curl = curl_init("https://api.paystack.co/bank?country=nigeria");
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $PAYSTACK_KEY"
    ]
]);
$response = curl_exec($curl);
curl_close($curl);

echo $response;