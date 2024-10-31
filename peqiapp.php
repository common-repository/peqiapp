<?php

/**
 * @package Peqi App
 * @version 2.0.18
 * Plugin Name: Peqi App
 * Plugin URI: http://wordpress.org/plugins/peqiapp/
 * Description: You can manage your application settings, perform cache cleaning, adjust optimization levels, and view performance metrics.
 * Version: 2.0.18
 * Requires at least: 4.7
 * Author: Peqi
 * Author URI: https://get.peqi.app/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: peqiapp
 * Domain Path: /languages
 */

/**
 * Sai se o arquivo é chamado diretamente ou não
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Define o Debug Mode
 */
if (!defined('PEQI_DEBUG')) {
    define('PEQI_DEBUG', false);
}

/**
 * Carrega o autoloader do Composer
 */
require_once __DIR__ . '/vendor/autoload.php';

if (!class_exists('PeqiApp')) {
    class PeqiApp
    {

        /**
         * Construtor da classe
         */
        function __construct()
        {
            $this->define_constants();
            $this->init_hooks();
            $this->load_dependencies();
            $this->load_textdomain();
        }

        /**
         * Inicializa os hooks do plugin
         */
        private function init_hooks()
        {
            add_action('admin_enqueue_scripts', array($this, 'enqueue_assets'), 999);
            add_action('admin_enqueue_scripts', array($this, 'enqueue_intl_tel_input'), 999);
            add_action('admin_enqueue_scripts', array($this, 'javascript_variables'), 999);
            add_action('activated_plugin', array($this, 'peqiapp_activation_redirect'));
        }

        /**
         * Carrega as dependências/classes do plugin
         */
        private function load_dependencies()
        {
            require_once PEQIAPP_PATH . 'includes/functions.php';
            $functionsInstance = new PeqiApp_Functions();

            require_once PEQIAPP_PATH . 'includes/api.php';
            $apiInstance = new PeqiApp_API();

            require_once PEQIAPP_PATH . 'includes/pages.php';
            $pagesInstance = new PeqiApp_Pages();

        }

        /**
         * Define as constantes do plugin
         */
        public function define_constants()
        {
            define('PEQIAPP_PATH', plugin_dir_path(__FILE__));
            define('PEQIAPP_URL', plugin_dir_url(__FILE__));
            define('PEQIAPP_VERSION', '2.0.18');

            if (defined('PEQI_DEBUG') && PEQI_DEBUG === true) {
                define('PEQI_API_URL', 'https://dev-api.peqi.app');
            } else {
                define('PEQI_API_URL', 'https://api.peqi.app');
            }
            
            define('PEQI_ENDPOINT_AUTH', '/v0/auth/token/');
            define('PEQI_ENDPOINT_TOKEN', '/v0/tokens/');
            define('PEQI_ENDPOINT_USER', '/v0/users/');
            define('PEQI_ENDPOINT_DOMAIN', '/v0/domains/');
            define('PEQI_ENDPOINT_REPORT', '/v0/reports/');
            define('PEQI_ENDPOINT_PLANS', '/v0/plans/');
            define('PEQI_ENDPOINT_CHECKOUT', '/v0/checkout/');
            define('PEQI_ENDPOINT_SUBSCRIPTION', '/v0/subscriptions/');
            define('PEQI_ENDPOINT_EVENTS', '/v0/events/');

            define('PEQI_WEBSITE', sanitize_text_field($_SERVER['HTTP_HOST']));
        }

        /**
         * Carrega as traduções do plugin
         */
        public function load_textdomain()
        {
            load_plugin_textdomain('peqiapp', false, dirname(plugin_basename(__FILE__)) . '/languages/');
        }

        /**
         * Hook de ativação do plugin
         */
        public static function activate()
        {
            add_option('peqi_token', '');
            add_option('peqi_user_name', '');
            add_option('peqi_user_email', '');
            add_option('peqi_domain_id', '');
            add_option('peqi_domain_fqdn', '');
            add_option('peqi_domain_key', '');
            add_option('peqi_checkpoint', '');

            PeqiApp_Functions::send_event('plugin-install', PEQI_WEBSITE);
            PeqiApp_Functions::send_stage_gchat(1);
        }

        /**
         * Hook de desativação do plugin
         */
        public static function deactivate()
        {
            delete_option('peqi_token', '');
            delete_option('peqi_user_name', '');
            delete_option('peqi_user_email', '');
            delete_option('peqi_domain_id', '');
            delete_option('peqi_domain_fqdn', '');
            delete_option('peqi_domain_key', '');
            delete_option('peqi_checkpoint', '');
        }

        /**
         * Redireciona ao instalar o plugin
         */
        function peqiapp_activation_redirect($plugin)
        {
            if ($plugin == plugin_basename(__FILE__)) {
                exit(wp_redirect(admin_url('admin.php?page=peqiapp-register')));
            }
        }

        /**
         * Adiciona os assets (CSS, JS) do plugin
         */
        public function enqueue_assets()
        {
            // Impedir que os assets sejam carregados em outras páginas
            if (!isset($_GET['page']) || strpos($_GET['page'], 'peqiapp') !== 0) {
                return;
            }
            wp_enqueue_style('peqiapp-style', PEQIAPP_URL . 'assets/css/style.css', array(), PEQIAPP_VERSION, 'all');
            wp_enqueue_style('peqiapp-styleguide', PEQIAPP_URL . 'assets/css/styleguide.css', array(), PEQIAPP_VERSION, 'all');
            wp_enqueue_style('peqiapp-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), PEQIAPP_VERSION, 'all');
            wp_enqueue_script('peqiapp-script', PEQIAPP_URL . 'assets/js/script.js',
                array('jquery'),
                PEQIAPP_VERSION,
                true
            );
        }

        /**
         * Adiciona os assets do plugin Intl Tel Input
         */
        public function enqueue_intl_tel_input()
        {
            // Impedir que os assets sejam carregados em outras páginas
            if (!isset($_GET['page']) || $_GET['page'] !== 'peqiapp-register') {
                return;
            } 
            wp_enqueue_style('intl-tel-input-css', PEQIAPP_URL . 'vendor/intl-tel-input/intlTelInput.css', array(), PEQIAPP_VERSION, 'all');
            wp_enqueue_script('intl-tel-input-js', PEQIAPP_URL . 'vendor/intl-tel-input/intlTelInput.js', array('jquery'), PEQIAPP_VERSION, true);
            
        }

        /**
         * Passa variáveis do PHP para o script JS
         */
        public function javascript_variables()
        {
            $array = array(
                'PEQI_WEBSITE' => PEQI_WEBSITE,
                'PEQI_DEBUG' => defined('PEQI_DEBUG') && PEQI_DEBUG === true ? true : false,
            );

            wp_localize_script('peqiapp-script', 'PEQIAPP_VAR', $array);
        }
    }
}

/**
 * Instancia a classe principal do plugin
 */
if (class_exists('PeqiApp')) {
    register_activation_hook(__FILE__, array('PeqiApp', 'activate'));
    register_deactivation_hook(__FILE__, array('PeqiApp', 'deactivate'));

    $peqiapp = new PeqiApp();
}
