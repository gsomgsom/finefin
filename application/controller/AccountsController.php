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
 * Accounts controller
 */
class AccountsController extends Controller_Auth {

	/**
	 * Accounts list
	 */
	public function Index() {

		$request = Request::getInstance();

		$alertAddSuccess = false;
		$alertAddError = false;
		$alertEditSuccess = false;
		$alertEditError = false;

		// Operations
		if ($request->hasParam('operation')) {
			$operation = $request->getParam('operation');

			// Add
			if ($operation == 'add') {
				$description = $request->getParam('description');
				$color = str_replace('#', '', $request->getParam('color'));

				if (Money::addAccountEntry($description, $color)) {
					// Go to accounts page
					header('Location: /accounts/?operation=successAdd');
				}
				else {
					// Go to accounts page
					header('Location: /accounts/?operation=errorAdd');
				}
			}

			// Edit
			if ($operation == 'edit') {
				$id = intval($request->getParam('id'));
				$description = $request->getParam('description');
				$color = str_replace('#', '', $request->getParam('color'));

				if (Money::editAccountEntry($id, $description, $color)) {
					// Go to accounts page
					header('Location: /accounts/?operation=successEdit');
				}
				else {
					// Go to accounts page
					header('Location: /accounts/?operation=errorEdit');
				}
			}

			// Alert success add
			if ($operation == 'successAdd') {
				$alertAddSuccess = true;
			}

			// Alert error add
			if ($operation == 'errorAdd') {
				$alertAddError = true;
			}

			// Alert success edit
			if ($operation == 'successEdit') {
				$alertEditSuccess = true;
			}

			// Alert error edit
			if ($operation == 'errorEdit') {
				$alertEditError = true;
			}

		}

		return array(
			'accounts' => Money::getAccounts(),
			'alertAddSuccess' => $alertAddSuccess,
			'alertAddError' => $alertAddError,
			'alertEditSuccess' => $alertEditSuccess,
			'alertEditError' => $alertEditError,
		);
	}

}
