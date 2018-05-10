<?php

require_once "interfaces/AbstractDBObject.php";
require_once "interfaces/AbstractObjectServices.php";
require_once "objects/DBTable.php";
require_once "objects/DBProcedure.php";
require_once "objects/RightsMap.php";

/**
 * @brief The UserData class
 */
class UserData implements \JsonSerializable
{

    // -- consts
    const MEMBERSHIP_MISSING = 0;
    const MEMBERSHIP_EXISTS = 1;
    const MEMBERSHIP_VALID = 2;

    // -- attributes
    private $id = null;
    private $user_id = null;
    private $gender = null;
    private $firstname = null;
    private $lastname = null;
    private $birthdate = null;
    private $tel = null;
    private $email = null;
    private $address = null;
    private $city = null;
    private $postal_code = null;
    private $country = null;
    private $school_year = null;
    private $insa_dept = null;
    private $avatar_id = null;
    private $pos = null;
    private $ag = null;
    private $disabled = false;
    private $old = false;
    private $creation_date = null;
    private $admm_status = null;
    private $intm_status = null;

    /**
     * @brief Constructs a udata
     */
    public function __construct($id, $userId, $gender, $firstname, $lastname, $birthdate,
                                $tel, $email, $address, $city, $postalCode, $country, $schoolYear,
                                $insaDept, $avatarId, $ag, $disabled, $old, $creationDate, $pos)
    {
        $this->id = intval($id);
        $this->user_id = intval($userId);
        $this->gender = $gender;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->birthdate = $birthdate;
        $this->tel = $tel;
        $this->email = $email;
        $this->address = $address;
        $this->city = $city;
        $this->postal_code = intval($postalCode);
        $this->country = $country;
        $this->school_year = intval($schoolYear);
        $this->insa_dept = $insaDept;
        $this->avatar_id = intval($avatarId);
        $this->pos = $pos;
        $this->ag = $ag;
        $this->disabled = (bool)$disabled;
        $this->old = (bool)$old;
        $this->creation_date = $creationDate;
    }

    public function jsonSerialize()
    {
        return [
            UserDataDBObject::COL_ID => $this->id,
            UserDataDBObject::COL_USER_ID => $this->user_id,
            UserDataDBObject::COL_GENDER => $this->gender,
            UserDataDBObject::COL_FIRSTNAME => $this->firstname,
            UserDataDBObject::COL_LASTNAME => $this->lastname,
            UserDataDBObject::COL_BIRTHDATE => $this->birthdate,
            UserDataDBObject::COL_TEL => $this->tel,
            UserDataDBObject::COL_EMAIL => $this->email,
            UserDataDBObject::COL_ADDRESS => $this->address,
            UserDataDBObject::COL_CITY => $this->city,
            UserDataDBObject::COL_POSTAL_CODE => $this->postal_code,
            UserDataDBObject::COL_COUNTRY => $this->country,
            UserDataDBObject::COL_SCHOOL_YEAR => $this->school_year,
            UserDataDBObject::COL_INSA_DEPT => $this->insa_dept,
            UserDataDBObject::COL_AVATAR_ID => $this->avatar_id,
            UserDataDBObject::COL_AG => $this->ag,
            UserDataDBObject::COL_DISABLED => $this->disabled,
            UserDataDBObject::COL_OLD => $this->old,
            UserDataDBObject::COL_POSITION => $this->pos, //Not in DB...
            UserDataDBObject::COL_CREATION_DATE => $this->creation_date,
            UserDataDBObject::COL_ADMM_STATUS => $this->admm_status,
            UserDataDBObject::COL_INTM_STATUS => $this->intm_status
        ];
    }

    /**
     * @brief Returns UserData id
     */
    public function GetId()
    {
        return $this->id;
    }

    /**
     * @brief Returns UserData id
     */
    public function GetUserId()
    {
        return $this->user_id;
    }

    /**
     * @brief Returns UserData id
     */
    public function GetGender()
    {
        return $this->gender;
    }

    /**
     * @brief Returns UserData id
     */
    public function GetFirstname()
    {
        return $this->firstname;
    }

    /**
     * @brief Returns UserData id
     */
    public function GetLastname()
    {
        return $this->lastname;
    }

    /**
     * @brief Returns UserData id
     */
    public function GetBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @brief Returns UserData id
     */
    public function GetTel()
    {
        return $this->tel;
    }

    /**
     * @brief Returns UserData id
     */
    public function GetEmail()
    {
        return $this->email;
    }

    /**
     * @brief Returns UserData id
     */
    public function GetAddress()
    {
        return $this->address;
    }

    /**
     * @brief Returns UserData id
     */
    public function GetCity()
    {
        return $this->city;
    }

    /**
     * @brief Returns UserData id
     */
    public function GetPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * @brief Returns UserData id
     */
    public function GetCountry()
    {
        return $this->country;
    }

    /**
     * @brief Returns UserData school year
     */
    public function GetSchoolYear()
    {
        return $this->school_year;
    }

    /**
     * @brief Returns UserData INSA departement id
     */
    public function GetINSADept()
    {
        return $this->insa_dept;
    }

    /**
     * @brief Returns UserData avatar id
     */
    public function GetAvatarId()
    {
        return $this->avatar_id;
    }

    /**
     * @brief Returns UserData last position
     */
    public function GetPos()
    {
        return $this->pos;
    }

    /**
     * @brief Returns UserData agr
     */
    public function GetAg()
    {
        return $this->ag;
    }

    /**
     * @brief Returns UserData disabled
     */
    public function GetDisabled()
    {
        return $this->disabled;
    }

    /**
     * @brief Returns UserData old
     */
    public function GetOld()
    {
        return $this->old;
    }

    /**
     * @brief Returns UserData creation date
     */
    public function GetCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * @brief Returns Admm status
     */
    public function GetAdmmStatus()
    {
        return $this->admm_status;
    }

    /**
     * @brief Returns Intm status
     */
    public function GetIntmStatus()
    {
        return $this->intm_status;
    }

    /**
     * @brief Set Admm status
     */
    public function SetAdmmStatus($status)
    {
        $this->admm_status = $status;
        return $this;
    }

    /**
     * @brief Set Intm status
     */
    public function SetIntmStatus($status)
    {
        $this->intm_status = $status;
        return $this;
    }

}


class UserDataServices extends AbstractObjectServices
{

    // -- consts
    // --- params keys
    const PARAM_ID = "id";
    const PARAM_USER_ID = "userId";
    const PARAM_GENDER = "gender";
    const PARAM_FIRSTNAME = "firstname";
    const PARAM_LASTNAME = "lastname";
    const PARAM_BIRTHDATE = "birthdate";
    const PARAM_TEL = "tel";
    const PARAM_EMAIL = "email";
    const PARAM_ADDRESS = "address";
    const PARAM_CITY = "city";
    const PARAM_POSTAL_CODE = "postalCode";
    const PARAM_COUNTRY = "country";
    const PARAM_DIVISION = "division";
    const PARAM_SCHOOL_YEAR = "schoolYear";
    const PARAM_INSA_DEPT = "insaDept";
    const PARAM_POSITION = "position";
    const PARAM_CREATION_DATE = "creationDate";
    const PARAM_AVATAR_ID = "avatarId";
    const PARAM_AG = "ag";
    const PARAM_PRESENCE = "presence";
    const PARAM_DISABLED = "disabled";
    const PARAM_OLD = "old";
    const PARAM_SINCE = "since";
    // --- internal services (actions)
    const GET_USER_DATA_BY_ID = "byidud";
    const GET_USER_DATA_BY_USER_ID = "byuidud";
    const GET_ALL_BY_DIV = "allbydiv";
    const GET_ALL_BY_POS = "allbypos";
    const GET_ALL_BY_DPT = "allbydpt";
    const GET_CURRENT_USER_DATA = "currud";
    const GET_USER_LAST_POS = "lastpos";
    const GET_ALL_USER_POS = "allupos";
    const GET_USER_RG_CODE = "rgcode";
    const GET_ALL_USER_DATA = "allud";
    const GET_ALL_GENDERS = "allg";
    const GET_ALL_COUNTRIES = "allc";
    const GET_ALL_INSA_DEPTS = "alldept";
    const GET_ALL_SCHOOL_YEARS = "allyear";
    const GET_ALL_DIVISIONS = "alldiv";
    const GET_ALL_POSITIONS = "allpos";
    const GET_ALL_AGS = "allag";
    const GET_USER_RIGHTS = "userrights";
    const CHECK_MAIL = "checkmail";
    const INSERT_AG = "insag";
    const DELETE_AG = "delag";
    const INSERT = "insert";
    const UPDATE = "update";
    const UPDATE_POSTION = "updatepos";
    const UPDATE_AVATAR = "updateava";
    const DELETE = "delete";
    const DISABLE = "disable";
    const ENABLE = "enable";
    const TAG_OLD = "old";
    const UNTAG_OLD = "unold";
    const UPDATE_OWN = "updown";
    // -- services that should not be used except for data migration
    const FORCE_INSERT = "forins";
    const FORCE_POSITION = "forpos";
    // -- functions

    // -- construct
    public function __construct($currentUser, $dbObject, $dbConnection)
    {
        parent::__construct($currentUser, $dbObject, $dbConnection);
    }

