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

if (!defined('USER_SALT')) {
	define('USER_SALT', '8a7ebc9f');
}

/**
 * User model
 */
abstract class User {

	/**
	 * Returns user id or 0 if not authorized
	 * @return integer
	 */
	public static function loggedUserID($token = '') {
		$token = $token ? $token : Funcs::cookieGet('token');
		$db = Database::getInstance();
		$query = $db->prepare("select t.user_id from tokens t where code=:code limit 1");
		$query->bindParam(':code', $token, PDO::PARAM_STR);
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$row = $query->fetch();
		if (isset($row['user_id']) && intval($row['user_id']) > 0) {
			return $row['user_id'];
		}
		return 0;
	}

	/**
	 * Returns user data by provided id
	 * @return array
	 */
	public static function getUserInfo($user_id = 0) {
		if (!$user_id) {
			$user_id = self::loggedUserID();
		}
		$db = Database::getInstance();
		$query = $db->prepare("select u.* from users u where u.id = :user_id");
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$row = $query->fetch();
		return $row;
	}

	/**
	 * Check user e-mail/pass
	 * @return array
	 */
	public static function checkUserPass($email, $pass) {
		if ($email && $pass) {
			$db = Database::getInstance();
			$query = $db->prepare("select count(*) cnt from users u where lower(u.email) = lower(:email) and u.pass = :pass");
			$query->bindParam(':email', $email, PDO::PARAM_STR);
			$pass_hash = md5($pass.USER_SALT);
			$query->bindParam(':pass', $pass_hash, PDO::PARAM_STR);
			$query->execute();
			$query->setFetchMode(PDO::FETCH_ASSOC);
			$row = $query->fetch();
			return (intval($row['cnt']) > 0);
		}
		return FALSE;
	}

	/**
	 * Create token for user by E-mail
	 * @return integer
	 */
	public static function createToken($email) {
		if ($email) {
			$db = Database::getInstance();
			$query = $db->prepare("insert into tokens (user_id, code) values ((select u.id from users u where u.email = :email), :token)");
			$token = Funcs::randString();
			$query->bindParam(':email', $email, PDO::PARAM_STR);
			$query->bindParam(':token', $token, PDO::PARAM_STR);
			$query->execute();
			return $token;
		}
		return FALSE;
	}

