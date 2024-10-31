<?php

/**
 * Sai se o arquivo é chamado diretamente ou não
 */
if (!defined('ABSPATH')) {
    exit;
}

// Captura as mensagens de erro da sessão
$error_login_mail = get_transient('peqi_error_login_mail');
$error_login_password = get_transient('peqi_error_login_password');
$error_login = get_transient('peqi_error_login');
$success_message = get_transient('peqi_success_register');


// Remove as mensagens de erro da sessão
delete_transient('peqi_error_login_mail');
delete_transient('peqi_error_login_password');
delete_transient('peqi_error_login');
delete_transient('peqi_success_register');
?>

<div class="peqiapp-page">
    <?php require_once PEQIAPP_PATH . 'pages/header.php'; ?>

    <div id="signin-page">
        <div class="card-container">
            <div class="text">
                <img src="<?php echo esc_url(PEQIAPP_URL . 'assets/images/signin.png'); ?>" alt="signin" class="image-title">
                <div class="typography">
                    <div class="heading-1-xl">Access your account</div>
                </div>
                <div class="typography">
                    <p class="paragraph-2-m">Let's increase your website's performance in just a few steps!</p>
                </div>
            </div>

            <form method="post" class="form-inputs" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="peqi_login_form">
                <div class="container-input">
                    <div class="subcontainer-input">
                        <div class="required"><label for="peqi_email" class="label-input">E-mail</label></div>
                        <input class="input" type="email" id="peqi_email" name="peqi_email" placeholder="email@example.com" value="" required />
                    </div>
                </div>
                <?php if (!empty($error_login_mail)) : ?>
                    <div class="error-message"><?php echo esc_html($error_login_mail); ?></div>
                <?php endif; ?>
                <div class="container-input">
                    <div class="subcontainer-input">
                        <div class="required"><label for="peqi_password" class="label-input">Password</label></div>
                        <input class="input" type="password" id="peqi_password" name="peqi_password" placeholder="Enter your password" value="" required />
                    </div>
                </div>
                <?php if (!empty($error_login_password)) : ?>
                    <div class="error-message"><?php echo esc_html($error_login_password); ?></div>
                <?php endif; ?>
                <?php if (!empty($error_login)) : ?>
                    <div class="error-message"><?php echo esc_html($error_login); ?></div>
                <?php endif; ?>
                <?php if ($success_message) : ?>
                    <div class="success-message"><?php echo esc_html("Registration successful!"); ?></div>
                    <div class="success-message"><?php echo esc_html("Please login with your new credentials."); ?></div>
                <?php endif; ?>

                <div class="button-login-text">
                    <button class="primary-button" type="submit" name="peqi_send_login">LOGIN</button>
                </div>
            </form>

            <form method="post" class="form-inputs" action="<?php echo admin_url('admin.php?page=peqiapp-register'); ?>">
                <div class="container-2-not-registered">
                    <button class="not-registered" type="submit" name="create_account">First time here? Click to create your account.</button>
                </div>
            </form>
        </div>
    </div>
</div>