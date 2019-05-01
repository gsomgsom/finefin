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
 * Handles controllers and actions
 */
class Dispatcher {
	protected $searchDir = '.';
	protected $controller;
	protected $defaultController = 'Index';
	protected $defaultAction = 'Index';

	/**
	 * Returns controller search directoriy
	 *
	 * @return type
	 */
	public function getSearchDir() {
		return $this->searchDir;
	}

	/**
	 * Set default controller
	 *
	 * @param type $defaultController
	 * @return \Dispatcher
	 */
	public function setDefaultController($defaultController) {
		$this->defaultController = $defaultController;
		return $this;
	}

	/**
	 * Returns name of default controller
	 *
	 * @return type
	 */
	public function getDefaultController() {
		return $this->defaultController;
	}

	/**
	 * Sets default controller name
	 *
	 * @param type $defaultAction
	 * @return \Dispatcher
	 */
	public function setDefaultAction($defaultAction) {
		$this->defaultAction = $defaultAction;
		return $this;
	}

	/**
	 * Returns default action name
	 *
	 * @return type
	 */
	public function getDefaultAction() {
		return $this->defaultAction;
	}

	/**
	 * Set controller directory path
	 *
	 * @param type $path
	 * @return \Dispatcher
	 */
	public function setSearchDir($path) {
		$this->searchDir = $path;
		return $this;
	}

	/**
	 * Create and activate controller
	 *
	 * @param string $controllerName Controller name
	 */
	public function create($controllerName) {
		if (!$controllerName)
			$controllerName = $this->defaultController;

		$controllerName = ucfirst(strtolower($controllerName)).'Controller';
		$controllerFilename = $this->searchDir.'/'.$controllerName.'.php';

		if (preg_match('/[^a-zA-Z0-9]/', $controllerName))
			throw new Exception('Invalid controller name', 404);

		if (!file_exists($controllerFilename)) {
			throw new Exception('Controller not found "'.$controllerName.'"', 404);
		}

		require_once $controllerFilename;

		if (!class_exists($controllerName) || !is_subclass_of($controllerName, 'Controller'))
			throw new Exception('Unknown controller "'.$controllerName.'"', 404);

		$this->controller = new $controllerName();
		return $this;
	}

	/**
	 * Returns created controller
	 *
	 * @return Controller
	 */
	public function getController()	{
		return $this->controller;
	}

	/**
	 * Runs action of created controller
	 *
	 * @param string $actionName action method
	 * @return mixed
	 */
	public function run($actionName) {
		$actionName = ucfirst(strtolower($actionName));

		if (!$actionName)
			$actionName = $this->defaultAction;

		if (preg_match('/\_?[^a-zA-Z0-9]/', $actionName))
			throw new Exception('Invalid action name', 404);

		if (!is_object($this->controller))
			throw new Exception('No controller', 404);

		$controllerName = str_replace(
				"Controller",
				"",
				get_class($this->controller)
		);

		if ($controllerName == 'Error') {
			$actionName = 'Error404';
		}

		if (!method_exists($this->controller, $actionName)) {
			$this->create("ErrorController");
			return $this->controller->Error404();
		}

		return $this->controller->$actionName();
	}
}
