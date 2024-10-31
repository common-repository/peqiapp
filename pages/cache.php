<?php

/**
 * Sai se o arquivo é chamado diretamente ou não
 */
if (!defined('ABSPATH')) {
    exit;
}

$error_clear_cache = get_transient('peqi_error_clear_cache');
$success_clear_cache = get_transient('peqi_success_clear_cache');

delete_transient('peqi_error_clear_cache');
delete_transient('peqi_success_clear_cache');

?>

<div id="cache-page">
    <div class="card-container-xl">
        <div class="title-container">
            <h3>Clear Cache</h3>
            <h4>You can clear the cached data of your application.</h4>

        </div>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="peqi_clear_cache">
            <?php if (!empty($error_clear_cache)) : ?>
                <p class="error-message"><?php echo esc_html($error_clear_cache); ?></p>
            <?php endif; ?>
            <?php if (!empty($success_clear_cache)) : ?>
                <p class="success-message"><?php echo esc_html($success_clear_cache); ?></p>
            <?php endif; ?>
            <div class="button-home">
                <button name="cache_clear" type="submit" class="primary-button">CLEAR CACHE</button>
            </div>
        </form>
    </div>
</div>