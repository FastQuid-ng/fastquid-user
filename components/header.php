<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ./'); // or login page
    exit();
}

$firstName = htmlspecialchars($_SESSION['first_name'] ?? '');
$lastName  = htmlspecialchars($_SESSION['last_name'] ?? '');
$userEmail = htmlspecialchars($_SESSION['email'] ?? '');
$fullName  = trim("$firstName $lastName");
$avatar = htmlspecialchars($_SESSION['avatar'] ?? '');

$pageTitles = [
    'dashboard' => 'Dashboard',
    'profile'   => 'Profile',
    'loan'     => 'Loans',
    'bank'   => 'Bank Details',
    'security'  => 'Security',
    'support'  => 'Support',
    'loan-application'  => 'Loan Application',
];

$title = $pageTitles[$pageTitle] ?? 'FastQuid';

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta name="color-scheme" content="light">

    <title>FastQuid&trade; :: <?= $title ?></title>

    <meta name="description" content="At Fastquid, we’ve got you covered with our terrific digital lending solutions designed just for folks like you, whether you work for a big company or a small business.">
    <meta property="og:url" content="https://fastquid.ng/"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="FastQuid&trade; :: A faster way to borrow money"/>
    <meta name="og:description" content="At Fastquid, we’ve got you covered with our terrific digital lending solutions designed just for folks like you, whether you work for a big company or a small business.">
    <meta name="keywords" content="credit, loan, payments, africa, nigeria, fintech, tech in africa, lagos, fastquid, agency banking, money agent, fastquid, Quick Cash">
    <meta name="author" content="Webify">

    <link rel="shortcut icon" href="./assets/img/favicon.png">

    <link rel="stylesheet" type="text/css" href="./assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/utility.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://api.fontshare.com/v2/css?f=satoshi@900,700,500,300,401,400&amp;display=swap">
</head>

<body class="bg-body-tertiary">