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
 * Tags controller
 */
class TagsController extends Controller_Auth {

	/**
	 * Index action
 	 */
	public function Index() {
		$messages = Array();

		$request = Request::getInstance();

		$operation   = $request->hasParam('operation')   ? $request->getParam('operation')   : '';
		$id          = $request->hasParam('id')          ? $request->getParam('id')          : 0;
		$name        = $request->hasParam('name')        ? $request->getParam('name')        : 'Безымянный #'.$id;

		if ($operation == 'add') {
			if (Money::addTagEntry($name)) {
				// Go to tags page
				header('Location: /tags/?operation=successAdd');
			}
			else {
				// Go to tags page
				header('Location: /tags/?operation=errorAdd');
			}
		}
		else
		if ($operation == 'edit') {
			if (Money::editTagEntry($id, $name)) {
				// Go to tags page
				header('Location: /tags/?operation=successEdit');
			}
			else {
				// Go to tags page
				header('Location: /tags/?operation=errorEdit');
			}
		}
		else
		if ($operation == 'successAdd') {
			$messages[] = array(Funcs::MSG_SUCCESS, 'Запись о тэге добавлена.');
		}
		else
		if ($operation == 'errorAdd') {
			$messages[] = array(Funcs::MSG_ERROR, 'При добавлении записи о тэге произошла ошибка.');
		}
		else
		if ($operation == 'successEdit') {
			$messages[] = array(Funcs::MSG_SUCCESS, 'Запись о тэге изменена.');
		}
		else
		if ($operation == 'errorEdit') {
			$messages[] = array(Funcs::MSG_ERROR, 'При изменении записи о тэге произошла ошибка.');
		}
	
		return array(
			'tagsData' => Money::getTags(),
			'messages' => $messages,
		);
	}

}
