<?php

/**
 * Sai se o arquivo é chamado diretamente ou não
 */
if (!defined('ABSPATH')) {
    exit;
}

?>

<div id="account-page">
    <div class="card-container-xl">
        <div class="title-container">
            <h3>Status: <span class="status">Active</span></h3>
            <p style="line-height: 2px">You're connected as <span class="user-info"><?php echo esc_html(PEQI_USER_NAME); ?> (<?php echo esc_html(PEQI_USER_EMAIL); ?>)</span>.</p>
            <?php if (PEQI_WEBSITE) { ?>
                <p style="line-height: 2px">Your website is <span class="user-domain"><?php echo esc_html(PEQI_WEBSITE); ?>.</span> </p>
            <?php } ?>
        </div>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="peqi_switch_account_form">
            <div class="button-home">
                <button name="switch_account" class="primary-button">SWITCH ACCOUNT</button>
            </div>
        </form>
    </div>
</div>