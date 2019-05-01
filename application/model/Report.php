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
 * Report model
 */
abstract class Report {

	/**
	 * Returns monthly income/expenses report for 5 last monthes
	 * @return array
	 */
	public static function getSummaryMonthData($account_id = 0) {
		$monthes = array('Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек');
		$result = array();
		$db = Database::getInstance();
		$user_id = User::loggedUserID();
		for ($i=4; $i>=0; $i--) {
			$year_from = date('Y', time() - 30*24*60*60 * ($i-1));
			$month_from = date('m', time() - 30*24*60*60 * ($i-1));
			$date_from = $year_from.'-'.$month_from.'-01';
			$year_to = date('Y', time() - 30*24*60*60 * $i);
			$month_to = date('m', time() - 30*24*60*60 * $i);
			$date_to = $year_to.'-'.$month_to.'-01';
			$month_stat = $monthes[date('n', time() - 30*24*60*60 * ($i))-1].'. '.$year_to;
			$where = '';
			if ($account_id > 0) {
				$where = 'and op.account_id = :account_id';
			}
			$query = $db->prepare("
				select
					sum(op.sum) s,
					op.op_type
				from operations op
				where
					op.user_id = :user_id
						and
					op.dt >= :date_to
						and
					op.dt < :date_from
				".$where."
				group by op.op_type
			");
			$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
			$query->bindParam(':date_from', $date_from, PDO::PARAM_STR);
			$query->bindParam(':date_to', $date_to, PDO::PARAM_STR);
			if ($account_id > 0) {
				$query->bindParam(':account_id', $account_id, PDO::PARAM_INT);
			}
			$query->execute();
			$query->setFetchMode(PDO::FETCH_ASSOC);
			$result_month = array();
			$result_month['name'] = $month_stat;
			$result_month['data'][1]['value'] = 0;
			$result_month['data'][2]['value'] = 0;
			while ($row = $query->fetch()) {
				$result_month['data'][$row['op_type']]['value'] = $row['s'];
			}
			$result[] = $result_month;
		}
		return $result;
	}

	/**
	 * Returns monthly income/expenses report for 5 last monthes
	 * @return array
	 */
	public static function getReportTagMonthData($tag_name = '', $account_id = 0) {
		$monthes = array('Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек');
		$result = array();
		$db = Database::getInstance();
		$user_id = User::loggedUserID();
		for ($i=4; $i>=0; $i--) {
			$year_from = date('Y', time() - 30*24*60*60 * ($i-1));
			$month_from = date('m', time() - 30*24*60*60 * ($i-1));
			$date_from = $year_from.'-'.$month_from.'-01';
			$year_to = date('Y', time() - 30*24*60*60 * $i);
			$month_to = date('m', time() - 30*24*60*60 * $i);
			$date_to = $year_to.'-'.$month_to.'-01';
			$month_stat = $monthes[date('n', time() - 30*24*60*60 * ($i))-1].'. '.$year_to;
			$where = '';
			if ($account_id > 0) {
				$where = 'and op.account_id = :account_id';
			}
			$query = $db->prepare("
				select
					sum(op.sum) s,
					op.op_type
				from operations op
				left join operation_tags ot
					on ot.operation_id = op.id
				left join user_tags t
					on t.id = ot.tag_id
				where
					op.user_id = :user_id
						and
					op.dt >= :date_to
						and
					op.dt < :date_from
						and
					t.name = :tag_name
				".$where."
				group by op.op_type
			");
			$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
			$query->bindParam(':date_from', $date_from, PDO::PARAM_STR);
			$query->bindParam(':date_to', $date_to, PDO::PARAM_STR);
			$query->bindParam(':tag_name', $tag_name, PDO::PARAM_STR);
			if ($account_id > 0) {
				$query->bindParam(':account_id', $account_id, PDO::PARAM_INT);
			}
			$query->execute();
			$query->setFetchMode(PDO::FETCH_ASSOC);
			$result_month = array();
			$result_month['name'] = $month_stat;
			$result_month['data'][1]['value'] = 0;
			$result_month['data'][2]['value'] = 0;
			while ($row = $query->fetch()) {
				$result_month['data'][$row['op_type']]['value'] = $row['s'];
			}
			$result[] = $result_month;
		}
		return $result;
	}

	/**
	 * Returns last month operations summary by tags
	 * @return array
	 */
	public static function getSummaryLastData($op_type = Money::OP_NOP, $account_id = 0) {
		$result = array();
		$db = Database::getInstance();
		$user_id = User::loggedUserID();
		$where = '';
		if ($account_id > 0) {
			$where = 'and op.account_id = :account_id';
		}
		$query = $db->prepare("
			select
				sum(op.sum) sum,
				ot.tag_id,
				t.name
			from operations op
			left join operation_tags ot
				on ot.operation_id = op.id
			left join user_tags t
				on t.id = ot.tag_id
			where
				op.user_id = :user_id
					and
				unix_timestamp(now()) - unix_timestamp(dt) <= 30*24*60*60
					and
				op_type = :op_type
			".$where."
			group by ot.tag_id
			order by sum desc
		");
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':op_type', $op_type, PDO::PARAM_INT);
		if ($account_id > 0) {
			$query->bindParam(':account_id', $account_id, PDO::PARAM_INT);
		}
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		while ($row = $query->fetch()) {
			$result[] = $row;
		}
		return $result;
	}

}
