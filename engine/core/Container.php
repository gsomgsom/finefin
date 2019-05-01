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
 * Container
 */
class Container {
	public $view;
	public $response;
	public $content;

	public function __construct(View $view, Response $response) {
		$this->view = $view;
		$this->response = $response;
	}

	public function __get($name) {
		return $this->view->getParam($name);
	}

	public function __set($name, $value) {
		$this->view->setParam($name, $value);
	}

	public function __isset($name) {
		return $this->view->issetParam($name);
	}

	public function title($title=null) {
		return $this->response->title();
	}

	public function view() {
		return $this->view;
	}

	public function response() {
		return $this->response;
	}

	public function load($file) {
		if (!file_exists($file)) {
			$this->content = "Container '$file' not found.";
			return;
		}

		ob_start();
		include $file;
		$this->content = ob_get_clean();
	}
}