    public function GetResponseData($action, $params)
    {
        $data = null;
        if (!strcmp($action, UserDataServices::GET_USER_DATA_BY_ID)) {
            $data = $this->__get_user_data_by_id($params[UserDataServices::PARAM_ID]);
        } else if (!strcmp($action, UserDataServices::GET_USER_DATA_BY_USER_ID)) {
            $data = $this->__get_user_data_by_user_id($params[UserDataServices::PARAM_USER_ID]);
        }else if (!strcmp($action, UserDataServices::GET_CURRENT_USER_DATA)) {
            $data = $this->__get_current_user_data();
        } else if (!strcmp($action, UserDataServices::GET_USER_LAST_POS)) {
            $data = $this->__get_user_last_position($params[UserDataServices::PARAM_USER_ID]);
        } else if (!strcmp($action, UserDataServices::GET_ALL_USER_POS)) {
            $data = $this->__get_all_user_positions($params[UserDataServices::PARAM_USER_ID]);
        } else if (!strcmp($action, UserDataServices::GET_USER_RG_CODE)) {
            $data = $this->__get_user_rgcode();
        } else if (!strcmp($action, UserDataServices::GET_ALL_USER_DATA)) {
            $data = $this->__get_all_user_data();
        } else if (!strcmp($action, UserDataServices::GET_ALL_BY_DIV)) {
            $data = $this->__get_all_user_data_by_division($params[UserDataServices::PARAM_DIVISION]);
        } else if (!strcmp($action, UserDataServices::GET_ALL_BY_POS)) {
            $data = $this->__get_all_user_data_by_position($params[UserDataServices::PARAM_POSITION]);
        } else if (!strcmp($action, UserDataServices::GET_ALL_BY_DPT)) {
            $data = $this->__get_all_user_data_by_insa_dept($params[UserDataServices::PARAM_INSA_DEPT]);
        } else if (!strcmp($action, UserDataServices::GET_ALL_GENDERS)) {
            $data = $this->__get_all_genders();
        } else if (!strcmp($action, UserDataServices::GET_ALL_COUNTRIES)) {
            $data = $this->__get_all_countries();
        } else if (!strcmp($action, UserDataServices::GET_ALL_INSA_DEPTS)) {
            $data = $this->__get_all_INSA_depts();
        } else if (!strcmp($action, UserDataServices::GET_ALL_SCHOOL_YEARS)) {
            $data = $this->__get_all_school_years();
        } else if (!strcmp($action, UserDataServices::GET_ALL_DIVISIONS)) {
            $data = $this->__get_all_divisions();
        } else if (!strcmp($action, UserDataServices::GET_ALL_POSITIONS)) {
            $data = $this->__get_all_positions();
        } else if (!strcmp($action, UserDataServices::GET_ALL_AGS)) {
            $data = $this->__get_all_ags();
        } else if (!strcmp($action, UserDataServices::GET_USER_RIGHTS)) {
            $data = $this->__get_user_rights($params[UserDataServices::PARAM_USER_ID]);
        } else if (!strcmp($action, UserDataServices::INSERT_AG)) {
            $data = $this->__insert_ag($params[UserDataServices::PARAM_AG], $params[UserDataServices::PARAM_PRESENCE]);
        } else if (!strcmp($action, UserDataServices::DELETE_AG)) {
            $data = $this->__delete_ag($params[UserDataServices::PARAM_AG]);
        } else if (!strcmp($action, UserDataServices::CHECK_MAIL)) {
            $data = $this->__check_mail($params[UserDataServices::PARAM_EMAIL]);
        } else if (!strcmp($action, UserDataServices::INSERT)) {
            $data = $this->__insert_user_data(
                $params[UserDataServices::PARAM_USER_ID],
                $params[UserDataServices::PARAM_GENDER],
                $params[UserDataServices::PARAM_FIRSTNAME],
                $params[UserDataServices::PARAM_LASTNAME],
                $params[UserDataServices::PARAM_BIRTHDATE],
                $params[UserDataServices::PARAM_TEL],
                $params[UserDataServices::PARAM_EMAIL],
                $params[UserDataServices::PARAM_ADDRESS],
                $params[UserDataServices::PARAM_CITY],
                $params[UserDataServices::PARAM_POSTAL_CODE],
                $params[UserDataServices::PARAM_COUNTRY],
                $params[UserDataServices::PARAM_SCHOOL_YEAR],
                $params[UserDataServices::PARAM_INSA_DEPT],
                $params[UserDataServices::PARAM_POSITION],
                $params[UserDataServices::PARAM_AG]);
        } else if (!strcmp($action, UserDataServices::FORCE_INSERT)) {
            $data = $this->__force_insert_user_data(
                $params[UserDataServices::PARAM_ID],
                $params[UserDataServices::PARAM_USER_ID],
                $params[UserDataServices::PARAM_GENDER],
                $params[UserDataServices::PARAM_FIRSTNAME],
                $params[UserDataServices::PARAM_LASTNAME],
                $params[UserDataServices::PARAM_BIRTHDATE],
                $params[UserDataServices::PARAM_TEL],
                $params[UserDataServices::PARAM_EMAIL],
                $params[UserDataServices::PARAM_ADDRESS],
                $params[UserDataServices::PARAM_CITY],
                $params[UserDataServices::PARAM_POSTAL_CODE],
                $params[UserDataServices::PARAM_COUNTRY],
                $params[UserDataServices::PARAM_SCHOOL_YEAR],
                $params[UserDataServices::PARAM_INSA_DEPT],
                $params[UserDataServices::PARAM_AVATAR_ID],
                $params[UserDataServices::PARAM_AG],
                $params[UserDataServices::PARAM_DISABLED],
                $params[UserDataServices::PARAM_OLD],
                $params[UserDataServices::PARAM_CREATION_DATE]
            );
        } else if (!strcmp($action, UserDataServices::UPDATE)) {
            $data = $this->__update_user_data(
                $params[UserDataServices::PARAM_ID],
                $params[UserDataServices::PARAM_USER_ID],
                $params[UserDataServices::PARAM_GENDER],
                $params[UserDataServices::PARAM_FIRSTNAME],
                $params[UserDataServices::PARAM_LASTNAME],
                $params[UserDataServices::PARAM_BIRTHDATE],
                $params[UserDataServices::PARAM_TEL],
                $params[UserDataServices::PARAM_EMAIL],
                $params[UserDataServices::PARAM_ADDRESS],
                $params[UserDataServices::PARAM_CITY],
                $params[UserDataServices::PARAM_POSTAL_CODE],
                $params[UserDataServices::PARAM_COUNTRY],
                $params[UserDataServices::PARAM_SCHOOL_YEAR],
                $params[UserDataServices::PARAM_INSA_DEPT],
                $params[UserDataServices::PARAM_POSITION],
                $params[UserDataServices::PARAM_AG]);
        } else if (!strcmp($action, UserDataServices::UPDATE_OWN)) {
            $data = $this->__update_own_user_data(
                $params[UserDataServices::PARAM_GENDER],
                $params[UserDataServices::PARAM_FIRSTNAME],
                $params[UserDataServices::PARAM_LASTNAME],
                $params[UserDataServices::PARAM_BIRTHDATE],
                $params[UserDataServices::PARAM_TEL],
                $params[UserDataServices::PARAM_EMAIL],
                $params[UserDataServices::PARAM_ADDRESS],
                $params[UserDataServices::PARAM_CITY],
                $params[UserDataServices::PARAM_POSTAL_CODE],
                $params[UserDataServices::PARAM_COUNTRY],
                $params[UserDataServices::PARAM_SCHOOL_YEAR],
                $params[UserDataServices::PARAM_INSA_DEPT]);
        } else if (!strcmp($action, UserDataServices::UPDATE_POSTION)) {
            $data = $this->__update_user_position(
                $params[UserDataServices::PARAM_USER_ID],
                $params[UserDataServices::PARAM_POSITION]);
        } else if (!strcmp($action, UserDataServices::FORCE_POSITION)) {
            $data = $this->__force_insert_user_position(
                $params[UserDataServices::PARAM_USER_ID],
                $params[UserDataServices::PARAM_POSITION],
                $params[UserDataServices::PARAM_SINCE]);
        } else if (!strcmp($action, UserDataServices::UPDATE_AVATAR)) {
            $data = $this->__update_user_avatar(
                $params[UserDataServices::PARAM_AVATAR_ID]);
        } else if (!strcmp($action, UserDataServices::DELETE)) {
            $data = $this->__delete_user_data($params[UserDataServices::PARAM_ID], $params[UserDataServices::PARAM_USER_ID]);
        } else if (!strcmp($action, UserDataServices::DISABLE)) {
            $data = $this->__disable_user_data($params[UserDataServices::PARAM_ID]);
        } else if (!strcmp($action, UserDataServices::ENABLE)) {
            $data = $this->__enable_user_data($params[UserDataServices::PARAM_ID]);
        } else if (!strcmp($action, UserDataServices::TAG_OLD)) {
            $data = $this->__tag_old_user_data($params[UserDataServices::PARAM_ID]);
        } else if (!strcmp($action, UserDataServices::UNTAG_OLD)) {
            $data = $this->__untag_old_user_data($params[UserDataServices::PARAM_ID]);
        }
        return $data;
    }

# PROTECTED & PRIVATE ####################################################

    // -- consult

