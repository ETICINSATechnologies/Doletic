<?php

require_once "interfaces/AbstractDBObject.php";
require_once "interfaces/AbstractObjectServices.php";
require_once "objects/DBTable.php"; 

/**
 *	@brief The User class
 */
class User implements \JsonSerializable {
	
	// -- consts

	// -- attributes
	private $id;
	private $username;
	private $last_connection_timestamp;
	private $sign_up_timestamp;

	/**
	*	@brief Constructs a user
	*/
	public function __construct($id, $username, $lastConnectionTimestamp, $signUpTimestamp) {
		$this->id = $id;
		$this->username = $username;
		$this->last_connection_timestamp = $lastConnectionTimestamp;
		$this->sign_up_timestamp = $signUpTimestamp;
	}

	public function jsonSerialize() {
		return [
			UserDBObject::COL_ID => $this->id,
			UserDBObject::COL_USERNAME => $this->username,
			UserDBObject::COL_LAST_CON_TSMP => $this->last_connection_timestamp,
			UserDBObject::COL_SIGNUP_TSMP => $this->sign_up_timestamp
		];
	}

	/**
	*	@brief Returns user firstname and name concatenated
	*	@return string
	*/
	public function GetId() {
		return $this->id;
	}
	/**
	*	@brief Returns user firstname and name concatenated
	*	@return string
	*/
	public function GetUsername() {
		return $this->username;
	}
	/**
	*	@brief Returns birthdate formatted : yyyy-mm-dd
	*	@return string
	*/
	public function GetLastConnectionTimestamp() {
		return $this->last_connection_timestamp;
	}
	/**
	*	@brief Returns inscription date
	*	@return string
	*/
	public function GetSignUpTimestamp() {
		return $this->sign_up_timestamp;
	}

}


class UserServices extends AbstractObjectServices {

	// -- consts
	// --- params keys
	const PARAM_ID 		= "id";
	const PARAM_UNAME 	= "username";
	const PARAM_HASH	= "password";
	// --- internal services (actions)
	const GET_USER_BY_ID 	= "byid";
	const GET_USER_BY_UNAME = "byuname";
	const GET_ALL_USERS 	= "all";
	const INSERT_USER		= "insert";
	const UPDATE_USER		= "update";
	const DELETE_USER		= "delete";
	// -- functions

	// -- construct
	public function __construct($dbObject, $dbConnection) {
		parent::__construct($dbObject, $dbConnection);
	}

	public function GetResponseData($action, $params) {
		$data = null;
		if(!strcmp($action, UserServices::GET_USER_BY_ID)) {
			$data = $this->getUserById($params[UserServices::PARAM_ID]);
		} else if(!strcmp($action, UserServices::GET_USER_BY_UNAME)) {
			$data = $this->getUserByUsernameAndHash($params[UserServices::PARAM_UNAME], $params[UserServices::PARAM_HASH]);
		} else if(!strcmp($action, UserServices::GET_ALL_USERS)) {
			$data = $this->getAllUsers();
		} else if(!strcmp($action, UserServices::INSERT_USER)) {
			$data = $this->insertUser($params[UserServices::PARAM_UNAME], $params[UserServices::PARAM_HASH]);
		} else if(!strcmp($action, UserServices::UPDATE_USER)) {
			$data = $this->updateUserPassword($params[UserServices::PARAM_ID], $params[UserServices::PARAM_HASH]);
		} else if(!strcmp($action, UserServices::DELETE_USER)) {
			$data = $this->deleteUser($params[UserServices::PARAM_ID]);
		}
		return $data;
	}

# PROTECTED & PRIVATE ####################################################

	// -- consult

	private function getUserById($id) {
		// create sql params array
		$sql_params = array(":".UserDBObject::COL_ID => $id);
		// create sql request
		$sql = parent::getDBObject()->GetTable(UserDBObject::TABL_USER)->GetSELECTQuery(
			array(DBTable::SELECT_ALL), array(UserDBObject::COL_ID));
		// execute SQL query and save result
		$pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
		// create ticket var
		$user = null;
		if($pdos != null) {
			if( ($row = $pdos->fetch()) !== false) {
				$user = new User(
					$row[UserDBObject::COL_ID], 
					$row[UserDBObject::COL_USERNAME], 
					$row[UserDBObject::COL_LAST_CON_TSMP], 
					$row[UserDBObject::COL_SIGNUP_TSMP]);
			}
		}
		return $user;
	}

