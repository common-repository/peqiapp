<?php

/**
 * Sai se o arquivo é chamado diretamente ou não
 */
defined('ABSPATH') || exit;

if (!class_exists('PeqiApp_Functions')) {
    class PeqiApp_Functions
    {
        public static $peqi_token;
        public static $peqi_domain_key;
        public static $peqi_domain_fqdn;
        public static $peqi_domain_id;
        public static $peqi_user_name;
        public static $peqi_user_email;
        public static $peqi_checkpoint;

        /**
         * Construtor da classe 
         */
        function __construct()
        {
            $this->define_variables();
            $this->define_constants();
            $this->define_actions();
        }

        /**
         * Define as constantes do plugin
         */
        public function define_constants()
        {
            if (!defined('PEQI_TOKEN')) {
                define('PEQI_TOKEN', self::$peqi_token);
            }
            if (!defined('PEQI_DOMAIN_KEY')) {
                define('PEQI_DOMAIN_KEY', self::$peqi_domain_key);
            }
            if (!defined('PEQI_DOMAIN_FQDN')) {
                define('PEQI_DOMAIN_FQDN', self::$peqi_domain_fqdn);
            }
            if (!defined('PEQI_DOMAIN_ID')) {
                define('PEQI_DOMAIN_ID', self::$peqi_domain_id);
            }
            if (!defined('PEQI_USER_NAME')) {
                define('PEQI_USER_NAME', self::$peqi_user_name);
            }
            if (!defined('PEQI_USER_EMAIL')) {
                define('PEQI_USER_EMAIL', self::$peqi_user_email);
            }
            if (!defined('PEQI_CHECKPOINT')) {
                define('PEQI_CHECKPOINT', self::$peqi_checkpoint);
            }
        }

        /**
         * Define as variáveis do plugin
         */
        public function define_variables()
        {
            self::$peqi_token = get_option('peqi_token');
            self::$peqi_domain_key = get_option('peqi_domain_key');
            self::$peqi_domain_fqdn = get_option('peqi_domain_fqdn');
            self::$peqi_domain_id = get_option('peqi_domain_id');
            self::$peqi_user_name = get_option('peqi_user_name');
            self::$peqi_user_email = get_option('peqi_user_email');
            self::$peqi_checkpoint = get_option('peqi_checkpoint');
        }

        /**
         * Define as actions do plugin
         */
        public function define_actions()
        {
            // Actions para os formulários
            add_action('admin_post_peqi_login_form', array('PeqiApp_Functions', 'peqi_login_form'));
            add_action('admin_post_peqi_register_form', array('PeqiApp_Functions', 'peqi_register_form'));
            add_action('admin_post_peqi_clear_cache', array('PeqiApp_Functions', 'peqi_clear_cache'));
            add_action('admin_post_peqi_check_form', array('PeqiApp_Functions', 'peqi_check_form'));
            add_action('admin_post_peqi_switch_account_form', array('PeqiApp_Functions', 'peqi_switch_account_form'));
            add_action('admin_post_peqi_change_level_form', array('PeqiApp_Functions', 'peqi_change_level_form'));
            add_action('admin_post_peqi_activate_plan_form', array('PeqiApp_Functions', 'peqi_activate_plan_form'));
            add_action('admin_post_peqi_create_domain_form', array('PeqiApp_Functions', 'peqi_create_domain_form'));
            add_action('admin_post_peqi_pointed_domain_form', array('PeqiApp_Functions', 'peqi_pointed_domain_form'));

            // Action ao limpar o cache
            add_action('schedule_task', array('PeqiApp_API', 'clear_cache'));

            // Action ao criar, editar ou deletar um post
            add_action('save_post', array('PeqiApp_Functions', 'schedule_clear_cache'));
            add_action('delete_post', array('PeqiApp_Functions', 'schedule_clear_cache'));

            // Action ao criar, editar ou deletar uma página
            add_action('save_page', array('PeqiApp_Functions', 'schedule_clear_cache'));
            add_action('delete_page', array('PeqiApp_Functions', 'schedule_clear_cache'));

            // Action ao criar, editar ou deletar uma categoria
            add_action('save_category', array('PeqiApp_Functions', 'schedule_clear_cache'));
            add_action('delete_category', array('PeqiApp_Functions', 'schedule_clear_cache'));

            // Action ao criar, editar ou deletar uma tag
            add_action('save_post_tag', array('PeqiApp_Functions', 'schedule_clear_cache'));
            add_action('delete_post_tag', array('PeqiApp_Functions', 'schedule_clear_cache'));

            //Action ao trocar de tema
            add_action('switch_theme', array('PeqiApp_Functions', 'schedule_clear_cache'));
        }

        /**
         * Agenda o envio da solicitação de limpeza de cache
         */
        public static function schedule_clear_cache()
        {
            if (Peqiapp_Pages::is_user_authenticated()) {
                if (!wp_next_scheduled('schedule_task')) {
                    wp_schedule_single_event(time(), 'schedule_task');
                    spawn_cron();
                    sleep(1);
                }
            }
        }


        /**
         * Função Formulário de Login
         */
        public static function peqi_login_form()
        {
            $peqi_email = isset($_POST['peqi_email']) ? sanitize_text_field($_POST['peqi_email']) : '';
            $peqi_password = isset($_POST['peqi_password']) ? sanitize_text_field($_POST['peqi_password']) : '';

            try {
                // Verifica se os campos não estão vazios
                if (empty($peqi_email)) {
                    $error_login_mail = "E-mail cannot be blank.";
                    set_transient('peqi_error_login_mail', $error_login_mail, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-login'));
                    exit();
                }
                if (empty($peqi_password)) {
                    $error_login_password = "Password cannot be blank.";
                    set_transient('peqi_error_login_password', $error_login_password, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-login'));
                    exit();
                }

                // Chama o endpoint sign_in
                $response = PeqiApp_API::sign_in($peqi_email, $peqi_password);
                $response_body = json_decode(wp_remote_retrieve_body($response), true);
                $http_code = wp_remote_retrieve_response_code($response);

                if ($http_code === 200 && !empty($response_body['access'])) {
                    // Pegar o token access chamar o endpoint get_token
                    $access = $response_body['access'];

                    // Chama o endpoint get_token
                    $response_token = PeqiApp_API::get_token($access);
                    $response_token_body = json_decode(wp_remote_retrieve_body($response_token), true);
                    $response_token_code = wp_remote_retrieve_response_code($response_token);

                    // Se o endpoint get_token retornar uma key, salvar o email, name e key
                    if ($response_token_code === 200 && !empty($response_token_body['results'][0]['key'])) {
                        update_option('peqi_user_email', $peqi_email);
                        update_option('peqi_user_name', $response_body['name']);
                        update_option('peqi_token', $response_token_body['results'][0]['key']);

                        // Agora com a key, chamar o endpoint get_domain
                        $response_domain = PeqiApp_API::get_domain($response_token_body['results'][0]['key']);
                        $response_domain_body = json_decode(wp_remote_retrieve_body($response_domain), true);
                        $response_domain_code = wp_remote_retrieve_response_code($response_domain);

                        // Se o endpoint get_domain retornar um id e um fqdn, salvar o id e o fqdn
                        if ($response_domain_code === 200 && !empty($response_domain_body['results'][0]['id']) && !empty($response_domain_body['results'][0]['fqdn'])) {
                            update_option('peqi_domain_id', $response_domain_body['results'][0]['id']);
                            update_option('peqi_domain_fqdn', $response_domain_body['results'][0]['fqdn']);
                            update_option('peqi_domain_key', $response_domain_body['results'][0]['key']);

                            wp_redirect(admin_url('admin.php?page=peqiapp-dashboard'));
                            exit();
                        } elseif ($response_domain_code === 200 && empty($response_domain_body['results'])) {
                            // Cria o checkpoint check-domain
                            update_option('peqi_checkpoint', 'check-domain');
                            // Envia mensagem para o GChat
                            PeqiApp_Functions::send_event('plugin-account', get_option('peqi_user_email'));
                            PeqiApp_Functions::send_stage_gchat(2);
                            wp_redirect(admin_url('admin.php?page=peqiapp-check-domain'));
                            exit();
                        } else {
                            // Se o domínio não for válido, exibir um erro
                            $error_login = 'Your session has expired. Please log in again.';
                            set_transient('peqi_error_login', $error_login, 1);
                            wp_redirect(admin_url('admin.php?page=peqiapp-login'));
                            exit();
                        }
                    } elseif ($response_token_code === 401 && !empty($response_token_body['detail']) && $response_token_body['detail'] === 'Given token not valid for any token type') {
                        // Se o token estiver expirado, exibir um erro
                        $error_login = 'Your session has expired. Please log in again.';
                        set_transient('peqi_error_login', $error_login, 1);
                        wp_redirect(admin_url('admin.php?page=peqiapp-login'));
                        exit();
                    } else {
                        // Se o token não for válido, exibir um erro
                        $error_login = 'Your session has expired. Please log in again.';
                        set_transient('peqi_error_login', $error_login, 1);
                        wp_redirect(admin_url('admin.php?page=peqiapp-login'));
                        exit();
                    }
                } elseif ($http_code === 401 && !empty($response_body['detail']) && $response_body['detail'] === 'No active account found with the given credentials') {
                    // Se não encontrar uma conta ativa, exibir um erro
                    $error_login = 'E-mail or password is incorrect. Please try again.';
                    set_transient('peqi_error_login', $error_login, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-login'));
                    exit();
                } else {
                    // Se a autenticação falhar, exibir um erro
                    $error_login = 'Login failed. Please try again.';
                    set_transient('peqi_error_login', $error_login, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-login'));
                    exit();
                }
            } catch (Exception $e) {
                $error_login = $e->getMessage();
                set_transient('peqi_error_login', $error_login, 1);
                wp_redirect(admin_url('admin.php?page=peqiapp-login'));
                exit;
            }
        }

        /**
         * Função Formulário de Registro
         */
        public static function peqi_register_form()
        {
            $email = sanitize_text_field($_POST['peqi_email']);
            $name = sanitize_text_field($_POST['peqi_username']);
            $password = sanitize_text_field($_POST['peqi_password']);
            $phone = sanitize_text_field($_POST['peqi_country_code_phone']);

            try {
                // Verifica se os campos não estão vazios
                if (empty($email)) {
                    $error_register_mail = 'E-mail cannot be blank.';
                    set_transient('peqi_error_register_mail', $error_register_mail, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-register'));
                    exit();
                }

                if (empty($name)) {
                    $error_register_name = 'Full Name cannot be blank.';
                    set_transient('peqi_error_register_name', $error_register_name, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-register'));
                    exit();
                }

                if (empty($phone)) {
                    $error_register_phone = 'Phone number cannot be blank.';
                    set_transient('peqi_error_register_phone', $error_register_phone, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-register'));
                    exit();
                }

                if (empty($password)) {
                    $error_register_password = 'Password cannot be blank.';
                    set_transient('peqi_error_register_password', $error_register_password, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-register'));
                    exit();
                }

                // Chama o endpoint register
                $response = PeqiApp_API::register($email, $name, $phone, $password);
                $response_body = json_decode(wp_remote_retrieve_body($response), true);
                $http_code = wp_remote_retrieve_response_code($response);

                if ($http_code === 201) {
                    // Se o registro for bem-sucedido, efetuar o login e redirecionar para a página de validação de domínio
                    $response_login = PeqiApp_API::sign_in($email, $password);
                    $response_login_body = json_decode(wp_remote_retrieve_body($response_login), true);
                    $http_code_login = wp_remote_retrieve_response_code($response_login);

                    if ($http_code_login === 200 && !empty($response_login_body['access'])) {
                        // Pegar o token access chamar o endpoint get_token
                        $access = $response_login_body['access'];

                        // Chama o endpoint get_token
                        $response_token = PeqiApp_API::get_token($access);
                        $response_token_body = json_decode(wp_remote_retrieve_body($response_token), true);
                        $response_token_code = wp_remote_retrieve_response_code($response_token);

                        // Se o endpoint get_token retornar uma key, salvar o email, name e key
                        if ($response_token_code === 200 && !empty($response_token_body['results'][0]['key'])) {
                            update_option('peqi_user_email', $email);
                            update_option('peqi_user_name', $response_login_body['name']);
                            update_option('peqi_token', $response_token_body['results'][0]['key']);

                            // Cria o checkpoint check-domain
                            update_option('peqi_checkpoint', 'check-domain');
                            // Envia mensagem para o GChat
                            PeqiApp_Functions::send_event('plugin-account', get_option('peqi_user_email'));
                            PeqiApp_Functions::send_stage_gchat(2);
                            // Redireciona para a página de validação de domínio
                            wp_redirect(admin_url('admin.php?page=peqiapp-check-domain'));
                        } else {
                            $success_message = true;
                            set_transient('peqi_success_register', $success_message, 1);
                            wp_redirect(admin_url('admin.php?page=peqiapp-login'));
                            exit();
                        }
                    } else {
                        $success_message = true;
                        set_transient('peqi_success_register', $success_message, 1);
                        wp_redirect(admin_url('admin.php?page=peqiapp-login'));
                        exit();
                    }
                } elseif ($http_code === 400 && !empty($response_body['email']) && $response_body['email'][0] === 'This field must be unique.') {
                    // Se o e-mail já estiver em uso, exibir um erro
                    $error_register_mail = "This e-mail is already in use. Please try another one.";
                    set_transient('peqi_error_register_mail', $error_register_mail, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-register'));
                    exit();
                } else {
                    // Se o registro falhar, exibir um erro
                    $error_register = 'Registration failed. Please try again.';
                    set_transient('peqi_error_register', $error_register, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-register'));
                    exit();
                }
            } catch (Exception $e) {
                $error_register = $e->getMessage();
                set_transient('peqi_error_register', $error_register, 1);
                wp_redirect(admin_url('admin.php?page=peqiapp-register'));
                exit;
            }
        }

        /**
         * Função Formulário Limpar Cache
         */
        public static function peqi_clear_cache()
        {
            try {
                // Chama o endpoint clear_cache
                $response = PeqiApp_API::clear_cache(true);
                $http_code = wp_remote_retrieve_response_code($response);

                if ($http_code === 200) {
                    // Se o cache for limpo com sucesso, redirecionar para a página de dashboard
                    $success_clear_cache = 'Cache cleared successfully.';
                    set_transient('peqi_success_clear_cache', $success_clear_cache, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-dashboard'));
                    exit();
                } else {
                    // Se o cache não for limpo, exibir um erro
                    $error_clear_cache = 'Failed to clear cache. Please try again.';
                    set_transient('peqi_error_clear_cache', $error_clear_cache, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-dashboard'));
                    exit();
                }
            } catch (Exception $e) {
                $error_clear_cache = $e->getMessage();
                set_transient('peqi_error_clear_cache', $error_clear_cache, 1);
                wp_redirect(admin_url('admin.php?page=peqiapp-dashboard'));
                exit;
            }
        }

        /**
         * Função Formulário de Validação de Domínio
         */
        public static function peqi_check_form()
        {
            $peqi_website = isset($_POST['peqi_website']) ? sanitize_text_field($_POST['peqi_website']) : '';

            try {
                // Verifica se o campo não está vazio
                if (empty($peqi_website)) {
                    $error_check_website = 'Website URL cannot be blank.';
                    set_transient('peqi_error_check_website', $error_check_website, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-check-domain'));
                    exit();
                }

                // Chama o endpoint check_website
                $response = PeqiApp_API::validate_domain($peqi_website);
                $response_body = json_decode(wp_remote_retrieve_body($response), true);
                $http_code = wp_remote_retrieve_response_code($response);


                if ($response_body['status']) {
                    // Pegar o resultado da validação e salvar em um transient
                    set_transient('peqi_validation_results', $response_body['results'], 10);
                    // Envia mensagem para o GChat
                    PeqiApp_Functions::send_event('plugin-validate', PEQI_WEBSITE);
                    PeqiApp_Functions::send_stage_gchat(3);
                    wp_redirect(admin_url('admin.php?page=peqiapp-check-domain'));
                    exit();
                } else {
                    // Se a verificação falhar, exibir um erro
                    $error_message = 'Failed to validate website. Please try again.';
                    set_transient('peqi_error_check_website', $error_message, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-check-domain'));
                    exit();
                }
            } catch (Exception $e) {
                $error_check_website = $e->getMessage();
                set_transient('peqi_error_check_website', $error_check_website, 1);
                wp_redirect(admin_url('admin.php?page=peqiapp-check-domain'));
                exit;
            }
        }

        /**
         * Função Formulário de Alteração de Nível de Otimização
         */
        public static function peqi_change_level_form()
        {
            $scripts_level = sanitize_text_field($_POST['combo-box-scripts']);
            $images_level = sanitize_text_field($_POST['combo-box-images']);
            $styles_level = sanitize_text_field($_POST['combo-box-styles']);
            $includes_level = sanitize_text_field($_POST['combo-box-includes']);

            try {
                // Chama o endpoint change_optimization
                $response = PeqiApp_API::change_optimization($scripts_level, $images_level, $styles_level, $includes_level);
                $http_code = wp_remote_retrieve_response_code($response);

                if ($http_code === 200) {
                    // Se o nível de otimização for alterado com sucesso, redirecionar para a página de dashboard
                    $success_change_level = 'Optimization level updated successfully.';
                    set_transient('peqi_success_change_level', $success_change_level, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-dashboard'));
                    exit();
                } else {
                    // Se a alteração do nível de otimização falhar, exibir um erro
                    $error_change_level = 'Failed to update optimization level. Please try again.';
                    set_transient('peqi_error_change_level', $error_change_level, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-dashboard'));
                    exit();
                }
            } catch (Exception $e) {
                $error_change_level = $e->getMessage();
                set_transient('peqi_error_change_level', $error_change_level, 1);
                wp_redirect(admin_url('admin.php?page=peqiapp-dashboard'));
                exit;
            }
        }

        /**
         * Função Formulário Ativar Plano
         */
        public static function peqi_activate_plan_form()
        {
            if (defined('PEQI_DEBUG') && PEQI_DEBUG === true) {
                $plan_trial = "price_1OZdPuJUpNS565Y8EpmNx5fN";
            } else {
                $plan_trial = "price_1OoXpcJUpNS565Y8337IJIDk";
            }

            try {
                // Chama o endpoint activate_plan
                $response = PeqiApp_API::create_checkout($plan_trial);
                $response_body = json_decode(wp_remote_retrieve_body($response), true);
                $http_code = wp_remote_retrieve_response_code($response);

                if ($http_code === 200) {
                    // Se o plano for ativado com sucesso, redirecionar para a página de pagamento
                    $payment_url = $response_body['url'];
                    set_transient('peqi_payment_url', $payment_url, 60);

                    // Atualiza o checkpoint de awaiting-payment
                    update_option('peqi_checkpoint', 'awaiting-payment');
                    // Envia mensagem para o GChat
                    PeqiApp_Functions::send_event('plugin-payment', PEQI_WEBSITE);
                    PeqiApp_Functions::send_event('plugin-awaiting', PEQI_WEBSITE);
                    PeqiApp_Functions::send_stage_gchat(7);
                    wp_redirect(admin_url('admin.php?page=peqiapp-awaiting'));
                    exit();
                } else {
                    // Se a ativação do plano falhar, exibir um erro
                    $error_activate_plan = 'Failed to activate plan. Please try again.';
                    set_transient('peqi_error_activate_plan', $error_activate_plan, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-results'));
                    exit();
                }
            } catch (Exception $e) {
                $error_activate_plan = $e->getMessage();
                set_transient('peqi_error_activate_plan', $error_activate_plan, 1);
                wp_redirect(admin_url('admin.php?page=peqiapp-results'));
                exit;
            }
        }

        /**
         * Função Formulário Criar Domínio
         */
        public static function peqi_create_domain_form()
        {
            $fqdn = sanitize_text_field($_POST['peqi_website']);
            $ip_address = sanitize_text_field($_POST['ip_address']);

            try {
                // Chama o endpoint create_domain
                if (empty($ip_address)) {
                    $response = PeqiApp_API::create_domain($fqdn);
                } else {
                    $response = PeqiApp_API::create_domain($fqdn, $ip_address);
                }
                $response_body = json_decode(wp_remote_retrieve_body($response), true);
                $http_code = wp_remote_retrieve_response_code($response);

                if ($http_code === 201) {
                    // Se o domínio for criado com sucesso, redirecionar para a página de resultados
                    update_option('peqi_domain_id', $response_body['id']);
                    update_option('peqi_domain_fqdn', $response_body['fqdn']);
                    update_option('peqi_domain_key', $response_body['key']);

                    // Atualiza o checkpoint results-preview
                    update_option('peqi_checkpoint', 'results-preview');
                    // Envia mensagem para o GChat
                    PeqiApp_Functions::send_event('plugin-domain', PEQI_WEBSITE);
                    PeqiApp_Functions::send_event('plugin-preview', PEQI_WEBSITE);
                    PeqiApp_Functions::send_stage_gchat(5);
                    wp_redirect(admin_url('admin.php?page=peqiapp-results'));
                    exit();
                } elseif ($http_code === 400 && !empty($response_body['fqdn']) && $response_body['fqdn'][0] === 'Domain FQDN already being used.') {
                    // Se o domínio já estiver em uso, exibir um erro
                    $error_create_domain = 'This domain is already in use. Please try another one.';
                    set_transient('peqi_error_create_domain', $error_create_domain, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-check-domain'));
                    exit();
                } elseif ($http_code === 400 && !empty($response_body['ipaddr']) && $response_body['ipaddr'][0] === 'Invalid IP Address') {
                    // Se o domínio já estiver em uso, exibir um erro
                    $error_create_domain = 'This IP Address is invalid. Please try another one.';
                    set_transient('peqi_error_create_domain', $error_create_domain, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-check-domain'));
                    exit();
                } else {
                    // Se a criação do domínio falhar, exibir um erro
                    $error_create_domain = 'Failed to create domain. Please try again.';
                    set_transient('peqi_error_create_domain', $error_create_domain, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-check-domain'));
                    exit();
                }
            } catch (Exception $e) {
                $error_create_domain = $e->getMessage();
                set_transient('peqi_error_create_domain', $error_create_domain, 1);
                wp_redirect(admin_url('admin.php?page=peqiapp-check-domain'));
                exit;
            }
        }

        /**
         * Função Formulário de Domínio Apontado
         */
        public static function peqi_pointed_domain_form()
        {
            try {
                $response = PeqiApp_API::active_domain();
                $response_body = json_decode(wp_remote_retrieve_body($response), true);
                $http_code = wp_remote_retrieve_response_code($response);

                if ($http_code === 200 && $response_body['status'] === 'success') {
                    //Remove o checkpoint check-domain
                    update_option('peqi_checkpoint', '');
                    // Envia mensagem para o GChat
                    PeqiApp_Functions::send_event('plugin-dns', PEQI_WEBSITE);
                    PeqiApp_Functions::send_stage_gchat(9);
                    wp_redirect(admin_url('admin.php?page=peqiapp-dashboard'));
                } elseif ($http_code === 200 && $response_body['status'] === 'error') {
                    // Se o domínio não estiver apontado, exibir um erro
                    $error_pointed_domain = 'Domain not pointing to Peqi. Await ammount of time and try again.';
                    set_transient('peqi_error_pointed_domain', $error_pointed_domain, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-success'));
                    exit();
                } else {
                    // Se a verificação falhar, exibir um erro
                    $error_pointed_domain = 'Failed to check domain. Please try again.';
                    set_transient('peqi_error_pointed_domain', $error_pointed_domain, 1);
                    wp_redirect(admin_url('admin.php?page=peqiapp-success'));
                    exit();
                }
            } catch (Exception $e) {
                $error_pointed_domain = $e->getMessage();
                set_transient('peqi_error_pointed_domain', $error_pointed_domain, 1);
                wp_redirect(admin_url('admin.php?page=peqiapp-success'));
                exit;
            }
        }

        /**
         * Função Formulário de Desconexão
         */
        public static function peqi_switch_account_form()
        {
            update_option('peqi_token', '');
            update_option('peqi_domain_key', '');
            update_option('peqi_domain_fqdn', '');
            update_option('peqi_domain_id', '');
            update_option('peqi_user_name', '');
            update_option('peqi_user_email', '');
            update_option('peqi_checkpoint', '');

            wp_redirect(admin_url('admin.php?page=peqiapp-login'));
            exit();
        }

        /**
         * Enviar stage para o GChat
         */
        public static function send_stage_gchat($stage)
        {
            $domain = sanitize_text_field($_SERVER['HTTP_HOST']);
            $current_user = wp_get_current_user();
            $email = $current_user->user_email;
            $plugin_version = PEQIAPP_VERSION;
            $php_version = phpversion();
            $wordpress_version = get_bloginfo('version');

            $stages = [
                1 => 'Installation Plugin',
                2 => 'Registration User',
                3 => 'Validation Domain',
                4 => 'Create Domain',
                5 => 'Report Preview',
                6 => 'Payment Plan',
                7 => 'Awaiting Payment',
                8 => 'Success Payment',
                9 => 'Pointed Domain',
            ];

            $last_stage = max(array_keys($stages));

            $message = "<b>Domain:</b> " . $domain . "\n"
            . "<b>E-mail:</b> " . $email . "\n"
            . "<b>Plugin Version:</b> " . $plugin_version . "\n"
            . "<b>PHP Version:</b> " . $php_version . "\n"
            . "<b>Wordpress Version:</b> " . $wordpress_version . "\n";

            foreach ($stages as $key => $stage_name) {
                if ($key < $stage) {
                    $message .= "✅ <b>" . $stage_name . "</b>\n";
                } elseif ($key == $stage) {
                    $emoji = ($stage == $last_stage) ? "✅" : "☑️";
                    $message .= $emoji . " <b>" . $stage_name . "</b>\n";
                } else {
                    $message .= "🔲 <b>" . $stage_name . "</b>\n";
                }
            }

            PeqiApp_Functions::send_gchat($message);
        }

        /**
         * Enviar mensagem para GChat
         */
        public static function send_gchat($message)
        {

            if (defined('PEQI_DEBUG') && PEQI_DEBUG === true) {
                return;
            }

            $url = 'https://chat.googleapis.com/v1/spaces/AAAAUAxxSBI/messages?key=AIzaSyDdI0hCZtE6vySjMm-WEfRq3CPzqKqqsHI&token=MpCcMzDdQyrJFAX9Ittwum2sGZNOboSFU0mQ-68eoOc';

            $data = array(
                'cards' => array(
                    array(
                        'header' => array(
                            'title' => '📣 Peqiapp Plugin Wordpress'
                        ),
                        'sections' => array(
                            array(
                                'widgets' => array(
                                    array(
                                        'textParagraph' => array(
                                            'text' => $message
                                        )
                                    )
                                )
                            )
                        )
                    )
                )
            );

            $args = array(
                'body' => wp_json_encode($data),
                'headers' => array(
                    'Content-Type' => 'application/json',
                ),
                'timeout' => 15,
            );

            $response = wp_remote_post($url, $args);

            if (is_wp_error($response)) {
                return false;
            }

            return true;
        }

        /**
         * Enviar evento para a API
         */
        public static function send_event($action, $target)
        {
            PeqiApp_API::create_event($action, $target);
            return true;
        }


        /**
         * Mostra um log no console do navegador.
         */
        public static function console($type, $title = null, $data = null)
        {
            if ($title !== null) {
                $title = esc_js($title);
            }

            if ($data !== null) {
                if (is_array($data)) {
                    $message = wp_json_encode($data);
                } else {
                    $message = $data;
                }
            } else {
                $message = null;
            }

            switch ($type) {
                case 'info':
                    $console_type = 'info';
                    break;
                case 'log':
                    $console_type = 'log';
                    break;
                case 'error':
                    $console_type = 'error';
                    break;
                case 'table':
                    $console_type = 'table';
                    break;
                case 'warn':
                    $console_type = 'warn';
                    break;
                default:
                    $console_type = 'log';
                    break;
            }

            // Prepara o log para ser executado no console do navegador
            $log_script = '';
            if ($title !== null && $message !== null) {
                $log_script = 'console.' . $console_type . '("' . $title . '", ' . $message . ');';
            } elseif ($title !== null && $message === null) {
                $log_script = 'console.' . $console_type . '("' . $title . '");';
            } elseif ($title === null && $message !== null) {
                $log_script = 'console.' . $console_type . '(' . $message . ');';
            }

            // Adiciona o script diretamente no output
            if (!empty($log_script)) {
                echo '<script>' . $log_script . '</script>';
            }
        }
    }
}
