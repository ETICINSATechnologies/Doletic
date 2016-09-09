<?php

require_once "interfaces/AbstractDBObject.php";
require_once "interfaces/AbstractObjectServices.php";
require_once "objects/DBProcedure.php";
require_once "objects/DBTable.php";

/**
 * @brief Contact object
 */
class Contact implements \JsonSerializable
{

    // -- consts

    // -- attributes
    private $id = null;
    private $gender = null;
    private $firstname = null;
    private $lastname = null;
    private $firm_id = null;
    private $email = null;
    private $phone = null;
    private $category = null;
    private $last_update = null;

    /**
     * @brief Constructs a contact
     */
    public function __construct($id, $gender, $firstname, $lastname, $firmId, $email, $phone, $category, $lastUpdate)
    {
        $this->id = intval($id);
        $this->gender = $gender;
        $this->firstname = $firstname;
        $this->lastchange = $lastname;
        $this->firm_id = intval($firmId);
        $this->email = $email;
        $this->phone = $phone;
        $this->category = intval($category);
        $this->last_update = $lastUpdate;
    }

    public function jsonSerialize()
    {
        return [
            ContactDBObject::COL_ID => $this->id,
            ContactDBObject::COL_GENDER => $this->gender,
            ContactDBObject::COL_FIRSTNAME => $this->firstname,
            ContactDBObject::COL_LASTNAME => $this->lastname,
            ContactDBObject::COL_FIRM_ID => $this->firm_id,
            ContactDBObject::COL_EMAIL => $this->email,
            ContactDBObject::COL_PHONE => $this->phone,
            ContactDBObject::COL_CATEGORY => $this->category,
            ContactDBObject::COL_LAST_UPDATE => $this->last_update
        ];
    }

    /**
     * @brief Returns object's id
     * @return int
     */
    public function GetId()
    {
        return $this->id;
    }

    /**
     * @brief
     */
    public function GetGender()
    {
        return $this->gender;
    }

    /**
     * @brief
     */
    public function GetFirstname()
    {
        return $this->firstname;
    }

    /**
     * @brief
     */
    public function GetLastname()
    {
        return $this->lastname;
    }

    /**
     * @brief
     */
    public function GetFirmId()
    {
        return $this->firm_id;
    }

    /**
     * @brief
     */
    public function GetEmail()
    {
        return $this->email;
    }

    /**
     * @brief
     */
    public function GetPhone()
    {
        return $this->phone;
    }

    /**
     * @brief
     */
    public function GetCategoryId()
    {
        return $this->category;
    }

    /**
     * @brief
     */
    public function GetlastUpdate()
    {
        return $this->last_update;
    }
}

/**
 * @brief Contact object related services
 */
class ContactServices extends AbstractObjectServices
{

    // -- consts
    // --- params
    const PARAM_ID = "id";
    const PARAM_GENDER = "gender";
    const PARAM_FIRSTNAME = "firstname";
    const PARAM_LASTNAME = "lastname";
    const PARAM_FIRM_ID = "firmId";
    const PARAM_EMAIL = "email";
    const PARAM_PHONE = "phone";
    const PARAM_CATEGORY = "category";
    const PARAM_LAST_UPDATE = "lastUpdate";

    // --- actions
    const GET_CONTACT_BY_ID = "byid";
    const GET_ALL_CONTACTS = "all";
    const GET_ALL_CONTACT_TYPES = "alltypes";
    const INSERT = "insert";
    const UPDATE = "update";
    const DELETE = "delete";

    // -- functions

    // --- construct
    public function __construct($currentUser, $dbObject, $dbConnection)
    {
        parent::__construct($currentUser, $dbObject, $dbConnection);
    }

    public function GetResponseData($action, $params)
    {
        $data = null;
        if (!strcmp($action, ContactServices::GET_CONTACT_BY_ID)) {
            $data = $this->__get_contact_by_id($params[ContactServices::PARAM_ID]);
        } else if (!strcmp($action, ContactServices::GET_ALL_CONTACTS)) {
            $data = $this->__get_all_contacts();
        } else if (!strcmp($action, ContactServices::GET_ALL_CONTACT_TYPES)) {
            $data = $this->__get_all_contact_types();
        } else if (!strcmp($action, ContactServices::INSERT)) {
            $data = $this->__insert_contact(
                $params[ContactServices::PARAM_GENDER],
                $params[ContactServices::PARAM_FIRSTNAME],
                $params[ContactServices::PARAM_LASTNAME],
                $params[ContactServices::PARAM_FIRM_ID],
                $params[ContactServices::PARAM_EMAIL],
                $params[ContactServices::PARAM_PHONE],
                $params[ContactServices::PARAM_CATEGORY]);
        } else if (!strcmp($action, ContactServices::UPDATE)) {
            $data = $this->__update_contact(
                $params[ContactServices::PARAM_ID],
                $params[ContactServices::PARAM_GENDER],
                $params[ContactServices::PARAM_FIRSTNAME],
                $params[ContactServices::PARAM_LASTNAME],
                $params[ContactServices::PARAM_FIRM_ID],
                $params[ContactServices::PARAM_EMAIL],
                $params[ContactServices::PARAM_PHONE],
                $params[ContactServices::PARAM_CATEGORY]);
        } else if (!strcmp($action, ContactServices::DELETE)) {
            $data = $this->__delete_contact($params[ContactServices::PARAM_ID]);
        }
        return $data;
    }

# PROTECTED & PRIVATE ###########################################################