    private function __get_user_data_by_id($id)
    {
        // create sql params array
        $sql_params = array(":" . UserDataDBObject::COL_ID => $id);
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(UserDataDBObject::COL_ID));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $udata = null;
        if (isset($pdos)) {
            if (($row = $pdos->fetch()) !== false) {
                $udata = new UserData(
                    $row[UserDataDBObject::COL_ID],
                    $row[UserDataDBObject::COL_USER_ID],
                    $row[UserDataDBObject::COL_GENDER],
                    $row[UserDataDBObject::COL_FIRSTNAME],
                    $row[UserDataDBObject::COL_LASTNAME],
                    $row[UserDataDBObject::COL_BIRTHDATE],
                    $row[UserDataDBObject::COL_TEL],
                    $row[UserDataDBObject::COL_EMAIL],
                    $row[UserDataDBObject::COL_ADDRESS],
                    $row[UserDataDBObject::COL_CITY],
                    $row[UserDataDBObject::COL_POSTAL_CODE],
                    $row[UserDataDBObject::COL_COUNTRY],
                    $row[UserDataDBObject::COL_SCHOOL_YEAR],
                    $row[UserDataDBObject::COL_INSA_DEPT],
                    $row[UserDataDBObject::COL_AVATAR_ID],
                    $row[UserDataDBObject::COL_AG],
                    $row[UserDataDBObject::COL_DISABLED],
                    $row[UserDataDBObject::COL_OLD],
                    $row[UserDataDBObject::COL_CREATION_DATE],
                    $this->__get_all_user_positions($row[UserDataDBObject::COL_USER_ID]));
            }
        }
        return $udata;
    }
    private function __get_user_data_by_user_id($user_id)
    {
        // create sql params array
        $sql_params = array(":" . UserDataDBObject::COL_USER_ID => $user_id);
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(UserDataDBObject::COL_USER_ID));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $udata = null;
        if (isset($pdos)) {
            if (($row = $pdos->fetch()) !== false) {
                $udata = new UserData(
                    $row[UserDataDBObject::COL_ID],
                    $row[UserDataDBObject::COL_USER_ID],
                    $row[UserDataDBObject::COL_GENDER],
                    $row[UserDataDBObject::COL_FIRSTNAME],
                    $row[UserDataDBObject::COL_LASTNAME],
                    $row[UserDataDBObject::COL_BIRTHDATE],
                    $row[UserDataDBObject::COL_TEL],
                    $row[UserDataDBObject::COL_EMAIL],
                    $row[UserDataDBObject::COL_ADDRESS],
                    $row[UserDataDBObject::COL_CITY],
                    $row[UserDataDBObject::COL_POSTAL_CODE],
                    $row[UserDataDBObject::COL_COUNTRY],
                    $row[UserDataDBObject::COL_SCHOOL_YEAR],
                    $row[UserDataDBObject::COL_INSA_DEPT],
                    $row[UserDataDBObject::COL_AVATAR_ID],
                    $row[UserDataDBObject::COL_AG],
                    $row[UserDataDBObject::COL_DISABLED],
                    $row[UserDataDBObject::COL_OLD],
                    $row[UserDataDBObject::COL_CREATION_DATE],
                    $this->__get_all_user_positions($row[UserDataDBObject::COL_USER_ID]));
            }
        }
        return $udata;
    }

    private function __get_all_user_data_by_division($division)
    {
        $sql_params = array(":" . UserDataDBObject::COL_DIVISION => $division);
        $sql1 = parent::getDBObject()->GetTable(UserDataDBObject::TABL_COM_POSITION)->GetSELECTQuery(
            array(DBTable::SELECT_ALL),
            array(UserDataDBObject::COL_DIVISION));
        $sql2 = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_POSITION)->GetLastOfEachQuery(
            UserDataDBObject::COL_USER_ID,
            UserDataDBObject::COL_SINCE
        );
        $sql3 = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetSELECTQuery();
        $sql = DBTable::GetJOINQuery(DBTable::GetJOINQuery($sql1, $sql2, array(UserDataDBObject::COL_LABEL, UserDataDBObject::COL_POSITION)), $sql3, array(UserDataDBObject::COL_USER_ID, UserDataDBObject::COL_USER_ID));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create an empty array for udata and fill it
        $udata = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($udata, new UserData(
                    $row[UserDataDBObject::COL_ID],
                    $row[UserDataDBObject::COL_USER_ID],
                    $row[UserDataDBObject::COL_GENDER],
                    $row[UserDataDBObject::COL_FIRSTNAME],
                    $row[UserDataDBObject::COL_LASTNAME],
                    $row[UserDataDBObject::COL_BIRTHDATE],
                    $row[UserDataDBObject::COL_TEL],
                    $row[UserDataDBObject::COL_EMAIL],
                    $row[UserDataDBObject::COL_ADDRESS],
                    $row[UserDataDBObject::COL_CITY],
                    $row[UserDataDBObject::COL_POSTAL_CODE],
                    $row[UserDataDBObject::COL_COUNTRY],
                    $row[UserDataDBObject::COL_SCHOOL_YEAR],
                    $row[UserDataDBObject::COL_INSA_DEPT],
                    $row[UserDataDBObject::COL_AVATAR_ID],
                    $row[UserDataDBObject::COL_AG],
                    $row[UserDataDBObject::COL_DISABLED],
                    $row[UserDataDBObject::COL_OLD],
                    $row[UserDataDBObject::COL_CREATION_DATE],
                    $this->__get_all_user_positions($row[UserDataDBObject::COL_USER_ID])));
            }
        }
        return $udata;
    }

    private function __get_all_user_data_by_position($position)
    {
        $sql_params = array(":" . UserDataDBObject::COL_POSITION => $position);
        // create sql request
        $sql1 = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetSELECTQuery();
        $sql2 = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_POSITION)->GetLastOfEachQuery(
            UserDataDBObject::COL_USER_ID,
            UserDataDBObject::COL_SINCE,
            array(UserDataDBObject::COL_POSITION)
        );
        $sql = DBTable::GetJOINQuery($sql1, $sql2, array(UserDataDBObject::COL_USER_ID, UserDataDBObject::COL_USER_ID));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create an empty array for udata and fill it
        $udata = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($udata, new UserData(
                    $row[UserDataDBObject::COL_ID],
                    $row[UserDataDBObject::COL_USER_ID],
                    $row[UserDataDBObject::COL_GENDER],
                    $row[UserDataDBObject::COL_FIRSTNAME],
                    $row[UserDataDBObject::COL_LASTNAME],
                    $row[UserDataDBObject::COL_BIRTHDATE],
                    $row[UserDataDBObject::COL_TEL],
                    $row[UserDataDBObject::COL_EMAIL],
                    $row[UserDataDBObject::COL_ADDRESS],
                    $row[UserDataDBObject::COL_CITY],
                    $row[UserDataDBObject::COL_POSTAL_CODE],
                    $row[UserDataDBObject::COL_COUNTRY],
                    $row[UserDataDBObject::COL_SCHOOL_YEAR],
                    $row[UserDataDBObject::COL_INSA_DEPT],
                    $row[UserDataDBObject::COL_AVATAR_ID],
                    $row[UserDataDBObject::COL_AG],
                    $row[UserDataDBObject::COL_DISABLED],
                    $row[UserDataDBObject::COL_OLD],
                    $row[UserDataDBObject::COL_CREATION_DATE],
                    $this->__get_all_user_positions($row[UserDataDBObject::COL_USER_ID])));
            }
        }
        return $udata;
    }

    private function __get_all_user_data_by_insa_dept($dept)
    {
        // create sql params array
        $sql_params = array(":" . UserDataDBObject::COL_INSA_DEPT => $dept);
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(UserDataDBObject::COL_INSA_DEPT));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create an empty array for udata and fill it
        $udata = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($udata, new UserData(
                    $row[UserDataDBObject::COL_ID],
                    $row[UserDataDBObject::COL_USER_ID],
                    $row[UserDataDBObject::COL_GENDER],
                    $row[UserDataDBObject::COL_FIRSTNAME],
                    $row[UserDataDBObject::COL_LASTNAME],
                    $row[UserDataDBObject::COL_BIRTHDATE],
                    $row[UserDataDBObject::COL_TEL],
                    $row[UserDataDBObject::COL_EMAIL],
                    $row[UserDataDBObject::COL_ADDRESS],
                    $row[UserDataDBObject::COL_CITY],
                    $row[UserDataDBObject::COL_POSTAL_CODE],
                    $row[UserDataDBObject::COL_COUNTRY],
                    $row[UserDataDBObject::COL_SCHOOL_YEAR],
                    $row[UserDataDBObject::COL_INSA_DEPT],
                    $row[UserDataDBObject::COL_AVATAR_ID],
                    $row[UserDataDBObject::COL_AG],
                    $row[UserDataDBObject::COL_DISABLED],
                    $row[UserDataDBObject::COL_OLD],
                    $row[UserDataDBObject::COL_CREATION_DATE],
                    $this->__get_all_user_positions($row[UserDataDBObject::COL_USER_ID])));
            }
        }
        return $udata;
    }

    private function __get_current_user_data()
    {
        // create sql params array
        $sql_params = array(":" . UserDataDBObject::COL_USER_ID => parent::getCurrentUser()->GetId());
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(UserDataDBObject::COL_USER_ID));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $udata = null;
        if (isset($pdos)) {
            if (($row = $pdos->fetch()) !== false) {
                $udata = new UserData(
                    $row[UserDataDBObject::COL_ID],
                    $row[UserDataDBObject::COL_USER_ID],
                    $row[UserDataDBObject::COL_GENDER],
                    $row[UserDataDBObject::COL_FIRSTNAME],
                    $row[UserDataDBObject::COL_LASTNAME],
                    $row[UserDataDBObject::COL_BIRTHDATE],
                    $row[UserDataDBObject::COL_TEL],
                    $row[UserDataDBObject::COL_EMAIL],
                    $row[UserDataDBObject::COL_ADDRESS],
                    $row[UserDataDBObject::COL_CITY],
                    $row[UserDataDBObject::COL_POSTAL_CODE],
                    $row[UserDataDBObject::COL_COUNTRY],
                    $row[UserDataDBObject::COL_SCHOOL_YEAR],
                    $row[UserDataDBObject::COL_INSA_DEPT],
                    $row[UserDataDBObject::COL_AVATAR_ID],
                    $row[UserDataDBObject::COL_AG],
                    $row[UserDataDBObject::COL_DISABLED],
                    $row[UserDataDBObject::COL_OLD],
                    $row[UserDataDBObject::COL_CREATION_DATE],
                    $this->__get_all_user_positions($row[UserDataDBObject::COL_USER_ID]));
            }
        }
        return $udata;
    }

    private function __get_user_last_position($userId)
    {
        // create sql params array
        $sql_params = array(":" . UserDataDBObject::COL_USER_ID => $userId);
        $sql1 = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_POSITION)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(UserDataDBObject::COL_USER_ID),
            array(),
            array(UserDataDBObject::COL_SINCE => DBTable::ORDER_DESC),
            1);
        $sql2 = parent::getDBObject()->GetTable(UserDataDBObject::TABL_COM_POSITION)->GetSELECTQuery(
            array(DBTable::SELECT_ALL));
        $sql = DBTable::GetJOINQuery($sql1, $sql2, array(UserDataDBObject::COL_POSITION, UserDataDBObject::COL_LABEL));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create an empty array for udata and fill it
        $position = array();
        if (($row = $pdos->fetch()) !== false) {
            $position = array(
                UserDataDBObject::COL_LABEL => $row[UserDataDBObject::COL_LABEL],
                UserDataDBObject::COL_SINCE => $row[UserDataDBObject::COL_SINCE],
                UserDataDBObject::COL_RG_CODE => $row[UserDataDBObject::COL_RG_CODE],
                UserDataDBObject::COL_DIVISION => $row[UserDataDBObject::COL_DIVISION]
            );
        }
        return $position;
    }

    private function __get_all_user_positions($userId)
    {
        // create sql params array
        $sql_params = array(":" . UserDataDBObject::COL_USER_ID => $userId);
        // create sql request
        $sql1 = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_POSITION)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(UserDataDBObject::COL_USER_ID));
        $sql2 = parent::getDBObject()->GetTable(UserDataDBObject::TABL_COM_POSITION)->GetSELECTQuery(
            array(DBTable::SELECT_ALL));
        $sql = DBTable::GetJOINQuery($sql1, $sql2, array(UserDataDBObject::COL_POSITION, UserDataDBObject::COL_LABEL), DBTable::DT_INNER, "", false, null, array(), array(UserDataDBObject::COL_SINCE => DBTable::ORDER_DESC));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create an empty array for udata and fill it
        $positions = array();
        while (($row = $pdos->fetch()) !== false) {
            array_push($positions, array(
                UserDataDBObject::COL_LABEL => $row[UserDataDBObject::COL_LABEL],
                UserDataDBObject::COL_SINCE => $row[UserDataDBObject::COL_SINCE],
                UserDataDBObject::COL_RG_CODE => $row[UserDataDBObject::COL_RG_CODE],
                UserDataDBObject::COL_DIVISION => $row[UserDataDBObject::COL_DIVISION]
            ));
        }
        return $positions;
    }

    private function __get_user_rgcode()
    {
        $position = $this->__get_user_last_position(parent::getCurrentUser()->GetId());
        $rgcode = null;
        if (isset($position)) {
            $rgcode = $position[UserDataDBObject::COL_RG_CODE];
        }
        return $rgcode;
    }

    private function __get_all_user_data()
    {
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetSELECTQuery();
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, array());
        // create an empty array for udata and fill it
        $udata = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($udata, new UserData(
                    $row[UserDataDBObject::COL_ID],
                    $row[UserDataDBObject::COL_USER_ID],
                    $row[UserDataDBObject::COL_GENDER],
                    $row[UserDataDBObject::COL_FIRSTNAME],
                    $row[UserDataDBObject::COL_LASTNAME],
                    $row[UserDataDBObject::COL_BIRTHDATE],
                    $row[UserDataDBObject::COL_TEL],
                    $row[UserDataDBObject::COL_EMAIL],
                    $row[UserDataDBObject::COL_ADDRESS],
                    $row[UserDataDBObject::COL_CITY],
                    $row[UserDataDBObject::COL_POSTAL_CODE],
                    $row[UserDataDBObject::COL_COUNTRY],
                    $row[UserDataDBObject::COL_SCHOOL_YEAR],
                    $row[UserDataDBObject::COL_INSA_DEPT],
                    $row[UserDataDBObject::COL_AVATAR_ID],
                    $row[UserDataDBObject::COL_AG],
                    $row[UserDataDBObject::COL_DISABLED],
                    $row[UserDataDBObject::COL_OLD],
                    $row[UserDataDBObject::COL_CREATION_DATE],
                    $this->__get_all_user_positions($row[UserDataDBObject::COL_USER_ID])));
            }
        }
        return $udata;
    }

    private function __get_all_genders()
    {
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_COM_GENDER)->GetSELECTQuery();
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, array());
        // create an empty array for labels and fill it
        $labels = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($labels, $row[UserDataDBObject::COL_LABEL]);
            }
        }
        return $labels;
    }

    private function __get_all_countries()
    {
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_COM_COUNTRY)->GetSELECTQuery();
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, array());
        // create an empty array for labels and fill it
        $labels = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($labels, $row[UserDataDBObject::COL_LABEL]);
            }
        }
        return $labels;
    }

    private function __get_all_INSA_depts()
    {
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_COM_INSA_DEPT)->GetSELECTQuery();
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, array());
        // create an empty array for labels and fill it
        $labels = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($labels, array(
                    UserDataDBObject::COL_LABEL => $row[UserDataDBObject::COL_LABEL],
                    UserDataDBObject::COL_DETAIL => $row[UserDataDBObject::COL_DETAIL]));
            }
        }
        return $labels;
    }

    private function __get_all_school_years()
    {
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_COM_SCHOOL_YEAR)->GetSELECTQuery();
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, array());
        // create an empty array for labels and fill it
        $labels = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($labels, $row[UserDataDBObject::COL_LABEL]);
            }
        }
        return $labels;
    }

    private function __get_all_positions()
    {
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_COM_POSITION)->GetSELECTQuery();
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, array());
        // create an empty array for labels and fill it
        $labels = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($labels, $row[UserDataDBObject::COL_LABEL]);
            }
        }
        return $labels;
    }

    private function __check_mail($email)
    {
        // create sql params array
        $sql_params = array(":" . UserDataDBObject::COL_EMAIL => $email);
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(UserDataDBObject::COL_EMAIL));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $udata = null;
        if (isset($pdos)) {
            if (($row = $pdos->fetch()) !== false) {
                $udata = new UserData(
                    $row[UserDataDBObject::COL_ID],
                    $row[UserDataDBObject::COL_USER_ID],
                    $row[UserDataDBObject::COL_GENDER],
                    $row[UserDataDBObject::COL_FIRSTNAME],
                    $row[UserDataDBObject::COL_LASTNAME],
                    $row[UserDataDBObject::COL_BIRTHDATE],
                    $row[UserDataDBObject::COL_TEL],
                    $row[UserDataDBObject::COL_EMAIL],
                    $row[UserDataDBObject::COL_ADDRESS],
                    $row[UserDataDBObject::COL_CITY],
                    $row[UserDataDBObject::COL_POSTAL_CODE],
                    $row[UserDataDBObject::COL_COUNTRY],
                    $row[UserDataDBObject::COL_SCHOOL_YEAR],
                    $row[UserDataDBObject::COL_INSA_DEPT],
                    $row[UserDataDBObject::COL_AVATAR_ID],
                    $row[UserDataDBObject::COL_AG],
                    $row[UserDataDBObject::COL_DISABLED],
                    $row[UserDataDBObject::COL_OLD],
                    $row[UserDataDBObject::COL_CREATION_DATE],
                    $this->__get_all_user_positions($row[UserDataDBObject::COL_USER_ID]));
            }
        }
        return $udata;
    }

    private function __get_all_ags()
    {
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_AG)->GetSELECTQuery();
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, array());
        // create an empty array for teams and fill it
        $ags = array();
        if ($pdos != null) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($ags, array(
                    UserDataDBObject::COL_AG => $row[UserDataDBObject::COL_AG],
                    UserDataDBObject::COL_PRESENCE => $row[UserDataDBObject::COL_PRESENCE]
                ));
            }
        }
        return $ags;
    }

    private function __get_user_rights($userId)
    {
        $position = $this->__get_user_last_position($userId);
        $sql_params = array(":" . UserDataDBObject::COL_POSITION => $position[UserDataDBObject::COL_LABEL]);
        // create sql query
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_POSITION_RIGHTS)->GetSELECTQuery(
            array(DBTable::SELECT_ALL),
            array(UserDataDBObject::COL_POSITION)
        );
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create an empty array for teams and fill it
        $rights = array();
        if ($pdos != null) {
            while (($row = $pdos->fetch()) !== false) {
                $rights[$row[UserDataDBObject::COL_MODULE]] = $row[UserDataDBObject::COL_RG_CODE];
            }
        }
        return $rights;

    }

    // -- modify

    private function __insert_user_data($userId, $gender, $firstname, $lastname, $birthdate,
                                        $tel, $email, $address, $city, $postalCode, $country, $schoolYear,
                                        $insaDept, $position, $ag)
    {
        // create sql params
        $sql_params = array(
            ":" . UserDataDBObject::COL_ID => null,
            ":" . UserDataDBObject::COL_USER_ID => $userId,
            ":" . UserDataDBObject::COL_GENDER => $gender,
            ":" . UserDataDBObject::COL_FIRSTNAME => $firstname,
            ":" . UserDataDBObject::COL_LASTNAME => $lastname,
            ":" . UserDataDBObject::COL_BIRTHDATE => $birthdate,
            ":" . UserDataDBObject::COL_TEL => $tel,
            ":" . UserDataDBObject::COL_EMAIL => $email,
            ":" . UserDataDBObject::COL_ADDRESS => $address,
            ":" . UserDataDBObject::COL_CITY => $city,
            ":" . UserDataDBObject::COL_POSTAL_CODE => $postalCode,
            ":" . UserDataDBObject::COL_COUNTRY => $country,
            ":" . UserDataDBObject::COL_SCHOOL_YEAR => $schoolYear,
            ":" . UserDataDBObject::COL_INSA_DEPT => $insaDept,
            ":" . UserDataDBObject::COL_AVATAR_ID => null,
            ":" . UserDataDBObject::COL_AG => $ag,
            ":" . UserDataDBObject::COL_DISABLED => 0,
            ":" . UserDataDBObject::COL_OLD => 0,
            ":" . UserDataDBObject::COL_CREATION_DATE => date('Y-m-d'));
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetINSERTQuery();
        // execute query
        if (parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params)) {
            $position = $position === UserDataDBObject::VAL_OLD ? UserDataDBObject::VAL_DEFAULT_POS : $position;
            return $this->__update_user_position($userId, $position);
        } else {
            return FALSE;
        }
    }

    private function __force_insert_user_data($id, $userId, $gender, $firstname, $lastname, $birthdate,
                                              $tel, $email, $address, $city, $postalCode, $country, $schoolYear,
                                              $insaDept, $avatarId, $ag, $disabled, $old, $creationDate)
    {
        // create sql params
        $sql_params = array(
            ":" . UserDataDBObject::COL_ID => $id,
            ":" . UserDataDBObject::COL_USER_ID => $userId,
            ":" . UserDataDBObject::COL_GENDER => $gender,
            ":" . UserDataDBObject::COL_FIRSTNAME => $firstname,
            ":" . UserDataDBObject::COL_LASTNAME => $lastname,
            ":" . UserDataDBObject::COL_BIRTHDATE => $birthdate,
            ":" . UserDataDBObject::COL_TEL => $tel,
            ":" . UserDataDBObject::COL_EMAIL => $email,
            ":" . UserDataDBObject::COL_ADDRESS => $address,
            ":" . UserDataDBObject::COL_CITY => $city,
            ":" . UserDataDBObject::COL_POSTAL_CODE => $postalCode,
            ":" . UserDataDBObject::COL_COUNTRY => $country,
            ":" . UserDataDBObject::COL_SCHOOL_YEAR => $schoolYear,
            ":" . UserDataDBObject::COL_INSA_DEPT => $insaDept,
            ":" . UserDataDBObject::COL_AVATAR_ID => $avatarId,
            ":" . UserDataDBObject::COL_AG => $ag,
            ":" . UserDataDBObject::COL_DISABLED => $disabled,
            ":" . UserDataDBObject::COL_OLD => $old,
            ":" . UserDataDBObject::COL_CREATION_DATE => $creationDate);
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetINSERTQuery();
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }


    private function __insert_ag($ag, $presence)
    {
        // create sql params
        $sql_params = array(":" . UserDataDBObject::COL_AG => $ag,
            ":" . UserDataDBObject::COL_PRESENCE => $presence,);
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_AG)->GetINSERTQuery();
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __update_user_data($id, $userId, $gender, $firstname, $lastname, $birthdate,
                                        $tel, $email, $address, $city, $postalCode, $country, $schoolYear,
                                        $insaDept, $position, $ag)
    {
        // create sql params
        $sql_params = array(
            ":" . UserDataDBObject::COL_ID => $id,
            ":" . UserDataDBObject::COL_USER_ID => $userId,
            ":" . UserDataDBObject::COL_GENDER => $gender,
            ":" . UserDataDBObject::COL_FIRSTNAME => $firstname,
            ":" . UserDataDBObject::COL_LASTNAME => $lastname,
            ":" . UserDataDBObject::COL_BIRTHDATE => $birthdate,
            ":" . UserDataDBObject::COL_TEL => $tel,
            ":" . UserDataDBObject::COL_EMAIL => $email,
            ":" . UserDataDBObject::COL_ADDRESS => $address,
            ":" . UserDataDBObject::COL_CITY => $city,
            ":" . UserDataDBObject::COL_POSTAL_CODE => $postalCode,
            ":" . UserDataDBObject::COL_COUNTRY => $country,
            ":" . UserDataDBObject::COL_SCHOOL_YEAR => $schoolYear,
            ":" . UserDataDBObject::COL_INSA_DEPT => $insaDept,
            ":" . UserDataDBObject::COL_OLD => ($position == UserDataDBObject::VAL_OLD ? 1 : 0),
            ":" . UserDataDBObject::COL_AG => $ag);
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetUPDATEQuery(array(
            UserDataDBObject::COL_ID,
            UserDataDBObject::COL_USER_ID,
            UserDataDBObject::COL_GENDER,
            UserDataDBObject::COL_FIRSTNAME,
            UserDataDBObject::COL_LASTNAME,
            UserDataDBObject::COL_BIRTHDATE,
            UserDataDBObject::COL_TEL,
            UserDataDBObject::COL_EMAIL,
            UserDataDBObject::COL_ADDRESS,
            UserDataDBObject::COL_CITY,
            UserDataDBObject::COL_POSTAL_CODE,
            UserDataDBObject::COL_COUNTRY,
            UserDataDBObject::COL_SCHOOL_YEAR,
            UserDataDBObject::COL_INSA_DEPT,
            UserDataDBObject::COL_OLD,
            UserDataDBObject::COL_AG
        ));
        // execute query
        if (parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params)) {
            return $this->__update_user_position($userId, $position);
        } else {
            return FALSE;
        }
    }

    private function __update_own_user_data($gender, $firstname, $lastname, $birthdate,
                                        $tel, $email, $address, $city, $postalCode, $country, $schoolYear,
                                        $insaDept)
    {
        // create sql params
        $sql_params = array(
            ":" . UserDataDBObject::COL_USER_ID => $this->getCurrentUser()->GetId(),
            ":" . UserDataDBObject::COL_GENDER => $gender,
            ":" . UserDataDBObject::COL_FIRSTNAME => $firstname,
            ":" . UserDataDBObject::COL_LASTNAME => $lastname,
            ":" . UserDataDBObject::COL_BIRTHDATE => $birthdate,
            ":" . UserDataDBObject::COL_TEL => $tel,
            ":" . UserDataDBObject::COL_EMAIL => $email,
            ":" . UserDataDBObject::COL_ADDRESS => $address,
            ":" . UserDataDBObject::COL_CITY => $city,
            ":" . UserDataDBObject::COL_POSTAL_CODE => $postalCode,
            ":" . UserDataDBObject::COL_COUNTRY => $country,
            ":" . UserDataDBObject::COL_SCHOOL_YEAR => $schoolYear,
            ":" . UserDataDBObject::COL_INSA_DEPT => $insaDept);
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetUPDATEQuery(array(
            UserDataDBObject::COL_GENDER,
            UserDataDBObject::COL_FIRSTNAME,
            UserDataDBObject::COL_LASTNAME,
            UserDataDBObject::COL_BIRTHDATE,
            UserDataDBObject::COL_TEL,
            UserDataDBObject::COL_EMAIL,
            UserDataDBObject::COL_ADDRESS,
            UserDataDBObject::COL_CITY,
            UserDataDBObject::COL_POSTAL_CODE,
            UserDataDBObject::COL_COUNTRY,
            UserDataDBObject::COL_SCHOOL_YEAR,
            UserDataDBObject::COL_INSA_DEPT
        ), array(UserDataDBObject::COL_USER_ID));
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __update_user_position($userId, $position)
    {
        $previousPosition = $this->__get_user_last_position($userId);
        if (!array_key_exists(UserDataDBObject::COL_LABEL, $previousPosition) || $position != $previousPosition[UserDataDBObject::COL_LABEL]) {
            // create sql params
            $sql_params = array(
                ":" . UserDataDBObject::COL_ID => null,
                ":" . UserDataDBObject::COL_USER_ID => $userId,
                ":" . UserDataDBObject::COL_POSITION => $position,
                ":" . UserDataDBObject::COL_SINCE => date('Y-m-d H:i:s'));
            // create sql request
            $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_POSITION)->GetINSERTQuery();
            // execute query
            return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
        }
        return true;
    }

    private function __force_insert_user_position($userId, $position, $since)
    {
        // create sql params
        $sql_params = array(
            ":" . UserDataDBObject::COL_ID => null,
            ":" . UserDataDBObject::COL_USER_ID => $userId,
            ":" . UserDataDBObject::COL_POSITION => $position,
            ":" . UserDataDBObject::COL_SINCE => $since);
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_POSITION)->GetINSERTQuery();
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __remove_last_user_position($userId)
    {
        $positions = $this->__get_all_user_positions($userId);
        if (count($positions) < 2) {
            return true;
        }
        // create sql params
        $sql_params = array(
            ":" . UserDataDBObject::COL_USER_ID => $userId,
            ":" . UserDataDBObject::COL_POSITION => $positions[0][UserDataDBObject::COL_LABEL],
            ":" . UserDataDBObject::COL_SINCE => $positions[0][UserDataDBObject::COL_SINCE]
        );
        // create sql query
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_POSITION)
            ->GetDELETEQuery(array(
                UserDataDBObject::COL_USER_ID,
                UserDataDBObject::COL_POSITION,
                UserDataDBObject::COL_SINCE));
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __update_user_avatar($avatarId)
    {
        // create sql params
        $sql_params = array(
            ":" . UserDataDBObject::COL_USER_ID => parent::getCurrentUser()->GetId(),
            ":" . UserDataDBObject::COL_AVATAR_ID => $avatarId);
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetUPDATEQuery(
            array(UserDataDBObject::COL_AVATAR_ID), array(UserDataDBObject::COL_USER_ID));
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __delete_user_data($id, $userId)
    {
        // DELETE POSITIONS HISTORY FIRST
        // create sql params
        $sql_params = array(":" . UserDataDBObject::COL_USER_ID => $userId);
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_POSITION)->GetDELETEQuery(array(UserDataDBObject::COL_USER_ID));
        // execute query
        if (parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params)) {
            // create sql params
            $sql_params_bis = array(":" . UserDataDBObject::COL_ID => $id);
            // create sql request
            $sql_bis = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetDELETEQuery();
            // execute query
            return parent::getDBConnection()->PrepareExecuteQuery($sql_bis, $sql_params_bis);
        }
        return FALSE;
    }

    private function __disable_user_data($id)
    {
        // create sql params
        $sql_params = array(
            ":" . UserDataDBObject::COL_ID => $id,
            ":" . UserDataDBObject::COL_DISABLED => 1);
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetUPDATEQuery(
            array(UserDataDBObject::COL_DISABLED));
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __enable_user_data($id)
    {
        // create sql params
        $sql_params = array(
            ":" . UserDataDBObject::COL_ID => $id,
            ":" . UserDataDBObject::COL_DISABLED => 0);
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetUPDATEQuery(
            array(UserDataDBObject::COL_DISABLED));
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __tag_old_user_data($id)
    {
        // create sql params
        $sql_params = array(
            ":" . UserDataDBObject::COL_ID => $id,
            ":" . UserDataDBObject::COL_OLD => true);
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetUPDATEQuery(
            array(UserDataDBObject::COL_OLD));
        // execute query
        if (parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params)) {
            return $this->__update_user_position($id, UserDataDBObject::VAL_OLD);
        }
        return false;
    }

    private function __untag_old_user_data($id)
    {
        // create sql params
        $sql_params = array(
            ":" . UserDataDBObject::COL_ID => $id,
            ":" . UserDataDBObject::COL_OLD => false);
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_USER_DATA)->GetUPDATEQuery(
            array(UserDataDBObject::COL_OLD));
        // execute query
        if (parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params)) {
            return $this->__remove_last_user_position($id);
        }
        return false;
    }


    private function __delete_ag($ag)
    {
        // create sql params
        $sql_params = array(":" . UserDataDBObject::COL_AG => $ag);
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_AG)->GetDELETEQuery(array(UserDataDBObject::COL_AG));
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __get_all_divisions()
    {
        // create sql request
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_COM_DIVISION)->GetSELECTQuery();
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, array());
        // create an empty array for divisions and fill it
        $divisions = array();
        if ($pdos != null) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($divisions, $row[UserDataDBObject::COL_LABEL]);
            }
        }
        return $divisions;
    }


