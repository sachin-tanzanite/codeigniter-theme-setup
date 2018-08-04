<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* include table constants file */
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'tables_constants.php');

/* define base path and db details */
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    define('BASE_URL', 'http://localhost/questionnaire_app');
    define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/questionnaire_app/');


    define('DATABASE_HOST', '{##HOST##}');
    define('DATABASE_USER', '{##USER##}');
    define('DATABASE_PASSWORD', '{##PASSWORD##}');
    define('DATABASE_DATABASE_NAME', '{##DATABASE##}');

    error_reporting(E_ALL);
    ini_set('display_errors', true);
} else {
    define('BASE_URL', '');
    define('BASE_PATH', '');

    define('DATABASE_HOST', '{##HOST##}');
    define('DATABASE_USER', '{##USER##}');
    define('DATABASE_PASSWORD', '{##PASSWORD##}');
    define('DATABASE_DATABASE_NAME', '{##DATABASE##}');
    
    error_reporting(0);
    ini_set('display_errors', false);
}

/* include phpmailer */
require_once(BASE_PATH . "PHPMailer-master/PHPMailerAutoload.php");

/* define api base path */
define('API_BASE_PATH', '/api/');

/* define app details */
define('APP_EMAIL', '');
define('APP_NAME', '');

/* user status */
define('STATUS_INACTIVE', '0');
define('STATUS_ACTIVE', '1');

$_USER_STATUS[STATUS_INACTIVE] = array('title' => 'In Active', 'class' => 'danger');
$_USER_STATUS[STATUS_ACTIVE] = array('title' => 'Active', 'class' => 'success');

$config['user_status'] = $_USER_STATUS;
?>