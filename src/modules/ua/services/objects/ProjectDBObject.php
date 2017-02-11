<?php

require_once "interfaces/AbstractDBObject.php";
require_once "interfaces/AbstractObjectServices.php";
require_once "objects/DBTable.php";
require_once "objects/DBProcedure.php";
require_once "objects/RightsMap.php";

/**
 * @brief The Project class
 */
class Project implements \JsonSerializable
{

    // -- consts
    const STATUS = [
        'En sollicitation',
        'En négociation',
        'En cours',
        'En recette',
        'En clôture',
        'Clôturée',
        'En rupture',
        'Archivée'
    ];

    // -- attributes
    private $number = null;
    private $name = null;
    private $description = null;
    private $origin = null;
    private $field = null;
    private $status = null;
    private $firm_id = null;
    private $auditor_id = null;
    private $sign_date = null;
    private $end_date = null;
    private $mgmt_fee = null;
    private $app_fee = null;
    private $rebilled_fee = null;
    private $advance = null;
    private $secret = false;
    private $critical = false;
    private $creation_date = null;
    private $update_date = null;
    private $disabled = false;
    private $disabled_since = null;
    private $disabled_until = null;
    private $archived = false;
    private $archived_since = null;

    // Lists
    private $contacts = array();
    private $ints = array();
    private $chadaffs = array();
    private $amendments = array();

    private $tasks = array();

    /**
     * Project constructor.
     */
    public function __construct($number, $name, $description, $origin, $field, $status, $firmId, $auditorId,
                                $signDate, $endDate, $mgmtFee, $appFee, $rebilledFee, $advance, $secret,
                                $critical, $creationDate, $updateDate, $disabled, $disabledSince, $disabledUntil,
                                $archived, $archivedSince, $contacts = [], $ints = [], $chadaffs = [], $amendments = [])
    {
        $this->number = $number;
        $this->name = $name;
        $this->description = $description;
        $this->origin = $origin;
        $this->field = $field;
        $this->status = $status;
        $this->firm_id = $firmId;
        $this->auditor_id = $auditorId;
        $this->sign_date = $signDate;
        $this->end_date = $endDate;
        $this->mgmt_fee = $mgmtFee;
        $this->app_fee = $appFee;
        $this->rebilled_fee = $rebilledFee;
        $this->advance = $advance;
        $this->secret = boolval($secret);
        $this->critical = boolval($critical);
        $this->creation_date = $creationDate;
        $this->update_date = $updateDate;
        $this->disabled = boolval($disabled);
        $this->disabled_since = $disabledSince;
        $this->disabled_until = $disabledUntil;
        $this->archived = boolval($archived);
        $this->archived_since = $archivedSince;
        $this->contacts = $contacts;
        $this->ints = $ints;
        $this->chadaffs = $chadaffs;
        $this->amendments = $amendments;
    }


