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
 * API controller
 */
class ApiController extends Controller {

	/**
	 * Index action
 	 */
	public function Index() {
	}

	/**
	 * Login action
 	 */
	public function Auth() {
		Application::getInstance()->response->asJSON();

		$request = Request::getInstance();

		if ($request->hasParam('email') &&
				$request->getParam('email') &&
				$request->hasParam('pass') &&
				$request->getParam('pass')) {
			$email = $request->getParam('email');
			$pass = $request->getParam('pass');
			if (User::checkUserPass($email, $pass)) {
				$token = User::createToken($email);
				return array(
					'result' => 'success',
					'token' => $token,
				);
			}
		}
		return array(
			'result' => 'error',
			'message' => 'Email or password error!',
		);
	}

	/**
	 * API Export action
 	 */
	public function Operations() {
		Application::getInstance()->response->asJSON();

		$request = Request::getInstance();

		$token = $request->hasParam('token') ? $request->getParam('token') : '';

		$user_id = User::loggedUserID($token);

		if ($user_id > 0) {
			return array(
				'operationsData' => Money::getOperationsData(Money::OP_NOP, 0, 100000, $user_id),
			);
		}

		return array(
			'result' => 'error',
			'message' => 'No token given or token is expired.',
		);
	}

}
