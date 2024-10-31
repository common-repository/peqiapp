<?php

/**
 * Sai se o arquivo é chamado diretamente ou não
 * 
 */
defined('ABSPATH') || exit;

if (!class_exists('PeqiApp_API')) {
    class PeqiApp_API
    {
        /**
         * Construtor da classe
         */
        function __construct()
        {
        }

        /**
         * Efetuar autenticação (POST /auth/token/)
         */
        public static function sign_in($email, $password)
        {
            $url = PEQI_API_URL . PEQI_ENDPOINT_AUTH;

            $args = array(
                'body' => array(
                    'email' => $email,
                    'password' => $password,
                ),
            );

            $response = wp_remote_post($url, $args);

            return $response;
        }

        /**
         * Pegar token de autenticação (GET /tokens/)
         */
        public static function get_token($jwt)
        {
            $url = PEQI_API_URL . PEQI_ENDPOINT_TOKEN;

            $args = array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $jwt,
                    'Content-Type' => 'application/json',
                ),
            );

            $response = wp_remote_get($url, $args);

            return $response;
        }

        /**
         * Registrar um novo usuário (POST /users/)
         */
        public static function register($email, $name, $phone, $password)
        {
            $url = PEQI_API_URL . PEQI_ENDPOINT_USER;

            $args = array(
                'body' => json_encode(array(
                    'email' => $email,
                    'name' => $name,
                    'phone' => $phone,
                    'password' => $password,
                )),
                'headers' => array(
                    'Content-Type' => 'application/json',
                ),
            );

            $response = wp_remote_post($url, $args);
            
            return $response;
        }

        /**
         * Criar um novo domínio (POST /domains/)
         */
        public static function create_domain($domain, $ip_address = null)
        {
            $url = PEQI_API_URL . PEQI_ENDPOINT_DOMAIN;

            $body = array(
                    'fqdn' => $domain,
            );

            if ($ip_address !== null) {
                $body['ipaddr'] = $ip_address;
            }

            $args = array(
                'body' => json_encode($body),
                'headers' => array(
                    'Authorization' => 'Token ' . PEQI_TOKEN,
                    'Content-Type' => 'application/json',
                ),
            );

            $response = wp_remote_post($url, $args);

            return $response;
        }

        /**
         * Pegar informações do domínio (GET /domains/)
         */
        public static function get_domain($token)
        {
            $url = PEQI_API_URL . PEQI_ENDPOINT_DOMAIN . '?fqdn=' . PEQI_WEBSITE;

            $args = array(
                'headers' => array(
                    'Authorization' => 'Token ' . $token,
                ),
            );

            $response = wp_remote_get($url, $args);

            return $response;
        }

        /**
         * Validar domínio (POST /domains/validate/)
         */
        public static function validate_domain($website)
        {
            $url = PEQI_API_URL . PEQI_ENDPOINT_DOMAIN . 'validate/';

            $data = array(
                'url' => $website,
                'skip_framework' => true,
            );

            $args = array(
                'headers' => array(
                    'Authorization' => 'Token ' . PEQI_TOKEN,
                ),
                'body' => $data,
            );


            $response = wp_remote_post($url, $args);

            return $response;
        }

        /**
         * Confirmar apontamento do domínio (GET /domains/{domain_id}/point/)
         */
        public static function active_domain()
        {
            $url = PEQI_API_URL . PEQI_ENDPOINT_DOMAIN . PEQI_DOMAIN_ID . '/activate/';

            $args = array(
                'headers' => array(
                    'Authorization' => 'Token ' . PEQI_TOKEN,
                ),
            );

            $response = wp_remote_get($url, $args);

            return $response;
        }     

        /**
         * Limpar o cache do domínio (PURGE /domains/{domain_id}/)
         */
        public static function clear_cache($full = false)
        {
            if ($full) {
                $url = PEQI_API_URL . PEQI_ENDPOINT_DOMAIN . PEQI_DOMAIN_ID . '/?key=' . PEQI_DOMAIN_KEY . '&full=true';
            } else {
                $url = PEQI_API_URL . PEQI_ENDPOINT_DOMAIN . PEQI_DOMAIN_ID . '/?key=' . PEQI_DOMAIN_KEY;
            }
            
            $args = array(
                'method'      => 'PURGE',
                'headers'     => array(
                    'Authorization' => 'Token ' . PEQI_TOKEN,
                ),
            );

            $response = wp_remote_request($url, $args);

            return $response;
        }

        /**
         * Alterar level de otimização (PATCH /domains/{domain_id}/)
         */
        public static function change_optimization($scripts_level, $images_level, $styles_level, $includes_level)
        {
            $url = PEQI_API_URL . PEQI_ENDPOINT_DOMAIN . PEQI_DOMAIN_ID . '/';

            $args = array(
                'body' => json_encode(array(
                    'scripts_level' => $scripts_level,
                    'images_level' => $images_level,
                    'styles_level' => $styles_level,
                    'includes_level' => $includes_level
                )),
                'method'      => 'PATCH',
                'headers'     => array(
                    'Authorization' => 'Token ' . PEQI_TOKEN,
                    'Content-Type' => 'application/json',
                ),
            );

            $response = wp_remote_request($url, $args);

            return $response;
        }

        /**
         * Solicitar relatórios no GTMetrix (GET /domains/{domain_id}/reports/ ou GET /domains/{domain_id}/reports/?origin=true)
         */
        public static function get_reports($origin = false)
        {
            if ($origin) {
                $url = PEQI_API_URL . PEQI_ENDPOINT_DOMAIN . PEQI_DOMAIN_ID . '/reports/?origin=true';
            } else {
                $url = PEQI_API_URL . PEQI_ENDPOINT_DOMAIN . PEQI_DOMAIN_ID . '/reports/';
            }

            $args = array(
                'headers' => array(
                    'Authorization' => 'Token ' . PEQI_TOKEN,
                    'Content-Type' => 'application/json',
                ),
            );

            $response = wp_remote_get($url, $args);

            return $response;
        }

        /**
         * Buscar planos disponíveis (GET /plans/)
         */
        public static function get_plans()
        {
            $url = PEQI_API_URL . PEQI_ENDPOINT_PLANS;

            $args = array(
                'headers' => array(
                    'Authorization' => 'Token ' . PEQI_TOKEN,
                    'Content-Type' => 'application/json',
                ),
            );

            $response = wp_remote_get($url, $args);

            return $response;
        }

        /**
         * Criar link de pagamento (POST /checkout/)
         */
        public static function create_checkout($plan_id)
        {
            $url = PEQI_API_URL . PEQI_ENDPOINT_CHECKOUT;

            $args = array(
                'body' => json_encode(array(
                    'plan' => $plan_id,
                )),
                'headers' => array(
                    'Authorization' => 'Token ' . PEQI_TOKEN,
                    'Content-Type' => 'application/json',
                ),
            );

            $response = wp_remote_post($url, $args);

            return $response;
        }

        /**
         * Criar eventos (POST /events/)
         */
        public static function create_event($action, $target)
        {
            $url = PEQI_API_URL . PEQI_ENDPOINT_EVENTS;

            $headers = array(
                'Content-Type' => 'application/json',
            );

            if ($action !== 'plugin-install' && $action !== 'plugin-account') {
                $headers['Authorization'] = 'Token ' . PEQI_TOKEN;
            }

            $args = array(
                'body' => json_encode(array(
                    'action' => $action,
                    'target' => $target,
                )),
                'headers' => $headers,
            );

            $response = wp_remote_post($url, $args);

            return $response;
        }
    }
}
