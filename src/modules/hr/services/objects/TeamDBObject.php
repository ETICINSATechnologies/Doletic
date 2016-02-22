<?php

require_once "interfaces/AbstractDBObject.php";
require_once "interfaces/AbstractObjectServices.php";
require_once "objects/DBTable.php"; 

/**
 * @brief Team object
 */
class Team implements \JsonSerializable {
	
	// -- consts
	const AUTO_ID = -1;

	// -- attributes
	private $id;
	private $name;
	private $leader_id;
	private $creation_date;
	private $division;
	private $members;

	/**
	*	@brief Constructs a team
	*	@param string $name
	*		Team name
	*	@param int $leaderId
	*		Leader's ID 
	*	@param string $creationDate
	*		Team creation date
	*	@param string $division
	*		Related division
	*   @param user[] $members
	*		Team members
	*/
	public function __construct($id, $leaderId, $creationDate, $division, $members) {
		$this->id = intval($id);
		$this->name = $name;
		$this->leader_id = intval($leaderId);
		$this->creation_date = $creationDate;
		$this->division = $division;
		$this->members = $members;
	}

public function jsonSerialize() {
		return [
			TeamDBObject::COL_ID => $this->id,
			TeamDBObject::COL_NAME => $this->name,
			TeamDBObject::COL_LEADER_ID => $this->leader_id,
			TeamDBObject::COL_CREATION_DATE => $this->creation_date,
			TeamDBObject::COL_DIVISION => $this->division,
			TeamDBObject::COL_MEMBER_ID => $this->members,
		];
	}

	/**
	 * @brief Returns object's id
	 * @return int
	 */
	public function GetId() {
		return $this->id;
	}
	/**
	 * @brief 
	 */
	public function GetName() {
		return $this->name;
	}
	/**
	 * @brief
	 */
	public function GetLeaderId() {
		return $this->leader_id;
	}
	/**
	 * @brief
	 */
	public function GetCreationDate() {
		return $this->creation_date;
	}
	/**
	 * @brief
	 */
	public function GetDivision() {
		return $this->division;
	}
	/**
	 * @brief
	 */
	public function GetMembers() {
		return $this->members;
	}
}

/**
 * @brief Team object related services
 */
class TeamServices extends AbstractObjectServices {
	
	// -- consts
	// --- params
	const PARAM_ID 			= "id";
	const PARAM_NAME	 	= "name";
	const PARAM_LEADER		= "leaderId";
	const PARAM_CREATION 	= "creationDate";
	const PARAM_DIVISION	= "division";
	const PARAM_MEMBER_ID   = "memberId";
	// --- actions
	const GET_TEAM_BY_ID 	= "byidt";
	const GET_TEAM_BY_DIV = "bydiv";
	const GET_TEAM_MEMBERS = "memt";
	const GET_ALL_TEAMS  = "allt";
	const GET_USER_TEAMS = "allut";
	const GET_ALL_DIVISIONS = "alldiv";
	const INSERT_MEMBER = "insmem";
	const DELETE_MEMBER = "delmem";
	const INSERT 		   = "insert";
	const UPDATE           = "update";
	const DELETE           = "delete";

	// -- functions

	// --- construct
	public function __construct($currentUser, $dbObject, $dbConnection) {
		parent::__construct($currentUser, $dbObject, $dbConnection);
	}

