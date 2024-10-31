<?php

/**
 * Sai se o arquivo é chamado diretamente ou não
 */
defined('ABSPATH') || exit;

$payment_url = get_transient('peqi_payment_url');
$payment_id = get_transient('peqi_payment_id');

if (empty($payment_id)) {
    $payment_id = bin2hex(random_bytes(8));
    set_transient('peqi_payment_id', $payment_id, 60 * 60);
}

if (empty($payment_url)) {
    $plan_trial = "price_1OZdPuJUpNS565Y8EpmNx5fN";
    $response = PeqiApp_API::create_checkout($plan_trial);
    $payment_url = json_decode(wp_remote_retrieve_body($response), true)['url'];
    set_transient('peqi_payment_url', $payment_url, 60 * 60);
}

wp_localize_script('peqiapp-script', 'PEQIAPP_VAR', array(
    'payment_url' => esc_url($payment_url),
    'token' => esc_attr(PEQI_TOKEN),
    'subscription_url' => esc_url(PEQI_API_URL . PEQI_ENDPOINT_SUBSCRIPTION),
));

?>

<div class="peqiapp-page">
    <?php require_once PEQIAPP_PATH . 'pages/header.php'; ?>

    <div id="awaiting-page">
        <div class="card-container">
            <div class="payment-body">
                <div class="payment-body-left">
                    <div class="configure-container">
                        <img src="<?php echo esc_url(PEQIAPP_URL . 'assets/images/awaiting.png'); ?>" alt="awaiting" class="image-title">
                        <div class="awaiting-your-awaiting-has-been-approved">
                            Waiting for payment...
                        </div>

                        <div class="awaiting-id-22330028283">
                            <?php echo "Payment ID: #" . $payment_id; ?>
                        </div>
                        <div class="awaiting-frame-2725">
                            <svg class="awaiting-envelope-simple" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M28 6H4C3.73478 6 3.48043 6.10536 3.29289 6.29289C3.10536 6.48043 3 6.73478 3 7V24C3 24.5304 3.21071 25.0391 3.58579 25.4142C3.96086 25.7893 4.46957 26 5 26H27C27.5304 26 28.0391 25.7893 28.4142 25.4142C28.7893 25.0391 29 24.5304 29 24V7C29 6.73478 28.8946 6.48043 28.7071 6.29289C28.5196 6.10536 28.2652 6 28 6ZM25.4287 8L16 16.6437L6.57125 8H25.4287ZM27 24H5V9.27375L15.3237 18.7375C15.5082 18.9069 15.7496 19.0008 16 19.0008C16.2504 19.0008 16.4918 18.9069 16.6763 18.7375L27 9.27375V24Z" fill="#c39305" />
                            </svg>
                            <div class="awaiting-you-will-receive-the-proof-of-purchase-and-invoice-for-your-purchase-in-your-email">
                                You will receive the payment link in your email.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="payment-body-right">
                    <div class="configure-container">

                        <div class="awaiting-heading-1-xl">Please proced to the <br>payment page to complete <br>your purchase.</div>
                        <p class="subtext">Complete the payment to start enjoying all the benefits of Peqi on your website.</p>
                        <form method="post">
                            <div class="button-create">
                                <p class="subtext" style="margin-top: 5px;">
                                    To proceed to payment, <a id="payment-link" href="<?php echo esc_url($payment_url); ?>" target="_blank">click here.</a>
                                </p>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>