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
 * Money operations model
 */
abstract class Money {

	// Operation type consts
	const OP_NOP       = 0; // No operation (abstract)
	const OP_EXPENSE   = 1; // Expense
	const OP_INCOME    = 2; // Income
	const OP_EXCHANGE  = 3; // Exchange

	/**
	 * Returns text name of operation by id
	 * @return string
	 */
	public static function getOperationText($op_type = Money::OP_NOP) {

		switch ($op_type) {
			case self::OP_NOP:
				return 'Без операции';

			case self::OP_EXPENSE:
				return 'Расход';

			case self::OP_INCOME:
				return 'Доход';

			case self::OP_EXCHANGE:
				return 'Перевод';

			default:
				return 'Неизвестно';
		}

	}

	/**
	 * Returns last X income/expense operations of current user
	 * @return array
	 */
	public static function getOperationsData($op_type = Money::OP_NOP, $limit_from = 0, $limit_count = 50, $user_id = 0) {
		$db = Database::getInstance();
		$user_id = $user_id ? $user_id : User::loggedUserID();
		if ($op_type > Money::OP_NOP) {
			$op_where = "and op.op_type = :op_type";
		}
		else {
			$op_where = "";
		}
		$query = "select op.id, op.dt, op.sum, op.op_type, op.currency, op.description, op.account_id, op.account2_id, abs(op.required) required, abs(op.planned) planned, ac.name account_name, ac.color account_color, ac.icon account_icon from operations op left join accounts ac on (op.account_id = ac.id) where op.user_id = :user_id $op_where order by op.dt desc, op.id desc limit :limit_from, :limit_count";
		$query = $db->prepare($query);
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':limit_from', $limit_from, PDO::PARAM_INT);
		$query->bindParam(':limit_count', $limit_count, PDO::PARAM_INT);
		if ($op_type > Money::OP_NOP) {
			$query->bindParam(':op_type', $op_type, PDO::PARAM_INT);
		}
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$result = array();
		while ($row = $query->fetch()) {
			$result[] = $row;
		}

		// Get tags @todo - one query at all...
		foreach ($result as &$entry) {
			$entry['tags'] = self::getOperationTags($entry['id']);
			$entry['tag_ids'] = self::getOperationTagIDs($entry['id']);
		}