	public function GetResponseData($action, $params) {
		$data = null;
		if(!strcmp($action, TeamServices::GET_TEAM_BY_ID)) {
			$data = $this->__get_team_by_id($params[TeamServices::PARAM_ID]);
		} else if(!strcmp($action, TeamServices::GET_TEAM_BY_DIV)) {
			$data = $this->__get_team_by_division($params[TeamServices::PARAM_DIVISION]);
		} else if(!strcmp($action, TeamServices::GET_TEAM_MEMBERS)) {
			$data = $this->__get_team_members($params[TeamServices::PARAM_ID]);
		} else if(!strcmp($action, TeamServices::GET_ALL_TEAMS)) {
			$data = $this->__get_all_teams();
		} else if(!strcmp($action, TeamServices::GET_USER_TEAMS)) {
			$data = $this->__get_current_user_Teams();
		} else if(!strcmp($action, TeamServices::GET_ALL_DIVISIONS)) {
			$data = $this->__get_all_divisions();
		} else if(!strcmp($action, TeamServices::INSERT_MEMBER)) {
			$data = $this->__insert_member($params[TeamServices::PARAM_ID], $params[TeamServices::PARAM_MEMBER_ID]);
		} else if(!strcmp($action, TeamServices::DELETE_MEMBER)) {
			$data = $this->__delete_member($params[TeamServices::PARAM_ID], $params[TeamServices::PARAM_MEMBER_ID]);
		} else if(!strcmp($action, TeamServices::INSERT)) {
			$data = $this->__insert_team(
				$params[TeamServices::PARAM_NAME],
				$params[TeamServices::PARAM_LEADER],
				$params[TeamServices::PARAM_DIVISION]);
		} else if(!strcmp($action, TeamServices::UPDATE)) {
			$data = $this->__update_team(
				$params[TeamServices::PARAM_ID],
				$params[TeamServices::PARAM_NAME],
				$params[TeamServices::PARAM_LEADER],
				$params[TeamServices::PARAM_DIVISION]);
		} else if(!strcmp($action, TeamServices::DELETE)) {
			$data = $this->__delete_team($params[TeamServices::PARAM_ID]);
		}
		return $data;
	}

# PROTECTED & PRIVATE ###############################################################

	// --- consult

	private function __get_team_by_id($id) {
		// create sql params array
		$sql_params = array(":".TeamDBObject::COL_ID => $id);
		// create sql request
		$sql = parent::getDBObject()->GetTable(TeamDBObject::TABL_TEAM)->GetSELECTQuery(
			array(DBTable::SELECT_ALL), array(TeamDBObject::COL_ID));
		// execute SQL query and save result
		$pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
		// create team var
		$team = null;
		if($pdos != null) {
			if( ($row = $pdos->fetch()) !== false) {
				$team = new Team(
					$row[TeamDBObject::COL_ID], 
					$row[TeamDBObject::COL_NAME], 
					$row[TeamDBObject::COL_LEADER_ID], 
					$row[TeamDBObject::COL_CREATION_DATE], 
					$row[TeamDBObject::COL_DIVISION],  
					__get_team_members($row[TeamDBObject::COL_ID]));
			}
		}
		return $team;
	}

	private function __get_team_by_division($division) {
		// create sql params array
		$sql_params = array(":".TeamDBObject::COL_DIVISION => $division);
		// create sql request
		$sql = parent::getDBObject()->GetTable(TeamDBObject::TABL_TEAM)->GetSELECTQuery(
			array(DBTable::SELECT_ALL), array(TeamDBObject::COL_DIVISION));
		// execute SQL query and save result
		$pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
		// create team var
		$teams = array();
		if($pdos != null) {
			while( ($row = $pdos->fetch()) !== false) {
				array_push($teams, new Team(
					$row[TeamDBObject::COL_ID], 
					$row[TeamDBObject::COL_NAME], 
					$row[TeamDBObject::COL_LEADER_ID], 
					$row[TeamDBObject::COL_CREATION_DATE], 
					$row[TeamDBObject::COL_DIVISION],  
					__get_team_members($row[TeamDBObject::COL_ID])));
			}
		}
		return $teams;
	}

	private function __get_team_members($id) {
		// create sql params array
		$sql_params = array(":".TeamDBObject::COL_ID => $id);
		// create sql request
		$sql = parent::getDBObject()->GetTable(TeamDBObject::TABL_MEMBERS)->GetSELECTQuery(
			array(DBTable::SELECT_ALL), array(TeamDBObject::COL_ID));
		// execute SQL query and save result
		$pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
		// create an empty array for members and fill it
		$memberIds = array();
		while( ($row = $pdos->fetch()) !== false) {
			array_push($memberIds, $row[TeamDBObject::COL_MEMBER_ID]);
		}
		return $memberIds;
	}

	private function __get_all_teams() {
		// create sql request
		$sql = parent::getDBObject()->GetTable(TeamDBObject::TABL_TEAM)->GetSELECTQuery();
		// execute SQL query and save result
		$pdos = parent::getDBConnection()->ResultFromQuery($sql, array());
		// create an empty array for teams and fill it
		$teams = array();
		if($pdos != null) {
			while( ($row = $pdos->fetch()) !== false) {
				array_push($teams, new Team(
					$row[TeamDBObject::COL_ID], 
					$row[TeamDBObject::COL_NAME], 
					$row[TeamDBObject::COL_LEADER_ID], 
					$row[TeamDBObject::COL_CREATION_DATE], 
					$row[TeamDBObject::COL_DIVISION],  
					__get_team_members($row[TeamDBObject::COL_ID])));
			}
		}
		return $teams;
	}