    // --- consult

    private function __get_contact_by_id($id)
    {
        // create sql params array
        $sql_params = array(":" . ContactDBObject::COL_ID => $id);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ContactDBObject::TABL_CONTACT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(FirmDBObject::COL_ID));
        // execute SQery and sresult
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create contact
        $contact = null;
        if (isset($pdos)) {
            if (($row = $pdos->fetch()) !== false) {
                $contact = new Contact(
                    $row[ContactDBObject::COL_ID],
                    $row[ContactDBObject::COL_GENDER],
                    $row[ContactDBObject::COL_FIRSTNAME],
                    $row[ContactDBObject::COL_LASTNAME],
                    $row[ContactDBObject::COL_FIRM_ID],
                    $row[ContactDBObject::COL_EMAIL],
                    $row[ContactDBObject::COL_PHONE],
                    $row[ContactDBObject::COL_CATEGORY],
                    $row[ContactDBObject::COL_LAST_UPDATE]
                );
            }
        }
        return $contact;
    }

    private function __get_all_contacts()
    {
        // create sql request
        $sql = parent::getDBObject()->GetTable(ContactDBObject::TABL_CONTACT)->GetSELECTQuery();
        // execute SQery and sresult
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, array());
        // create an empty array for contacts and fill it
        $contacts = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($contacts, new Contact(
                    $row[ContactDBObject::COL_ID],
                    $row[ContactDBObject::COL_GENDER],
                    $row[ContactDBObject::COL_FIRSTNAME],
                    $row[ContactDBObject::COL_LASTNAME],
                    $row[ContactDBObject::COL_FIRM_ID],
                    $row[ContactDBObject::COL_EMAIL],
                    $row[ContactDBObject::COL_PHONE],
                    $row[ContactDBObject::COL_CATEGORY],
                    $row[ContactDBObject::COL_LAST_UPDATE]
                ));
            }
        }
        return $contacts;
    }

    private function __get_all_contact_types()
    {
        // create sql request
        $sql = parent::getDBObject()->GetTable(ContactDBObject::TABL_CONTACT_TYPE)->GetSELECTQuery();
        // execute SQery and sresult
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, array());
        // create an empty array for contacts and fill it
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($contacts, $row[ContactDBObject::COL_LABEL]);
            }
        }
        return $data;
    }

    // --- modify

    private function __insert_contact($gender, $firstname, $lastname, $firmId, $email, $phone, $category)
    {
        // create sql params
        $sql_params = array(
            ":" . ContactDBObject::COL_ID => null,
            ":" . ContactDBObject::COL_GENDER => $gender,
            ":" . ContactDBObject::COL_FIRSTNAME => $firstname,
            ":" . ContactDBObject::COL_LASTNAME => $lastname,
            ":" . ContactDBObject::COL_FIRM_ID => $firmId,
            ":" . ContactDBObject::COL_EMAIL => $email,
            ":" . ContactDBObject::COL_PHONE => $phone,
            ":" . ContactDBObject::COL_CATEGORY => $category,
            ":" . ContactDBObject::COL_LAST_UPDATE => date('Y-m-d')
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(ContactDBObject::TABL_CONTACT)->GetINSERTQuery();
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __update_contact($id, $gender, $firstname, $lastname, $firmId, $email, $phone, $category)
    {
        // create sql params
        $sql_params = array(
            ":" . ContactDBObject::COL_ID => $id,
            ":" . ContactDBObject::COL_FIRSTNAME => $gender,
            ":" . ContactDBObject::COL_FIRSTNAME => $firstname,
            ":" . ContactDBObject::COL_LASTNAME => $lastname,
            ":" . ContactDBObject::COL_FIRM_ID => $firmId,
            ":" . ContactDBObject::COL_EMAIL => $email,
            ":" . ContactDBObject::COL_PHONE => $phone,
            ":" . ContactDBObject::COL_CATEGORY => $category,
            ":" . ContactDBObject::COL_LAST_UPDATE => date('Y-m-d')
        );
        // sql request
        $sql = parent::getDBObject()->GetTable(ContactDBObject::TABL_CONTACT)->GetUPDATEQuery();
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __delete_contact($id)
    {
        // create sql params
        $sql_params = array(":" . ContactDBObject::COL_ID => $id);
        // create sql request
        $sql = parent::getDBObject()->GetTable(ContactDBObject::TABL_CONTACT)->GetDELETEQuery();
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }


# PUBLIC RESET STATIC PHONE FUNCTION --------------------------------------------------------------------

    /**
     *    ---------!---------!---------!---------!---------!---------!---------!---------!---------
     *  !                            PHONEBASE CONSISTENCY WARNING                                !
     *  !                                                                                        !
     *  !  Please respect the following points :                                                !
     *    !  - When adding static data to existing data => always add at the end of the list      !
     *  !  - Never remove data (or ensure that no database element use one as a foreign key)    !
     *    ---------!---------!---------!---------!---------!---------!---------!---------!---------
     */
    public function ResetStaticData()
    {
        // --- retrieve SQL query
        $types = [
            'Client',
            'Fournisseur',
            'Prospect',
            'Prospect indirect'
        ];
        $sql = parent::getDBObject()->GetTable(ContactDBObject::TABL_CONTACT_TYPE)->GetINSERTQuery();
        foreach ($types as $type) {
            // --- create param array
            $sql_params = array(
                ":" . ContactDBObject::COL_LABEL => $type
            );
            // --- execute SQL query
            parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
        }
    }

}

/*
 *	@brief Contact object interface
 */

class ContactDBObject extends AbstractDBObject
{

    // -- consts
    // --- object name
    const OBJ_NAME = "contact";
    // --- tables
    const TABL_CONTACT = "dol_contact";
    const TABL_CONTACT_TYPE = "dol_contact_type";
    // --- columns
    const COL_ID = "id";
    const COL_LABEL = "label";
    const COL_GENDER = "gender";
    const COL_FIRSTNAME = "firstname";
    const COL_LASTNAME = "lastname";
    const COL_FIRM_ID = "firm_id";
    const COL_EMAIL = "email";
    const COL_PHONE = "phone";
    const COL_CATEGORY = "category";
    const COL_LAST_UPDATE = "last_update";
    // -- attributes

    // -- functions

    public function __construct($module)
    {
        // -- construct parent
        parent::__construct($module, ContactDBObject::OBJ_NAME);
        // -- create tables
        // --- dol_contact table
        $dol_contact_type = new DBTable(ContactDBObject::TABL_CONTACT_TYPE);
        $dol_contact_type
            ->AddColumn(ContactDBObject::COL_LABEL, DBTable::DT_VARCHAR, 255, false, "", false, true);

        // --- dol_contact table
        $dol_contact = new DBTable(ContactDBObject::TABL_CONTACT);
        $dol_contact
            ->AddColumn(ContactDBObject::COL_ID, DBTable::DT_INT, 11, false, "", true, true)
            ->AddColumn(ContactDBObject::COL_GENDER, DBTable::DT_VARCHAR, 255, false)
            ->AddColumn(ContactDBObject::COL_FIRSTNAME, DBTable::DT_VARCHAR, 255, false)
            ->AddColumn(ContactDBObject::COL_LASTNAME, DBTable::DT_VARCHAR, 255, false)
            ->AddColumn(ContactDBObject::COL_FIRM_ID, DBTable::DT_INT, 11, false)
            ->AddColumn(ContactDBObject::COL_EMAIL, DBTable::DT_VARCHAR, 255, false)
            ->AddColumn(ContactDBObject::COL_PHONE, DBTable::DT_VARCHAR, 255, false)
            ->AddColumn(ContactDBObject::COL_CATEGORY, DBTable::DT_VARCHAR, 255, false)
            ->AddColumn(ContactDBObject::COL_LAST_UPDATE, DBTable::DT_VARCHAR, 255, false)
            ->AddForeignKey(
                ContactDBObject::TABL_CONTACT . '_fk1',
                ContactDBObject::COL_CATEGORY,
                ContactDBObject::TABL_CONTACT_TYPE,
                ContactDBObject::COL_LABEL, DBTable::DT_CASCADE, DBTable::DT_CASCADE
            )
            ->AddForeignKey(
                ContactDBObject::TABL_CONTACT . '_fk2',
                ContactDBObject::COL_FIRM_ID,
                FirmDBObject::TABL_FIRM,
                FirmDBObject::COL_ID, DBTable::DT_CASCADE, DBTable::DT_CASCADE
            )
            ->AddForeignKey(
                ContactDBObject::TABL_CONTACT . '_fk3',
                ContactDBObject::COL_GENDER,
                UserDataDBObject::TABL_COM_GENDER,
                UserDataDBObject::COL_LABEL, DBTable::DT_CASCADE, DBTable::DT_CASCADE
            );

        // -- add tables
        parent::addTable($dol_contact_type);
        parent::addTable($dol_contact);
    }

    /**
     * @brief Returns all services associated with this object
     */
    public function GetServices($currentUser)
    {
        return new ContactServices($currentUser, $this, $this->getDBConnection());
    }

    /**
     *    Initialize static data
     */
    public function ResetStaticData()
    {
        $services = new ContactServices(null, $this, $this->getDBConnection());
        $services->ResetStaticData();
    }

}
