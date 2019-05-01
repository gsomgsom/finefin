<?php
/**
 * Fine Finances
 *
 * @copyright     2012 Zhelnin Evgeniy
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 * @author        Zhelnin Evgeniy (evgeniy@zhelnin.perm.ru)
 * @version       1.0
 * @package       core
 */

/**
 * Database management
 */

/*
 Example:

$db = Database::getInstance();
$e = $db-> prepare ( "SELECT * FROM tablo" ) ;
$e -> execute ( ) ;
$e->setFetchMode(PDO::FETCH_NUM); //FETCH_ROW

while($row = $e->fetch()) {
echo $row[0] . "\n";     echo $row[1] . "\n";
}
*/

if (!defined('DB_HOST')) {
	define('DB_HOST', 'localhost');
}
if (!defined('DB_PORT')) {
	define('DB_PORT', 3306);
}
if (!defined('DB_USER')) {
	define('DB_USER', 'root');
}
if (!defined('DB_PASS')) {
	define('DB_PASS', '');
}
if (!defined('DB_NAME')) {
	define('DB_NAME', 'finefin');
}
if (!defined('DB_CHARSET')) {
	define('DB_CHARSET', 'utf8');
}

class Database {
	protected static $instance;

	protected function __construct() {
	}

	public static function getInstance() {
		if(empty(self::$instance)) {
			try {
				self::$instance = new PDO("mysql:host=".DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME, DB_USER, DB_PASS);
				self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
				self::$instance->query('SET NAMES '.DB_CHARSET);
				self::$instance->query('SET CHARACTER SET '.DB_CHARSET);
			}
			catch(PDOException $e) {
				throw new Exception($e->getMessage(), 100);
			}
		}

		return self::$instance;
	}

}