		return $result;
	}

	/**
	 * Returns accounts of current user
	 * @return array
	 */
	public static function getAccounts() {
		$db = Database::getInstance();
		$user_id = User::loggedUserID();
		$query = "select ac.* from accounts ac where ac.user_id = :user_id order by ac.id asc";
		$query = $db->prepare($query);
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$result = array();
		while ($row = $query->fetch()) {
			$result[] = $row;
		}
		return $result;
	}

	/**
	 * Returns account of current user by ID
	 * @return array
	 */
	public static function getAccountByID($account_id) {
		foreach (self::getAccounts() as $accountEntry) {
			if ($account_id == $accountEntry['id']) {
				return $accountEntry;
			}
		}
		return array(
			'id'      => $account_id,
			'name'    => 'Неизвестный счёт',
			'color'   => 'FF0000',
			'curr_id' => 3,
		);
	}

	/**
	 * Add operation entry to current user
	 * @return boolean
	 */
	public static function addOperationEntry($op_type, $dt, $sum, $description, $account_id, $required, $planned, $account2_id = NULL, $tags = Array()) {
		$db = Database::getInstance();
		$user_id = User::loggedUserID();
		$currency = 3; // RUB @TODO: use this property
		$query = "insert into operations (user_id, dt, sum, op_type, currency, description, account_id, account2_id, required, planned) values (:user_id, :dt, :sum, :op_type, :currency, :description, :account_id, :account2_id, :required, :planned)";
		$query = $db->prepare($query);
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':dt', $dt, PDO::PARAM_STR);
		$query->bindParam(':sum', $sum, PDO::PARAM_STR);
		$query->bindParam(':op_type', $op_type, PDO::PARAM_INT);
		$query->bindParam(':currency', $currency, PDO::PARAM_INT);
		$query->bindParam(':description', $description, PDO::PARAM_STR);
		$query->bindParam(':account_id', $account_id, PDO::PARAM_INT);
		$query->bindParam(':account2_id', $account2_id, PDO::PARAM_INT);
		$query->bindParam(':required', $required, PDO::PARAM_INT);
		$query->bindParam(':planned', $planned, PDO::PARAM_INT);
		$result = $query->execute();
		$lastId = $db->lastInsertId();
		if ($result) {
			foreach ($tags as $tag) {
				$query = "insert into operation_tags (operation_id, tag_id) values (:operation_id, :tag_id)";
				$query = $db->prepare($query);
				$query->bindParam(':operation_id', $lastId, PDO::PARAM_INT);
				$query->bindParam(':tag_id', $tag, PDO::PARAM_INT);
				$query->execute();
			}
		}
		return $result;
	}

	/**
	 * Edit operation entry of current user
	 * @return boolean
	 */
	public static function editOperationEntry($id, $op_type, $dt, $sum, $description, $account_id, $required, $planned, $account2_id = NULL, $tags = Array()) {
		$db = Database::getInstance();
		$user_id = User::loggedUserID();
		$query = "update operations set dt=:dt, sum=:sum, op_type=:op_type, description=:description, account_id=:account_id, account2_id=:account2_id, required=:required, planned=:planned where id=:id and user_id=:user_id";
		$query = $db->prepare($query);
		$query->bindParam(':dt', $dt, PDO::PARAM_STR);
		$query->bindParam(':sum', $sum, PDO::PARAM_STR);
		$query->bindParam(':op_type', $op_type, PDO::PARAM_INT);
		$query->bindParam(':description', $description, PDO::PARAM_STR);
		$query->bindParam(':account_id', $account_id, PDO::PARAM_INT);
		$query->bindParam(':account2_id', $account2_id, PDO::PARAM_INT);
		$query->bindParam(':required', $required, PDO::PARAM_INT);
		$query->bindParam(':planned', $planned, PDO::PARAM_INT);
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$result = $query->execute();
		if ($result) {
			$query = $db->prepare("delete from operation_tags where operation_id = :operation_id");
			$query->bindParam(':operation_id', $id, PDO::PARAM_INT);
			$query->execute();
			foreach ($tags as $tag) {
				$query = "insert into operation_tags (operation_id, tag_id) values (:operation_id, :tag_id)";
				$query = $db->prepare($query);
				$query->bindParam(':operation_id', $id, PDO::PARAM_INT);
				$query->bindParam(':tag_id', $tag, PDO::PARAM_INT);
				$query->execute();
			}
		}
		return $result;
	}

	/**
	 * Delete operation entry
	 * @return boolean
	 */
	public static function deleteOperationEntry($id) {
		if ($id) {
			$db = Database::getInstance();
			$user_id = User::loggedUserID();
			$query = $db->prepare("delete from operations where id = :id and user_id=:user_id");
			$query->bindParam(':id', $id, PDO::PARAM_INT);
			$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
			$query->execute();
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Add account entry to current user
	 * @return boolean
	 */
	public static function addAccountEntry($name, $color) {
		$db = Database::getInstance();
		$user_id = User::loggedUserID();
		$currency = 3; // RUB @TODO: use this property
		$query = "insert into accounts (user_id, curr_id, name, color) values (:user_id, :currency, :name, :color)";
		$query = $db->prepare($query);
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':currency', $currency, PDO::PARAM_INT);
		$query->bindParam(':name', $name, PDO::PARAM_STR);
		$query->bindParam(':color', $color, PDO::PARAM_STR);
		return $query->execute();
	}

	/**
	 * Edit account entry of current user
	 * @return boolean
	 */
	public static function editAccountEntry($id, $name, $color) {
		$db = Database::getInstance();
		$user_id = User::loggedUserID();
		$query = "update accounts set name=:name, color=:color where id=:id and user_id=:user_id";
		$query = $db->prepare($query);
		$query->bindParam(':name', $name, PDO::PARAM_STR);
		$query->bindParam(':color', $color, PDO::PARAM_STR);
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		return $query->execute();
	}

	/**
	 * Returns tags list
	 * @return array
	 */
	public static function getTags($op_id = NULL) {
		$db = Database::getInstance();
		$user_id = User::loggedUserID();
		$where = "";
		if (!is_null($op_id)) {
			$where =" where operation_id=".intval($op_id);
		}
		if ($where == "") {
			$where = " where ";
		}
		$where.="user_id = :user_id";
		$query = "select * from user_tags ".$where." order by name asc";
		$query = $db->prepare($query);
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$result = array();
		while ($row = $query->fetch()) {
			$result[] = $row;
		}
		return $result;
	}

	/**
	 * Returns operation tags list
	 * @return array
	 */
	public static function getOperationTags($op_id) {
		$db = Database::getInstance();
		$query = "select t.name from operation_tags ot left join user_tags t on (ot.tag_id = t.id) where operation_id=:op_id order by t.name asc";
		$query = $db->prepare($query);
		$query->bindParam(':op_id', $op_id, PDO::PARAM_INT);
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$result = array();
		while ($row = $query->fetch()) {
			$result[] = $row['name'];
		}
		return $result;
	}

	/**
	 * Returns operation tag id's
	 * @return array
	 */
	public static function getOperationTagIDs($op_id) {
		$db = Database::getInstance();
		$query = "select t.id from operation_tags ot left join user_tags t on (ot.tag_id = t.id) where operation_id=:op_id order by t.name asc";
		$query = $db->prepare($query);
		$query->bindParam(':op_id', $op_id, PDO::PARAM_INT);
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$result = array();
		while ($row = $query->fetch()) {
			$result[] = $row['id'];
		}
		return $result;
	}

	/**
	 * Returns debts of current user
	 * @return array
	 */
	public static function getDebts() {
		$db = Database::getInstance();
		$user_id = User::loggedUserID();
		$query = "select d.* from debts d where d.user_id = :user_id order by d.id asc";
		$query = $db->prepare($query);
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$result = array();
		while ($row = $query->fetch()) {
			$result[] = $row;
		}
		return $result;
	}

	/**
	 * Delete debt entry of current user
	 * @return boolean
	 */
	public static function deleteDebtEntry($id) {
		if ($id) {
			$db = Database::getInstance();
			$user_id = User::loggedUserID();
			$query = $db->prepare("delete from debts where id = :id and user_id=:user_id");
			$query->bindParam(':id', $id, PDO::PARAM_INT);
			$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
			$query->execute();
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Add debt entry to current user
	 * @return boolean
	 */
	public static function addDebtEntry($sum, $description) {
		$db = Database::getInstance();
		$user_id = User::loggedUserID();
		$query = "insert into debts (user_id, sum, description) values (:user_id, :sum, :description)";
		$query = $db->prepare($query);
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':sum', $sum, PDO::PARAM_STR);
		$query->bindParam(':description', $description, PDO::PARAM_STR);
		return $query->execute();
	}

	/**
	 * Edit debt entry of current user
	 * @return boolean
	 */
	public static function editDebtEntry($id, $sum, $description) {
		$db = Database::getInstance();
		$user_id = User::loggedUserID();
		$query = "update debts set sum=:sum, description=:description where id=:id and user_id=:user_id";
		$query = $db->prepare($query);
		$query->bindParam(':sum', $sum, PDO::PARAM_STR);
		$query->bindParam(':description', $description, PDO::PARAM_STR);
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		return $query->execute();
	}

	/**
	 * Add tag entry to current user
	 * @return boolean
	 */
	public static function addTagEntry($name) {
		$db = Database::getInstance();
		$user_id = User::loggedUserID();
		$query = "insert into user_tags (user_id, name) values (:user_id, :name)";
		$query = $db->prepare($query);
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$query->bindParam(':name', $name, PDO::PARAM_STR);
		return $query->execute();
	}

	/**
	 * Edit tag entry of current user
	 * @return boolean
	 */
	public static function editTagEntry($id, $name) {
		$db = Database::getInstance();
		$user_id = User::loggedUserID();
		$query = "update user_tags set name=:name where id=:id and user_id=:user_id";
		$query = $db->prepare($query);
		$query->bindParam(':name', $name, PDO::PARAM_STR);
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		return $query->execute();
	}

}