	private function getUserByUsernameAndHash($username, $hash) {
		// create sql params array
		$sql_params = array(
			":".UserDBObject::COL_USERNAME => $username,
			":".UserDBObject::COL_PASSWORD => $hash
			);
		// create sql request
		$sql = parent::getDBObject()->GetTable(UserDBObject::TABL_USER)->GetSELECTQuery(
			array(DBTable::SELECT_ALL), array(UserDBObject::COL_USERNAME, UserDBObject::COL_PASSWORD));
		// execute SQL query and save result
		$pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
		// create ticket var
		$user = null;
		if($pdos != null) {
			if( ($row = $pdos->fetch()) !== false) {
				$user = new User(
					$row[UserDBObject::COL_ID], 
					$row[UserDBObject::COL_USERNAME], 
					$row[UserDBObject::COL_LAST_CON_TSMP], 
					$row[UserDBObject::COL_SIGNUP_TSMP]);
			}
		}
		return $user;
	}

	private function getAllUsers() {
		// create sql request
		$sql = parent::getDBObject()->GetTable(UserDBObject::TABL_USER)->GetSELECTQuery();
		// execute SQL query and save result
		$pdos = parent::getDBConnection()->ResultFromQuery($sql, array());
		// create an empty array for tickets and fill it
		$users = array();
		if($pdos != null) {
			while( ($row = $pdos->fetch()) !== false) {
				array_push($users, new User(
					$row[UserDBObject::COL_ID], 
					$row[UserDBObject::COL_USERNAME], 
					$row[UserDBObject::COL_LAST_CON_TSMP], 
					$row[UserDBObject::COL_SIGNUP_TSMP]));
			}
		}
		return $users;
	}

	// -- modify

	private function insertUser($username, $hash) {
		// create sql params
		$sql_params = array(
			":".UserDBObject::COL_ID => "NULL",
			":".UserDBObject::COL_USERNAME => $username,
			":".UserDBObject::COL_PASSWORD => $hash,
			":".UserDBObject::COL_LAST_CON_TSMP => date(DateTime::ISO8601),
			":".UserDBObject::COL_SIGNUP_TSMP => date(DateTime::ISO8601));
		// create sql request
		$sql = parent::getDBObject()->GetTable(UserDBObject::TABL_USER)->GetINSERTQuery();
		// execute query
		return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
	} 

	private function updateUserPassword($id, $hash) {
		// create sql params
		$sql_params = array(
			":".UserDBObject::COL_ID => $id,
			":".UserDBObject::COL_PASSWORD => $hash);
		// create sql request
		$sql = parent::getDBObject()->GetTable(UserDBObject::TABL_USER)->GetUPDATEQuery(array(UserDBObject::COL_PASSWORD));
		// execute query
		return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
	}

	private function deleteUser($id) {
		// create sql params
		$sql_params = array(":".UserDBObject::COL_ID => $id);
		// create sql request
		$sql = parent::getDBObject()->GetTable(UserDBObject::TABL_USER)->GetDELETEQuery();
		// execute query
		return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
	}

}

/**
 *	@brief User object interface
 */
class UserDBObject extends AbstractDBObject {

	// -- consts
	// --- object name
	const OBJ_NAME = "user";
	// --- tables
	const TABL_USER = "dol_user";
	// --- columns
	const COL_ID = "id";
	const COL_USERNAME = "username";
	const COL_PASSWORD = "password";
	const COL_LAST_CON_TSMP = "last_connect_timestamp";
	const COL_SIGNUP_TSMP = "sign_up_timestamp";
	// -- attributes

	// -- functions

	public function __construct(&$dbConnection) {
		// -- construct parent
		parent::__construct($dbConnection, "user");
		// -- create tables
		// --- dol_user table
		$dol_user = new DBTable(UserDBObject::TABL_USER);
		$dol_user->AddColumn(UserDBObject::COL_ID, DBTable::DT_INT, 11, false, "", true, true);
		$dol_user->AddColumn(UserDBObject::COL_USERNAME, DBTable::DT_VARCHAR, 255, false);
		$dol_user->AddColumn(UserDBObject::COL_PASSWORD, DBTable::DT_VARCHAR, 255, false);
		$dol_user->AddColumn(UserDBObject::COL_LAST_CON_TSMP, DBTable::DT_VARCHAR, 255, false);
		$dol_user->AddColumn(UserDBObject::COL_SIGNUP_TSMP, DBTable::DT_VARCHAR, 255, false);

		// -- add tables
		parent::addTable($dol_user);
	}

	/**
	 *	@brief Returns all services associated with this object
	 */
	public function GetServices() {
		return new UserServices($this, $this->getDBConnection());
	}

}