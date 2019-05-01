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
 * Site section logic
 */
class Controller {

	public function __construct() {
		$this->before();
	}

	public function before() {
	}

	public function _request() {
		return Application::getInstance()
		->request;
	}

	public function _response() {
		return Application::getInstance()
		->response;
	}

	public function __get($name) {
		return Application::getInstance()
		->view->getParam($name);
	}

	public function __set($name, $value) {
		return Application::getInstance()
		->view->setParam($name, $value);
	}

	public function Index() {
	}

}
