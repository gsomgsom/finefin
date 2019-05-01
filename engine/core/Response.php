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
 * Handles output
 */
class Response {
	protected $title;
	protected $responseType = 'html';
	protected $templateFile;
	protected $pageFile;

	public function title($title = null) {
		if (is_null($title))
			return $this->title;

		$this->title = $title;
		return $this;
	}

	public function templateFile($file) {
		$this->templateFile = $file;
		return $this;
	}

	public function pageFile($file)	{
		$this->pageFile = $file;
		return $this;
	}

	public function asHTML() {
		$this->responseType = 'html';
		return $this;
	}

	public function asJSON() {
		$this->responseType = 'json';
		return $this;
	}

	public function send(View $view) {
		switch ($this->responseType) {
			case 'html':
				header('Content-type', 'text/html; charset=UTF-8');

				$container = new Container($view, $this);
				$container->load($this->pageFile);
				$view->setParam('_pageContent', $container->content);
				$view->setParam('_title', $container->title);
				$container->load($this->templateFile);
				echo $container->content;
				break;

			case 'json':
				header('Content-type', 'application/json.; charset=UTF-8');
				echo json_encode($view->getParams());
				break;
		}

		return $this;
	}
}