    public function jsonSerialize()
    {
        return [
            ProjectDBObject::COL_NUMBER => $this->number,
            ProjectDBObject::COL_NAME => $this->name,
            ProjectDBObject::COL_DESCRIPTION => $this->description,
            ProjectDBObject::COL_ORIGIN => $this->origin,
            ProjectDBObject::COL_FIELD => $this->field,
            ProjectDBObject::COL_STATUS => $this->status,
            ProjectDBObject::COL_FIRM_ID => $this->firm_id,
            ProjectDBObject::COL_AUDITOR_ID => $this->auditor_id,
            ProjectDBObject::COL_SIGN_DATE => $this->sign_date,
            ProjectDBObject::COL_END_DATE => $this->end_date,
            ProjectDBObject::COL_MGMT_FEE => $this->mgmt_fee,
            ProjectDBObject::COL_APP_FEE => $this->app_fee,
            ProjectDBObject::COL_REBILLED_FEE => $this->rebilled_fee,
            ProjectDBObject::COL_ADVANCE => $this->advance,
            ProjectDBObject::COL_SECRET => $this->secret,
            ProjectDBObject::COL_CRITICAL => $this->critical,
            ProjectDBObject::COL_CREATION_DATE => $this->creation_date,
            ProjectDBObject::COL_UPDATE_DATE => $this->update_date,
            ProjectDBObject::COL_DISABLED => $this->disabled,
            ProjectDBObject::COL_DISABLED_SINCE => $this->disabled_since,
            ProjectDBObject::COL_DISABLED_UNTIL => $this->disabled_until,
            ProjectDBObject::COL_ARCHIVED => $this->archived,
            ProjectDBObject::COL_ARCHIVED_SINCE => $this->archived_since,
            ProjectDBObject::COL_CONTACT_ID => $this->contacts,
            ProjectDBObject::COL_INT_ID => $this->ints,
            ProjectDBObject::COL_CHADAFF_ID => $this->chadaffs,
            ProjectDBObject::COL_AMENDMENT => $this->amendments
        ];
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getFirmId()
    {
        return $this->firm_id;
    }

    /**
     * @return int
     */
    public function getAuditorId()
    {
        return $this->auditor_id;
    }

    /**
     * @return string
     */
    public function getSignDate()
    {
        return $this->sign_date;
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @return int
     */
    public function getMgmtFee()
    {
        return $this->mgmt_fee;
    }

    /**
     * @return int
     */
    public function getAppFee()
    {
        return $this->app_fee;
    }

    /**
     * @return int
     */
    public function getRebilledFee()
    {
        return $this->rebilled_fee;
    }

    /**
     * @return int
     */
    public function getAdvance()
    {
        return $this->advance;
    }

    /**
     * @return boolean
     */
    public function isSecret()
    {
        return $this->secret;
    }

    /**
     * @return boolean
     */
    public function isCritical()
    {
        return $this->critical;
    }

    /**
     * @return string
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * @return string
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }

    /**
     * @return boolean
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * @return string
     */
    public function getDisabledSince()
    {
        return $this->disabled_since;
    }

    /**
     * @return string
     */
    public function getDisabledUntil()
    {
        return $this->disabled_until;
    }

    /**
     * @return boolean
     */
    public function isArchived()
    {
        return $this->archived;
    }

    /**
     * @return string
     */
    public function getArchivedSince()
    {
        return $this->archived_since;
    }

    /**
     * @return array
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @return array
     */
    public function getInts()
    {
        return $this->ints;
    }

    /**
     * @return array
     */
    public function getChadaffs()
    {
        return $this->chadaffs;
    }

    /**
     * @return array
     */
    public function getAmendments()
    {
        return $this->amendments;
    }

    /**
     * @return array
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param null $firm_id
     * @return $this
     */
    public function setFirmId($firm_id)
    {
        $this->firm_id = $firm_id;

        return $this;
    }

    /**
     * @param null $auditor_id
     * @return $this
     */
    public function setAuditorId($auditor_id)
    {
        $this->auditor_id = $auditor_id;

        return $this;
    }

    /**
     * @param array $contacts
     * @return $this
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * @param array $ints
     * @return $this
     */
    public function setInts($ints)
    {
        $this->ints = $ints;

        return $this;
    }

    /**
     * @param array $chadaffs
     * @return $this
     */
    public function setChadaffs($chadaffs)
    {
        $this->chadaffs = $chadaffs;

        return $this;
    }


    /**
     * @param array $tasks
     * @return $this
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;

        return $this;
    }

}


class ProjectServices extends AbstractObjectServices
{

    // -- consts
    // --- params keys
    const PARAM_NUMBER = "number";
    const PARAM_NAME = "name";
    const PARAM_DESCRIPTION = "description";
    const PARAM_ORIGIN = "origin";
    const PARAM_FIELD = "field";
    const PARAM_STATUS = "status";
    const PARAM_FIRM_ID = "firmId";
    const PARAM_CONTACT_ID = "contactId";
    const PARAM_CHADAFF_ID = "chadaffId";
    const PARAM_INT_ID = "intId";
    const PARAM_AUDITOR_ID = "auditorId";
    const PARAM_SIGN_DATE = "signDate";
    const PARAM_END_DATE = "endDate";
    const PARAM_MGMT_FEE = "mgmtFee";
    const PARAM_APP_FEE = "appFee";
    const PARAM_REBILLED_FEE = "rebilledFee";
    const PARAM_ADVANCE = "advance";
    const PARAM_SECRET = "secret";
    const PARAM_CRITICAL = "critical";
    const PARAM_CREATION_DATE = "creationDate";
    const PARAM_UPDATE_DATE = "updateDate";
    const PARAM_PROJECT_NUMBER = "projectNumber";
    const PARAM_TYPE = "type";
    const PARAM_CONTENT = "content";
    const PARAM_ATTRIBUTABLE = "attributable";
    const PARAM_ID = "id";
    const PARAM_JEH_ASSIGNED = "jehAssigned";
    const PARAM_PAY = "pay";
    const PARAM_ASSIGN_CURRENT = "assignCurrent";
    const PARAM_DISABLED = "disabled";
    const PARAM_DISABLED_SINCE = "disabledSince";
    const PARAM_DISABLED_UNTIL = "disabledUntil";
    const PARAM_ARCHIVED = "archived";
    const PARAM_ARCHIVED_SINCE = "archivedSince";
    // --- internal services (actions)
    const GET_ALL = "getall";
    const GET_ALL_FULL = "getallful";
    const GET_DISABLED = "getdisabled";
    const GET_BY_NUMBER = "getbynum";
    const GET_FULL_BY_NUMBER = "fullbynum";
    const GET_BY_STATUS = "getbystatus";
    const GET_BY_ORIGIN = "getbyorigin";
    const GET_BY_FIELD = "getbyfield";
    const GET_BY_CHADAFF = "getbycha";
    const GET_BY_INT = "getbyint";
    const GET_BY_AUDITOR = "getbyaud";
    const GET_BY_FIRM = "getbyfirm";
    const GET_BY_CONTACT = "getbycont";
    const GET_CRITICAL = "getcritical";
    const GET_SECRET = "getsecret";
    const GET_ALL_STATUS = "allstatus";
    const GET_ALL_ORIGIN = "allorigin";
    const GET_ALL_AMEND_TYPE = "allamendtype";
    const GET_ALL_AMENDMENT = "allamendment";
    const GET_AMENDMENT_BY_ID = "amendbyid";
    const GET_ALL_AMENDMENT_BY_PROJECT = "amendbypro";
    const GET_ALL_CHADAFF_BY_PROJECT = "allchabypro";
    const GET_ALL_INT_BY_PROJECT = "allintbypro";
    const GET_INT_BY_PROJECT_AND_USER = "intbyprouser";
    const GET_ALL_CONTACT_BY_PROJECT = "allcontbypro";
    const INSERT = "insert";
    const INSERT_OWN = "insertown";
    const UPDATE = "update";
    const UPDATE_OWN = "updateown";
    const UNSIGN = "unsign";
    const SIGN = "sign";
    const BAD_END = "break";
    const END = "end";
    const UNEND = "unend";
    const ASSIGN_CHADAFF = "assigncha";
    const REMOVE_CHADAFF = "removecha";
    const ASSIGN_AUDITOR = "assignaudit";
    const ASSIGN_CONTACT = "assigncontact";
    const ASSIGN_CONTACT_OWN = "asscontown";
    const REMOVE_CONTACT = "removecontact";
    const REMOVE_CONTACT_OWN = "remcontown";
    const ASSIGN_INT = "assignint";
    const ASSIGN_INT_OWN = "assintown";
    const REMOVE_INT = "removeint";
    const REMOVE_INT_OWN = "remintown";
    const DELETE = "delete";
    const DISABLE = "disable";
    const ENABLE = "enable";
    const INSERT_AMENDMENT = "insam";
    const INSERT_AMENDMENT_OWN = "insamown";
    const UPDATE_AMENDMENT = "updam";
    const UPDATE_AMENDMENT_OWN = "updamown";
    const DELETE_AMENDMENT = "delam";
    const DELETE_AMENDMENT_OWN = "delamown";
    const ABORT = "abort";
    const ARCHIVE = "archive";
    const UNARCHIVE = "unarchive";
    const HAS_RIGHTS = "hasrights";
    const HAS_AUDITOR_RIGHTS = "hasauditrights";
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
        if (!strcmp($action, ProjectServices::GET_ALL)) {
            $data = $this->__get_all_projects();
        } else if (!strcmp($action, ProjectServices::GET_BY_NUMBER)) {
            $data = $this->__get_project_by_number($params[ProjectServices::PARAM_NUMBER]);
        } else if (!strcmp($action, ProjectServices::GET_FULL_BY_NUMBER)) {
            $data = $this->__get_full_project_by_number($params[ProjectServices::PARAM_NUMBER]);
        } else if (!strcmp($action, ProjectServices::GET_ALL_FULL)) {
            $data = $this->__get_all_full_projects();
        } else if (!strcmp($action, ProjectServices::GET_BY_STATUS)) {
            $data = $this->__get_projects_by_status($params[ProjectServices::PARAM_STATUS]);
        } else if (!strcmp($action, ProjectServices::GET_BY_ORIGIN)) {
            $data = $this->__get_projects_by_origin($params[ProjectServices::PARAM_ORIGIN]);
        } else if (!strcmp($action, ProjectServices::GET_BY_FIELD)) {
            $data = $this->__get_projects_by_field($params[ProjectServices::PARAM_FIELD]);
        } else if (!strcmp($action, ProjectServices::GET_BY_CHADAFF)) {
            $data = $this->__get_projects_by_chadaff($params[ProjectServices::PARAM_CHADAFF_ID]);
        } else if (!strcmp($action, ProjectServices::GET_BY_INT)) {
            $data = $this->__get_projects_by_int($params[ProjectServices::PARAM_INT_ID]);
        } else if (!strcmp($action, ProjectServices::GET_BY_AUDITOR)) {
            $data = $this->__get_projects_by_auditor($params[ProjectServices::PARAM_AUDITOR_ID]);
        } else if (!strcmp($action, ProjectServices::GET_BY_CONTACT)) {
            $data = $this->__get_projects_by_contact($params[ProjectServices::PARAM_CONTACT_ID]);
        } else if (!strcmp($action, ProjectServices::GET_BY_FIRM)) {
            $data = $this->__get_projects_by_firm($params[ProjectServices::PARAM_FIRM_ID]);
        } else if (!strcmp($action, ProjectServices::GET_CRITICAL)) {
            $data = $this->__get_projects_by_critical(ProjectServices::PARAM_CRITICAL);
        } else if (!strcmp($action, ProjectServices::GET_SECRET)) {
            $data = $this->__get_projects_by_secrecy(ProjectServices::PARAM_SECRET);
        } else if (!strcmp($action, ProjectServices::GET_ALL_STATUS)) {
            $data = $this->__get_all_statuses();
        } else if (!strcmp($action, ProjectServices::GET_ALL_ORIGIN)) {
            $data = $this->__get_all_origins();
        } else if (!strcmp($action, ProjectServices::GET_ALL_AMEND_TYPE)) {
            $data = $this->__get_all_amendment_types();
        } else if (!strcmp($action, ProjectServices::GET_ALL_AMENDMENT)) {
            $data = $this->__get_all_amendments();
        } else if (!strcmp($action, ProjectServices::GET_AMENDMENT_BY_ID)) {
            $data = $this->__get_amendment_by_id($params[ProjectServices::PARAM_ID]);
        } else if (!strcmp($action, ProjectServices::GET_ALL_AMENDMENT_BY_PROJECT)) {
            $data = $this->__get_all_amendments_by_project($params[ProjectServices::PARAM_PROJECT_NUMBER]);
        } else if (!strcmp($action, ProjectServices::GET_ALL_CHADAFF_BY_PROJECT)) {
            $data = $this->__get_all_chadaffs_by_project($params[ProjectServices::PARAM_PROJECT_NUMBER]);
        } else if (!strcmp($action, ProjectServices::GET_ALL_CONTACT_BY_PROJECT)) {
            $data = $this->__get_all_contacts_by_project($params[ProjectServices::PARAM_PROJECT_NUMBER]);
        } else if (!strcmp($action, ProjectServices::GET_ALL_INT_BY_PROJECT)) {
            $data = $this->__get_all_ints_by_project($params[ProjectServices::PARAM_PROJECT_NUMBER]);
        } else if (!strcmp($action, ProjectServices::GET_INT_BY_PROJECT_AND_USER)) {
            $data = $this->__get_int_by_project_and_user(
                $params[ProjectServices::PARAM_PROJECT_NUMBER],
                $params[ProjectServices::PARAM_INT_ID]
            );
        } else if (!strcmp($action, ProjectServices::INSERT)) {
            $data = $this->__insert_project(
                $params[ProjectServices::PARAM_NAME],
                $params[ProjectServices::PARAM_DESCRIPTION],
                $params[ProjectServices::PARAM_ORIGIN],
                $params[ProjectServices::PARAM_FIELD],
                $params[ProjectServices::PARAM_FIRM_ID],
                $params[ProjectServices::PARAM_MGMT_FEE],
                $params[ProjectServices::PARAM_APP_FEE],
                $params[ProjectServices::PARAM_REBILLED_FEE],
                $params[ProjectServices::PARAM_ADVANCE],
                $params[ProjectServices::PARAM_SECRET],
                $params[ProjectServices::PARAM_CRITICAL],
                $params[ProjectServices::PARAM_ASSIGN_CURRENT]
            );
        } else if (!strcmp($action, ProjectServices::FORCE_INSERT)) {
            $data = $this->__force_insert_project(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_NAME],
                $params[ProjectServices::PARAM_DESCRIPTION],
                $params[ProjectServices::PARAM_ORIGIN],
                $params[ProjectServices::PARAM_FIELD],
                $params[ProjectServices::PARAM_STATUS],
                $params[ProjectServices::PARAM_FIRM_ID],
                $params[ProjectServices::PARAM_AUDITOR_ID],
                $params[ProjectServices::PARAM_SIGN_DATE],
                $params[ProjectServices::PARAM_END_DATE],
                $params[ProjectServices::PARAM_MGMT_FEE],
                $params[ProjectServices::PARAM_APP_FEE],
                $params[ProjectServices::PARAM_REBILLED_FEE],
                $params[ProjectServices::PARAM_ADVANCE],
                $params[ProjectServices::PARAM_SECRET],
                $params[ProjectServices::PARAM_CRITICAL],
                $params[ProjectServices::PARAM_CREATION_DATE],
                $params[ProjectServices::PARAM_UPDATE_DATE],
                $params[ProjectServices::PARAM_DISABLED],
                $params[ProjectServices::PARAM_DISABLED_SINCE],
                $params[ProjectServices::PARAM_DISABLED_UNTIL],
                $params[ProjectServices::PARAM_ARCHIVED],
                $params[ProjectServices::PARAM_ARCHIVED_SINCE]
            );
        } else if (!strcmp($action, ProjectServices::INSERT_OWN)) {
            $data = $this->__insert_project(
                $params[ProjectServices::PARAM_NAME],
                $params[ProjectServices::PARAM_DESCRIPTION],
                $params[ProjectServices::PARAM_ORIGIN],
                $params[ProjectServices::PARAM_FIELD],
                $params[ProjectServices::PARAM_FIRM_ID],
                $params[ProjectServices::PARAM_MGMT_FEE],
                $params[ProjectServices::PARAM_APP_FEE],
                $params[ProjectServices::PARAM_REBILLED_FEE],
                $params[ProjectServices::PARAM_ADVANCE],
                $params[ProjectServices::PARAM_SECRET],
                $params[ProjectServices::PARAM_CRITICAL],
                true
            );
        } else if (!strcmp($action, ProjectServices::UPDATE)) {
            $data = $this->__update_project(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_NAME],
                $params[ProjectServices::PARAM_DESCRIPTION],
                $params[ProjectServices::PARAM_ORIGIN],
                $params[ProjectServices::PARAM_FIELD],
                $params[ProjectServices::PARAM_FIRM_ID],
                $params[ProjectServices::PARAM_MGMT_FEE],
                $params[ProjectServices::PARAM_APP_FEE],
                $params[ProjectServices::PARAM_REBILLED_FEE],
                $params[ProjectServices::PARAM_ADVANCE],
                $params[ProjectServices::PARAM_SECRET],
                $params[ProjectServices::PARAM_CRITICAL]
            );
        } else if (!strcmp($action, ProjectServices::UPDATE_OWN)) {
            $data = $this->__update_own_project(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_NAME],
                $params[ProjectServices::PARAM_DESCRIPTION],
                $params[ProjectServices::PARAM_ORIGIN],
                $params[ProjectServices::PARAM_FIELD],
                $params[ProjectServices::PARAM_FIRM_ID],
                $params[ProjectServices::PARAM_MGMT_FEE],
                $params[ProjectServices::PARAM_APP_FEE],
                $params[ProjectServices::PARAM_REBILLED_FEE],
                $params[ProjectServices::PARAM_ADVANCE],
                $params[ProjectServices::PARAM_SECRET],
                $params[ProjectServices::PARAM_CRITICAL]
            );
        } else if (!strcmp($action, ProjectServices::SIGN)) {
            $data = $this->__sign_project(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_SIGN_DATE]
            );
        } else if (!strcmp($action, ProjectServices::UNSIGN)) {
            $data = $this->__unsign_project($params[ProjectServices::PARAM_NUMBER]);
        } else if (!strcmp($action, ProjectServices::END)) {
            $data = $this->__end_project(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_END_DATE]
            );
        } else if (!strcmp($action, ProjectServices::BAD_END)) {
            $data = $this->__bad_end_project(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_END_DATE],
                $params[ProjectServices::PARAM_CONTENT],
                $params[ProjectServices::PARAM_ATTRIBUTABLE]
            );
        } else if (!strcmp($action, ProjectServices::UNEND)) {
            $data = $this->__unend_project($params[ProjectServices::PARAM_NUMBER]);
        } else if (!strcmp($action, ProjectServices::ENABLE)) {
            $data = $this->__enable_project($params[ProjectServices::PARAM_NUMBER]);
        } else if (!strcmp($action, ProjectServices::DISABLE)) {
            $data = $this->__disable_project(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_DISABLED_UNTIL]
            );
        } else if (!strcmp($action, ProjectServices::DELETE)) {
            $data = $this->__delete_project($params[ProjectServices::PARAM_NUMBER]);
        } else if (!strcmp($action, ProjectServices::ASSIGN_AUDITOR)) {
            $data = $this->__assign_auditor(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_AUDITOR_ID]
            );
        } else if (!strcmp($action, ProjectServices::ASSIGN_CHADAFF)) {
            $data = $this->__assign_chadaff(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_CHADAFF_ID]
            );
        } else if (!strcmp($action, ProjectServices::ASSIGN_CONTACT)) {
            $data = $this->__assign_contact(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_CONTACT_ID]
            );
        } else if (!strcmp($action, ProjectServices::ASSIGN_CONTACT_OWN)) {
            $data = $this->__assign_contact_own(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_CONTACT_ID]
            );
        } else if (!strcmp($action, ProjectServices::ASSIGN_INT)) {
            $data = $this->__assign_int(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_INT_ID],
                $params[ProjectServices::PARAM_JEH_ASSIGNED],
                $params[ProjectServices::PARAM_PAY]
            );
        } else if (!strcmp($action, ProjectServices::ASSIGN_INT_OWN)) {
            $data = $this->__assign_int_own(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_INT_ID],
                $params[ProjectServices::PARAM_JEH_ASSIGNED],
                $params[ProjectServices::PARAM_PAY]
            );
        } else if (!strcmp($action, ProjectServices::REMOVE_CHADAFF)) {
            $data = $this->__remove_chadaff(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_CHADAFF_ID]
            );
        } else if (!strcmp($action, ProjectServices::REMOVE_CONTACT)) {
            $data = $this->__remove_contact(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_CONTACT_ID]
            );
        } else if (!strcmp($action, ProjectServices::REMOVE_CONTACT_OWN)) {
            $data = $this->__remove_contact_own(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_CONTACT_ID]
            );
        } else if (!strcmp($action, ProjectServices::REMOVE_INT)) {
            $data = $this->__remove_int(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_INT_ID]
            );
        } else if (!strcmp($action, ProjectServices::REMOVE_INT_OWN)) {
            $data = $this->__remove_int_own(
                $params[ProjectServices::PARAM_NUMBER],
                $params[ProjectServices::PARAM_INT_ID]
            );
        } else if (!strcmp($action, ProjectServices::INSERT_AMENDMENT)) {
            $data = $this->__insert_amendment(
                $params[ProjectServices::PARAM_PROJECT_NUMBER],
                $params[ProjectServices::PARAM_TYPE],
                $params[ProjectServices::PARAM_CONTENT],
                $params[ProjectServices::PARAM_ATTRIBUTABLE],
                $params[ProjectServices::PARAM_CREATION_DATE]
            );
        } else if (!strcmp($action, ProjectServices::INSERT_AMENDMENT_OWN)) {
            $data = $this->__insert_amendment_own(
                $params[ProjectServices::PARAM_PROJECT_NUMBER],
                $params[ProjectServices::PARAM_TYPE],
                $params[ProjectServices::PARAM_CONTENT],
                $params[ProjectServices::PARAM_ATTRIBUTABLE],
                $params[ProjectServices::PARAM_CREATION_DATE]
            );
        } else if (!strcmp($action, ProjectServices::UPDATE_AMENDMENT)) {
            $data = $this->__update_amendment(
                $params[ProjectServices::PARAM_ID],
                $params[ProjectServices::PARAM_TYPE],
                $params[ProjectServices::PARAM_CONTENT],
                $params[ProjectServices::PARAM_ATTRIBUTABLE],
                $params[ProjectServices::PARAM_CREATION_DATE]
            );
        } else if (!strcmp($action, ProjectServices::UPDATE_AMENDMENT_OWN)) {
            $data = $this->__update_amendment_own(
                $params[ProjectServices::PARAM_ID],
                $params[ProjectServices::PARAM_TYPE],
                $params[ProjectServices::PARAM_CONTENT],
                $params[ProjectServices::PARAM_ATTRIBUTABLE],
                $params[ProjectServices::PARAM_CREATION_DATE]
            );
        } else if (!strcmp($action, ProjectServices::DELETE_AMENDMENT)) {
            $data = $this->__delete_amendment($params[ProjectServices::PARAM_ID]);
        } else if (!strcmp($action, ProjectServices::DELETE_AMENDMENT_OWN)) {
            $data = $this->__delete_amendment_own($params[ProjectServices::PARAM_ID]);
        } else if (!strcmp($action, ProjectServices::ABORT)) {
            $data = $this->__abort_project($params[ProjectServices::PARAM_NUMBER]);
        } else if (!strcmp($action, ProjectServices::ARCHIVE)) {
            $data = $this->__archive_project($params[ProjectServices::PARAM_NUMBER]);
        } else if (!strcmp($action, ProjectServices::UNARCHIVE)) {
            $data = $this->__unarchive_project($params[ProjectServices::PARAM_NUMBER]);
        } else if (!strcmp($action, ProjectServices::HAS_RIGHTS)) {
            $data = $this->__user_has_rights($params[ProjectServices::PARAM_NUMBER]);
        } else if (!strcmp($action, ProjectServices::HAS_AUDITOR_RIGHTS)) {
            $data = $this->__user_has_auditor_rights($params[ProjectServices::PARAM_NUMBER]);
        }
        return $data;
    }

# PROTECTED & PRIVATE ####################################################

    // -- consult
    private function __get_project_by_number($number)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_NUMBER => $number);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(ProjectDBObject::COL_NUMBER));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = null;
        if (isset($pdos)) {
            if (($row = $pdos->fetch()) !== false) {
                $data = new Project(
                    $row[ProjectDBObject::COL_NUMBER],
                    $row[ProjectDBObject::COL_NAME],
                    $row[ProjectDBObject::COL_DESCRIPTION],
                    $row[ProjectDBObject::COL_ORIGIN],
                    $row[ProjectDBObject::COL_FIELD],
                    $row[ProjectDBObject::COL_STATUS],
                    $row[ProjectDBObject::COL_FIRM_ID],
                    $row[ProjectDBObject::COL_AUDITOR_ID],
                    $row[ProjectDBObject::COL_SIGN_DATE],
                    $row[ProjectDBObject::COL_END_DATE],
                    $row[ProjectDBObject::COL_MGMT_FEE],
                    $row[ProjectDBObject::COL_APP_FEE],
                    $row[ProjectDBObject::COL_REBILLED_FEE],
                    $row[ProjectDBObject::COL_ADVANCE],
                    $row[ProjectDBObject::COL_SECRET],
                    $row[ProjectDBObject::COL_CRITICAL],
                    $row[ProjectDBObject::COL_CREATION_DATE],
                    $row[ProjectDBObject::COL_UPDATE_DATE],
                    $row[ProjectDBObject::COL_DISABLED],
                    $row[ProjectDBObject::COL_DISABLED_SINCE],
                    $row[ProjectDBObject::COL_DISABLED_UNTIL],
                    $row[ProjectDBObject::COL_ARCHIVED],
                    $row[ProjectDBObject::COL_ARCHIVED_SINCE]);
            }
        }
        return $data;
    }

    private function __get_full_project_by_number($number)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_NUMBER => $number);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(ProjectDBObject::COL_NUMBER));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = null;
        if (isset($pdos)) {
            if (($row = $pdos->fetch()) !== false) {
                $data = new Project(
                    $row[ProjectDBObject::COL_NUMBER],
                    $row[ProjectDBObject::COL_NAME],
                    $row[ProjectDBObject::COL_DESCRIPTION],
                    $row[ProjectDBObject::COL_ORIGIN],
                    $row[ProjectDBObject::COL_FIELD],
                    $row[ProjectDBObject::COL_STATUS],
                    $row[ProjectDBObject::COL_FIRM_ID],
                    $row[ProjectDBObject::COL_AUDITOR_ID],
                    $row[ProjectDBObject::COL_SIGN_DATE],
                    $row[ProjectDBObject::COL_END_DATE],
                    $row[ProjectDBObject::COL_MGMT_FEE],
                    $row[ProjectDBObject::COL_APP_FEE],
                    $row[ProjectDBObject::COL_REBILLED_FEE],
                    $row[ProjectDBObject::COL_ADVANCE],
                    $row[ProjectDBObject::COL_SECRET],
                    $row[ProjectDBObject::COL_CRITICAL],
                    $row[ProjectDBObject::COL_CREATION_DATE],
                    $row[ProjectDBObject::COL_UPDATE_DATE],
                    $row[ProjectDBObject::COL_DISABLED],
                    $row[ProjectDBObject::COL_DISABLED_SINCE],
                    $row[ProjectDBObject::COL_DISABLED_UNTIL],
                    $row[ProjectDBObject::COL_ARCHIVED],
                    $row[ProjectDBObject::COL_ARCHIVED_SINCE],
                    $this->__get_all_contacts_by_project($number),
                    $this->__get_all_ints_by_project($number),
                    $this->__get_all_chadaffs_by_project($number),
                    $this->__get_all_amendments_by_project($number)
                );
            }
        }
        return $data;
    }

    private function __get_all_full_projects()
    {
        // create sql params array
        $sql_params = array();
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL),
            array(DBTable::EVERYWHERE),
            array(),
            array(ProjectDBObject::COL_NUMBER => DBTable::ORDER_DESC)
        );
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, new Project(
                        $row[ProjectDBObject::COL_NUMBER],
                        $row[ProjectDBObject::COL_NAME],
                        $row[ProjectDBObject::COL_DESCRIPTION],
                        $row[ProjectDBObject::COL_ORIGIN],
                        $row[ProjectDBObject::COL_FIELD],
                        $row[ProjectDBObject::COL_STATUS],
                        $row[ProjectDBObject::COL_FIRM_ID],
                        $row[ProjectDBObject::COL_AUDITOR_ID],
                        $row[ProjectDBObject::COL_SIGN_DATE],
                        $row[ProjectDBObject::COL_END_DATE],
                        $row[ProjectDBObject::COL_MGMT_FEE],
                        $row[ProjectDBObject::COL_APP_FEE],
                        $row[ProjectDBObject::COL_REBILLED_FEE],
                        $row[ProjectDBObject::COL_ADVANCE],
                        $row[ProjectDBObject::COL_SECRET],
                        $row[ProjectDBObject::COL_CRITICAL],
                        $row[ProjectDBObject::COL_CREATION_DATE],
                        $row[ProjectDBObject::COL_UPDATE_DATE],
                        $row[ProjectDBObject::COL_DISABLED],
                        $row[ProjectDBObject::COL_DISABLED_SINCE],
                        $row[ProjectDBObject::COL_DISABLED_UNTIL],
                        $row[ProjectDBObject::COL_ARCHIVED],
                        $row[ProjectDBObject::COL_ARCHIVED_SINCE],
                        $this->__get_all_contacts_by_project($row[ProjectDBObject::COL_NUMBER]),
                        $this->__get_all_ints_by_project($row[ProjectDBObject::COL_NUMBER]),
                        $this->__get_all_chadaffs_by_project($row[ProjectDBObject::COL_NUMBER]),
                        $this->__get_all_amendments_by_project($row[ProjectDBObject::COL_NUMBER])
                    )
                );
            }
        }
        return $data;
    }

    private function __get_all_projects()
    {
        // create sql params array
        $sql_params = array();
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL),
            array(DBTable::EVERYWHERE),
            array(),
            array(ProjectDBObject::COL_NUMBER => DBTable::ORDER_DESC)
        );
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, new Project(
                        $row[ProjectDBObject::COL_NUMBER],
                        $row[ProjectDBObject::COL_NAME],
                        $row[ProjectDBObject::COL_DESCRIPTION],
                        $row[ProjectDBObject::COL_ORIGIN],
                        $row[ProjectDBObject::COL_FIELD],
                        $row[ProjectDBObject::COL_STATUS],
                        $row[ProjectDBObject::COL_FIRM_ID],
                        $row[ProjectDBObject::COL_AUDITOR_ID],
                        $row[ProjectDBObject::COL_SIGN_DATE],
                        $row[ProjectDBObject::COL_END_DATE],
                        $row[ProjectDBObject::COL_MGMT_FEE],
                        $row[ProjectDBObject::COL_APP_FEE],
                        $row[ProjectDBObject::COL_REBILLED_FEE],
                        $row[ProjectDBObject::COL_ADVANCE],
                        $row[ProjectDBObject::COL_SECRET],
                        $row[ProjectDBObject::COL_CRITICAL],
                        $row[ProjectDBObject::COL_CREATION_DATE],
                        $row[ProjectDBObject::COL_UPDATE_DATE],
                        $row[ProjectDBObject::COL_DISABLED],
                        $row[ProjectDBObject::COL_DISABLED_SINCE],
                        $row[ProjectDBObject::COL_DISABLED_UNTIL],
                        $row[ProjectDBObject::COL_ARCHIVED],
                        $row[ProjectDBObject::COL_ARCHIVED_SINCE])
                );
            }
        }
        return $data;
    }

    private function __get_projects_by_status($status)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_STATUS => $status);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(ProjectDBObject::COL_STATUS));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, new Project(
                        $row[ProjectDBObject::COL_NUMBER],
                        $row[ProjectDBObject::COL_NAME],
                        $row[ProjectDBObject::COL_DESCRIPTION],
                        $row[ProjectDBObject::COL_ORIGIN],
                        $row[ProjectDBObject::COL_FIELD],
                        $row[ProjectDBObject::COL_STATUS],
                        $row[ProjectDBObject::COL_FIRM_ID],
                        $row[ProjectDBObject::COL_AUDITOR_ID],
                        $row[ProjectDBObject::COL_SIGN_DATE],
                        $row[ProjectDBObject::COL_END_DATE],
                        $row[ProjectDBObject::COL_MGMT_FEE],
                        $row[ProjectDBObject::COL_APP_FEE],
                        $row[ProjectDBObject::COL_REBILLED_FEE],
                        $row[ProjectDBObject::COL_ADVANCE],
                        $row[ProjectDBObject::COL_SECRET],
                        $row[ProjectDBObject::COL_CRITICAL],
                        $row[ProjectDBObject::COL_CREATION_DATE],
                        $row[ProjectDBObject::COL_UPDATE_DATE],
                        $row[ProjectDBObject::COL_DISABLED],
                        $row[ProjectDBObject::COL_DISABLED_SINCE],
                        $row[ProjectDBObject::COL_DISABLED_UNTIL],
                        $row[ProjectDBObject::COL_ARCHIVED],
                        $row[ProjectDBObject::COL_ARCHIVED_SINCE])
                );
            }
        }
        return $data;
    }

    private function __get_projects_by_origin($origin)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_ORIGIN => $origin);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(ProjectDBObject::COL_ORIGIN));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, new Project(
                        $row[ProjectDBObject::COL_NUMBER],
                        $row[ProjectDBObject::COL_NAME],
                        $row[ProjectDBObject::COL_DESCRIPTION],
                        $row[ProjectDBObject::COL_ORIGIN],
                        $row[ProjectDBObject::COL_FIELD],
                        $row[ProjectDBObject::COL_STATUS],
                        $row[ProjectDBObject::COL_FIRM_ID],
                        $row[ProjectDBObject::COL_AUDITOR_ID],
                        $row[ProjectDBObject::COL_SIGN_DATE],
                        $row[ProjectDBObject::COL_END_DATE],
                        $row[ProjectDBObject::COL_MGMT_FEE],
                        $row[ProjectDBObject::COL_APP_FEE],
                        $row[ProjectDBObject::COL_REBILLED_FEE],
                        $row[ProjectDBObject::COL_ADVANCE],
                        $row[ProjectDBObject::COL_SECRET],
                        $row[ProjectDBObject::COL_CRITICAL],
                        $row[ProjectDBObject::COL_CREATION_DATE],
                        $row[ProjectDBObject::COL_UPDATE_DATE],
                        $row[ProjectDBObject::COL_DISABLED],
                        $row[ProjectDBObject::COL_DISABLED_SINCE],
                        $row[ProjectDBObject::COL_DISABLED_UNTIL],
                        $row[ProjectDBObject::COL_ARCHIVED],
                        $row[ProjectDBObject::COL_ARCHIVED_SINCE])
                );
            }
        }
        return $data;
    }

    private function __get_projects_by_field($field)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_FIELD => $field);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(ProjectDBObject::COL_FIELD));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, new Project(
                        $row[ProjectDBObject::COL_NUMBER],
                        $row[ProjectDBObject::COL_NAME],
                        $row[ProjectDBObject::COL_DESCRIPTION],
                        $row[ProjectDBObject::COL_ORIGIN],
                        $row[ProjectDBObject::COL_FIELD],
                        $row[ProjectDBObject::COL_STATUS],
                        $row[ProjectDBObject::COL_FIRM_ID],
                        $row[ProjectDBObject::COL_AUDITOR_ID],
                        $row[ProjectDBObject::COL_SIGN_DATE],
                        $row[ProjectDBObject::COL_END_DATE],
                        $row[ProjectDBObject::COL_MGMT_FEE],
                        $row[ProjectDBObject::COL_APP_FEE],
                        $row[ProjectDBObject::COL_REBILLED_FEE],
                        $row[ProjectDBObject::COL_ADVANCE],
                        $row[ProjectDBObject::COL_SECRET],
                        $row[ProjectDBObject::COL_CRITICAL],
                        $row[ProjectDBObject::COL_CREATION_DATE],
                        $row[ProjectDBObject::COL_UPDATE_DATE],
                        $row[ProjectDBObject::COL_DISABLED],
                        $row[ProjectDBObject::COL_DISABLED_SINCE],
                        $row[ProjectDBObject::COL_DISABLED_UNTIL],
                        $row[ProjectDBObject::COL_ARCHIVED],
                        $row[ProjectDBObject::COL_ARCHIVED_SINCE])
                );
            }
        }
        return $data;
    }

    private function __get_projects_by_auditor($auditorId)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_AUDITOR_ID => $auditorId);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL),
            array(ProjectDBObject::COL_AUDITOR_ID),
            array(),
            array(ProjectDBObject::COL_NUMBER => DBTable::ORDER_DESC)
        );
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, new Project(
                        $row[ProjectDBObject::COL_NUMBER],
                        $row[ProjectDBObject::COL_NAME],
                        $row[ProjectDBObject::COL_DESCRIPTION],
                        $row[ProjectDBObject::COL_ORIGIN],
                        $row[ProjectDBObject::COL_FIELD],
                        $row[ProjectDBObject::COL_STATUS],
                        $row[ProjectDBObject::COL_FIRM_ID],
                        $row[ProjectDBObject::COL_AUDITOR_ID],
                        $row[ProjectDBObject::COL_SIGN_DATE],
                        $row[ProjectDBObject::COL_END_DATE],
                        $row[ProjectDBObject::COL_MGMT_FEE],
                        $row[ProjectDBObject::COL_APP_FEE],
                        $row[ProjectDBObject::COL_REBILLED_FEE],
                        $row[ProjectDBObject::COL_ADVANCE],
                        $row[ProjectDBObject::COL_SECRET],
                        $row[ProjectDBObject::COL_CRITICAL],
                        $row[ProjectDBObject::COL_CREATION_DATE],
                        $row[ProjectDBObject::COL_UPDATE_DATE],
                        $row[ProjectDBObject::COL_DISABLED],
                        $row[ProjectDBObject::COL_DISABLED_SINCE],
                        $row[ProjectDBObject::COL_DISABLED_UNTIL],
                        $row[ProjectDBObject::COL_ARCHIVED],
                        $row[ProjectDBObject::COL_ARCHIVED_SINCE])
                );
            }
        }
        return $data;
    }

    private function __get_projects_by_firm($firmId)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_FIRM_ID => $firmId);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL),
            array(ProjectDBObject::COL_FIRM_ID),
            array(),
            array(ProjectDBObject::COL_NUMBER => DBTable::ORDER_DESC)
        );
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, new Project(
                        $row[ProjectDBObject::COL_NUMBER],
                        $row[ProjectDBObject::COL_NAME],
                        $row[ProjectDBObject::COL_DESCRIPTION],
                        $row[ProjectDBObject::COL_ORIGIN],
                        $row[ProjectDBObject::COL_FIELD],
                        $row[ProjectDBObject::COL_STATUS],
                        $row[ProjectDBObject::COL_FIRM_ID],
                        $row[ProjectDBObject::COL_AUDITOR_ID],
                        $row[ProjectDBObject::COL_SIGN_DATE],
                        $row[ProjectDBObject::COL_END_DATE],
                        $row[ProjectDBObject::COL_MGMT_FEE],
                        $row[ProjectDBObject::COL_APP_FEE],
                        $row[ProjectDBObject::COL_REBILLED_FEE],
                        $row[ProjectDBObject::COL_ADVANCE],
                        $row[ProjectDBObject::COL_SECRET],
                        $row[ProjectDBObject::COL_CRITICAL],
                        $row[ProjectDBObject::COL_CREATION_DATE],
                        $row[ProjectDBObject::COL_UPDATE_DATE],
                        $row[ProjectDBObject::COL_DISABLED],
                        $row[ProjectDBObject::COL_DISABLED_SINCE],
                        $row[ProjectDBObject::COL_DISABLED_UNTIL],
                        $row[ProjectDBObject::COL_ARCHIVED],
                        $row[ProjectDBObject::COL_ARCHIVED_SINCE])
                );
            }
        }
        return $data;
    }

    private function __get_projects_by_chadaff($chadaffId)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_CHADAFF_ID => $chadaffId);
        // create sql request
        $sql1 = parent::getDBObject()->GetTable(ProjectDBObject::TABL_CHADAFF)->GetSELECTQuery(
            array(DBTable::SELECT_ALL),
            array(ProjectDBObject::COL_CHADAFF_ID)
        );

        $sql2 = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetSELECTQuery();

        $sql = DBTable::GetJOINQuery(
            $sql1,
            $sql2,
            [ProjectDBObject::COL_PROJECT_NUMBER, ProjectDBObject::COL_NUMBER],
            DBTable::DT_INNER,
            "",
            false,
            null,
            array(),
            array(ProjectDBObject::COL_NUMBER => DBTable::ORDER_DESC)
        );

        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, new Project(
                        $row[ProjectDBObject::COL_NUMBER],
                        $row[ProjectDBObject::COL_NAME],
                        $row[ProjectDBObject::COL_DESCRIPTION],
                        $row[ProjectDBObject::COL_ORIGIN],
                        $row[ProjectDBObject::COL_FIELD],
                        $row[ProjectDBObject::COL_STATUS],
                        $row[ProjectDBObject::COL_FIRM_ID],
                        $row[ProjectDBObject::COL_AUDITOR_ID],
                        $row[ProjectDBObject::COL_SIGN_DATE],
                        $row[ProjectDBObject::COL_END_DATE],
                        $row[ProjectDBObject::COL_MGMT_FEE],
                        $row[ProjectDBObject::COL_APP_FEE],
                        $row[ProjectDBObject::COL_REBILLED_FEE],
                        $row[ProjectDBObject::COL_ADVANCE],
                        $row[ProjectDBObject::COL_SECRET],
                        $row[ProjectDBObject::COL_CRITICAL],
                        $row[ProjectDBObject::COL_CREATION_DATE],
                        $row[ProjectDBObject::COL_UPDATE_DATE],
                        $row[ProjectDBObject::COL_DISABLED],
                        $row[ProjectDBObject::COL_DISABLED_SINCE],
                        $row[ProjectDBObject::COL_DISABLED_UNTIL],
                        $row[ProjectDBObject::COL_ARCHIVED],
                        $row[ProjectDBObject::COL_ARCHIVED_SINCE]
                    )
                );
            }
        }
        return $data;
    }

    private function __get_projects_by_contact($contactId)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_CONTACT_ID => $contactId);
        // create sql request
        $sql1 = parent::getDBObject()->GetTable(ProjectDBObject::TABL_CONTACT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(ProjectDBObject::COL_CONTACT_ID));

        $sql2 = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetSELECTQuery();

        $sql = DBTable::GetJOINQuery(
            $sql1,
            $sql2,
            [ProjectDBObject::COL_PROJECT_NUMBER, ProjectDBObject::COL_NUMBER],
            DBTable::DT_INNER,
            "",
            false,
            null,
            array(),
            array(ProjectDBObject::COL_NUMBER => DBTable::ORDER_DESC)
        );

        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, new Project(
                        $row[ProjectDBObject::COL_NUMBER],
                        $row[ProjectDBObject::COL_NAME],
                        $row[ProjectDBObject::COL_DESCRIPTION],
                        $row[ProjectDBObject::COL_ORIGIN],
                        $row[ProjectDBObject::COL_FIELD],
                        $row[ProjectDBObject::COL_STATUS],
                        $row[ProjectDBObject::COL_FIRM_ID],
                        $row[ProjectDBObject::COL_AUDITOR_ID],
                        $row[ProjectDBObject::COL_SIGN_DATE],
                        $row[ProjectDBObject::COL_END_DATE],
                        $row[ProjectDBObject::COL_MGMT_FEE],
                        $row[ProjectDBObject::COL_APP_FEE],
                        $row[ProjectDBObject::COL_REBILLED_FEE],
                        $row[ProjectDBObject::COL_ADVANCE],
                        $row[ProjectDBObject::COL_SECRET],
                        $row[ProjectDBObject::COL_CRITICAL],
                        $row[ProjectDBObject::COL_CREATION_DATE],
                        $row[ProjectDBObject::COL_UPDATE_DATE],
                        $row[ProjectDBObject::COL_DISABLED],
                        $row[ProjectDBObject::COL_DISABLED_SINCE],
                        $row[ProjectDBObject::COL_DISABLED_UNTIL],
                        $row[ProjectDBObject::COL_ARCHIVED],
                        $row[ProjectDBObject::COL_ARCHIVED_SINCE]
                    )
                );
            }
        }
        return $data;
    }

    private function __get_projects_by_int($intId)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_INT_ID => $intId);
        // create sql request
        $sql1 = parent::getDBObject()->GetTable(ProjectDBObject::TABL_INT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(ProjectDBObject::COL_INT_ID));

        $sql2 = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetSELECTQuery();

        $sql = DBTable::GetJOINQuery(
            $sql1,
            $sql2,
            [ProjectDBObject::COL_PROJECT_NUMBER, ProjectDBObject::COL_NUMBER],
            DBTable::DT_INNER,
            "",
            false,
            null,
            array(),
            array(ProjectDBObject::COL_NUMBER => DBTable::ORDER_DESC)
        );

        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, new Project(
                        $row[ProjectDBObject::COL_NUMBER],
                        $row[ProjectDBObject::COL_NAME],
                        $row[ProjectDBObject::COL_DESCRIPTION],
                        $row[ProjectDBObject::COL_ORIGIN],
                        $row[ProjectDBObject::COL_FIELD],
                        $row[ProjectDBObject::COL_STATUS],
                        $row[ProjectDBObject::COL_FIRM_ID],
                        $row[ProjectDBObject::COL_AUDITOR_ID],
                        $row[ProjectDBObject::COL_SIGN_DATE],
                        $row[ProjectDBObject::COL_END_DATE],
                        $row[ProjectDBObject::COL_MGMT_FEE],
                        $row[ProjectDBObject::COL_APP_FEE],
                        $row[ProjectDBObject::COL_REBILLED_FEE],
                        $row[ProjectDBObject::COL_ADVANCE],
                        $row[ProjectDBObject::COL_SECRET],
                        $row[ProjectDBObject::COL_CRITICAL],
                        $row[ProjectDBObject::COL_CREATION_DATE],
                        $row[ProjectDBObject::COL_UPDATE_DATE],
                        $row[ProjectDBObject::COL_DISABLED],
                        $row[ProjectDBObject::COL_DISABLED_SINCE],
                        $row[ProjectDBObject::COL_DISABLED_UNTIL],
                        $row[ProjectDBObject::COL_ARCHIVED],
                        $row[ProjectDBObject::COL_ARCHIVED_SINCE]
                    )
                );
            }
        }
        return $data;
    }

    private function __get_projects_by_secrecy($secret)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_SECRET => $secret);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(ProjectDBObject::COL_SECRET));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, new Project(
                        $row[ProjectDBObject::COL_NUMBER],
                        $row[ProjectDBObject::COL_NAME],
                        $row[ProjectDBObject::COL_DESCRIPTION],
                        $row[ProjectDBObject::COL_ORIGIN],
                        $row[ProjectDBObject::COL_FIELD],
                        $row[ProjectDBObject::COL_STATUS],
                        $row[ProjectDBObject::COL_FIRM_ID],
                        $row[ProjectDBObject::COL_AUDITOR_ID],
                        $row[ProjectDBObject::COL_SIGN_DATE],
                        $row[ProjectDBObject::COL_END_DATE],
                        $row[ProjectDBObject::COL_MGMT_FEE],
                        $row[ProjectDBObject::COL_APP_FEE],
                        $row[ProjectDBObject::COL_REBILLED_FEE],
                        $row[ProjectDBObject::COL_ADVANCE],
                        $row[ProjectDBObject::COL_SECRET],
                        $row[ProjectDBObject::COL_CRITICAL],
                        $row[ProjectDBObject::COL_CREATION_DATE],
                        $row[ProjectDBObject::COL_UPDATE_DATE],
                        $row[ProjectDBObject::COL_DISABLED],
                        $row[ProjectDBObject::COL_DISABLED_SINCE],
                        $row[ProjectDBObject::COL_DISABLED_UNTIL],
                        $row[ProjectDBObject::COL_ARCHIVED],
                        $row[ProjectDBObject::COL_ARCHIVED_SINCE]
                    )
                );
            }
        }
        return $data;
    }

    private function __get_projects_by_critical($critical)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_CRITICAL => $critical);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(ProjectDBObject::COL_CRITICAL));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, new Project(
                        $row[ProjectDBObject::COL_NUMBER],
                        $row[ProjectDBObject::COL_NAME],
                        $row[ProjectDBObject::COL_DESCRIPTION],
                        $row[ProjectDBObject::COL_ORIGIN],
                        $row[ProjectDBObject::COL_FIELD],
                        $row[ProjectDBObject::COL_STATUS],
                        $row[ProjectDBObject::COL_FIRM_ID],
                        $row[ProjectDBObject::COL_AUDITOR_ID],
                        $row[ProjectDBObject::COL_SIGN_DATE],
                        $row[ProjectDBObject::COL_END_DATE],
                        $row[ProjectDBObject::COL_MGMT_FEE],
                        $row[ProjectDBObject::COL_APP_FEE],
                        $row[ProjectDBObject::COL_REBILLED_FEE],
                        $row[ProjectDBObject::COL_ADVANCE],
                        $row[ProjectDBObject::COL_SECRET],
                        $row[ProjectDBObject::COL_CRITICAL],
                        $row[ProjectDBObject::COL_CREATION_DATE],
                        $row[ProjectDBObject::COL_UPDATE_DATE],
                        $row[ProjectDBObject::COL_DISABLED],
                        $row[ProjectDBObject::COL_DISABLED_SINCE],
                        $row[ProjectDBObject::COL_DISABLED_UNTIL],
                        $row[ProjectDBObject::COL_ARCHIVED],
                        $row[ProjectDBObject::COL_ARCHIVED_SINCE]
                    )
                );
            }
        }
        return $data;
    }

    private function __get_all_statuses()
    {
        // create sql params array
        $sql_params = array();
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_STATUS)->GetSELECTQuery();
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, $row[ProjectDBObject::COL_LABEL]);
            }
        }
        return $data;
    }

    private function __get_all_origins()
    {
        // create sql params array
        $sql_params = array();
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_ORIGIN)->GetSELECTQuery();
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, $row[ProjectDBObject::COL_LABEL]);
            }
        }
        return $data;
    }

    private function __get_all_amendment_types()
    {
        // create sql params array
        $sql_params = array();
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_AMENDMENT_TYPE)->GetSELECTQuery();
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, $row[ProjectDBObject::COL_LABEL]);
            }
        }
        return $data;
    }

    private function __get_all_amendments()
    {
        // create sql params array
        $sql_params = array();
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_AMENDMENT)->GetSELECTQuery();
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, [
                    ProjectDBObject::COL_ID => $row[ProjectDBObject::COL_ID],
                    ProjectDBObject::COL_PROJECT_NUMBER => $row[ProjectDBObject::COL_PROJECT_NUMBER],
                    ProjectDBObject::COL_CONTENT => $row[ProjectDBObject::COL_CONTENT],
                    ProjectDBObject::COL_ATTRIBUTABLE => boolval($row[ProjectDBObject::COL_ATTRIBUTABLE]),
                    ProjectDBObject::COL_CREATION_DATE => $row[ProjectDBObject::COL_CREATION_DATE],
                    ProjectDBObject::COL_TYPE => $this->__get_amendment_types_by_id($row[ProjectDBObject::COL_ID])
                ]);
            }
        }
        return $data;
    }

    private function __get_amendment_by_id($id)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_ID => $id);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_AMENDMENT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(ProjectDBObject::COL_ID)
        );
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            if (($row = $pdos->fetch()) !== false) {
                $data = [
                    ProjectDBObject::COL_ID => $row[ProjectDBObject::COL_ID],
                    ProjectDBObject::COL_PROJECT_NUMBER => $row[ProjectDBObject::COL_PROJECT_NUMBER],
                    ProjectDBObject::COL_CONTENT => $row[ProjectDBObject::COL_CONTENT],
                    ProjectDBObject::COL_ATTRIBUTABLE => boolval($row[ProjectDBObject::COL_ATTRIBUTABLE]),
                    ProjectDBObject::COL_CREATION_DATE => $row[ProjectDBObject::COL_CREATION_DATE],
                    ProjectDBObject::COL_TYPE => $this->__get_amendment_types_by_id($row[ProjectDBObject::COL_ID])
                ];
            }
        }
        return $data;
    }

    private function __get_all_amendments_by_project($projectNumber)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_PROJECT_NUMBER => $projectNumber);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_AMENDMENT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(ProjectDBObject::COL_PROJECT_NUMBER)
        );
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, [
                    ProjectDBObject::COL_ID => $row[ProjectDBObject::COL_ID],
                    ProjectDBObject::COL_PROJECT_NUMBER => $row[ProjectDBObject::COL_PROJECT_NUMBER],
                    ProjectDBObject::COL_CONTENT => $row[ProjectDBObject::COL_CONTENT],
                    ProjectDBObject::COL_ATTRIBUTABLE => boolval($row[ProjectDBObject::COL_ATTRIBUTABLE]),
                    ProjectDBObject::COL_CREATION_DATE => $row[ProjectDBObject::COL_CREATION_DATE],
                    ProjectDBObject::COL_TYPE => $this->__get_amendment_types_by_id($row[ProjectDBObject::COL_ID])
                ]);
            }
        }
        return $data;
    }

    private function __get_all_chadaffs_by_project($projectNumber)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_PROJECT_NUMBER => $projectNumber);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_CHADAFF)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(ProjectDBObject::COL_PROJECT_NUMBER)
        );
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, [
                    ProjectDBObject::COL_PROJECT_NUMBER => $row[ProjectDBObject::COL_PROJECT_NUMBER],
                    ProjectDBObject::COL_CHADAFF_ID => $row[ProjectDBObject::COL_CHADAFF_ID]
                ]);
            }
        }
        return $data;
    }

    private function __get_all_contacts_by_project($projectNumber)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_PROJECT_NUMBER => $projectNumber);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_CONTACT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(ProjectDBObject::COL_PROJECT_NUMBER)
        );
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, [
                    ProjectDBObject::COL_PROJECT_NUMBER => $row[ProjectDBObject::COL_PROJECT_NUMBER],
                    ProjectDBObject::COL_CONTACT_ID => $row[ProjectDBObject::COL_CONTACT_ID]
                ]);
            }
        }
        return $data;
    }

    private function __get_all_ints_by_project($projectNumber)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_PROJECT_NUMBER => $projectNumber);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_INT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(ProjectDBObject::COL_PROJECT_NUMBER)
        );
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, [
                    ProjectDBObject::COL_ID => $row[ProjectDBObject::COL_ID],
                    ProjectDBObject::COL_INT_ID => $row[ProjectDBObject::COL_INT_ID],
                    ProjectDBObject::COL_NUMBER => $row[ProjectDBObject::COL_NUMBER],
                    ProjectDBObject::COL_JEH_ASSIGNED => $row[ProjectDBObject::COL_JEH_ASSIGNED],
                    ProjectDBObject::COL_PAY => $row[ProjectDBObject::COL_PAY]
                ]);
            }
        }
        return $data;
    }

    private function __get_int_by_project_and_user($projectNumber, $intId)
    {
        // create sql params array
        $sql_params = array(
            ":" . ProjectDBObject::COL_PROJECT_NUMBER => $projectNumber,
            ":" . ProjectDBObject::COL_INT_ID => $intId
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_INT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(ProjectDBObject::COL_PROJECT_NUMBER, ProjectDBObject::COL_INT_ID)
        );
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = null;
        if (isset($pdos)) {
            if (($row = $pdos->fetch()) !== false) {
                $data = [
                    ProjectDBObject::COL_ID => $row[ProjectDBObject::COL_ID],
                    ProjectDBObject::COL_INT_ID => $row[ProjectDBObject::COL_INT_ID],
                    ProjectDBObject::COL_NUMBER => $row[ProjectDBObject::COL_NUMBER],
                    ProjectDBObject::COL_JEH_ASSIGNED => $row[ProjectDBObject::COL_JEH_ASSIGNED],
                    ProjectDBObject::COL_PAY => $row[ProjectDBObject::COL_PAY]
                ];
            }
        }
        return $data;
    }

    // -- modify
    private function __insert_project($name, $description, $origin, $field, $firmId, $mgmtFee, $appFee,
                                      $rebilledFee, $advance, $secret, $critical, $assignCurrent)
    {
        $number = $this->__get_next_project_number();
        $sql_params = array(
            ":" . ProjectDBObject::COL_NUMBER => $number,
            ":" . ProjectDBObject::COL_NAME => $name,
            ":" . ProjectDBObject::COL_DESCRIPTION => $description,
            ":" . ProjectDBObject::COL_ORIGIN => $origin,
            ":" . ProjectDBObject::COL_FIELD => $field,
            ":" . ProjectDBObject::COL_STATUS => Project::STATUS[0],
            ":" . ProjectDBObject::COL_FIRM_ID => $firmId,
            ":" . ProjectDBObject::COL_AUDITOR_ID => null,
            ":" . ProjectDBObject::COL_SIGN_DATE => null,
            ":" . ProjectDBObject::COL_END_DATE => null,
            ":" . ProjectDBObject::COL_MGMT_FEE => $mgmtFee,
            ":" . ProjectDBObject::COL_APP_FEE => $appFee,
            ":" . ProjectDBObject::COL_REBILLED_FEE => $rebilledFee,
            ":" . ProjectDBObject::COL_ADVANCE => $advance,
            ":" . ProjectDBObject::COL_SECRET => $secret,
            ":" . ProjectDBObject::COL_CRITICAL => $critical,
            ":" . ProjectDBObject::COL_CREATION_DATE => date('Y-m-d H:i:s'),
            ":" . ProjectDBObject::COL_UPDATE_DATE => date('Y-m-d H:i:s'),
            ":" . ProjectDBObject::COL_DISABLED => 0,
            ":" . ProjectDBObject::COL_DISABLED_SINCE => null,
            ":" . ProjectDBObject::COL_DISABLED_UNTIL => null,
            ":" . ProjectDBObject::COL_ARCHIVED => 0,
            ":" . ProjectDBObject::COL_ARCHIVED_SINCE => null
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetINSERTQuery();
        // execute query
        $result = parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
        if ($result && $assignCurrent) {
            return $this->__assign_chadaff($number, $this->getCurrentUser()->getId());
        }
        return $result;
    }

    private function __force_insert_project($number, $name, $description, $origin, $field, $status, $firmId, $auditorId,
                                            $signDate, $endDate, $mgmtFee, $appFee, $rebilledFee, $advance, $secret,
                                            $critical, $creationDate, $updateDate, $disabled,
                                            $disabledSince, $disabledUntil, $archived, $archivedSince)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_NUMBER => $number,
            ":" . ProjectDBObject::COL_NAME => $name,
            ":" . ProjectDBObject::COL_DESCRIPTION => $description,
            ":" . ProjectDBObject::COL_ORIGIN => $origin,
            ":" . ProjectDBObject::COL_FIELD => $field,
            ":" . ProjectDBObject::COL_STATUS => $status,
            ":" . ProjectDBObject::COL_FIRM_ID => $firmId,
            ":" . ProjectDBObject::COL_AUDITOR_ID => $auditorId,
            ":" . ProjectDBObject::COL_SIGN_DATE => $signDate,
            ":" . ProjectDBObject::COL_END_DATE => $endDate,
            ":" . ProjectDBObject::COL_MGMT_FEE => $mgmtFee,
            ":" . ProjectDBObject::COL_APP_FEE => $appFee,
            ":" . ProjectDBObject::COL_REBILLED_FEE => $rebilledFee,
            ":" . ProjectDBObject::COL_ADVANCE => $advance,
            ":" . ProjectDBObject::COL_SECRET => $secret,
            ":" . ProjectDBObject::COL_CRITICAL => $critical,
            ":" . ProjectDBObject::COL_CREATION_DATE => $creationDate,
            ":" . ProjectDBObject::COL_UPDATE_DATE => $updateDate,
            ":" . ProjectDBObject::COL_DISABLED => $disabled,
            ":" . ProjectDBObject::COL_DISABLED_SINCE => $disabledSince,
            ":" . ProjectDBObject::COL_DISABLED_UNTIL => $disabledUntil,
            ":" . ProjectDBObject::COL_ARCHIVED => $archived,
            ":" . ProjectDBObject::COL_ARCHIVED_SINCE => $archivedSince
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetINSERTQuery();
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __update_project($number, $name, $description, $origin, $field, $firmId, $mgmtFee, $appFee,
                                      $rebilledFee, $advance, $secret, $critical)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_NUMBER => $number,
            ":" . ProjectDBObject::COL_NAME => $name,
            ":" . ProjectDBObject::COL_DESCRIPTION => $description,
            ":" . ProjectDBObject::COL_ORIGIN => $origin,
            ":" . ProjectDBObject::COL_FIELD => $field,
            ":" . ProjectDBObject::COL_FIRM_ID => $firmId,
            ":" . ProjectDBObject::COL_MGMT_FEE => $mgmtFee,
            ":" . ProjectDBObject::COL_APP_FEE => $appFee,
            ":" . ProjectDBObject::COL_REBILLED_FEE => $rebilledFee,
            ":" . ProjectDBObject::COL_ADVANCE => $advance,
            ":" . ProjectDBObject::COL_SECRET => $secret,
            ":" . ProjectDBObject::COL_CRITICAL => $critical,
            ":" . ProjectDBObject::COL_UPDATE_DATE => date('Y-m-d H:i:s')
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetUPDATEQuery(
            array(
                ProjectDBObject::COL_NAME,
                ProjectDBObject::COL_DESCRIPTION,
                ProjectDBObject::COL_ORIGIN,
                ProjectDBObject::COL_FIELD,
                ProjectDBObject::COL_FIRM_ID,
                ProjectDBObject::COL_MGMT_FEE,
                ProjectDBObject::COL_APP_FEE,
                ProjectDBObject::COL_REBILLED_FEE,
                ProjectDBObject::COL_ADVANCE,
                ProjectDBObject::COL_SECRET,
                ProjectDBObject::COL_CRITICAL,
                ProjectDBObject::COL_UPDATE_DATE
            ),
            array(
                ProjectDBObject::COL_NUMBER
            )
        );
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __update_own_project($number, $name, $description, $origin, $field, $firmId, $mgmtFee, $appFee,
                                          $rebilledFee, $advance, $secret, $critical)
    {
        // If user is a chargé d'affaires in the project, (s)he is allowed to update it
        if ($this->__user_has_rights($number)) {
            return $this->__update_project($number, $name, $description, $origin, $field, $firmId, $mgmtFee,
                $appFee, $rebilledFee, $advance, $secret, $critical);
        }
        return false;
    }

    private function __sign_project($number, $signDate)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_NUMBER => $number,
            ":" . ProjectDBObject::COL_SIGN_DATE => $signDate,
            ":" . ProjectDBObject::COL_STATUS => Project::STATUS[2],
            ":" . ProjectDBObject::COL_UPDATE_DATE => date('Y-m-d H:i:s')
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetUPDATEQuery(
            array(
                ProjectDBObject::COL_SIGN_DATE,
                ProjectDBObject::COL_STATUS,
                ProjectDBObject::COL_UPDATE_DATE
            ),
            array(
                ProjectDBObject::COL_NUMBER
            )
        );
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __unsign_project($number)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_NUMBER => $number,
            ":" . ProjectDBObject::COL_SIGN_DATE => null,
            ":" . ProjectDBObject::COL_STATUS => Project::STATUS[1],
            ":" . ProjectDBObject::COL_UPDATE_DATE => date('Y-m-d H:i:s')
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetUPDATEQuery(
            array(
                ProjectDBObject::COL_SIGN_DATE,
                ProjectDBObject::COL_STATUS,
                ProjectDBObject::COL_UPDATE_DATE
            ),
            array(
                ProjectDBObject::COL_NUMBER
            )
        );
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __end_project($number, $endDate)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_NUMBER => $number,
            ":" . ProjectDBObject::COL_STATUS => Project::STATUS[4],
            ":" . ProjectDBObject::COL_END_DATE => $endDate,
            ":" . ProjectDBObject::COL_UPDATE_DATE => date('Y-m-d H:i:s')
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetUPDATEQuery(
            array(
                ProjectDBObject::COL_END_DATE,
                ProjectDBObject::COL_STATUS,
                ProjectDBObject::COL_UPDATE_DATE
            ),
            array(
                ProjectDBObject::COL_NUMBER
            )
        );
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __bad_end_project($number, $endDate, $content, $attributable)
    {
        // Create amendment
        if (!$this->__insert_amendment(
            $number,
            ['Rupture'],
            $content,
            $attributable,
            $endDate
        )
        ) {
            return false;
        }

        $sql_params = array(
            ":" . ProjectDBObject::COL_NUMBER => $number,
            ":" . ProjectDBObject::COL_STATUS => Project::STATUS[6],
            ":" . ProjectDBObject::COL_END_DATE => $endDate,
            ":" . ProjectDBObject::COL_UPDATE_DATE => date('Y-m-d H:i:s')
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetUPDATEQuery(
            array(
                ProjectDBObject::COL_END_DATE,
                ProjectDBObject::COL_STATUS,
                ProjectDBObject::COL_UPDATE_DATE
            ),
            array(
                ProjectDBObject::COL_NUMBER
            )
        );
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __unend_project($number)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_NUMBER => $number,
            ":" . ProjectDBObject::COL_END_DATE => null,
            ":" . ProjectDBObject::COL_UPDATE_DATE => date('Y-m-d H:i:s')
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetUPDATEQuery(
            array(
                ProjectDBObject::COL_END_DATE,
                ProjectDBObject::COL_UPDATE_DATE
            ),
            array(
                ProjectDBObject::COL_NUMBER
            )
        );
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __disable_project($number, $disabledUntil)
    {
        // create sql params
        $sql_params = array(
            ":" . ProjectDBObject::COL_NUMBER => $number,
            ":" . ProjectDBObject::COL_DISABLED => 1,
            ":" . ProjectDBObject::COL_DISABLED_SINCE => date('Y-m-d'),
            ":" . ProjectDBObject::COL_DISABLED_UNTIL => $disabledUntil
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetUPDATEQuery(array(
            ProjectDBObject::COL_DISABLED,
            ProjectDBObject::COL_DISABLED_SINCE,
            ProjectDBObject::COL_DISABLED_UNTIL
        ),
            array(
                ProjectDBObject::COL_NUMBER
            )
        );
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __enable_project($number)
    {
        // create sql params
        $sql_params = array(
            ":" . ProjectDBObject::COL_NUMBER => $number,
            ":" . ProjectDBObject::COL_DISABLED => 0,
            ":" . ProjectDBObject::COL_DISABLED_SINCE => null,
            ":" . ProjectDBObject::COL_DISABLED_UNTIL => null
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetUPDATEQuery(array(
            ProjectDBObject::COL_DISABLED,
            ProjectDBObject::COL_DISABLED_SINCE,
            ProjectDBObject::COL_DISABLED_UNTIL
        ),
            array(
                ProjectDBObject::COL_NUMBER
            )
        );
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __delete_project($number)
    {
        // create sql params
        $sql_params = array(":" . ProjectDBObject::COL_NUMBER => $number);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetDELETEQuery(
            array(ProjectDBObject::COL_NUMBER)
        );
        // execute query
        return (parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params));
    }

    private function __assign_chadaff($number, $chadaffId)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_PROJECT_NUMBER => $number,
            ":" . ProjectDBObject::COL_CHADAFF_ID => $chadaffId,
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_CHADAFF)->GetINSERTQuery();
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __assign_contact($number, $contactId)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_PROJECT_NUMBER => $number,
            ":" . ProjectDBObject::COL_CONTACT_ID => $contactId,
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_CONTACT)->GetINSERTQuery();
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __assign_contact_own($number, $contactId)
    {
        if ($this->__user_has_rights($number)) {
            return $this->__assign_contact($number, $contactId);
        }
        return false;
    }

    private function __assign_int($number, $intId, $jehAssigned, $pay)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_ID => null,
            ":" . ProjectDBObject::COL_PROJECT_NUMBER => $number,
            ":" . ProjectDBObject::COL_NUMBER => $this->__get_next_int_number($number),
            ":" . ProjectDBObject::COL_INT_ID => $intId,
            ":" . ProjectDBObject::COL_JEH_ASSIGNED => $jehAssigned,
            ":" . ProjectDBObject::COL_PAY => $pay
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_INT)->GetINSERTQuery();
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __assign_int_own($number, $intId, $jehAssigned, $pay)
    {
        if ($this->__user_has_rights($number)) {
            return $this->__assign_int($number, $intId, $jehAssigned, $pay);
        }
        return false;
    }

    private function __assign_auditor($number, $auditorId)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_NUMBER => $number,
            ":" . ProjectDBObject::COL_AUDITOR_ID => $auditorId,
            ":" . ProjectDBObject::COL_UPDATE_DATE => date('Y-m-d H:i:s')
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetUPDATEQuery(
            array(
                ProjectDBObject::COL_AUDITOR_ID,
                ProjectDBObject::COL_UPDATE_DATE
            ),
            array(
                ProjectDBObject::COL_NUMBER
            )
        );
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __remove_chadaff($number, $chadaffId)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_PROJECT_NUMBER => $number,
            ":" . ProjectDBObject::COL_CHADAFF_ID => $chadaffId,
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_CHADAFF)->GetDELETEQuery(array(
                ProjectDBObject::COL_PROJECT_NUMBER,
                ProjectDBObject::COL_CHADAFF_ID
            )
        );
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __remove_contact($number, $contactId)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_PROJECT_NUMBER => $number,
            ":" . ProjectDBObject::COL_CONTACT_ID => $contactId,
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_CONTACT)->GetDELETEQuery(array(
                ProjectDBObject::COL_PROJECT_NUMBER,
                ProjectDBObject::COL_CONTACT_ID
            )
        );
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __remove_contact_own($number, $contactId)
    {
        if ($this->__user_has_rights($number)) {
            return $this->__remove_contact($number, $contactId);
        }
        return false;
    }

    private function __remove_int($number, $intId)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_PROJECT_NUMBER => $number,
            ":" . ProjectDBObject::COL_INT_ID => $intId
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_INT)->GetDELETEQuery(array(
            ProjectDBObject::COL_PROJECT_NUMBER,
            ProjectDBObject::COL_INT_ID
        ));
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __remove_int_own($number, $intId)
    {
        if ($this->__user_has_rights($number)) {
            return $this->__remove_int($number, $intId);
        }
        return false;
    }

    private function __insert_amendment($number, $type, $content, $attributable, $creationDate)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_ID => null,
            ":" . ProjectDBObject::COL_PROJECT_NUMBER => $number,
            ":" . ProjectDBObject::COL_CONTENT => $content,
            ":" . ProjectDBObject::COL_ATTRIBUTABLE => $attributable,
            ":" . ProjectDBObject::COL_CREATION_DATE => $creationDate
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_AMENDMENT)->GetINSERTQuery();
        // execute query
        $type = preg_split('/,/', $type);
        if (parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params)) {
            $ok = true;
            foreach ($type as $amType) {
                $amendments = $this->__get_all_amendments();
                if (($ok = $this->__insert_amendment_type_rel(end($amendments)[ProjectDBObject::COL_ID], $amType))) {
                    continue;
                }
                break;
            }
            return $ok;
        }
    }

    private function __insert_amendment_type_rel($id, $type)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_AMENDMENT_ID => $id,
            ":" . ProjectDBObject::COL_TYPE => $type
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_AMENDMENT_TYPE_REL)->GetINSERTQuery();
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __delete_amendment_type_rels($id)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_AMENDMENT_ID => $id
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_AMENDMENT_TYPE_REL)->GetDELETEQuery(
            array(ProjectDBObject::COL_AMENDMENT_ID)
        );
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __insert_amendment_own($number, $type, $content, $attributable, $creationDate)
    {
        if ($this->__user_has_rights($number)) {
            return $this->__insert_amendment($number, $type, $content, $attributable, $creationDate);
        }
        return false;
    }

    private function __update_amendment($id, $type, $content, $attributable, $creationDate)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_ID => $id,
            ":" . ProjectDBObject::COL_CONTENT => $content,
            ":" . ProjectDBObject::COL_ATTRIBUTABLE => $attributable,
            ":" . ProjectDBObject::COL_CREATION_DATE => $creationDate
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_AMENDMENT)->GetUPDATEQuery(
            array(
                ProjectDBObject::COL_CONTENT,
                ProjectDBObject::COL_ATTRIBUTABLE,
                ProjectDBObject::COL_CREATION_DATE
            )
        );
        // execute query
        if (parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params)) {
            if ($this->__delete_amendment_type_rels($id)) {
                $ok = true;
                $type = preg_split('/,/', $type);
                foreach ($type as $amType) {
                    $amendments = $this->__get_all_amendments();
                    if ($ok = $this->__insert_amendment_type_rel(end($amendments)[ProjectDBObject::COL_ID], $amType)) {
                        continue;
                    }
                    break;
                }
                return $ok;
            }
        }
    }

    private function __update_amendment_own($id, $type, $content, $attributable, $creationDate)
    {
        $amendment = $this->__get_amendment_by_id($id);
        if ($this->__user_has_rights($amendment[ProjectDBObject::COL_PROJECT_NUMBER])) {
            return $this->__update_amendment($id, $type, $content, $attributable, $creationDate);
        }
        return false;
    }

    private function __delete_amendment($id)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_ID => $id
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_AMENDMENT)->GetDELETEQuery();
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __delete_amendment_own($id)
    {
        $amendment = $this->__get_amendment_by_id($id);
        if ($this->__user_has_rights($amendment[ProjectDBObject::COL_PROJECT_NUMBER])) {
            return $this->__delete_amendment($id);
        }
        return false;
    }

    private function __abort_project($number)
    {
        $sql_params = array(
            ":" . ProjectDBObject::COL_NUMBER => $number,
            ":" . ProjectDBObject::COL_STATUS => Project::STATUS[7],
            ":" . ProjectDBObject::COL_UPDATE_DATE => date('Y-m-d H:i:s'),
            ":" . ProjectDBObject::COL_ARCHIVED => 1,
            ":" . ProjectDBObject::COL_ARCHIVED_SINCE => date('Y-m-d')
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetUPDATEQuery(
            array(
                ProjectDBObject::COL_STATUS,
                ProjectDBObject::COL_UPDATE_DATE,
                ProjectDBObject::COL_ARCHIVED,
                ProjectDBObject::COL_ARCHIVED_SINCE
            ),
            array(
                ProjectDBObject::COL_NUMBER
            )
        );
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __archive_project($number)
    {
        $project = $this->__get_project_by_number($number);
        if ($project->getStatus() != Project::STATUS[4] && $project->getStatus() != Project::STATUS[6]) {
            return false;
        }
        $sql_params = array(
            ":" . ProjectDBObject::COL_NUMBER => $number,
            ":" . ProjectDBObject::COL_STATUS => Project::STATUS[array_search($project->getStatus(), Project::STATUS) + 1],
            ":" . ProjectDBObject::COL_UPDATE_DATE => date('Y-m-d H:i:s'),
            ":" . ProjectDBObject::COL_ARCHIVED => 1,
            ":" . ProjectDBObject::COL_ARCHIVED_SINCE => date('Y-m-d')
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetUPDATEQuery(
            array(
                ProjectDBObject::COL_STATUS,
                ProjectDBObject::COL_UPDATE_DATE,
                ProjectDBObject::COL_ARCHIVED,
                ProjectDBObject::COL_ARCHIVED_SINCE
            ),
            array(
                ProjectDBObject::COL_NUMBER
            )
        );
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __unarchive_project($number)
    {
        $project = $this->__get_project_by_number($number);
        if ($project->getStatus() != Project::STATUS[5] && $project->getStatus() != Project::STATUS[7]) {
            return false;
        }
        $status = Project::STATUS[array_search($project->getStatus(), Project::STATUS) - 1];
        if ($project->GetSignDate() == null) {
            $status = Project::STATUS[0];
        }
        $sql_params = array(
            ":" . ProjectDBObject::COL_NUMBER => $number,
            ":" . ProjectDBObject::COL_STATUS => $status,
            ":" . ProjectDBObject::COL_UPDATE_DATE => date('Y-m-d H:i:s'),
            ":" . ProjectDBObject::COL_ARCHIVED => 0,
            ":" . ProjectDBObject::COL_ARCHIVED_SINCE => null
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetUPDATEQuery(
            array(
                ProjectDBObject::COL_STATUS,
                ProjectDBObject::COL_UPDATE_DATE,
                ProjectDBObject::COL_ARCHIVED,
                ProjectDBObject::COL_ARCHIVED_SINCE
            ),
            array(
                ProjectDBObject::COL_NUMBER
            )
        );
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __user_has_rights($projectNumber)
    {
        $ids = array();
        foreach ($this->__get_all_chadaffs_by_project($projectNumber) as $chadaff) {
            array_push($ids, $chadaff[ProjectDBObject::COL_CHADAFF_ID]);
        }
        return in_array($this->getCurrentUser()->GetId(), $ids);
    }

    private function __user_has_auditor_rights($projectNumber)
    {
        return $this->__get_project_by_number($projectNumber)->GetAuditorId() == $this->getCurrentUser()->GetId();
    }

    // -- special

    private function __get_next_project_number()
    {
        // create sql params array
        $sql_params = array();
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_PROJECT)->GetSELECTQuery(
            array(ProjectDBObject::COL_NUMBER),
            array(DBTable::EVERYWHERE),
            array(),
            array(ProjectDBObject::COL_NUMBER => DBTable::ORDER_DESC),
            1
        );
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = 0;
        if (isset($pdos)) {
            if (($row = $pdos->fetch()) !== false) {
                $data = intval($row[ProjectDBObject::COL_NUMBER]);
            }
        }
        return $data + 1;
    }

    private function __get_amendment_types_by_id($amendmentId)
    {
        // create sql params array
        $sql_params = array(":" . ProjectDBObject::COL_AMENDMENT_ID => $amendmentId);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_AMENDMENT_TYPE_REL)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(ProjectDBObject::COL_AMENDMENT_ID)
        );
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create data var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, $row[ProjectDBObject::COL_TYPE]);
            }
        }
        return $data;
    }

    private function __get_next_int_number($number)
    {
        // create sql params array
        $sql_params = array(
            ":" . ProjectDBObject::COL_PROJECT_NUMBER => $number
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_INT)->GetSELECTQuery(
            array(ProjectDBObject::COL_NUMBER),
            array(ProjectDBObject::COL_PROJECT_NUMBER),
            array(),
            array(ProjectDBObject::COL_NUMBER => DBTable::ORDER_DESC),
            1
        );
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = 0;
        if (isset($pdos)) {
            if (($row = $pdos->fetch()) !== false) {
                $data = intval($row[ProjectDBObject::COL_NUMBER]);
            } else {
                $data = 0;
            }
        }
        return $data + 1;
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
        // -- init origin table --------------------------------------------------------------------
        $origins = array(
            "Site web",
            "Mail",
            "Salon",
            "Téléphone",
            "Appel d'offre",
            "Autre"
        );
        // --- retrieve SQL query
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_ORIGIN)->GetINSERTQuery();
        foreach ($origins as $origin) {
            // --- create param array
            $sql_params = array(
                ":" . ProjectDBObject::COL_LABEL => $origin
            );
            // --- execute SQL query
            parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
        }

        // -- init status table --------------------------------------------------------------------
        // --- retrieve SQL query
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_STATUS)->GetINSERTQuery();
        foreach (Project::STATUS as $status) {
            // --- create param array
            $sql_params = array(
                ":" . ProjectDBObject::COL_LABEL => $status
            );
            // --- execute SQL query
            parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
        }

        // -- init amendment type table --------------------------------------------------------------------
        $types = array(
            "Rupture",
            "Date",
            "Fonctionnalités",
            "Budget"
        );
        // --- retrieve SQL query
        $sql = parent::getDBObject()->GetTable(ProjectDBObject::TABL_AMENDMENT_TYPE)->GetINSERTQuery();
        foreach ($types as $type) {
            // --- create param array
            $sql_params = array(
                ":" . ProjectDBObject::COL_LABEL => $type
            );
            // --- execute SQL query
            parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
        }
    }

}

/**
 * @brief Project object interface
 */
class ProjectDBObject extends AbstractDBObject
{

    // -- consts
    // --- object name
    const OBJ_NAME = "project";
    // --- tables
    const TABL_PROJECT = "dol_project";
    const TABL_ORIGIN = "dol_project_origin";
    const TABL_STATUS = "dol_project_status";
    const TABL_AMENDMENT_TYPE = "dol_amendment_type";
    const TABL_AMENDMENT_TYPE_REL = 'dol_amendment_type_rel';
    const TABL_AMENDMENT = "dol_project_amendment";
    const TABL_CONTACT = "dol_project_contact";
    const TABL_CHADAFF = "dol_project_chadaff";
    const TABL_INT = "dol_project_int";
    // --- columns
    const COL_ID = "id";
    const COL_NUMBER = "number";
    const COL_NAME = "name";
    const COL_DESCRIPTION = "description";
    const COL_ORIGIN = "origin";
    const COL_FIELD = "field";
    const COL_STATUS = "status";
    const COL_FIRM_ID = "firm_id";
    const COL_AUDITOR_ID = "auditor_id";
    const COL_SIGN_DATE = "sign_date";
    const COL_END_DATE = "end_date";
    const COL_MGMT_FEE = "mgmt_fee";
    const COL_APP_FEE = "app_fee";
    const COL_REBILLED_FEE = "rebilled_fee";
    const COL_ADVANCE = "advance";
    const COL_SECRET = "secret";
    const COL_CRITICAL = "critical";
    const COL_CREATION_DATE = "creation_date";
    const COL_UPDATE_DATE = "update_date";
    const COL_LABEL = "label";
    const COL_PROJECT_NUMBER = "project_number";
    const COL_TYPE = "type";
    const COL_CONTENT = "content";
    const COL_ATTRIBUTABLE = "attributable";
    const COL_CONTACT_ID = "contact_id";
    const COL_CHADAFF_ID = "chadaff_id";
    const COL_INT_ID = "int_id";
    const COL_AMENDMENT = "amendment";
    const COL_JEH_ASSIGNED = "jeh_assigned";
    const COL_PAY = "pay";
    const COL_DISABLE_TSMP = "disable_timestamp";
    const COL_RESTORE_TSMP = "restore_timestamp";
    const COL_DISABLED = 'disabled';
    const COL_DISABLED_SINCE = 'disabled_since';
    const COL_DISABLED_UNTIL = 'disabled_until';
    const COL_ARCHIVED = 'archived';
    const COL_ARCHIVED_SINCE = 'archived_since';
    const COL_AMENDMENT_ID = 'amendment_id';
    // -- attributes

    // -- functions

    public function __construct($module)
    {
        // -- construct parent
        parent::__construct($module, ProjectDBObject::OBJ_NAME);

        // -- create tables
        // --- dol_origin table
        $dol_origin = new DBTable(ProjectDBObject::TABL_ORIGIN);
        $dol_origin->AddColumn(ProjectDBObject::COL_LABEL, DBTable::DT_VARCHAR, 255, false, "", false, true);

        // --- dol_status table
        $dol_status = new DBTable(ProjectDBObject::TABL_STATUS);
        $dol_status->AddColumn(ProjectDBObject::COL_LABEL, DBTable::DT_VARCHAR, 255, false, "", false, true);

        // --- dol_project table
        $dol_project = new DBTable(ProjectDBObject::TABL_PROJECT);
        $dol_project
            ->AddColumn(ProjectDBObject::COL_NUMBER, DBTable::DT_INT, 11, false, "", true, true)
            ->AddColumn(ProjectDBObject::COL_NAME, DBTable::DT_VARCHAR, 255, true, NULL)
            ->AddColumn(ProjectDBObject::COL_DESCRIPTION, DBTable::DT_TEXT, -1, true, NULL)
            ->AddColumn(ProjectDBObject::COL_ORIGIN, DBTable::DT_VARCHAR, 255, true, NULL)
            ->AddColumn(ProjectDBObject::COL_FIELD, DBTable::DT_VARCHAR, 255, true, NULL)
            ->AddColumn(ProjectDBObject::COL_STATUS, DBTable::DT_VARCHAR, 255, false, "")
            ->AddColumn(ProjectDBObject::COL_FIRM_ID, DBTable::DT_INT, 11, true, NULL)
            ->AddColumn(ProjectDBObject::COL_AUDITOR_ID, DBTable::DT_INT, 11, true, null)
            ->AddColumn(ProjectDBObject::COL_SIGN_DATE, DBTable::DT_DATE, -1, true, null)
            ->AddColumn(ProjectDBObject::COL_END_DATE, DBTable::DT_DATE, -1, true, null)
            ->AddColumn(ProjectDBObject::COL_MGMT_FEE, DBTable::DT_INT, 11, false, 0)
            ->AddColumn(ProjectDBObject::COL_APP_FEE, DBTable::DT_INT, 11, false, 0)
            ->AddColumn(ProjectDBObject::COL_REBILLED_FEE, DBTable::DT_INT, 11, false, 0)
            ->AddColumn(ProjectDBObject::COL_ADVANCE, DBTable::DT_INT, 11, false, 0)
            ->AddColumn(ProjectDBObject::COL_SECRET, DBTable::DT_INT, 1, false, 0)
            ->AddColumn(ProjectDBObject::COL_CRITICAL, DBTable::DT_INT, 1, false, 0)
            ->AddColumn(ProjectDBObject::COL_CREATION_DATE, DBTable::DT_DATETIME, -1, false)
            ->AddColumn(ProjectDBObject::COL_UPDATE_DATE, DBTable::DT_DATETIME, -1, false)
            ->AddColumn(ProjectDBObject::COL_DISABLED, DBTable::DT_INT, 1, false, 0)
            ->AddColumn(ProjectDBObject::COL_DISABLED_SINCE, DBTable::DT_DATE, -1, true, null)
            ->AddColumn(ProjectDBObject::COL_DISABLED_UNTIL, DBTable::DT_DATE, -1, true, null)
            ->AddColumn(ProjectDBObject::COL_ARCHIVED, DBTable::DT_INT, 1, false, 0)
            ->AddColumn(ProjectDBObject::COL_ARCHIVED_SINCE, DBTable::DT_DATE, -1, true, null)
            ->AddForeignKey(ProjectDBObject::TABL_PROJECT . '_fk1', ProjectDBObject::COL_AUDITOR_ID, UserDataDBObject::TABL_USER_DATA, UserDataDBObject::COL_USER_ID, DBTable::DT_RESTRICT, DBTable::DT_CASCADE)
            ->AddForeignKey(ProjectDBObject::TABL_PROJECT . '_fk2', ProjectDBObject::COL_ORIGIN, ProjectDBObject::TABL_ORIGIN, ProjectDBObject::COL_LABEL, DBTable::DT_RESTRICT, DBTable::DT_CASCADE)
            ->AddForeignKey(ProjectDBObject::TABL_PROJECT . '_fk3', ProjectDBObject::COL_FIELD, UserDataDBObject::TABL_COM_INSA_DEPT, UserDataDBObject::COL_LABEL, DBTable::DT_RESTRICT, DBTable::DT_CASCADE)
            ->AddForeignKey(ProjectDBObject::TABL_PROJECT . '_fk4', ProjectDBObject::COL_STATUS, ProjectDBObject::TABL_STATUS, ProjectDBObject::COL_LABEL, DBTable::DT_RESTRICT, DBTable::DT_CASCADE)
            ->AddForeignKey(ProjectDBObject::TABL_PROJECT . '_fk5', ProjectDBObject::COL_FIRM_ID, FirmDBObject::TABL_FIRM, FirmDBObject::COL_ID, DBTable::DT_RESTRICT, DBTable::DT_CASCADE);

        // --- dol_amendment_type table
        $dol_amendment_type = new DBTable(ProjectDBObject::TABL_AMENDMENT_TYPE);
        $dol_amendment_type->AddColumn(ProjectDBObject::COL_LABEL, DBTable::DT_VARCHAR, 255, false, "", false, true);

        // --- dol_amendment table
        $dol_amendment = new DBTable(ProjectDBObject::TABL_AMENDMENT);
        $dol_amendment
            ->AddColumn(ProjectDBObject::COL_ID, DBTable::DT_INT, 11, false, "", true, true)
            ->AddColumn(ProjectDBObject::COL_PROJECT_NUMBER, DBTable::DT_INT, 11, false, "")
            ->AddColumn(ProjectDBObject::COL_CONTENT, DBTable::DT_TEXT, -1, false, "")
            ->AddColumn(ProjectDBObject::COL_ATTRIBUTABLE, DBTable::DT_INT, 1, false, "")
            ->AddColumn(ProjectDBObject::COL_CREATION_DATE, DBTable::DT_VARCHAR, 255, false, "")
            ->AddForeignKey(ProjectDBObject::TABL_AMENDMENT . '_fk1', ProjectDBObject::COL_PROJECT_NUMBER, ProjectDBObject::TABL_PROJECT, ProjectDBObject::COL_NUMBER, DBTable::DT_CASCADE, DBTable::DT_CASCADE);

        // --- dol_amendment_type_rel table
        $dol_amendment_type_rel = new DBTable(ProjectDBObject::TABL_AMENDMENT_TYPE_REL);
        $dol_amendment_type_rel
            ->AddColumn(ProjectDBObject::COL_AMENDMENT_ID, DBTable::DT_INT, 11, false, "")
            ->AddColumn(ProjectDBObject::COL_TYPE, DBTable::DT_VARCHAR, 255, false, "")
            ->AddForeignKey(ProjectDBObject::TABL_AMENDMENT_TYPE_REL . '_fk1', ProjectDBObject::COL_TYPE, ProjectDBObject::TABL_AMENDMENT_TYPE, ProjectDBObject::COL_LABEL, DBTable::DT_CASCADE, DBTable::DT_CASCADE)
            ->AddForeignKey(ProjectDBObject::TABL_AMENDMENT_TYPE_REL . '_fk2', ProjectDBObject::COL_AMENDMENT_ID, ProjectDBObject::TABL_AMENDMENT, ProjectDBObject::COL_ID, DBTable::DT_CASCADE, DBTable::DT_CASCADE)
            ->AddUniqueColumns(array(ProjectDBObject::COL_AMENDMENT_ID, ProjectDBObject::COL_TYPE));

        // --- dol_contact table
        $dol_contact = new DBTable(ProjectDBObject::TABL_CONTACT);
        $dol_contact
            ->AddColumn(ProjectDBObject::COL_PROJECT_NUMBER, DBTable::DT_INT, 11, false, "")
            ->AddColumn(ProjectDBObject::COL_CONTACT_ID, DBTable::DT_INT, 11, false, "")
            ->AddForeignKey(ProjectDBObject::TABL_CONTACT . '_fk1', ProjectDBObject::COL_CONTACT_ID, ContactDBObject::TABL_CONTACT, ContactDBObject::COL_ID, DBTable::DT_RESTRICT, DBTable::DT_CASCADE)
            ->AddForeignKey(ProjectDBObject::TABL_CONTACT . '_fk2', ProjectDBObject::COL_PROJECT_NUMBER, ProjectDBObject::TABL_PROJECT, ProjectDBObject::COL_NUMBER, DBTable::DT_CASCADE, DBTable::DT_CASCADE)
            ->AddUniqueColumns(array(ProjectDBObject::COL_PROJECT_NUMBER, ProjectDBObject::COL_CONTACT_ID));

        // --- dol_chadaff table
        $dol_chadaff = new DBTable(ProjectDBObject::TABL_CHADAFF);
        $dol_chadaff
            ->AddColumn(ProjectDBObject::COL_PROJECT_NUMBER, DBTable::DT_INT, 11, false, "")
            ->AddColumn(ProjectDBObject::COL_CHADAFF_ID, DBTable::DT_INT, 11, false, "")
            ->AddForeignKey(ProjectDBObject::TABL_CHADAFF . '_fk1', ProjectDBObject::COL_CHADAFF_ID, UserDataDBObject::TABL_USER_DATA, UserDataDBObject::COL_USER_ID, DBTable::DT_RESTRICT, DBTable::DT_CASCADE)
            ->AddForeignKey(ProjectDBObject::TABL_CHADAFF . '_fk2', ProjectDBObject::COL_PROJECT_NUMBER, ProjectDBObject::TABL_PROJECT, ProjectDBObject::COL_NUMBER, DBTable::DT_CASCADE, DBTable::DT_CASCADE)
            ->AddUniqueColumns(array(ProjectDBObject::COL_PROJECT_NUMBER, ProjectDBObject::COL_CHADAFF_ID));

        // --- dol_int table
        $dol_int = new DBTable(ProjectDBObject::TABL_INT);
        $dol_int
            ->AddColumn(ProjectDBObject::COL_ID, DBTable::DT_INT, 11, false, "", true, true)
            ->AddColumn(ProjectDBObject::COL_PROJECT_NUMBER, DBTable::DT_INT, 11, false, "")
            ->AddColumn(ProjectDBObject::COL_INT_ID, DBTable::DT_INT, 11, false, "")
            ->AddColumn(ProjectDBObject::COL_NUMBER, DBTable::DT_INT, 11, false, "")
            ->AddColumn(ProjectDBObject::COL_JEH_ASSIGNED, DBTable::DT_INT, 11, false, "")
            ->AddColumn(ProjectDBObject::COL_PAY, DBTable::DT_INT, 11, false, "")
            ->AddForeignKey(ProjectDBObject::TABL_INT . '_fk1', ProjectDBObject::COL_INT_ID, UserDataDBObject::TABL_USER_DATA, UserDataDBObject::COL_USER_ID, DBTable::DT_RESTRICT, DBTable::DT_CASCADE)
            ->AddForeignKey(ProjectDBObject::TABL_INT . '_fk2', ProjectDBObject::COL_PROJECT_NUMBER, ProjectDBObject::TABL_PROJECT, ProjectDBObject::COL_NUMBER, DBTable::DT_CASCADE, DBTable::DT_CASCADE)
            ->AddUniqueColumns(array(ProjectDBObject::COL_PROJECT_NUMBER, ProjectDBObject::COL_INT_ID));

        // -- add tables
        parent::addTable($dol_origin);
        parent::addTable($dol_status);
        parent::addTable($dol_project);
        parent::addTable($dol_amendment_type);
        parent::addTable($dol_amendment);
        parent::addTable($dol_amendment_type_rel);
        parent::addTable($dol_contact);
        parent::addTable($dol_chadaff);
        parent::addTable($dol_int);

    }

    /**
     * @brief Returns all services associated with this object
     */
    public function GetServices($currentUser)
    {
        return new ProjectServices($currentUser, $this, $this->getDBConnection());
    }

    /**
     *    Initialize static data
     */
    public function ResetStaticData()
    {
        $services = new ProjectServices(null, $this, $this->getDBConnection());
        $services->ResetStaticData();
    }

}
