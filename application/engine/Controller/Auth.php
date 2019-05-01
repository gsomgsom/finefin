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
 * Site section logic with required autherization
 */
class Controller_Auth extends Controller {

	public function before() {
		if (!User::loggedUserID()) {
			header('Location: /');
		}
	}

}
