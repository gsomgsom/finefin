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
 * Browser detection functions based on wordpress browser plugin
 */
abstract class Browser {

/* USAGE

GET INFO:

Browser::php_browser_info() - returns array of all info
Browser::get_browser_name() - returns just the name
Browser::get_browser_version() - returns version and minor version (3.2)

CONDITIONAL STATEMENTS INCLUDED:

$version is optional. Include a number to test a specific one, or leave blank to test any for any version.

Browser::is_firefox($version)
Browser::is_safari($version)
Browser::is_chrome($version)
Browser::is_opera($version)
Browser::is_ie($version)

Browser::is_iphone($version)
Browser::is_ipad($version)
Browser::is_ipod($version)

Browser::is_mobile()

Browser::is_ie(6)
Browser::is_ie(7)

Browser::is_lt_IE(6)
Browser::is_lt_IE(7)
Browser::is_lt_IE(8)

Browser::browser_supports_javascript()
Browser::browser_supports_cookies()
Browser::browser_supports_css()


EXAMPLE:

if(Browser::is_ie()) :  DO SOMETHING ; else :  DO OTHER STUFF; endif;

*/

/**
 * Returns array of all browser info.
 *
 * @usage $browserInfo = php_browser_info();
 *
 * @return array
 */
public static function php_browser_info() {
	$agent = $_SERVER['HTTP_USER_AGENT'];

	$x = dirname(__FILE__);
	$browscap = $x.'/php_browser_detection_browscap.ini';
	if(!is_file(realpath($browscap))) {
		return array('error' => 'No browscap.ini file founded.');
	}
	$agent = $agent ? $agent : $_SERVER['HTTP_USER_AGENT'];
	$yu = array();
	$q_s = array("#\.#", "#\*#", "#\?#");
	$q_r = array("\.", ".*", ".?");

	if(version_compare(PHP_VERSION, '5.3.0') >= 0) {
		$brows = parse_ini_file(realpath($browscap), TRUE, INI_SCANNER_RAW);
	} else {
		$brows = parse_ini_file(realpath($browscap), TRUE);
	}

	foreach($brows as $k => $t) {
		if(fnmatch($k, $agent)) {
			$yu['browser_name_pattern'] = $k;
			$pat = preg_replace($q_s, $q_r, $k);
			$yu['browser_name_regex'] = strtolower("^$pat$");
			foreach($brows as $g => $r) {
				if($t['Parent'] == $g) {
					foreach($brows as $a => $b) {
						if($r['Parent'] == $a) {
							$yu = array_merge($yu, $b, $r, $t);
							foreach($yu as $d => $z) {
								$l = strtolower($d);
								$hu[$l] = $z;
							}
						}
					}
				}
			}
			break;
		}
	}
	return $hu;
}

/**
 * Returns the name of the browser.
 *
 * @return string
 */
public static function get_browser_name() {

	$browserInfo = self::php_browser_info();

	if(self::is_firefox()) {
		return 'Firefox';
	} elseif(self::is_safari()) {
		return 'Safari';
	} elseif(self::is_opera()) {
		return 'Opera';
	} elseif(self::is_chrome()) {
		return 'Chrome';
	} elseif(self::is_ie()) {
		return 'Internet Explorer'; // The Root of All Evil
	} elseif(self::is_ipad()) {
		return 'iPad';
	} elseif(self::is_ipod()) {
		return 'iPod';
	} elseif(self::is_iphone()) {
		return 'iPhone';
	} else {
		return 'Unknown Browser: '.$browserInfo['browser'].' - Version: '.get_browser_version();
	}
}

/**
 *
 * Returns the browser version number.
 *
 * @return mixed
 */
public static function get_browser_version() {
	$browserInfo = self::php_browser_info();
	return $browserInfo['version'];
}

/**
 *
 * Conditional to test for Firefox.
 *
 * @param string $version
 *
 * @return bool
 */
public static function is_firefox($version = '') {
	$browserInfo = self::php_browser_info();
	if(isset($browserInfo['browser']) && $browserInfo['browser'] == 'Firefox') {
		if($version == '') :
			return TRUE; elseif($browserInfo['majorver'] == $version) :
			return TRUE; else :
			return FALSE;
		endif;
	} else {
		return FALSE;
	}
}

/**
 *
 * Conditional to test for Safari.
 *
 * @param string $version
 *
 * @return bool
 */
public static function is_safari($version = '') {
	$browserInfo = self::php_browser_info();
	if(isset($browserInfo['browser']) && $browserInfo['browser'] == 'Safari') {
		if($version == '') :
			return TRUE; elseif($browserInfo['majorver'] == $version) :
			return TRUE; else :
			return FALSE;
		endif;
	} else {
		return FALSE;
	}
}

/**
 * Conditional to test for Chrome.
 *
 * @param string $version
 *
 * @return bool
 */
public static function is_chrome($version = '') {
	$browserInfo = self::php_browser_info();
	if(isset($browserInfo['browser']) && $browserInfo['browser'] == 'Chrome') {
		if($version == '') :
			return TRUE; elseif($browserInfo['majorver'] == $version) :
			return TRUE; else :
			return FALSE;
		endif;
	} else {
		return FALSE;
	}
}

/**
 * Conditional to test for Opera.
 *
 * @param string $version
 *
 * @return bool
 */
public static function is_opera($version = '') {
	$browserInfo = self::php_browser_info();
	if(isset($browserInfo['browser']) && $browserInfo['browser'] == 'Opera') {
		if($version == '') :
			return TRUE; elseif($browserInfo['majorver'] == $version) :
			return TRUE; else :
			return FALSE;
		endif;
	} else {
		return FALSE;
	}
}

/**
 * Conditional to test for IE.
 *
 * @param string $version
 *
 * @return bool
 */
public static function is_ie($version = '') {
	$browserInfo = self::php_browser_info();
	if(isset($browserInfo['browser']) && $browserInfo['browser'] == 'IE') {
		if($version == '') :
			return TRUE; elseif($browserInfo['majorver'] == $version) :
			return TRUE; else :
			return FALSE;
		endif;
	} else {
		return FALSE;
	}
}

/**
 * Conditional to test for mobile devices.
 *
 * @return bool
 */
public static function is_mobile() {
	$browserInfo = self::php_browser_info();
	if(isset($browserInfo['ismobiledevice']) && ($browserInfo['ismobiledevice'] == 'true')) {
		return TRUE;
	}
	return FALSE;
}

/**
 * Conditional to test for iPhone.
 *
 * @param string $version
 *
 * @return bool
 */
public static function is_iphone($version = '') {
	$browserInfo = self::php_browser_info();
	if((isset($browserInfo['browser']) && $browserInfo['browser'] == 'iPhone') || strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')) {
		if($version == '') :
			return TRUE; elseif($browserInfo['majorver'] == $version) :
			return TRUE; else :
			return FALSE;
		endif;
	} else {
		return FALSE;
	}
}

/**
 * Conditional to test for iPad.
 *
 * @param string $version
 *
 * @return bool
 */
public static function is_ipad($version = '') {
	$browserInfo = self::php_browser_info();
	if(preg_match("/iPad/", $browserInfo['browser_name_pattern'], $matches) || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
		if($version == '') :
			return TRUE; elseif($browserInfo['majorver'] == $version) :
			return TRUE; else :
			return FALSE;
		endif;
	} else {
		return FALSE;
	}
}

/**
 * Conditional to test for iPod.
 *
 * @param string $version
 *
 * @return bool
 */
public static function is_ipod($version = '') {
	$browserInfo = self::php_browser_info();
	if(preg_match("/iPod/", $browserInfo['browser_name_pattern'], $matches)) {
		if($version == '') :
			return TRUE; elseif($browserInfo['majorver'] == $version) :
			return TRUE; else :
			return FALSE;
		endif;
	} else {
		return FALSE;
	}
}

/**
 * Conditional to test for JavaScript support.
 *
 * @return bool
 */
public static function browser_supports_javascript() {
	$browserInfo = self::php_browser_info();
	if(isset($browserInfo['javascript']) && $browserInfo['javascript'] == 'true') {
		return TRUE;
	}
	return FALSE;
}

/**
 * Conditional to test for cookie support.
 *
 * @return bool
 */
public static function browser_supports_cookies() {
	$browserInfo = self::php_browser_info();
	if(isset($browserInfo['cookies']) && $browserInfo['cookies'] == 'true') {
		return TRUE;
	}
	return FALSE;
}

/**
 * Conditional to test for CSS support.
 *
 * @return bool
 */
public static function browser_supports_css() {
	$browserInfo = self::php_browser_info();
	if(isset($browserInfo['supportscss']) && $browserInfo['supportscss'] == 'true') {
		return TRUE;
	}
	return FALSE;
}

/**
 * Conditional to test for IE6.
 *
 * @return bool
 *
 * @deprecated Use the future-proof syntax instead of this function: if(is_ie(6)) { }
 */
public static function is_ie6() {
	return self::is_ie(6);
}

/**
 *
 * Conditional to test for IE7.
 *
 * @return bool
 *
 * @deprecated Use the future-proof syntax instead of this function: if(is_ie(7)) { }
 */
public static function is_ie7() {
	return self::is_ie(7);
}

/**
 *
 * Conditional to test for IE8.
 *
 * @return bool
 *
 * @deprecated Use the future-proof syntax instead of this function: if(is_ie(8)) { }
 */
public static function is_ie8() {
	return self::is_ie(8);
}

/**
 *
 * Conditional to test for IE9.
 *
 * @return bool
 *
 * @deprecated Use the future-proof syntax instead of this function: if(is_ie(9)) { }
 */
public static function is_ie9() {
	return self::is_ie(9);
}

/**
 *
 * Conditional to test for IE10.
 *
 * @return bool
 *
 * @deprecated Use the future-proof syntax instead of this function: if(is_ie(10)) { }
 */
public static function is_ie10() {
	return self::is_ie(10);
}

/**
 *
 * Conditional to test for less than IE8.
 *
 * @return bool
 *
 * @deprecated Use the future-proof syntax instead of this function: if(is_ie() && get_browser_version() < 6) { }
 */
public static function is_lt_IE6() {
	if(self::is_ie() && self::get_browser_version() < 6) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Conditional to test for less than IE7.
 *
 * @return bool
 *
 * @deprecated Use the future-proof syntax instead of this function: if(is_ie() && get_browser_version() < 7) { }
 */
public static function is_lt_IE7() {
	if(self::is_ie() && self::get_browser_version() < 7) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Conditional to test for less than IE8.
 *
 * @return bool
 *
 * @deprecated Use the future-proof syntax instead of this function: if(is_ie() && get_browser_version() < 8) { }
 */
public static function is_lt_IE8() {
	if(is_ie() && get_browser_version() < 8) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Conditional to test for less than IE9.
 *
 * @return bool
 *
 * @deprecated Use the future-proof syntax instead of this function: if(is_ie() && get_browser_version() < 9) { }
 */
public static function is_lt_IE9() {
	if(self::is_ie() && self::get_browser_version() < 9) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Conditional to test for less than IE10.
 *
 * @return bool
 *
 * @deprecated Use the future-proof syntax instead of this function: if(is_ie() && get_browser_version() < 10) { }
 *
 */
public static function is_lt_IE10() {
	if(self::is_ie() && self::get_browser_version() < 10) {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Conditional to test for less than IE11.
 *
 * @return bool
 *
 * @deprecated Use the future-proof syntax instead of this function: if(is_ie() && get_browser_version() < 11) { }
 *
 */
public static function is_lt_IE11() {
	if(self::is_ie() && self::get_browser_version() < 11) {
		return TRUE;
	} else {
		return FALSE;
	}
}

}