	private function __get_all_divisions() {
		// create sql request
		$sql = parent::getDBObject()->GetTable(TeamDBObject::TABL_DIV)->GetSELECTQuery();
		// execute SQL query and save result
		$pdos = parent::getDBConnection()->ResultFromQuery($sql, array());
		// create an empty array for teams and fill it
		$divisions = array();
		if($pdos != null) {
			while( ($row = $pdos->fetch()) !== false) {
				$divisions[$row[TeamDBObject::COL_ID]] = $row[TeamDBObject::COL_LABEL];
			}
		}
		return $divisions;
	}

	private function __get_current_user_teams() {
		// create sql params array
		$sql_params = array(":".TeamDBObject::COL_MEMBER_ID => parent::getCurrentUser()->GetId());
		// create sql request
		$sql = parent::getDBObject()->GetTable(TeamDBObject::TABL_MEMBERS)->GetSELECTQuery(
			array(DBTable::SELECT_ALL), array(TeamDBObject::COL_MEMBER_ID));
		// execute SQL query and save result
		$pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
		// create an empty array for Teams and fill it
		$teams = array();
		if($pdos != null) {
			while( ($row = $pdos->fetch()) !== false) {
				array_push($teams, __get_team_by_id($row[TeamDBObject::COL_ID]));
			}
		}
		return $Teams;
	}

	private function __insert_member($id, $memberId){
		// create sql request
		$sql_params = array(
			":".TeamDBObject::COL_ID => $id,
			":".TeamDBObject::COL_MEMBER_ID => $memberId);
		// create sql request
		$sql = parent::getDBObject()->GetTable(TeamDBObject::TABL_MEMBERS)->GetINSERTQuery();
		// execute query
		return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
	}

	private function __delete_member($id, $memberId) {
		// create sql params
		$sql_params = array(
			":".TeamDBObject::COL_ID => $id,
			":".TeamDBObject::COL_MEMBER_ID => $memberId);
		// create sql request
		$sql = parent::getDBObject()->GetTable(TeamDBObject::TABL_MEMBERS)->GetDELETEQuery();
		// execute query
		return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
	}

	// --- modify

	private function __insert_team($name, $leaderId, $division) {
		// create sql params
		$sql_params = array(
			":".TeamDBObject::COL_ID => "NULL",
			":".TeamDBObject::COL_NAME => $name,
			":".TeamDBObject::COL_LEADER_ID => $leaderId,
			":".TeamDBObject::COL_CREATION_DATE => date('Y-m-d'),
			":".TeamDBObject::COL_DIVISION => $division);
		// create sql request
		$sql = parent::getDBObject()->GetTable(TeamDBObject::TABL_TEAM)->GetINSERTQuery();
		// execute query
		if (parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params)) {
			// Add leader as member
			$params = array(":".TeamDBObject::COL_NAME => $name);
			$sql = parent::getDBObject()->GetTable(TeamDBObject::TABL_TEAM)->GetSELECTQuery();
			if( ($row = $pdos->fetch()) !== false) {
				return __insert_member($row[TeamDBObject::COL_ID], $leaderId);
			}
		}
		return FALSE;
	}

	private function __update_Team($id, $name, $leaderId, $division) {
		// create sql params
		$sql_params = array(
			":".TeamDBObject::COL_ID => $id,
			":".TeamDBObject::COL_NAME => $name,
			":".TeamDBObject::COL_LEADER_ID => $leaderId,
			":".TeamDBObject::COL_DIVISION => $division);
		// create sql request
		$sql = parent::getDBObject()->GetTable(TeamDBObject::TABL_Team)->GetUPDATEQuery();
		// execute query
		if(parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params)) {
			// Add leader as member if not already there
			$members = __get_team_members($id);
			if(!in_array($leaderId, $members)) {
				return __insert_member($id, $leaderId);
			}
			return TRUE;
		}
		return FALSE;
	}	

	private function __delete_Team($id) {
		// create sql params
		$sql_params = array(":".TeamDBObject::COL_ID => $id);
		// create sql request
		$sql = parent::getDBObject()->GetTable(TeamDBObject::TABL_Team)->GetDELETEQuery();
		// execute query
		if(parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params)) {
			// Delete members
			$members = __get_team_members($id);
			foreach($members as $member) {
				__delete_member($id, $member);
			}
			return TRUE;
		}
		return FALSE;
	}

