<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$PAYSTACK_KEY = $_ENV['PAYSTACK_SECRET_KEY'];

// database connection
require_once __DIR__ . '/config/db.php';