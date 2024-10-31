<?php

/**
 * Sai se o arquivo é chamado diretamente ou não
 */
defined('ABSPATH') || exit;

if (!class_exists('Peqiapp_Pages')) {
    class Peqiapp_Pages
    {

        /**
         * Construtor da classe
         */
        function __construct()
        {
            $this->init_hooks();
        }

        /**
         * Inicializa os hooks do plugin
         */
        private function init_hooks()
        {
            add_action('admin_menu', array(__CLASS__, 'add_plugin_pages'), 10);
        }

        /**
         * Define o cookie da última página acessada
         */
        public function set_cookie($page)
        {
            setcookie("peqiapp_lastpage", $page, time() + (86400 * 30), "/");
        }

        /**
         * Adiciona o menu do plugin
         */
        public static function add_plugin_pages()
        {
            add_menu_page('PeqiApp', 'PeqiApp', 'manage_options', 'peqiapp', array(__CLASS__, 'peqi_init_page'), PEQIAPP_URL . 'assets/images/icon.svg');

            add_submenu_page(null, 'PeqiApp', 'Dashboard', 'manage_options', 'peqiapp-dashboard', array(__CLASS__, 'peqi_dashboard_page'));
            add_submenu_page(null, 'PeqiApp', 'Sign-In', 'manage_options', 'peqiapp-login', array(__CLASS__, 'peqi_login_page'));
            add_submenu_page(null, 'PeqiApp', 'Register', 'manage_options', 'peqiapp-register', array(__CLASS__, 'peqi_register_page'));
            add_submenu_page(null, 'PeqiApp', 'Survey', 'manage_options', 'peqiapp-survey', array(__CLASS__, 'peqi_survey_page'));
            add_submenu_page(null, 'PeqiApp', 'Check Domain', 'manage_options', 'peqiapp-check-domain', array(__CLASS__, 'peqi_check_domain_page'));
            add_submenu_page(null, 'PeqiApp', 'Results Preview', 'manage_options', 'peqiapp-results', array(__CLASS__, 'peqi_results_page'));
            add_submenu_page(null, 'PeqiApp', 'No Website', 'manage_options', 'peqiapp-nowebsite', array(__CLASS__, 'peqi_nowebsite_page'));
            add_submenu_page(null, 'PeqiApp', 'Awaiting Payment', 'manage_options', 'peqiapp-awaiting', array(__CLASS__, 'peqi_awaiting_page'));
            add_submenu_page(null, 'PeqiApp', 'Payment Successful', 'manage_options', 'peqiapp-success', array(__CLASS__, 'peqi_success_page'));
        }

        /**
         * Verifica se o usuário está autenticado
         */
        public static function is_user_authenticated()
        {
            if (defined('PEQI_DOMAIN_KEY') && defined('PEQI_DOMAIN_ID') && PEQI_DOMAIN_KEY && PEQI_DOMAIN_ID) {
                return true;
            }
            return false;
        }

        /**
         * Verifica se o usuário está no onboarding
         */
        public static function in_onboard()
        {
            if (defined('PEQI_CHECKPOINT') && PEQI_CHECKPOINT === 'check-domain') {
                return 'check-domain';
            } elseif (defined('PEQI_CHECKPOINT') && PEQI_CHECKPOINT === 'results-preview') {
                return 'results-preview';
            } elseif (defined('PEQI_CHECKPOINT') && PEQI_CHECKPOINT === 'awaiting-payment') {
                return 'awaiting-payment';
            } elseif (defined('PEQI_CHECKPOINT') && PEQI_CHECKPOINT === 'payment-success') {
                return 'payment-success';
            }
        }

        /**
         * Página Inicial
         */
        public static function peqi_init_page()
        {
            if (defined('PEQI_CHECKPOINT') && PEQI_CHECKPOINT === 'check-domain') {
                echo '<script>window.location.href = "' . admin_url('admin.php?page=peqiapp-check-domain') . '";</script>';
                exit;
            } elseif (defined('PEQI_CHECKPOINT') && PEQI_CHECKPOINT === 'results-preview') {
                echo '<script>window.location.href = "' . admin_url('admin.php?page=peqiapp-results') . '";</script>';
                exit;
            } elseif (defined('PEQI_CHECKPOINT') && PEQI_CHECKPOINT === 'awaiting-payment') {
                echo '<script>window.location.href = "' . admin_url('admin.php?page=peqiapp-awaiting') . '";</script>';
                exit;
            } elseif (defined('PEQI_CHECKPOINT') && PEQI_CHECKPOINT === 'payment-success') {
                echo '<script>window.location.href = "' . admin_url('admin.php?page=peqiapp-success') . '";</script>';
                exit;
            }


            if (!self::is_user_authenticated()) {
                echo '<script>window.location.href = "' . admin_url('admin.php?page=peqiapp-login') . '";</script>';
                exit;
            }

            include PEQIAPP_PATH . 'pages/dashboard.php';
        }

        /**
         * Página de Login do Usuário
         */
        public static function peqi_login_page()
        {
            include PEQIAPP_PATH . 'pages/signin.php';
        }

        /**
         * Página de Registrar Usuário
         */
        public static function peqi_register_page()
        {
            include PEQIAPP_PATH . 'pages/register.php';
        }

        /**
         * Página de Pesquisa
         */
        public static function peqi_survey_page()
        {
            include PEQIAPP_PATH . 'pages/survey.php';
        }

        /**
         * Página de Checar Domínio
         */
        public static function peqi_check_domain_page()
        {
            include PEQIAPP_PATH . 'pages/check.php';
        }

        /**
         * Página de Resultados GTMetrix
         */
        public static function peqi_results_page()
        {
            include PEQIAPP_PATH . 'pages/results.php';
        }

        /**
         * Página do Dashboard
         */
        public static function peqi_dashboard_page()
        {
            include PEQIAPP_PATH . 'pages/dashboard.php';
        }

        /**
         * Página de Domínio Não Encontrado
         */
        public static function peqi_nowebsite_page()
        {
            include PEQIAPP_PATH . 'pages/no_website.php';
        }

        /**
         * Página de Aguardando Pagamento
         */
        public static function peqi_awaiting_page()
        {
            include PEQIAPP_PATH . 'pages/awaiting.php';
        }

        /**
         * Página de Sucesso no Pagamento
         */
        public static function peqi_success_page()
        {
            include PEQIAPP_PATH . 'pages/success.php';
        }

        /**
         * Passa variáveis do PHP para o script JS
         */
        public function javascript_variables()
        {
            wp_localize_script('peqiapp-script', 'PEQIAPP_VAR', array('PEQI_WEBSITE' => PEQI_WEBSITE));
        }
    }

    new Peqiapp_Pages();
}
?>