# PUBLIC RESET STATIC DATA FUNCTION --------------------------------------------------------------------
	
	/**
	 *	---------!---------!---------!---------!---------!---------!---------!---------!---------
	 *  !  							DATABASE CONSISTENCY WARNING 							    !
	 *  !  																					    !
	 *  !  Please respect the following points :   												!
	 *	!  - When adding static data to existing data => always add at the end of the list      !
	 *  !  - Never remove data (or ensure that no database element use one as a foreign key)    !
	 *	---------!---------!---------!---------!---------!---------!---------!---------!---------
	 */
	public function ResetStaticData() {
		// -- init categories table --------------------------------------------------------------------
		$divisions = array("DSI","UA","GRC","Com", "Qualité", "SG", "Présidence", "RH", "Trésorerie");
		// --- retrieve SQL query
		$sql = parent::getDBObject()->GetTable(TeamDBObject::TABL_DIV)->GetINSERTQuery();
		foreach ($divisions as $division) {
			// --- create param array
			$sql_params = array(":".TeamDBObject::COL_ID => "NULL",
								":".TeamDBObject::COL_LABEL => $division);
			// --- execute SQL query
			parent::getDBConnection()->PrepareExecuteQuery($sql,$sql_params);
		}
	}

}

/**
 *	@brief Team object interface
 */
class TeamDBObject extends AbstractDBObject {

	// -- consts
	// --- object name
	const OBJ_NAME = "team";
	// --- tables
	const TABL_TEAM = "dol_team";
	const TABL_MEMBERS = "dol_team_member";
	const TABL_DIV = "dol_division";
	// --- columns
	const COL_ID = "id";
	const COL_NAME = "name";
	const COL_LEADER_ID = "leader_id";
	const COL_CREATION_DATE = "creation_date";
	const COL_DIVISION = "division";
	const COL_MEMBER_ID = "member_id";
	const COL_LABEL = "label";
	// -- attributes

	// -- functions

	public function __construct($module) {
		// -- construct parent
		parent::__construct($module, TeamDBObject::OBJ_NAME);
		// -- create tables
		// --- dol_team table
		$dol_team = new DBTable(TeamDBObject::TABL_TEAM);
		$dol_team->AddColumn(TeamDBObject::COL_ID, DBTable::DT_INT, 11, false, "", true, true);
		$dol_team->AddColumn(TeamDBObject::COL_NAME, DBTable::DT_VARCHAR, 255, false);
		$dol_team->AddColumn(TeamDBObject::COL_LEADER_ID, DBTable::DT_INT, 11, false);
		$dol_team->AddColumn(TeamDBObject::COL_CREATION_DATE, DBTable::DT_DATE, 11, false);
		$dol_team->AddColumn(TeamDBObject::COL_DIVISION, DBTable::DT_INT, 11, false);
		// --- dol_team_member
		$dol_team_member = new DBTable(TeamDBObject::TABL_MEMBERS);
		$dol_team_member->AddColumn(TeamDBObject::COL_ID, DBTable::DT_INT, 11, false, "", false, false);
		$dol_team_member->AddColumn(TeamDBObject::COL_MEMBER_ID, DBTable::DT_INT, 11, false, false);
		// --- dol_division table
		$dol_team_division = new DBTable(TeamDBObject::TABL_DIV);
		$dol_team_division->AddColumn(TeamDBObject::COL_ID, DBTable::DT_INT, 11, false, "", true, true);
		$dol_team_division->AddColumn(TeamDBObject::COL_LABEL, DBTable::DT_VARCHAR, 255, false);

		// -- add tables
		parent::addTable($dol_team);
		parent::addTable($dol_team_member);
		parent::addTable($dol_team_division);
	}
	/**
	 *	@brief Returns all services associated with this object
	 */
	public function GetServices($currentUser) {
		return new TeamServices($currentUser, $this, $this->getDBConnection());
	}
	/**
	 *	Initialize static data
	 */
	public function ResetStaticData() {
		$services = new TeamServices(null, $this, $this->getDBConnection());
		$services->ResetStaticData();
	}

}