<?php

ini_set('display_errors', 'On');
ini_set('html_errors', 'On');
ini_set('xdebug.trace_output_name', 'telemetry.%t');
ini_set('xdebug.trace_format', 1);

define('DIRSEP', DIRECTORY_SEPARATOR);

$url_root = $_SERVER['SCRIPT_NAME'];
$url_root = implode('/', explode('/', $url_root, -1));
$css_path = $url_root . '/css/standard.css';

$script_filename = $_SERVER["SCRIPT_FILENAME"];
$arr_script_filename = explode('/' , $script_filename, '-1');
$script_path = implode('/', $arr_script_filename) . '/';

define('CSS_PATH', $css_path);
define('APP_NAME', 'telemetry');
define('LANDING_PAGE', $url_root);

define('SMSUSER', '22_2610018');
define('SMSPASS', 'BearLeoTy2108?');
define('MSISDN', '781781419');
define('COUNTRY_CODE', '44');

$wsdl = 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl';
define('WSDL', $wsdl);

$settings = [
    "settings" => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        'mode' => 'development',
        'debug' => true,
        'class_path' => __DIR__ . '/src/',
        'view' => [
            'template_path' => __DIR__ . '/layouts/',
            'twig' => [
                'cache' => false,
                'auto_reload' => true,
            ]],

        'pdo_settings' => [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'telemetry_db',
            'port' => '3306',
            'user_name' => 'telemetry_user',
            'user_password' => 'telemetry_user_pass',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'max_packet_size' => 1024,
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ]
    ],

];

return $settings;