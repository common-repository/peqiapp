<?php

/**
 * Sai se o arquivo é chamado diretamente ou não
 */
defined('ABSPATH') || exit;
?>

<div class="peqiapp-page">
    <?php require_once PEQIAPP_PATH . 'pages/header.php'; ?>

    <div id="no-website-page">
        <div class="card-container">
            <div class="text">
                <img src="<?php echo esc_url(PEQIAPP_URL . 'assets/images/warning.png'); ?>" alt="warning" class="image-title">
                <div class="heading-1-xl">Website not found!</div>
                <div class="typography">
                    <p class="paragraph-2-m">Oops! This domain is not registered or is not registered to this user.</p>
                    <p class="paragraph-2-m">Please contact support at <a href="mailto:help@peqi.app">help@peqi.app</a> for assistance.</p>
                </div>
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="peqi_switch_account_form">
                    <div class="body-container">
                        <button name="switch_account" class="primary-button" style="width: 184px;">SWITCH ACCOUNT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>