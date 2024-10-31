<?php

/**
 * Sai se o arquivo é chamado diretamente ou não
 */
defined('ABSPATH') || exit;

$payment_id = get_transient('peqi_payment_id');
if (empty($payment_id)) {
    $payment_id = bin2hex(random_bytes(8));
    set_transient('peqi_payment_id', $payment_id, 60 * 60);
}

$checkpoint = get_option('peqi_checkpoint');
if ($checkpoint === 'awaiting-payment') {
    update_option('peqi_checkpoint', 'payment-success');
    // Envia mensagem para o GChat
    PeqiApp_Functions::send_event('plugin-success', PEQI_WEBSITE);
    PeqiApp_Functions::send_stage_gchat(8);
}

$error_pointed_domain = get_transient('peqi_error_pointed_domain');

delete_transient('peqi_error_pointed_domain');


?>

<div class="peqiapp-page">
    <?php require_once PEQIAPP_PATH . 'pages/header.php'; ?>

    <div id="success-page">
        <div class="card-container">
            <div class="payment-body">
                <div class="payment-body-left">
                    <div class="configure-container">
                        <img src="<?php echo esc_url(PEQIAPP_URL . 'assets/images/success.png'); ?>" alt="success" class="image-title">
                        <div class="payment-your-payment-has-been-approved">
                            Your payment has<br>
                            been approved!
                        </div>

                        <div class="payment-id-22330028283">
                            <?php echo "Payment ID: #" . $payment_id; ?>
                        </div>
                        <div class="payment-frame-2725">
                            <svg class="payment-envelope-simple" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M28 6H4C3.73478 6 3.48043 6.10536 3.29289 6.29289C3.10536 6.48043 3 6.73478 3 7V24C3 24.5304 3.21071 25.0391 3.58579 25.4142C3.96086 25.7893 4.46957 26 5 26H27C27.5304 26 28.0391 25.7893 28.4142 25.4142C28.7893 25.0391 29 24.5304 29 24V7C29 6.73478 28.8946 6.48043 28.7071 6.29289C28.5196 6.10536 28.2652 6 28 6ZM25.4287 8L16 16.6437L6.57125 8H25.4287ZM27 24H5V9.27375L15.3237 18.7375C15.5082 18.9069 15.7496 19.0008 16 19.0008C16.2504 19.0008 16.4918 18.9069 16.6763 18.7375L27 9.27375V24Z" fill="#96CC00" />
                            </svg>
                            <div class="payment-you-will-receive-the-proof-of-purchase-and-invoice-for-your-purchase-in-your-email">
                                You will receive the proof of purchase and invoice for your purchase in
                                your email.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="payment-body-right">
                    <div class="configure-container">

                        <div class="payment-heading-1-xl">DNS pointing</div>
                        <div class="payment-to-perform-optimizations-on-your-website-point-the-dns-to-your-hosting-provider">
                            Ready for some tech wizardry? Point your A-type DNS record to Peqi and let the fun begin!
                        </div>
                        <div class="payment-dns-configuration">Copy and paste this sub-domains in your hosting provider</div>
                        <div class="frame-309">
                            <div class="pill" id="ip-address-1">
                                <svg class="copy-simple" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.5 4H2.5C2.36739 4 2.24021 4.05268 2.14645 4.14645C2.05268 4.24021 2 4.36739 2 4.5V13.5C2 13.6326 2.05268 13.7598 2.14645 13.8536C2.24021 13.9473 2.36739 14 2.5 14H11.5C11.6326 14 11.7598 13.9473 11.8536 13.8536C11.9473 13.7598 12 13.6326 12 13.5V4.5C12 4.36739 11.9473 4.24021 11.8536 4.14645C11.7598 4.05268 11.6326 4 11.5 4ZM11 13H3V5H11V13ZM14 2.5V11.5C14 11.6326 13.9473 11.7598 13.8536 11.8536C13.7598 11.9473 13.6326 12 13.5 12C13.3674 12 13.2402 11.9473 13.1464 11.8536C13.0527 11.7598 13 11.6326 13 11.5V3H4.5C4.36739 3 4.24021 2.94732 4.14645 2.85355C4.05268 2.75979 4 2.63261 4 2.5C4 2.36739 4.05268 2.24021 4.14645 2.14645C4.24021 2.05268 4.36739 2 4.5 2H13.5C13.6326 2 13.7598 2.05268 13.8536 2.14645C13.9473 2.24021 14 2.36739 14 2.5Z" fill="#000814" />
                                </svg>
                                <div class="ip-address-1">151.101.193.91</div>
                            </div>
                            <div class="pill" id="ip-address-2">
                                <svg class="copy-simple2" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.5 4H2.5C2.36739 4 2.24021 4.05268 2.14645 4.14645C2.05268 4.24021 2 4.36739 2 4.5V13.5C2 13.6326 2.05268 13.7598 2.14645 13.8536C2.24021 13.9473 2.36739 14 2.5 14H11.5C11.6326 14 11.7598 13.9473 11.8536 13.8536C11.9473 13.7598 12 13.6326 12 13.5V4.5C12 4.36739 11.9473 4.24021 11.8536 4.14645C11.7598 4.05268 11.6326 4 11.5 4ZM11 13H3V5H11V13ZM14 2.5V11.5C14 11.6326 13.9473 11.7598 13.8536 11.8536C13.7598 11.9473 13.6326 12 13.5 12C13.3674 12 13.2402 11.9473 13.1464 11.8536C13.0527 11.7598 13 11.6326 13 11.5V3H4.5C4.36739 3 4.24021 2.94732 4.14645 2.85355C4.05268 2.75979 4 2.63261 4 2.5C4 2.36739 4.05268 2.24021 4.14645 2.14645C4.24021 2.05268 4.36739 2 4.5 2H13.5C13.6326 2 13.7598 2.05268 13.8536 2.14645C13.9473 2.24021 14 2.36739 14 2.5Z" fill="#000814" />
                                </svg>
                                <div class="ip-address-2">151.101.1.91</div>
                            </div>
                            <div class="pill" id="ip-address-3">
                                <svg class="copy-simple3" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.5 4H2.5C2.36739 4 2.24021 4.05268 2.14645 4.14645C2.05268 4.24021 2 4.36739 2 4.5V13.5C2 13.6326 2.05268 13.7598 2.14645 13.8536C2.24021 13.9473 2.36739 14 2.5 14H11.5C11.6326 14 11.7598 13.9473 11.8536 13.8536C11.9473 13.7598 12 13.6326 12 13.5V4.5C12 4.36739 11.9473 4.24021 11.8536 4.14645C11.7598 4.05268 11.6326 4 11.5 4ZM11 13H3V5H11V13ZM14 2.5V11.5C14 11.6326 13.9473 11.7598 13.8536 11.8536C13.7598 11.9473 13.6326 12 13.5 12C13.3674 12 13.2402 11.9473 13.1464 11.8536C13.0527 11.7598 13 11.6326 13 11.5V3H4.5C4.36739 3 4.24021 2.94732 4.14645 2.85355C4.05268 2.75979 4 2.63261 4 2.5C4 2.36739 4.05268 2.24021 4.14645 2.14645C4.24021 2.05268 4.36739 2 4.5 2H13.5C13.6326 2 13.7598 2.05268 13.8536 2.14645C13.9473 2.24021 14 2.36739 14 2.5Z" fill="#000814" />
                                </svg>
                                <div class="ip-address-3">151.101.65.91</div>
                            </div>
                            <div class="pill" id="ip-address-4">
                                <svg class="copy-simple4" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.5 4H2.5C2.36739 4 2.24021 4.05268 2.14645 4.14645C2.05268 4.24021 2 4.36739 2 4.5V13.5C2 13.6326 2.05268 13.7598 2.14645 13.8536C2.24021 13.9473 2.36739 14 2.5 14H11.5C11.6326 14 11.7598 13.9473 11.8536 13.8536C11.9473 13.7598 12 13.6326 12 13.5V4.5C12 4.36739 11.9473 4.24021 11.8536 4.14645C11.7598 4.05268 11.6326 4 11.5 4ZM11 13H3V5H11V13ZM14 2.5V11.5C14 11.6326 13.9473 11.7598 13.8536 11.8536C13.7598 11.9473 13.6326 12 13.5 12C13.3674 12 13.2402 11.9473 13.1464 11.8536C13.0527 11.7598 13 11.6326 13 11.5V3H4.5C4.36739 3 4.24021 2.94732 4.14645 2.85355C4.05268 2.75979 4 2.63261 4 2.5C4 2.36739 4.05268 2.24021 4.14645 2.14645C4.24021 2.05268 4.36739 2 4.5 2H13.5C13.6326 2 13.7598 2.05268 13.8536 2.14645C13.9473 2.24021 14 2.36739 14 2.5Z" fill="#000814" />
                                </svg>
                                <div class="ip-address-4">151.101.129.91</div>
                            </div>
                        </div>
                        <div>
                            <p class="payment-to-perform-optimizations-on-your-website-point-the-dns-to-your-hosting-provider">
                                <a id="payment-link" href="https://help.peqi.app/how-to-set-up-dns-cdn" target="_blank"> Here</a> is some help to DNS pointing
                            </p>

                            <p class="payment-to-perform-optimizations-on-your-website-point-the-dns-to-your-hosting-provider">
                                Follow <a id="payment-link" href="https://help.peqi.app/my-website-is-on-peqi-and-its-down-what-should-i-do" target="_blank">these</a> is firewall configuration instructions to ensure that your<br> hosting environment supports Peqi as your CDN.
                            </p>
                        </div>

                        <form method="post" class="form-inputs" style="align-items: center;" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                            <input type="hidden" name="action" value="peqi_pointed_domain_form">
                            <div class="button-login-text" style="width: 304px;">
                                <button class="primary-button" type="submit">I ALREADY HAVE POINTED THE DNS</button>
                            </div>
                        </form>

                        <div>
                            <?php if ($error_pointed_domain) : ?>
                                <div class="error-message">
                                    <p class="error-message"><?php echo $error_pointed_domain; ?></p>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>