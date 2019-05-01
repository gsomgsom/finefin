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
 * Operations controller
 */
class OperationsController extends Controller_Auth {

	/**
	 * Index action
 	 */
	public function Index() {

		$request = Request::getInstance();

		$alertAddSuccess = false;
		$alertEditSuccess = false;
		$alertDeleteSuccess = false;

		// Operations
		if ($request->hasParam('operation')) {
			$operation = $request->getParam('operation');

			// Add
			if ($operation == 'add') {
				$dt = date("Y-m-d", strtotime($request->getParam('dt')));
				$sum = $request->getParam('sum');
				$op_type = $request->getParam('op_type');
				$description = $request->getParam('description');
				$account_id = intval($request->getParam('account'));
				$account2_id = intval($request->getParam('account2'));
				$tags = explode(';', $request->getParam('tagsContainer'));
				if ($op_type != Money::OP_EXCHANGE) {
					$account2_id = NULL;
				}
				if ($request->hasParam('required') && ($request->getParam('required')=='on')) {
					$required = TRUE;
				}
				else {
					$required = FALSE;
				}
				if ($request->hasParam('planned') && ($request->getParam('planned')=='on')) {
					$planned = TRUE;
				}
				else {
					$planned = FALSE;
				}

				if (Money::addOperationEntry($op_type, $dt, $sum, $description, $account_id, $required, $planned, $account2_id, $tags)) {
					// Go to operations page
					header('Location: /operations/?operation=successAdd');
				}
				else {
					// Go to operations page
					header('Location: /operations/?operation=errorAdd');
				}
			}

			// Edit
			if ($operation == 'edit') {
				$dt = date("Y-m-d", strtotime($request->getParam('dt')));
				$id = intval($request->getParam('id'));
				$sum = $request->getParam('sum');
				$op_type = $request->getParam('op_type');
				$description = $request->getParam('description');
				$account_id = intval($request->getParam('account'));
				$account2_id = intval($request->getParam('account2'));
				$tags = explode(';', $request->getParam('tagsContainer'));
				if ($op_type != Money::OP_EXCHANGE) {
					$account2_id = NULL;
				}
				if ($request->hasParam('required') && ($request->getParam('required')=='on')) {
					$required = TRUE;
				}
				else {
					$required = FALSE;
				}
				if ($request->hasParam('planned') && ($request->getParam('planned')=='on')) {
					$planned = TRUE;
				}
				else {
					$planned = FALSE;
				}

				if (Money::editOperationEntry($id, $op_type, $dt, $sum, $description, $account_id, $required, $planned, $account2_id, $tags)) {
					// Go to operations page
					header('Location: /operations/?operation=successEdit');
				}
				else {
					// Go to operations page
					header('Location: /operations/?operation=errorEdit');
				}
			}

			// Delete
			if ($operation == 'delete') {
				$id = intval($request->getParam('id'));

				if (Money::deleteOperationEntry($id)) {
					// Go to operations page
					header('Location: /operations/?operation=successDelete');
				}
				else {
					// Go to operations page
					header('Location: /operations/?operation=errorDelete');
				}
			}

			// Alert success add
			if ($operation == 'successAdd') {
				$alertAddSuccess = true;
			}

			// Alert success edit
			if ($operation == 'successEdit') {
				$alertEditSuccess = true;
			}

			// Alert success delete
			if ($operation == 'successDelete') {
				$alertDeleteSuccess = true;
			}
		}

		return array(
			'operationsData' => Money::getOperationsData(Money::OP_NOP, 0, 500),
			'accounts' => Money::getAccounts(),
			'tags' => Money::getTags(),
			'alertAddSuccess' => $alertAddSuccess,
			'alertEditSuccess' => $alertEditSuccess,
			'alertDeleteSuccess' => $alertDeleteSuccess,
		);
	}

	/**
	 * Export action
 	 */
	public function Export() {
		return array(
			'operationsData' => Money::getOperationsData(Money::OP_NOP, 0, 100000),
		);
	}

	/**
	 * Add form
 	 */
	public function Addform() {
		return array(
			'accounts' => Money::getAccounts(),
			'tags' => Money::getTags(),
		);
	}

	/**
	 * Archive
 	 */
	public function Archive() {
		return array(
			'operationsData' => Money::getOperationsData(Money::OP_NOP, 0, 100000),
			'accounts' => Money::getAccounts(),
			'tags' => Money::getTags(),
		);
	}

}
