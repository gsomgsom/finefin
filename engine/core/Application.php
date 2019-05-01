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
 * Handles requests and renders the result
 */
class Application {
	protected static $_instance;

	public $request;
	public $dispatcher;
	public $view;
	public $response;

	public static function getInstance() {
		if (null === self::$_instance) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {
		$this->request = Request::getInstance();
		$this->dispatcher = new Dispatcher();
		$this->view = new View();
		$this->response = new Response();
	}

	public function getRequest() {
		$this->request
		->getControllerActionRequest('controller', 'action');

		if (!$this->request->getControllerName())
			$this->request->setParam('controller', $this->dispatcher->getDefaultController());

		if (!$this->request->getActionName())
			$this->request->setParam('action', $this->dispatcher->getDefaultAction());

		return $this;
	}

	public function dispatch() {
		$this->view
		->setParams(
				$this->dispatcher
				->setSearchDir(PATH_CONTROLLERS)
				->create($this->request->getControllerName())
				->run($this->request->getActionName())
		);

		return $this;
	}

	public function run() {
		try {
			$this->getRequest()->dispatch();
		}
		catch (Exception $e) {
			$this->view->setParam('errMessage', $e->getMessage());
			switch ($e->getCode()) {
				case 100:
					$this->request->setParam('action', 'ErrorDatabase');
					break;

				case 101:
					$this->view->setParam('errMessage', "
					".$e->getMessage()."<br/>
					In file \"".$e->getFile()."\", line ".$e->getLine());
					break;

				case 404:
					$this->request->setParam('action', 'Error404');
					break;

				default:
					$this->request->setParam('controller', 'Error');
					$this->view->setParam('errMessage',
							"Uncatched application exception #". $e->getCode() .":<br/>
							".$e->getMessage()."<br/>
							In file \"".$e->getFile()."\", line ".$e->getLine());
			}

			$this->dispatcher
			->setSearchDir(PATH_CONTROLLERS)
			->create('Error')
			->run($this->request->getActionName());

		}

		return $this;
	}

	public function sendResponse() {
		$controllerName = str_replace(
				"Controller",
				"",
				get_class($this->dispatcher->getController())
		);
		$actionName = $this->request->getActionName();

		$pagefile =
		$controllerName.'.'.
		ucfirst(strtolower($actionName)).'.php';

		$this->response
		->templateFile(PATH_LAYOUTS.'/template/default.php')
		->pageFile(PATH_LAYOUTS.'/pages/'.$pagefile)
		->send($this->view);

		return $this;
	}
}
