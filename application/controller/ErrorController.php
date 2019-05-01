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

/**
 * Error handler
 */
class ErrorController extends Controller {

	/**
	 * General error
	 */
	public function Index() {
	}

	/**
	 * Error 404
	 */
	public function Error404() {
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
	}

	/**
	 * Database connection error
	 */
	public function ErrorDatabase() {
	}

}
