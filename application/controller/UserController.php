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
 * User controller
 */
class UserController extends Controller {

	/**
	 * No index page, go to site index
	 */
	public function Index() {
		// Go to welcome page
		header('Location: /');
	}

	/**
	 * Register action
	 */
	public function Register() {
		// Guests only
		if (User::loggedUserID()) {
			// Go to welcome page
			header('Location: /');
		}

		$request = Request::getInstance();

		$messages = Array();

		$first_name = '';
		$email = '';
		$pass = '';

		$token = '';
		if ($request->hasParam('token')) {
			$token = $request->getParam('token');
		}

		if ($token == 'DfLNCfIfq7w8fZy5lkZjCKViCbIwqyYu') {
			$first_name = $request->p('first_name');
			if (!strlen($first_name)) {
				$messages[] = array(Funcs::MSG_ERROR, 'Назовите своё имя.');
			}

			$email = $request->p('email');
			if (!Funcs::checkEmail($email)) {
				$messages[] = array(Funcs::MSG_ERROR, 'Указан неверный Email. Укажите верный.');
			}
	
			$pass = $request->p('password1');
			if (strlen($pass) < 5) {
				$messages[] = array(Funcs::MSG_ERROR, 'Пароль очень короткий. Можно использовать и 5 символов, но это уже небезопасно.');
			}

			if (!sizeof($messages)) {
				if (!User::userExists($email)) {
					$result = User::createUser($first_name, $email, $pass);
					if ($result) {
						header('Location: /user/registerok/');
					}
					else {
						$messages[] = array(Funcs::MSG_ERROR, 'Во время регистрации произошла ошибка.');
					}
				}
				else {
					$messages[] = array(Funcs::MSG_ERROR, 'Пользователь с таким адресом Email уже зарегистрирован в системе.');
				}
			}
		}

		return array(
			'first_name' => $first_name,
			'email' => $email,
			'messages' => $messages,
		);
	}

	/**
	 * Registration was successfull
	 */
	public function Registerok() {
	}

	/**
	 * Forgot action
	 */
	public function Forgot() {
		// Guests only
		if (User::loggedUserID()) {
			// Go to welcome page
			header('Location: /');
		}

		$request = Request::getInstance();

		$messages = Array();

		$email = '';

		$token = '';
		if ($request->hasParam('token')) {
			$token = $request->getParam('token');
		}

		if ($token == 'DfLNCfIfq7w8fZy5lkZjCKViCbIwqyYu') {
			$email = $request->p('email');
			if (!Funcs::checkEmail($email)) {
				$messages[] = array(Funcs::MSG_ERROR, 'Указан неверный Email. Укажите верный.');
			}

			if (!sizeof($messages)) {
				if (User::userExists($email)) {
					User::sendForgotMessage($email);
					$messages[] = array(Funcs::MSG_SUCCESS, 'Письмо с инструкцией по восстановлению доступа отправлена на указанный E-mail');
				}
				else {
					$messages[] = array(Funcs::MSG_ERROR, 'Указанный Email не найден в наших записях.');
				}
			}
		}

		return array(
			'email' => $email,
			'messages' => $messages,
		);
	}

	/**
	 * New password
	 */
	public function Newpass() {
		$request = Request::getInstance();
		$email = $request->g('email');
		$token = $request->g('token');
		if (User::sendNewPass($email, $token)) {
			$messages[] = array(Funcs::MSG_SUCCESS, 'Новый пароль отправлен на ваш Email.');
		}
		else {
			$messages[] = array(Funcs::MSG_ERROR, 'Хм... Что-то пошло не так.');
		}
		return array(
			'messages' => $messages,
		);
	}

	/**
	 * Login action
	 */
	public function Login() {
		$request = Request::getInstance();
		if ($request->hasParam('email') &&
				$request->getParam('email') &&
				$request->hasParam('pass') &&
				$request->getParam('pass')) {
			$email = $request->getParam('email');
			$pass = $request->getParam('pass');
			if (User::checkUserPass($email, $pass)) {
				Funcs::cookieSet('token', User::createToken($email));
			}
		}
		if (isset($_SERVER['HTTP_REFERER'])) {
			// Go back
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}
		else {
			// Go to welcome page
			header('Location: /');
		}
	}

	/**
	 * Logout action
	 */
	public function Logout() {
		User::deleteToken(Funcs::cookieGet('token'));
		$token = Funcs::cookieSet('token', NULL, true);

		if (isset($_SERVER['HTTP_REFERER'])) {
			// Go back
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}
		else {
			// Go to welcome page
			header('Location: /');
		}
	}

	/**
 	 * Ulogin registration / authorization
 	 */
	public function Ulogin() {
		$request = Request::getInstance();

		if ($request->hasParam('token') && $request->getParam('token')) {
			$s = file_get_contents('http://ulogin.ru/token.php?token=' . $request->getParam('token') . '&host=' . $_SERVER['HTTP_HOST']);
			if (User::getUlogin(json_decode($s, true))) {
				Funcs::cookieSet('token', User::createTokenUlogin(json_decode($s, true)));
			}
		}

		// Go to welcome page
		header('Location: /');
	}

	/**
 	 * Profile information
 	 */
	public function Profile() {
		// Users only
		if (!User::loggedUserID()) {
			// Go to welcome page
			header('Location: /');
		}

		$userInfo = User::getUserInfo();

		$messages = Array();

		$request = Request::getInstance();

		$email = $request->p('email');
		$pass = $request->p('pass');
		$pass2 = $request->p('pass2');
		$name = $request->p('name');

		if (!is_null($name) && ($name!==$userInfo['name'])) {
			User::userSetName($name);
			$messages[] = array(Funcs::MSG_SUCCESS, 'Имя изменено.');
		}

		if (!is_null($email) && ($email!==$userInfo['email'])) {
			$emailResult = User::userSetEmail($email);
			if ($emailResult === TRUE) {
				$messages[] = array(Funcs::MSG_SUCCESS, 'Email изменён.');
			}
			else
			if ($emailResult === 'CheckError') {
				$messages[] = array(Funcs::MSG_ERROR, 'Указан неверный Email. Укажите верный.');
			}
			else
			if ($emailResult === 'ExistsError') {
				$messages[] = array(Funcs::MSG_ERROR, 'Такой email уже зарегистрирован в системе.');
			}
			else
			{
				$messages[] = array(Funcs::MSG_ERROR, 'При изменении email произошла ошибка. '.print_r($emailResult));
			}
		}

		if (!is_null($pass)) {
			if (!is_null($pass2)) {
				if ($pass!==$pass2) {
					$messages[] = array(Funcs::MSG_ERROR, 'Повторный пароль не совпадает с первым.');
				}
				else {
					User::userSetPassword($pass);
					$messages[] = array(Funcs::MSG_SUCCESS, 'Пароль успешно сменён');
				}
			}
			else {
				$messages[] = array(Funcs::MSG_ERROR, 'Повторный пароль не указан.');
			}
		}

		return array(
			'userInfo' => User::getUserInfo(),
			'messages' => $messages,
		);
	}

}
