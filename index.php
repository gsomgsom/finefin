<?php
/**
 * Fine Finances
 *
 * @copyright     2012 Zhelnin Evgeniy
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 * @author        Zhelnin Evgeniy (evgeniy@zhelnin.perm.ru)
 * @version       1.0
 * @package       finefin
 */

// Debug only
ini_set('display_errors', 1);
error_reporting(E_ALL);
//ini_set('display_errors', 0);
//error_reporting(E_NONE);

date_default_timezone_set('Europe/Moscow');

define('PATH_APPLICATION', dirname(__FILE__).'/application');
define('PATH_ENGINE', dirname(__FILE__).'/engine');

define('USER_SALT',  '8a7ebc9f');

define('DB_HOST',    'localhost');
define('DB_PORT',    3306);
define('DB_USER',    'user');
define('DB_PASS',    'pass');
define('DB_NAME',    'finefin');
define('DB_CHARSET', 'utf8');

// Parse query and routing
// http://host/controller/action/dir/../subdirX/?param1=1&param2=2&...&paramX=x
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
$url = "http://".$host.$_SERVER['REQUEST_URI'];
$temp_url = parse_url($url);
$dirs = explode('/', $temp_url['path']);
isset($temp_url['query']) && parse_str($temp_url['query'], $_GET);
$_GET['controller'] = @$dirs[1];
$_GET['action'] = @$dirs[2];
$_GET['dirs'] = $dirs;

require_once(PATH_ENGINE.'/Bootstrap.php');

set_error_handler(function($code, $text, $file, $line) {
	die("[$line] [$file] $text");
});

Bootstrap::getInstance()
->autoload()
->run();
