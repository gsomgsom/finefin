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
 * Index model
 */
abstract class Index {
	public static function getName() {
		$r = Request::getInstance();
		return $r->p('name');
	}
}
