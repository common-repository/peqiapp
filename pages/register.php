<?php

/**
 * Sai se o arquivo é chamado diretamente ou não
 */
if (!defined('ABSPATH')) {
    exit;
}

// Define o e-mail e nome do usuário atual
$current_user = wp_get_current_user();
$wp_email = $current_user->user_email;
$wp_firstname = $current_user->user_firstname;
$wp_lastname = $current_user->user_lastname;

$wp_fullname = '';

if (!empty($wp_firstname)) {
    $wp_fullname = $wp_firstname;
}

if (!empty($wp_lastname)) {
    $wp_fullname .= ' ' . $wp_lastname;
}

// Captura as mensagens de erro da sessão
$error_register_mail = get_transient('peqi_error_register_mail');
$error_register_name = get_transient('peqi_error_register_name');
$error_register_phone = get_transient('peqi_error_register_phone');
$error_register_password = get_transient('peqi_error_register_password');
$error_register = get_transient('peqi_error_register');

// Remove as mensagens de erro da sessão
delete_transient('peqi_error_register_mail');
delete_transient('peqi_error_register_name');
delete_transient('peqi_error_register_phone');
delete_transient('peqi_error_register_password');
delete_transient('peqi_error_register');
?>


<div class="peqiapp-page">
    <?php require_once PEQIAPP_PATH . 'pages/header.php'; ?>

    <div id="register-page">
        <div class="card-container">
            <div class="text">
                <img src="<?php echo esc_url(PEQIAPP_URL . 'assets/images/register.png'); ?>" alt="register" class="image-title">
                <div class="heading-1-xl">Create your account</div>
                <div class="typography">
                    <p class="paragraph-2-m">Join us to improve your website's performance and security!</p>
                </div>
            </div>
            <div class="inputs">
                <form method="post" class="form-inputs" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="peqi_register_form">
                    <div class="container-input">
                        <div class="subcontainer-input">
                            <div class="required"><label for="peqi_email" class="label-input">E-mail</label></div>
                            <input class="input" type="email" id="peqi_email" name="peqi_email" placeholder="Enter your best e-mail" value="<?php echo esc_attr($wp_email); ?>" required />
                        </div>
                    </div>
                    <?php if (!empty($error_register_mail)) : ?>
                        <div class="error-message"><?php echo esc_html($error_register_mail); ?></div>
                    <?php endif; ?>
                    <div class="container-input">
                        <div class="subcontainer-input">
                            <div class="required"><label for="peqi_username" class="label-input">Full Name</label></div>

                            <input class="input" type="text" id="peqi_username" name="peqi_username" placeholder="Enter your username" value="<?php echo esc_attr($wp_fullname); ?>" required />
                        </div>
                    </div>
                    <?php if (!empty($error_register_name)) : ?>
                        <div class="error-message"><?php echo esc_html($error_register_name); ?></div>
                    <?php endif; ?>
                    <div class="container-input">
                        <div class="subcontainer-input">
                            <div class="required"><label for="peqi_phone" class="label-input">Phone number</label></div>
                            <input class="input" type="text" id="peqi_phone" name="peqi_phone" placeholder="" value="" required />
                            <input type="hidden" id="peqi_country_code_phone" name="peqi_country_code_phone" value="" />
                        </div>
                    </div>
                    <?php if (!empty($error_register_phone)) : ?>
                        <div class="error-message"><?php echo esc_html($error_register_phone); ?></div>
                    <?php endif; ?>
                    <div class="container-input">
                        <div class="subcontainer-input">
                            <div class="required"><label for="peqi_password" class="label-input">Password</label></div>
                            <input class="input" type="password" id="peqi_password" name="peqi_password" placeholder="Enter a strong password" value="" required />
                        </div>
                    </div>
                    <?php if (!empty($error_register_password)) : ?>
                        <div class="error-message"><?php echo esc_html($error_register_password); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($error_register)) : ?>
                        <div class="error-message"><?php echo esc_html($error_register); ?></div>
                    <?php endif; ?>
                    <div class="button-create">
                        <button class="primary-button" type="submit" name="send_create">CREATE</button>
                    </div>
                </form>
                <form method="post" class="form-inputs" action="<?php echo admin_url('admin.php?page=peqiapp-login'); ?>">
                    <div class="container-not-registered">
                        <button class="not-registered" type="submit" name="go_to_register">Already have an account?</button>
                    </div>
                </form>
            </div>
        </div>
    </div>