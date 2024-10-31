<?php

/**
 * Sai se o arquivo é chamado diretamente ou não
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!PeqiApp_Pages::is_user_authenticated()) {
    require_once PEQIAPP_PATH . 'pages/signin.php';
    exit;
}

?>

<div class="peqiapp-page">
    <?php require_once PEQIAPP_PATH . 'pages/header.php'; ?>

    <?php require_once PEQIAPP_PATH . 'pages/account.php'; ?>
    <hr />
    <?php require_once PEQIAPP_PATH . 'pages/cache.php'; ?>
    <hr />
    <?php require_once PEQIAPP_PATH . 'pages/optimization.php'; ?>
    <hr />
    <?php require_once PEQIAPP_PATH . 'pages/reports.php'; ?>

</div>