<?php

/**
 * REQUIRE FILES
 */
require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/helpers.php";
require_once __DIR__ . "/session.php";

/**
 * DEFINE URL
 */
if (!defined('URL_CONFIG_FOLDER')) define('URL_CONFIG_FOLDER', 'app/config');
if (!defined('URL_PROTOCOL')) define('URL_PROTOCOL', '//');
if (!defined('URL_DOMAIN')) define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
if (!defined('URL_SUB_FOLDER')) define('URL_SUB_FOLDER', str_replace(URL_CONFIG_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
if (!defined('URL')) define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);

/**
 * DEFINE MAILTRAP CREDENTIALS
 */
if (!defined('MAILTRAP_USERNAME')) define('MAILTRAP_USERNAME', 'your_mailtrap_username');
if (!defined('MAILTRAP_PASSWORD')) define('MAILTRAP_PASSWORD', 'your_mailtrap_password');

/**
 * DEFINE DATABASE CREDENTIALS
 */
if (!defined('DB_TYPE')) define('DB_TYPE', 'mysql');
// if (!defined('DB_HOST')) define('DB_HOST', '127.0.0.1');
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_PORT')) define('DB_PORT', '3306');
if (!defined('DB_NAME')) define('DB_NAME', 'farmstand');
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', '');
if (!defined('DB_CHARSET')) define('DB_CHARSET', 'utf8mb4');
if (!defined('DB_COLLATION')) define('DB_COLLATION', 'utf8mb4_general_ci');


/**
 * CONNECT TO DATABASE (using Medoo namespace)
 */

use Medoo\Medoo;

$db = new Medoo([
  // [required]
  'type'       => DB_TYPE,
  'host'       => DB_HOST,
  'database'   => DB_NAME,
  'username'   => DB_USER,
  'password'   => DB_PASS,

  // [optional]
  'charset'   => DB_CHARSET,
  'collation' => DB_COLLATION,
  'port'      => DB_PORT,

  // [optional] Table prefix, all table names will be prefixed as PREFIX_table.
  'prefix' => '',

  // [optional] Enable logging, it is disabled by default for better performance.
  'logging' => true,

  // [optional]
  // Error mode
  // Error handling strategies when error is occurred.
  // PDO::ERRMODE_SILENT (default) | PDO::ERRMODE_WARNING | PDO::ERRMODE_EXCEPTION
  // Read more from https://www.php.net/manual/en/pdo.error-handling.php.
  'error' => PDO::ERRMODE_SILENT,

  // [optional]
  // The driver_option for connection.
  // Read more from http://www.php.net/manual/en/pdo.setattribute.php.
  'option' => [
    PDO::ATTR_CASE => PDO::CASE_NATURAL
  ],

  // [optional] Medoo will execute those commands after connected to the database.
  'command' => [
    'SET SQL_MODE=ANSI_QUOTES'
  ]
]);
