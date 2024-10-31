<?php

/**
 * Sai se o arquivo é chamado diretamente ou não
 */
if (!defined('ABSPATH')) {
    exit;
}

$peqi_levels = PeqiApp_API::get_domain(PEQI_TOKEN);
$peqi_levels = json_decode(wp_remote_retrieve_body($peqi_levels), true);

$scripts_level = $peqi_levels['results'][0]['scripts_level'];
$images_level = $peqi_levels['results'][0]['images_level'];
$styles_level = $peqi_levels['results'][0]['styles_level'];
$includes_level = $peqi_levels['results'][0]['includes_level'];


$error_change_level = get_transient('peqi_error_change_level');
$success_change_level = get_transient('peqi_success_change_level');

delete_transient('peqi_error_change_level');
delete_transient('peqi_success_change_level');

?>

<div id="optimization-page">
    <div class="card-container-xl">
        <div class="title-container">
            <h3>Optimization Level</h3>
            <h4>You can adjust the optimization levels of your application.</h4>
        </div>
        <form method="post" class="form-levels" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="peqi_change_level_form">
            <div class="container-optimization">

                <div class="container-input">
                    <div class="subcontainer-input">
                        <label for="combo-box-scripts">Scripts level:</label>
                        <select class="input-select" id="combo-box-scripts" name="combo-box-scripts">
                            <option value="0" <?php echo esc_attr($scripts_level == 0 ? 'selected' : ''); ?>>Minimum</option>
                            <option value="1" <?php echo esc_attr($scripts_level == 1 ? 'selected' : ''); ?>>Medium</option>
                            <option value="2" <?php echo esc_attr($scripts_level == 2 ? 'selected' : ''); ?>>Maximum</option>
                            <option value="3" <?php echo esc_attr($scripts_level == 3 ? 'selected' : ''); ?>>Experimental</option>
                        </select>
                    </div>
                </div>

                <div class="container-input">
                    <div class="subcontainer-input">
                        <label for="combo-box-images">Images level:</label>
                        <select class="input-select" id="combo-box-images" name="combo-box-images">
                            <option value="0" <?php echo esc_attr($images_level == 0 ? 'selected' : ''); ?>>Minimum</option>
                            <option value="1" <?php echo esc_attr($images_level == 1 ? 'selected' : ''); ?>>Medium</option>
                            <option value="2" <?php echo esc_attr($images_level == 2 ? 'selected' : ''); ?>>Maximum</option>
                        </select>
                    </div>
                </div>

                <div class="container-input">
                    <div class="subcontainer-input">
                        <label for="combo-box-styles">Styles level:</label>
                        <select class="input-select" id="combo-box-styles" name="combo-box-styles">
                            <option value="0" <?php echo esc_attr($styles_level == 0 ? 'selected' : ''); ?>>Minimum</option>
                            <option value="1" <?php echo esc_attr($styles_level == 1 ? 'selected' : ''); ?>>Medium</option>
                            <option value="2" <?php echo esc_attr($styles_level == 2 ? 'selected' : ''); ?>>Maximum</option>
                        </select>
                    </div>
                </div>

                <div class="container-input">
                    <div class="subcontainer-input">
                        <label for="combo-box-includes">Includes level:</label>
                        <select class="input-select" id="combo-box-includes" name="combo-box-includes">
                            <option value="0" <?php echo esc_attr($includes_level == 0 ? 'selected' : ''); ?>>Minimum</option>
                            <option value="2" <?php echo esc_attr($includes_level == 2 ? 'selected' : ''); ?>>Maximum</option>
                        </select>
                    </div>
                </div>
            </div>
            <?php if (!empty($error_change_level)) : ?>
                <p class="error-message"><?php echo esc_html($error_change_level); ?></p>
            <?php endif; ?>
            <?php if (!empty($success_change_level)) : ?>
                <p class="success-message"><?php echo esc_html($success_change_level); ?></p>
            <?php endif; ?>
            <div class="button-home">
                <button name="peqi_send_change_level" type="submit" class="primary-button">UPDATE</button>
            </div>
        </form>
    </div>
</div>