# PUBLIC RESET STATIC DATA FUNCTION --------------------------------------------------------------------

    /**
     *    ---------!---------!---------!---------!---------!---------!---------!---------!---------
     *  !                            DATABASE CONSISTENCY WARNING                                !
     *  !                                                                                        !
     *  !  Please respect the following points :                                                !
     *    !  - When adding static data to existing data => always add at the end of the list      !
     *  !  - Never remove data (or ensure that no database element use one as a foreign key)    !
     *    ---------!---------!---------!---------!---------!---------!---------!---------!---------
     */
    public function ResetStaticData()
    {
        // -- init gender table --------------------------------------------------------------------
        $genders = array(
            ["M.", "Monsieur"],
            ["Mlle", "Mademoiselle"],
            ["Mme", "Madame"],
            ["Mtre", "Maitre"]
        );
        // --- retrieve SQL query
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_COM_GENDER)->GetINSERTQuery();
        foreach ($genders as $gender) {
            // --- create param array
            $sql_params = array(
                ":" . UserDataDBObject::COL_LABEL => $gender[0],
                ":" . UserDataDBObject::COL_DETAIL => $gender[1]
            );
            // --- execute SQL query
            parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
        }
        // -- init countries table --------------------------------------------------------------------
        $countries = array("Afrique du Sud", "Algérie",
            "Angola", "Bénin", "Botswana", "Burkina Faso", "Burundi", "Cameroun", "Cap-Vert", "République centrafricaine", "Comores",
            "République du Congo", "République démocratique du Congo", "Côte d'Ivoire", "Djibouti", "Égypte", "Érythrée", "Éthiopie",
            "Gabon", "Gambie", "Ghana", "Guinée", "Guinée-Bissau", "Guinée équatoriale", "Kenya", "Lesotho", "Liberia", "Libye",
            "Madagascar", "Malawi", "Mali", "Maroc", "Maurice", "Mauritanie", "Mozambique", "Namibie", "Niger", "Nigeria", "Ouganda",
            "Rwanda", "Sahara Occidental", "Sao Tomé-et-Principe", "Sénégal", "Seychelles", "Sierra Leone", "Somalie", "Soudan",
            "Soudan du Sud", "Swaziland", "Tanzanie", "Tchad", "Togo", "Tunisie", "Zambie", "Zimbabwe", "Antigua-et-Barbuda",
            "Argentine", "Bahamas", "Barbade", "Belize", "Bolivie", "Brésil", "Canada", "Chili", "Colombie", "Costa Rica",
            "Cuba", "République dominicaine", "Dominique", "Équateur", "États-Unis", "Grenade", "Guatemala", "Guyana",
            "Haïti", "Honduras", "Jamaïque", "Mexique", "Nicaragua", "Panama", "Paraguay", "Pérou", "Saint-Christophe-et-Niévès",
            "Sainte-Lucie", "Saint-Vincent-et-les-Grenadines", "Salvador", "Suriname", "Trinité-et-Tobago",
            "Uruguay", "Venezuela", "Afghanistan", "Arabie saoudite", "Arménie", "Azerbaïdjan", "Bahreïn", "Bangladesh",
            "Bhoutan", "Birmanie", "Brunei", "Cambodge", "Chine", "Corée du Nord", "Corée du Sud", "Émirats arabes unis",
            "Géorgie", "Inde", "Indonésie", "Irak", "Iran", "Israël", "Japon", "Jordanie", "Kazakhstan", "Kirghizistan",
            "Koweït", "Laos", "Liban", "Malaisie", "Maldives", "Mongolie", "Népal", "Oman", "Ouzbékistan", "Pakistan",
            "Philippines", "Qatar", "Singapour", "Sri Lanka", "Syrie", "Tadjikistan", "Thaïlande", "Timor oriental",
            "Turkménistan", "Turquie", "Viêt Nam", "Yémen", "Albanie", "Allemagne", "Andorre", "Autriche", "Belgique",
            "Biélorussie", "Bosnie-Herzégovine", "Bulgarie", "Chypre", "Crete", "Croatie", "Danemark", "Espagne", "Estonie",
            "Finlande", "France", "Grèce", "Hongrie", "Irlande", "Islande", "Italie", "Lettonie", "Liechtenstein", "Lituanie",
            "Luxembourg", "Macédoine", "Malte", "Moldavie", "Monaco", "Monténégro", "Norvège", "Pays-Bas", "Pologne", "Portugal",
            "République tchèque", "Roumanie", "Royaume-Uni", "Russie", "Saint-Marin", "Serbie", "Slovaquie", "Slovénie",
            "Suède", "Suisse", "Ukraine", "Vatican", "Australie", "Fidji", "Kiribati", "Marshall", "Micronésie", "Nauru",
            "Nouvelle-Zélande", "Palaos", "Papouasie-Nouvelle-Guinée", "Salomon", "Samoa", "Tonga", "Tuvalu", "Vanuatu");
        // --- retrieve SQL query
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_COM_COUNTRY)->GetINSERTQuery();
        foreach ($countries as $country) {
            // --- create param array
            $sql_params = array(":" . UserDataDBObject::COL_LABEL => $country);
            // --- execute SQL query
            parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
        }
        // -- init INSA Dept table --------------------------------------------------------------------
        $depts = array(
            "BB" => "Biochimie et Biotechnologies",
            "BIM" => "BioInformatique et Modélisation",
            "GCU" => "Génie civil et urbanisme",
            "GE" => "Génie électrique",
            "GEN" => "Génie énergétique et environnement",
            "GMC" => "Génie mécanique conception",
            "GMD" => "Génie mécanique développement",
            "GMPP" => "Génie mécanique procédés plasturgie",
            "GI" => "Génie Industriel",
            "IF" => "Informatique",
            "SGM" => "Science et Génie des Matériaux",
            "TC" => "Télécommunications, Services et Usages",
            "PC" => "Premier Cycle");
        // --- retrieve SQL query
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_COM_INSA_DEPT)->GetINSERTQuery();
        foreach ($depts as $dept => $detail) {
            // --- create param array
            $sql_params = array(":" . UserDataDBObject::COL_LABEL => $dept,
                ":" . UserDataDBObject::COL_DETAIL => $detail);
            // --- execute SQL query
            parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
        }
        // -- init school year table --------------------------------------------------------------------
        $years = array(1, 2, 3, 4, 5, 6, 7, 8);
        // --- retrieve SQL query
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_COM_SCHOOL_YEAR)->GetINSERTQuery();
        foreach ($years as $year) {
            // --- create param array
            $sql_params = array(":" . UserDataDBObject::COL_LABEL => $year);
            // --- execute SQL query
            parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
        }
        // -- init ETIC div table --------------------------------------------------------------------
        $divisions = array("DSI", "UA", "GRC", "Com", "Qualité", "SG", "Présidence", "RH", "Trésorerie", "Client", "Ancien", "Consultant", "CNJE");
        // --- retrieve SQL query
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_COM_DIVISION)->GetINSERTQuery();
        foreach ($divisions as $division) {
            // --- create param array
            $sql_params = array(":" . UserDataDBObject::COL_LABEL => $division);
            // --- execute SQL query
            parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
        }
        // -- init ETIC pos table --------------------------------------------------------------------
        $positions = array(//definition: RightsMap::x_R  | RightsMap::x_G (| RightsMap::x_G)*
            "Président" => array((RightsMap::A_R | RightsMap::A_G | RightsMap::D_G), "Présidence"), // A  | A | D
            "Vice-Président" => array((RightsMap::A_R | RightsMap::A_G | RightsMap::D_G), "Présidence"), // A  | A | D
            "Secrétaire Général" => array((RightsMap::A_R | RightsMap::A_G | RightsMap::D_G), "SG"), // A  | A | D
            "Trésorier" => array((RightsMap::A_R | RightsMap::A_G | RightsMap::D_G), "Trésorerie"), // A  | A | D
            "Vice-Trésorier" => array((RightsMap::A_R | RightsMap::A_G | RightsMap::D_G), "Trésorerie"), // A  | A | D
            "Comptable" => array((RightsMap::A_R | RightsMap::M_G | RightsMap::D_G), "Trésorerie"), // A  | M | D
            "Responsable DSI" => array((RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G), "DSI"), // SA | A | D
            "Responsable GRC" => array((RightsMap::A_R | RightsMap::A_G | RightsMap::D_G), "GRC"), // A  | A | D
            "Responsable Com" => array((RightsMap::A_R | RightsMap::A_G | RightsMap::D_G), "Com"), // A  | A | D
            "Responsable UA" => array((RightsMap::A_R | RightsMap::A_G | RightsMap::D_G), "UA"), // A  | A | D
            "Responsable BU" => array((RightsMap::A_R | RightsMap::A_G | RightsMap::D_G), "UA"), // A  | A | D
            "Responsable Qualité" => array((RightsMap::A_R | RightsMap::A_G | RightsMap::D_G), "Qualité"), // A  | A | D
            "Junior DSI" => array((RightsMap::U_R | RightsMap::M_G | RightsMap::D_G), "DSI"), // U  | M | D
            "Junior GRC" => array((RightsMap::U_R | RightsMap::M_G | RightsMap::D_G), "GRC"), // U  | M | D
            "Junior Com" => array((RightsMap::U_R | RightsMap::M_G | RightsMap::D_G), "Com"), // U  | M | D
            UserDataDBObject::VAL_DEFAULT_POS => array((RightsMap::U_R | RightsMap::M_G | RightsMap::D_G), "UA"), // U  | M | D
            "Junior Qualité" => array((RightsMap::U_R | RightsMap::M_G | RightsMap::D_G), "Qualité"), // U  | M | D
            UserDataDBObject::VAL_OLD => array((RightsMap::G_R | RightsMap::C_G | RightsMap::D_G), "Ancien"), // G  | C | D
            "Consultant" => array((RightsMap::G_R | RightsMap::I_G | RightsMap::D_G), "Consultant"), // G  | I | D
            "Client" => array((RightsMap::G_R | RightsMap::C_G | RightsMap::D_G), "Client"), // G  | C | D
            "Auditeur CNJE" => array((RightsMap::G_R | RightsMap::C_G | RightsMap::D_G), "CNJE"), // G  | C | D
            "Membre CNJE" => array((RightsMap::G_R | RightsMap::C_G | RightsMap::D_G), "CNJE") // G  | C | D
        );
        // --- retrieve SQL query
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_COM_POSITION)->GetINSERTQuery();
        foreach ($positions as $position => $attr) {
            // --- create param array
            $sql_params = array(":" . UserDataDBObject::COL_LABEL => $position,
                ":" . UserDataDBObject::COL_RG_CODE => $attr[0],
                ":" . UserDataDBObject::COL_DIVISION => $attr[1]);
            // --- execute SQL query
            parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
        }

        $rights = [
            'hr' => [
                "Président" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Vice-Président" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Secrétaire Général" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Trésorier" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Vice-Trésorier" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Comptable" => (RightsMap::A_R | RightsMap::M_G | RightsMap::D_G),
                "Responsable DSI" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable GRC" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable Com" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable UA" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable BU" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Responsable Qualité" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Junior DSI" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior GRC" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior Com" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                UserDataDBObject::VAL_DEFAULT_POS => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior Qualité" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                UserDataDBObject::VAL_OLD => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Consultant" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Client" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Auditeur CNJE" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Membre CNJE" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G)
            ],
            'grc' => [
                "Président" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Vice-Président" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Secrétaire Général" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Trésorier" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Vice-Trésorier" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Comptable" => (RightsMap::A_R | RightsMap::M_G | RightsMap::D_G),
                "Responsable DSI" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable GRC" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable Com" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable UA" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable BU" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable Qualité" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Junior DSI" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior GRC" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Junior Com" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                UserDataDBObject::VAL_DEFAULT_POS => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Junior Qualité" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                UserDataDBObject::VAL_OLD => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Consultant" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Client" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Auditeur CNJE" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Membre CNJE" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G)
            ],
            'kernel' => [
                "Président" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Vice-Président" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Secrétaire Général" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Trésorier" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Vice-Trésorier" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Comptable" => (RightsMap::A_R | RightsMap::M_G | RightsMap::D_G),
                "Responsable DSI" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable GRC" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable Com" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable UA" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable BU" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Responsable Qualité" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Junior DSI" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior GRC" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior Com" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                UserDataDBObject::VAL_DEFAULT_POS => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior Qualité" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                UserDataDBObject::VAL_OLD => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Consultant" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Client" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Auditeur CNJE" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Membre CNJE" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G)
            ],
            'tools' => [
                "Président" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Vice-Président" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Secrétaire Général" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Trésorier" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Vice-Trésorier" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Comptable" => (RightsMap::A_R | RightsMap::M_G | RightsMap::D_G),
                "Responsable DSI" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable GRC" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable Com" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable UA" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable BU" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Responsable Qualité" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Junior DSI" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior GRC" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior Com" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                UserDataDBObject::VAL_DEFAULT_POS => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior Qualité" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                UserDataDBObject::VAL_OLD => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Consultant" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Client" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Auditeur CNJE" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Membre CNJE" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G)
            ],
            'support' => [
                "Président" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Vice-Président" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Secrétaire Général" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Trésorier" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Vice-Trésorier" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Comptable" => (RightsMap::A_R | RightsMap::M_G | RightsMap::D_G),
                "Responsable DSI" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable GRC" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable Com" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable UA" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Responsable BU" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable Qualité" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Junior DSI" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior GRC" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior Com" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                UserDataDBObject::VAL_DEFAULT_POS => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior Qualité" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                UserDataDBObject::VAL_OLD => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Consultant" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Client" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Auditeur CNJE" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Membre CNJE" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G)
            ],
            'ua' => [
                "Président" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Vice-Président" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Secrétaire Général" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Trésorier" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Vice-Trésorier" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Comptable" => (RightsMap::A_R | RightsMap::M_G | RightsMap::D_G),
                "Responsable DSI" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable GRC" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable Com" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable UA" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable BU" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable Qualité" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Junior DSI" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior GRC" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior Com" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                UserDataDBObject::VAL_DEFAULT_POS => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Junior Qualité" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                UserDataDBObject::VAL_OLD => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Consultant" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Client" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Auditeur CNJE" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Membre CNJE" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G)
            ],
            'dashboard' => [
                "Président" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Vice-Président" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Secrétaire Général" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Trésorier" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Vice-Trésorier" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Comptable" => (RightsMap::A_R | RightsMap::M_G | RightsMap::D_G),
                "Responsable DSI" => (RightsMap::SA_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable GRC" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable Com" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable UA" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Responsable BU" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Responsable Qualité" => (RightsMap::A_R | RightsMap::A_G | RightsMap::D_G),
                "Junior DSI" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior GRC" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior Com" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                UserDataDBObject::VAL_DEFAULT_POS => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Junior Qualité" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                UserDataDBObject::VAL_OLD => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Consultant" => (RightsMap::U_R | RightsMap::M_G | RightsMap::D_G),
                "Client" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Auditeur CNJE" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G),
                "Membre CNJE" => (RightsMap::G_R | RightsMap::C_G | RightsMap::D_G)
            ]
        ];

        // --- retrieve SQL query
        $sql = parent::getDBObject()->GetTable(UserDataDBObject::TABL_POSITION_RIGHTS)->GetINSERTQuery();
        foreach ($rights as $module => $right) {
            foreach ($right as $position => $key) {
                $sql_params = [
                    UserDataDBObject::COL_MODULE => $module,
                    UserDataDBObject::COL_POSITION => $position,
                    UserDataDBObject::COL_RG_CODE => $key
                ];
                // --- execute SQL query
                parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
            }
        }
    }

}

