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
 * Reports controller
 */
class ReportController extends Controller_Auth {

	/**
	 * Redirect to summary report page
	 */
	public function Index() {
	  // Go to summary report page
	  header('Location: /report/summary/');
	}

	/**
	 * Summary report page
	 */
	public function Summary() {
		$request = Request::getInstance();

		$account_id = 0;
		if ($request->hasParam('account_id')) {
			$account_id = intval(Funcs::parseCleanValue($request->getParam('account_id')));
		}

		return array(
			'monthData'	=> Report::getSummaryMonthData($account_id),
			'lastExpData'	=> Report::getSummaryLastData(Money::OP_EXPENSE, $account_id),
			'lastIncData'	=> Report::getSummaryLastData(Money::OP_INCOME, $account_id),
			'account'	=> Money::getAccountByID($account_id),
		);
	}

	/**
	 * Tag report page
	 */
	public function Tag() {
		$request = Request::getInstance();

		$tag_name = '';
		if ($request->hasParam('tag')) {
			$tag_name = Funcs::parseCleanValue($request->getParam('tag'));
		}

		return array(
			'tag_name'	=> $tag_name,
			'monthData'	=> Report::getReportTagMonthData($tag_name),
		);
	}

}
