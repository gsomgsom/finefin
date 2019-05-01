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
 * Debts controller
 */
class DebtsController extends Controller_Auth {

	/**
	 * Index action
 	 */
	public function Index() {
		$messages = Array();

		$request = Request::getInstance();

		$operation   = $request->hasParam('operation')   ? $request->getParam('operation')   : '';
		$id          = $request->hasParam('id')          ? $request->getParam('id')          : 0;
		$sum         = $request->hasParam('sum')         ? $request->getParam('sum')         : 0;
		$description = $request->hasParam('description') ? $request->getParam('description') : '';

		if ($operation == 'delete') {
			if (Money::deleteDebtEntry($id)) {
				// Go to debts page
				header('Location: /debts/?operation=successDelete');
			}
			else {
				// Go to debts page
				header('Location: /debts/?operation=errorDelete');
			}
		}
		else
		if ($operation == 'add') {
			if (Money::addDebtEntry($sum, $description)) {
				// Go to debts page
				header('Location: /debts/?operation=successAdd');
			}
			else {
				// Go to debts page
				header('Location: /debts/?operation=errorAdd');
			}
		}
		else
		if ($operation == 'edit') {
			if (Money::editDebtEntry($id, $sum, $description)) {
				// Go to debts page
				header('Location: /debts/?operation=successEdit');
			}
			else {
				// Go to debts page
				header('Location: /debts/?operation=errorEdit');
			}
		}
		else
		if ($operation == 'successDelete') {
			$messages[] = array(Funcs::MSG_SUCCESS, 'Запись о долге удалена.');
		}
		else
		if ($operation == 'errorDelete') {
			$messages[] = array(Funcs::MSG_ERROR, 'При удалении записи о долге произошла ошибка.');
		}
		else
		if ($operation == 'successAdd') {
			$messages[] = array(Funcs::MSG_SUCCESS, 'Запись о долге добавлена.');
		}
		else
		if ($operation == 'errorAdd') {
			$messages[] = array(Funcs::MSG_ERROR, 'При добавлении записи о долге произошла ошибка.');
		}
		else
		if ($operation == 'successEdit') {
			$messages[] = array(Funcs::MSG_SUCCESS, 'Запись о долге изменена.');
		}
		else
		if ($operation == 'errorEdit') {
			$messages[] = array(Funcs::MSG_ERROR, 'При изменении записи о долге произошла ошибка.');
		}
	
		return array(
			'debtsData' => Money::getDebts(),
			'messages' => $messages,
		);
	}

}