/**
 * @brief UserData object interface
 */
class UserDataDBObject extends AbstractDBObject
{

    // -- consts
    // --- object name
    const OBJ_NAME = "udata";
    // --- tables
    const TABL_USER_DATA = "dol_udata";
    const TABL_USER_POSITION = "dol_udata_position";
    const TABL_COM_GENDER = "com_gender";
    const TABL_COM_COUNTRY = "com_country";
    const TABL_COM_INSA_DEPT = "com_insa_dept";
    const TABL_COM_SCHOOL_YEAR = "com_school_year";
    const TABL_COM_DIVISION = "com_division";
    const TABL_COM_POSITION = "com_position";
    const TABL_POSITION_RIGHTS = "dol_position_rights";
    const TABL_AG = "com_ag";
    // --- columns
    const COL_ID = "id";
    const COL_USER_ID = "user_id";
    const COL_GENDER = "gender";
    const COL_FIRSTNAME = "firstname";
    const COL_LASTNAME = "lastname";
    const COL_BIRTHDATE = "birthdate";
    const COL_TEL = "tel";
    const COL_EMAIL = "email";
    const COL_ADDRESS = "address";
    const COL_CITY = "city";
    const COL_POSTAL_CODE = "postal_code";
    const COL_COUNTRY = "country";
    const COL_SCHOOL_YEAR = "school_year";
    const COL_INSA_DEPT = "insa_dept";
    const COL_POSITION = "position";
    const COL_LABEL = "label";
    const COL_DETAIL = "detail";
    const COL_SINCE = "since";
    const COL_RG_CODE = "rg_code";
    const COL_AVATAR_ID = "avatar_id";
    const COL_LAST_POS = "last_pos";
    const COL_AG = "ag";
    const COL_CREATION_DATE = "creation_date";
    const COL_PRESENCE = "presence";
    const COL_DIVISION = "division";
    const COL_DISABLED = "disabled";
    const COL_OLD = "old";
    const COL_ADMM_STATUS = "admm_status";
    const COL_INTM_STATUS = "intm_status";
    const COL_MODULE = "module";
    // -- attributes
    const VAL_OLD = "Ancien membre";
    const VAL_DEFAULT_POS = "Chargé d'affaires";