	/**
	 * Delete token
	 * @return boolean
	 */
	public static function deleteToken($code) {
		if ($code) {
			$db = Database::getInstance();
			$query = $db->prepare("delete from tokens where code = :code");
			$token = Funcs::randString();
			$query->bindParam(':code', $code, PDO::PARAM_STR);
			$query->execute();
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Get/create Ulogin user
	 * @return integer
	 */
	public static function getUlogin($user) {
		if (is_array($user) && isset($user['network']) && isset($user['uid'])) {
			$db = Database::getInstance();
			$query = $db->prepare("insert into users (name, network, uid, url) values (:name, :network, :uid, :url)");
			$query->bindParam(':name', $user['first_name'], PDO::PARAM_STR);
			$query->bindParam(':network', $user['network'], PDO::PARAM_STR);
			$query->bindParam(':uid', $user['uid'], PDO::PARAM_STR);
			$query->bindParam(':url', $user['identity'], PDO::PARAM_STR);
			$result = $query->execute();

			if ($result) {
				$query = $db->prepare("select id from users where email=:email limit 1");
				$query->bindParam(':email', $email, PDO::PARAM_STR);
				$query->execute();
				$query->setFetchMode(PDO::FETCH_ASSOC);
				$row = $query->fetch();
				$id = $row['id'];
				if ($id > 0) {
					$query = $db->prepare("insert into user_tags (name, user_id, template_id) (select t.name, :user_id, id template_id from tags_template t)");
					$query->bindParam(':user_id', $id, PDO::PARAM_STR);
					$query->execute();
				}
			}

			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Create simple user
	 * @return integer
	 */
	public static function createUser($name, $email, $pass) {
		$db = Database::getInstance();
		$query = $db->prepare("insert into users (name, email, pass) values (:name, :email, :pass)");
		$query->bindParam(':name', $name, PDO::PARAM_STR);
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$pass_hash = md5($pass.USER_SALT);
		$query->bindParam(':pass', $pass_hash, PDO::PARAM_STR);
		$result = $query->execute();

		if ($result) {
			$query = $db->prepare("select id from users where email=:email limit 1");
			$query->bindParam(':email', $email, PDO::PARAM_STR);
			$query->execute();
			$query->setFetchMode(PDO::FETCH_ASSOC);
			$row = $query->fetch();
			$id = $row['id'];
			if ($id > 0) {
				$query = $db->prepare("insert into user_tags (name, user_id, template_id) (select t.name, :user_id, id template_id from tags_template t)");
				$query->bindParam(':user_id', $id, PDO::PARAM_STR);
				$query->execute();
			}
		}

		return $result;
	}

	/**
	 * Create token for user by Ulogin
	 * @return integer
	 */
	public static function createTokenUlogin($user) {
		if (is_array($user) && isset($user['network']) && isset($user['uid'])) {
			$db = Database::getInstance();
			$query = $db->prepare("insert into tokens (user_id, code) values ((select u.id from users u where u.network = :network and u.uid = :uid), :token)");
			$token = Funcs::randString();
			$query->bindParam(':network', $user['network'], PDO::PARAM_STR);
			$query->bindParam(':uid', $user['uid'], PDO::PARAM_STR);
			$query->bindParam(':token', $token, PDO::PARAM_STR);
			$query->execute();
			return $token;
		}
		return FALSE;
	}

	/**
	 * Set user name
	 * @return boolean
	 */
	public static function userSetName($name) {
		$db = Database::getInstance();
		$user_id = User::loggedUserID();
		$query = "update users set name=:name where id=:user_id";
		$query = $db->prepare($query);
		$query->bindParam(':name', $name, PDO::PARAM_STR);
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$result = $query->execute();
		return $result;
	}

	/**
	 * Is user exists (by email)
	 * @return boolean
	 */
	public static function userExists($email) {
		$db = Database::getInstance();
		$query = $db->prepare("select count(*) cnt from users u where lower(u.email) = lower(:email)");
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$row = $query->fetch();
		$found = (bool) intval($row['cnt']);
		return $found;
	}


	/**
	 * Set user email
	 * @return boolean
	 */
	public static function userSetEmail($email) {
		$db = Database::getInstance();
		$user_id = User::loggedUserID();

		if (!Funcs::checkEmail($email)) {
			return 'CheckError';
		}

		if (!self::userExists($email)) {
			$query = "update users set email=:email where id=:user_id";
			$query = $db->prepare($query);
			$query->bindParam(':email', $email, PDO::PARAM_STR);
			$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
			$result = $query->execute();
			return $result;
		}
		else {
			return 'ExistsError';
		}

	}

	/**
	 * Set user password
	 * @return boolean
	 */
	public static function userSetPassword($pass) {
		$db = Database::getInstance();
		$user_id = User::loggedUserID();
		$query = "update users set pass=:pass where id=:user_id";
		$query = $db->prepare($query);
		$pass_hash = md5($pass.USER_SALT);
		$query->bindParam(':pass', $pass_hash, PDO::PARAM_STR);
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$result = $query->execute();
		return $result;
	}

	/**
	 * Send forgot Email message
	 * @return boolean
	 */
	public static function sendForgotMessage($email) {
		$db = Database::getInstance();
		$query = $db->prepare("select * from users where email=:email limit 1");
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$row = $query->fetch();
		$id = $row['id'];
		if ($id > 0) {
			$token = md5($row['name'].'_'.$row['id'].'_'.USER_SALT);
			$link = "http://beta.finefin.ru/user/newpass/?email=".urlencode($email)."&token=".$token;
			$subject = "Восстановление доступа FineFin.RU";
			$from = $reply = "info@finefin.ru";
			$message = "
Кто-то, может быть даже вы воспользовался функцией восстановления доступа к сайту FineFin.RU<br/>
Если вы не понимаете, о чём речь, то проигнорируйте это письмо.<br/>
<br/>
Ссылка для восстановления пароля: <a href=\"$link\">$link</a><br/>
<br/>
<br/>
Домашняя бухгалтерия FineFin.RU
";
			// @TODO: use mail library
			return mail($email, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, "'MIME-Version: 1.0\r\nFrom: $from <$reply>\nReply-To: $reply \nContent-type: text/html; charset=UTF-8". "\r\n");	
		}
		return false;
	}

	/**
	 * Send new passeord Email message
	 * @return boolean
	 */
	public static function sendNewPass($email, $token) {
		$db = Database::getInstance();
		$query = $db->prepare("select * from users where email=:email limit 1");
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$row = $query->fetch();
		$id = $row['id'];
		if ($id > 0) {
			$token_computed = md5($row['name'].'_'.$row['id'].'_'.USER_SALT);
			$newpass = Funcs::randString(8);
			$subject = "Пароль доступа на сайт FineFin.RU";
			$from = $reply = "info@finefin.ru";
			$message = "
Ваш новый пароль для FineFin.RU: ".$newpass."<br/>
Если он вам не нравится, зайдите в личный кабинет и поменяйте его.<br/>
<br/>
Если вы не понимаете, о чём речь, то проигнорируйте это письмо.<br/>
<br/>
<br/>
Домашняя бухгалтерия FineFin.RU
";
			if ($token == $token_computed) {
				$query = "update users set pass=:pass where id=:user_id";
				$query = $db->prepare($query);
				$pass_hash = md5($newpass.USER_SALT);
				$query->bindParam(':pass', $pass_hash, PDO::PARAM_STR);
				$query->bindParam(':user_id', $id, PDO::PARAM_INT);
				$result = $query->execute();

				// @TODO: use mail library
				return mail($email, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, "'MIME-Version: 1.0\r\nFrom: $from <$reply>\nReply-To: $reply \nContent-type: text/html; charset=UTF-8". "\r\n");	
			}
		}
		return false;
	}

}
