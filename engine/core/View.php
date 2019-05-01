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
 * Renders output
 */
class View {
	protected $vars;
	protected $response;

	public function setParam($name, $value) {
		$this->vars[$name] = $value;
	}

	public function setParams(Array $params = null) {
		if (is_array($params))
			foreach ($params as $name => $value)
			$this->setParam ($name, $value);
	}

	public function issetParam($name) {
		return isset($this->vars[$name]);
	}

	public function getParam($name, $defaultValue = '') {
		if (!isset($this->vars[$name])) {
			return $defaultValue;
		}
		else {
			return $this->vars[$name];
		}
	}

	public function getParams() {
		return $this->vars;
	}

	public function setResponse(Response $response) {
		$this->response = $response;
	}

	public function getResponse() {
		return $this->response;
	}
}
