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
 * Handles requests
 */
class Request {
	protected static $_instance;
	protected $vars;
	protected $controllerName = false;
	protected $actionName = false;

	/**
	 *  Returns self instance
	 */
	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Returns controller name
	 *
	 * @return type
	 */
	public function getControllerName() {
		return $this->controllerName;
	}

	/**
	 * Returns action name
	 *
	 * @return type
	 */
	public function getActionName() {
		return $this->actionName;
	}

	/**
	 * Gets controller and action name
	 */
	public function getControllerActionRequest($c, $a) {
		$this->controllerName = $this->g($c);
		$this->actionName = $this->g($a);
	}

	/**
	 * Returns param from internal metadata, GET, POST, COOKIE, SESSION
	 *
	 * @param type $name
	 * @return type
	 * @throws Exception
	 */
	public function getParam($name) {
		if (isset($this -> vars[$name]))
			return $this -> vars[$name];

		if (isset($_GET[$name]))
			return $_GET[$name];

		if (isset($_POST[$name]))
			return $_POST[$name];

		if (isset($_COOKIE[$name]))
			return $_COOKIE[$name];

		if (isset($_SESSION[$name]))
			return $_SESSION[$name];

		throw new Exception('Unknown request var "'.$name.'"', 101);
	}

	/**
	 * Returns if specifed param exists in internal metadata, GET, POST, COOKIE, SESSION
	 *
	 * @param type $name
	 * @return bool
	 */
	public function hasParam($name) {
		if (isset($this -> vars[$name]))
			return TRUE;

		if (isset($_GET[$name]))
			return TRUE;

		if (isset($_POST[$name]))
			return TRUE;

		if (isset($_COOKIE[$name]))
			return TRUE;

		if (isset($_SESSION[$name]))
			return TRUE;

		return FALSE;
	}

	/**
	 * Save request params
	 *
	 * @param type $name
	 * @param type $value
	 */
	public function setParam($name, $value) {
		switch ($name) {
			case 'controller':
				$this->controllerName = $value;
				break;

			case 'action':
				$this->actionName = $value;
				break;

			default:
				$this->vars[$name] = $value;
		}
	}

	/**
	 * Saves params array
	 *
	 * @param array $params
	 */
	public function setParams(Array $params) {
		foreach ($params as $name => $value)
			$this->setParam($name, $value);
	}

	/**
	 * $_GET + internal variables
	 * Internal variables are equal to $_GET variables
	 *
	 * @param type $name
	 * @return type
	 */
	public function g($name) {
		return isset($_GET[$name]) ? $_GET[$name] : (
				isset($this -> vars[$name]) ? $this -> vars[$name] : null);
	}

	/**
	 * $_POST
	 *
	 * @param type $name
	 * @return type
	 */
	public function p($name) {
		return isset($_POST[$name]) ? $_POST[$name] : (
				isset($this -> vars[$name]) ? $this -> vars[$name] : null);
	}

	/**
	 * $_COOKIE
	 *
	 * @param type $name
	 * @return type
	 */
	public function cookie($name) {
		return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
	}

	/**
	 * $_SESSION
	 *
	 * @param type $name
	 * @return type
	 */
	public function session($name) {
		return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
	}
}
