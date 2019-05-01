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

if (!defined('PATH_ENGINE') || !defined('PATH_APPLICATION')) {
	die('Please define PATH_ENGINE and PATH_APPLICATION');
}

define('PATH_APPENGINE',   PATH_APPLICATION.'/engine');
define('PATH_CONTROLLERS', PATH_APPLICATION.'/controller');
define('PATH_MODELS',      PATH_APPLICATION.'/model');
define('PATH_LAYOUTS',     PATH_APPLICATION.'/layout');

/**
 * Load modules and initialize the project
 */
class Bootstrap {
	protected static $_instance;

	public static function getInstance() {
		if (null === static::$_instance) {
			static::$_instance = new static();
		}
		return static::$_instance;
	}

	/**
	 * Autoload
	 */
	public function autoload() {
		spl_autoload_register(function($className) {

			// ZendFramework-like class names
			$className = str_replace('_', '/', $className);

			// First, trying to search user defined engine classes
			if (file_exists(PATH_APPENGINE.'/'.$className.'.php')) {
				$file = PATH_APPENGINE.'/'.$className.'.php';
			}
			else
			if (file_exists(PATH_ENGINE.'/core/'.$className.'.php')) {
				$file = PATH_ENGINE.'/core/'.$className.'.php';
			}
			else
				if (preg_match_all('/^(.*)Model$/', $className, $matches)) {
				$file = PATH_MODELS.'/'.$matches[1][0].'.php';
			}
			else
				if (file_exists(PATH_MODELS.'/'.$className.'.php')) {
				$file = PATH_MODELS.'/'.$className.'.php';
			}
			if (!isset($file) || !file_exists($file)) {
				return false;
			}

			require_once $file;
		});
		return $this;
	}

	public function run() {
		Application::getInstance()
		-> run()
		-> sendResponse();
	}
}
