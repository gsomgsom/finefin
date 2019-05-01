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
 * Useful functions
 */
abstract class Funcs {

	// Consts
	const MSG_NONE     = 0; // Nothing to see
	const MSG_SUCCESS  = 1; // Success!
	const MSG_ERROR    = 2; // Error! Something is wrong!
	const MSG_INFO     = 3; // Neutral information message.

	/**
	 * Set cookie
	 *
	 * @param string Name
	 * @param string Balue
	 * @param boolean delete?
	 * @return void
	 */
	public static function cookieSet($name, $value='', $delete=false) {
		$expires = ($delete) ? time()-86400 : time() + 2678400;
		setcookie('finefin_'.$name, $value, $expires, '/', NULL);
	}

	/**
	 * Get cookie
	 * @param string	Имя
	 * @return mixed
	 */
	public static function cookieGet($name) {
		if (isset($_COOKIE['finefin_'.$name])) {
			return self::parseCleanValue(urldecode($_COOKIE['finefin_'.$name]));
		}
		return FALSE;
	}

	/**
	 * Clean HTML and values.
	 * Useful when using _GET and _POST values
	 * @param string In value
	 * @return string Out value
	 */
	public static function parseCleanValue($val) {
		if ($val == '') {
			return '';
		}

		if (get_magic_quotes_gpc()) {
			$val = stripslashes($val);
			$val = preg_replace("/\\\(?!&amp;#|\?#)/", "&#092;", $val);
		}
		$val = str_replace("&#032;",      " ",            $val);
		$val = str_replace("&",           "&amp;",        $val);
		$val = str_replace("<!--",        "&#60;&#33;--", $val);
		$val = str_replace("-->",         "--&#62;",      $val);
		$val = preg_replace("/<script/i", "&#60;script",  $val);
		$val = str_replace(">",           "&gt;",         $val);
		$val = str_replace("<",           "&lt;",         $val);
		$val = str_replace('"',           "&quot;",       $val);
		$val = str_replace("$",           "&#036;",       $val);
		$val = str_replace("\r",          "",             $val); // Remove tab chars
		$val = str_replace("!",           "&#33;",        $val);
		$val = str_replace("'",           "&#39;",        $val); // for SQL injection security

		// Recover Unicode
		$val = preg_replace("/&amp;#([0-9]+);/s", "&#\\1;", $val);
		// Trying to fix HTML entities without ;
		$val = preg_replace("/&#(\d+?)([^\d;])/i", "&#\\1;\\2", $val);

		return $val;
	}

	/**
	 * Generates randomized string up to 40 characters length
	 * @return string truncated sha1 string
	 */
	public static function randString($length=32) {
		return substr(sha1(uniqid(rand(),true)), 0, $length);
	}

	public static function checkEmail($email) {
		return preg_match('/[.+a-zA-Z0-9-]+@[a-zA-Z0-9-]+.[a-zA-Z]+/', $email);
	}

}