    // -- functions

    public function __construct($module)
    {
        // -- construct parent
        parent::__construct($module, UserDataDBObject::OBJ_NAME);
        // -- create tables
        // --- com_gender table
        $com_gender = new DBTable(UserDataDBObject::TABL_COM_GENDER);
        $com_gender
            ->AddColumn(UserDataDBObject::COL_LABEL, DBTable::DT_VARCHAR, 255, false, "", false, true)
            ->AddColumn(UserDataDBObject::COL_DETAIL, DBTable::DT_VARCHAR, 255, false, "");
        // --- com_country table
        $com_country = new DBTable(UserDataDBObject::TABL_COM_COUNTRY);
        $com_country->AddColumn(UserDataDBObject::COL_LABEL, DBTable::DT_VARCHAR, 255, false, "", false, true);
        // --- com_insa_dept table
        $com_insa_dept = new DBTable(UserDataDBObject::TABL_COM_INSA_DEPT);
        $com_insa_dept
            ->AddColumn(UserDataDBObject::COL_LABEL, DBTable::DT_VARCHAR, 255, false, "", false, true)
            ->AddColumn(UserDataDBObject::COL_DETAIL, DBTable::DT_VARCHAR, 255, false, "");
        // --- com_school_year table
        $com_school_year = new DBTable(UserDataDBObject::TABL_COM_SCHOOL_YEAR);
        $com_school_year->AddColumn(UserDataDBObject::COL_LABEL, DBTable::DT_INT, 11, false, "", false, true);
        // --- com_division table
        $com_division = new DBTable(UserDataDBObject::TABL_COM_DIVISION);
        $com_division->AddColumn(UserDataDBObject::COL_LABEL, DBTable::DT_VARCHAR, 255, false, "", false, true);
        // --- com_position table
        $com_position = new DBTable(UserDataDBObject::TABL_COM_POSITION);
        $com_position
            ->AddColumn(UserDataDBObject::COL_LABEL, DBTable::DT_VARCHAR, 255, false, "", false, true)
            ->AddColumn(UserDataDBObject::COL_RG_CODE, DBTable::DT_INT, 11, false, "")
            ->AddColumn(UserDataDBObject::COL_DIVISION, DBTable::DT_VARCHAR, 255, false, "")
            ->AddForeignKey(UserDataDBObject::TABL_COM_POSITION . '_fk1', UserDataDBObject::COL_DIVISION, UserDataDBObject::TABL_COM_DIVISION, UserDataDBObject::COL_LABEL, DBTable::DT_RESTRICT, DBTable::DT_CASCADE);
        // --- com_ag table
        $com_ag = new DBTable(UserDataDBObject::TABL_AG);
        $com_ag
            ->AddColumn(UserDataDBObject::COL_AG, DBTable::DT_VARCHAR, 255, false, "", false, true)
            ->AddColumn(UserDataDBObject::COL_PRESENCE, DBTable::DT_INT, 11, false);
        // --- dol_udata table
        $dol_udata = new DBTable(UserDataDBObject::TABL_USER_DATA);
        $dol_udata
            ->AddColumn(UserDataDBObject::COL_ID, DBTable::DT_INT, 11, false, "", true, true)
            ->AddColumn(UserDataDBObject::COL_USER_ID, DBTable::DT_INT, 11, false, "", false, false, true)
            ->AddColumn(UserDataDBObject::COL_GENDER, DBTable::DT_VARCHAR, 255, true, NULL)
            ->AddColumn(UserDataDBObject::COL_FIRSTNAME, DBTable::DT_VARCHAR, 255, false, "")
            ->AddColumn(UserDataDBObject::COL_LASTNAME, DBTable::DT_VARCHAR, 255, false, "")
            ->AddColumn(UserDataDBObject::COL_BIRTHDATE, DBTable::DT_DATE, -1, true, NULL)
            ->AddColumn(UserDataDBObject::COL_TEL, DBTable::DT_VARCHAR, 255, true, NULL)
            ->AddColumn(UserDataDBObject::COL_EMAIL, DBTable::DT_VARCHAR, 255, false, "")
            ->AddColumn(UserDataDBObject::COL_ADDRESS, DBTable::DT_VARCHAR, 255, true, NULL)
            ->AddColumn(UserDataDBObject::COL_CITY, DBTable::DT_VARCHAR, 255, true, NULL)
            ->AddColumn(UserDataDBObject::COL_POSTAL_CODE, DBTable::DT_INT, 11, true, NULL)
            ->AddColumn(UserDataDBObject::COL_COUNTRY, DBTable::DT_VARCHAR, 255, true, NULL)
            ->AddColumn(UserDataDBObject::COL_SCHOOL_YEAR, DBTable::DT_INT, 11, true, NULL)
            ->AddColumn(UserDataDBObject::COL_INSA_DEPT, DBTable::DT_VARCHAR, 255, true, NULL)
            ->AddColumn(UserDataDBObject::COL_AVATAR_ID, DBTable::DT_INT, 11, true, "-1")
            ->AddColumn(UserDataDBObject::COL_AG, DBTable::DT_VARCHAR, 255, true)
            ->AddColumn(UserDataDBObject::COL_DISABLED, DBTable::DT_INT, 1, false, 0)
            ->AddColumn(UserDataDBObject::COL_OLD, DBTable::DT_INT, 1, false)
            ->AddColumn(UserDataDBObject::COL_CREATION_DATE, DBTable::DT_VARCHAR, 255, false)
            ->AddForeignKey(UserDataDBObject::TABL_USER_DATA . '_fk1', UserDataDBObject::COL_GENDER, UserDataDBObject::TABL_COM_GENDER, UserDataDBObject::COL_LABEL, DBTable::DT_RESTRICT, DBTable::DT_CASCADE)
            ->AddForeignKey(UserDataDBObject::TABL_USER_DATA . '_fk2', UserDataDBObject::COL_COUNTRY, UserDataDBObject::TABL_COM_COUNTRY, UserDataDBObject::COL_LABEL, DBTable::DT_RESTRICT, DBTable::DT_CASCADE)
            ->AddForeignKey(UserDataDBObject::TABL_USER_DATA . '_fk3', UserDataDBObject::COL_SCHOOL_YEAR, UserDataDBObject::TABL_COM_SCHOOL_YEAR, UserDataDBObject::COL_LABEL, DBTable::DT_RESTRICT, DBTable::DT_CASCADE)
            ->AddForeignKey(UserDataDBObject::TABL_USER_DATA . '_fk4', UserDataDBObject::COL_INSA_DEPT, UserDataDBObject::TABL_COM_INSA_DEPT, UserDataDBObject::COL_LABEL, DBTable::DT_RESTRICT, DBTable::DT_CASCADE)
            ->AddForeignKey(UserDataDBObject::TABL_USER_DATA . '_fk5', UserDataDBObject::COL_AG, UserDataDBObject::TABL_AG, UserDataDBObject::COL_AG, DBTable::DT_RESTRICT, DBTable::DT_CASCADE);
        // --- dol_udata_position table
        $dol_udata_position = new DBTable(UserDataDBObject::TABL_USER_POSITION);
        $dol_udata_position
            ->AddColumn(UserDataDBObject::COL_ID, DBTable::DT_INT, 11, false, "", true, true)
            ->AddColumn(UserDataDBObject::COL_USER_ID, DBTable::DT_INT, 11, false, "")
            ->AddColumn(UserDataDBObject::COL_POSITION, DBTable::DT_VARCHAR, 255, false, "")
            ->AddColumn(UserDataDBObject::COL_SINCE, DBTable::DT_DATETIME, -1, false, "")
            ->AddForeignKey(UserDataDBObject::TABL_USER_POSITION . '_fk1', UserDataDBObject::COL_USER_ID, UserDataDBObject::TABL_USER_DATA, UserDataDBObject::COL_USER_ID, DBTable::DT_CASCADE, DBTable::DT_CASCADE)
            ->AddForeignKey(UserDataDBObject::TABL_USER_POSITION . '_fk2', UserDataDBObject::COL_POSITION, UserDataDBObject::TABL_COM_POSITION, UserDataDBObject::COL_LABEL, DBTable::DT_RESTRICT, DBTable::DT_CASCADE);

        $dol_position_rights = new DBTable(UserDataDBObject::TABL_POSITION_RIGHTS);
        $dol_position_rights
            ->AddColumn(UserDataDBObject::COL_MODULE, DBTable::DT_VARCHAR, 255, false, "")
            ->AddColumn(UserDataDBObject::COL_POSITION, DBTable::DT_VARCHAR, 255, false)
            ->AddColumn(UserDataDBObject::COL_RG_CODE, DBTable::DT_INT, 11, false)
            ->AddForeignKey(
                UserDataDBObject::TABL_POSITION_RIGHTS . '_fk1',
                UserDataDBObject::COL_MODULE,
                ModuleDBObject::TABL_MODULE,
                ModuleDBObject::COL_LABEL, DBTable::DT_CASCADE, DBTable::DT_CASCADE
            )
            ->AddForeignKey(
                UserDataDBObject::TABL_POSITION_RIGHTS . '_fk2',
                UserDataDBObject::COL_POSITION,
                UserDataDBObject::TABL_COM_POSITION,
                UserDataDBObject::COL_LABEL, DBTable::DT_CASCADE, DBTable::DT_CASCADE
            );

        // -- add tables
        parent::addTable($com_gender);
        parent::addTable($com_country);
        parent::addTable($com_insa_dept);
        parent::addTable($com_school_year);
        parent::addTable($com_division);
        parent::addTable($com_position);
        parent::addTable($com_ag);
        parent::addTable($dol_udata);
        parent::addTable($dol_udata_position);
        parent::addTable($dol_position_rights);

    }

    /**
     * @brief Returns all services associated with this object
     */
    public function GetServices($currentUser)
    {
        return new UserDataServices($currentUser, $this, $this->getDBConnection());
    }

    /**
     *    Initialize static data
     */
    public function ResetStaticData()
    {
        $services = new UserDataServices(null, $this, $this->getDBConnection());
        $services->ResetStaticData();
    }

}
