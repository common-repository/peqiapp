<?php

/**
 * Sai se o arquivo é chamado diretamente ou não
 */
if (!defined('ABSPATH')) {
    exit;
}

$validation_results = get_transient('peqi_validation_results');

if ($validation_results !== false) {
    wp_localize_script('peqiapp-script', 'PEQIAPP_VARS', array(
        'validation_results' => $validation_results,
        'peqi_error_icon' => esc_url(PEQIAPP_URL . 'assets/images/error.svg'),
        'peqi_success_icon' => esc_url(PEQIAPP_URL . 'assets/images/success.svg'),
    ));
}

$error_create_domain = get_transient('peqi_error_create_domain');
$error_check_website = get_transient('peqi_error_check_website');


?>

<div class="peqiapp-page">
    <?php require_once PEQIAPP_PATH . 'pages/header.php'; ?>

    <div id="check-page">
        <div class="card-container">
            <div class="text">
                <img src="<?php echo esc_url(PEQIAPP_URL . 'assets/images/rocket.png'); ?>" alt="rocket" class="image-title">
                <div class="heading-1-xl">
                    Website validation
                </div>
                <div class="typography">
                    <p class="paragraph-2-m">Check if your website is eligible for peqifying:</p>
                </div>
            </div>
            <div class="onboard-_1" id="onboard_step1">
                <div class="onboard-content">
                    <div class="onboard-action">
                        <div class="onboard-content1">
                            <form method="post" class="form-inputs" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" id="peqiForm">
                                <input type="hidden" name="action" value="peqi_check_form">
                                <div class="container-input">
                                    <div class="subcontainer-input">
                                        <label for="peqi_website" class="label-input">URL website</label>
                                        <input class="input" type="text" id="peqi_website" name="peqi_website" placeholder="" value="<?php echo esc_attr(PEQI_WEBSITE); ?>" disabled />
                                        <input type="hidden" name="peqi_website" value="<?php echo esc_attr(PEQI_WEBSITE); ?>" />
                                    </div>
                                </div>
                                <div class="button-login-text" style="width: 176px;">
                                    <button class="primary-button" type="submit" name="peqi_send_validate_website" id="submitButton">CHECK</button>
                                </div>
                            </form>

                            <div id="validation-results"></div>

                            <?php if ($error_check_website) : ?>
                                <div class="error-message">
                                    <p class="error-message"><?php echo $error_check_website; ?></p>
                                </div>
                            <?php endif; ?>

                            <div class="item">
                                <p class="infoitem">Peqi is a website booster made to improve your website's performance and security.</p>
                                <div class="subitems">
                                    <img src="<?php echo esc_url(PEQIAPP_URL . 'assets/images/forward_button.png'); ?>" alt="subitem" class="image-subitems">
                                    <p class="subitems">Improved WAF that enhances security for WordPress</p>
                                </div>
                                <div class="subitems">
                                    <img src="<?php echo esc_url(PEQIAPP_URL . 'assets/images/forward_button.png'); ?>" alt="subitem" class="image-subitems">
                                    <p class="subitems">Automated on page optimizations applied to CDN layer</p>
                                </div>
                                <div class="subitems">
                                    <img src="<?php echo esc_url(PEQIAPP_URL . 'assets/images/forward_button.png'); ?>" alt="subitem" class="image-subitems">
                                    <p class="subitems">Improved performance and SEO</p>
                                </div>
                            </div>

                            <form method="post" class="form-inputs" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                                <input type="hidden" name="action" value="peqi_create_domain_form">
                                <input type="hidden" name="peqi_website" value="<?php echo esc_attr(PEQI_WEBSITE); ?>" />
                                <input type="hidden" name="ip_address" value="" />
                                <div id="success" style="display: none">
                                    <p class="paragraph-2-m">Let's optimize and secure your website?</p>
                                    <button class="primary-button" type="submit" name="peqi_send_validate_website" id="submitButton">PEQIFY MY WEBSITE!</button>
                                </div>
                            </form>

                            <?php if ($error_create_domain) : ?>
                                <div class="error-message">
                                    <p class="error-message"><?php echo $error_create_domain; ?></p>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>