<?php

/**
 * Sai se o arquivo é chamado diretamente ou não
 */
defined('WP_UNINSTALL_PLUGIN') || exit;

/**
 * Remove as opções do plugin
 */
delete_option('peqi_token', '');
delete_option('peqi_user_name', '');
delete_option('peqi_user_email', '');
delete_option('peqi_domain_id', '');
delete_option('peqi_domain_fqdn', '');
delete_option('peqi_domain_key', '');
delete_option('peqi_checkpoint', '');
