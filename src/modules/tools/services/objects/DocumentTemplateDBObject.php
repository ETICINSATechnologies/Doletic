<?php

require_once "interfaces/AbstractDBObject.php";
require_once "interfaces/AbstractObjectServices.php";
require_once "objects/DBProcedure.php";
require_once "objects/DBTable.php";
require_once "objects/DocumentProcessor.php";

/**
 * @brief Ticket object
 */
class DocumentTemplate implements \JsonSerializable
{

    // -- attributes
    private $id = null;
    private $upload_id = null;
    private $name = null;
    private $type = null;

    /**
     * @brief Constructs a DocumentTemplate
     * @param int $id
     *        DocumentTemplate's ID
     * @param int $uploadId
     *        Upload id
     * @param int $name
     *        Name of the template
     */
    public function __construct($id, $uploadId, $name, $type)
    {
        $this->id = intval($id);
        $this->upload_id = intval($uploadId);
        $this->name = $name;
        $this->type = $type;
    }

    public function jsonSerialize()
    {
        return [
            DocumentTemplateDBObject::COL_ID => $this->id,
            DocumentTemplateDBObject::COL_UPLOAD_ID => $this->upload_id,
            DocumentTemplateDBObject::COL_NAME => $this->name,
            DocumentTemplateDBObject::COL_TYPE => $this->type
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
    public function GetUploadId()
    {
        return $this->upload_id;
    }

    /**
     * @brief
     */
    public function GetName()
    {
        return $this->name;
    }

    public function GetType()
    {
        return $this->type;
    }
}

/**
 * @brief Ticket object related services
 */
class DocumentTemplateServices extends AbstractObjectServices
{

    // -- consts
    // --- params
    const PARAM_ID = "id";
    const PARAM_UPLOAD_ID = "uploadId";
    const PARAM_NAME = "name";
    const PARAM_TYPE = "type";
    // --- actions
    const GET_DOCTEMPLATE_BY_ID = "byid";
    const GET_ALL_DOCTEMPLATE = "all";
    const GET_DOCUMENT_TYPES = "doctypes";
    const GET_DOCS_BY_TYPE = "docsbytype";
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
        if (!strcmp($action, DocumentTemplateServices::GET_DOCTEMPLATE_BY_ID)) {
            $data = $this->__get_document_template_by_id($params[DocumentTemplateServices::PARAM_ID]);
        } else if (!strcmp($action, DocumentTemplateServices::GET_ALL_DOCTEMPLATE)) {
            $data = $this->__get_all_document_template();
        } else if (!strcmp($action, DocumentTemplateServices::INSERT)) {
            $data = $this->__insert_document_template(
                $params[DocumentTemplateServices::PARAM_UPLOAD_ID],
                $params[DocumentTemplateServices::PARAM_NAME],
                $params[DocumentTemplateServices::PARAM_TYPE]
            );
        } else if (!strcmp($action, DocumentTemplateServices::UPDATE)) {
            $data = $this->__update_document_template(
                $params[DocumentTemplateServices::PARAM_ID],
                $params[DocumentTemplateServices::PARAM_UPLOAD_ID],
                $params[DocumentTemplateServices::PARAM_NAME],
                $params[DocumentTemplateServices::PARAM_TYPE]
            );
        } else if (!strcmp($action, DocumentTemplateServices::DELETE)) {
            $data = $this->__delete_document_template($params[DocumentTemplateServices::PARAM_ID]);
        } else if (!strcmp($action, DocumentTemplateServices::GET_DOCUMENT_TYPES)) {
            $data = $this->__get_document_types();
        } else if (!strcmp($action, DocumentTemplateServices::GET_DOCS_BY_TYPE)) {
            $data = $this->__get_documents_by_type($params[DocumentTemplateServices::PARAM_TYPE]);
        }
        return $data;
    }

# PROTECTED & PRIVATE ###############################################################

    // --- consult

    private function __get_document_template_by_id($id)
    {
        // create sql params array
        $sql_params = array(":" . DocumentTemplateDBObject::COL_ID => $id);
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentTemplateDBObject::TABL_DOCTEMPLATE)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(DocumentTemplateDBObject::COL_ID));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create document_template var
        $document_template = null;
        if (isset($pdos)) {
            if (($row = $pdos->fetch()) !== false) {
                $document_template = new DocumentTemplate(
                    $row[DocumentTemplateDBObject::COL_ID],
                    $row[DocumentTemplateDBObject::COL_UPLOAD_ID],
                    $row[DocumentTemplateDBObject::COL_NAME],
                    $row[DocumentTemplateDBObject::COL_TYPE]);
            }
        }
        return $document_template;
    }

    private function __get_all_document_template()
    {
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentTemplateDBObject::TABL_DOCTEMPLATE)->GetSELECTQuery();
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, array());
        // create document_templates var
        $document_templates = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($document_templates, new DocumentTemplate(
                    $row[DocumentTemplateDBObject::COL_ID],
                    $row[DocumentTemplateDBObject::COL_UPLOAD_ID],
                    $row[DocumentTemplateDBObject::COL_NAME],
                    $row[DocumentTemplateDBObject::COL_TYPE]));
            }
        }
        return $document_templates;
    }

    private function __get_documents_by_type($type)
    {
        $sql_params = array(DocumentTemplateDBObject::COL_TYPE => $type);
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentTemplateDBObject::TABL_DOCTEMPLATE)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(DocumentTemplateDBObject::COL_TYPE));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create document_templates var
        $document_templates = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($document_templates, new DocumentTemplate(
                    $row[DocumentTemplateDBObject::COL_ID],
                    $row[DocumentTemplateDBObject::COL_UPLOAD_ID],
                    $row[DocumentTemplateDBObject::COL_NAME],
                    $row[DocumentTemplateDBObject::COL_TYPE]));
            }
        }
        return $document_templates;
    }

    private function __get_document_types()
    {
        return array(
            DocumentProcessor::TYPE_WORD,
            DocumentProcessor::TYPE_LATEX,
            DocumentProcessor::TYPE_POWERPOINT
        );
    }

    // --- modify

    private function __insert_document_template($uploadId, $name, $type)
    {
        // create sql params array
        $sql_params = array(":" . DocumentTemplateDBObject::COL_ID => null,
            ":" . DocumentTemplateDBObject::COL_UPLOAD_ID => $uploadId,
            ":" . DocumentTemplateDBObject::COL_NAME => $name,
            ":" . DocumentTemplateDBObject::COL_TYPE => $type);
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentTemplateDBObject::TABL_DOCTEMPLATE)->GetINSERTQuery();
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __update_document_template($id, $uploadId, $name, $type)
    {
        // create sql params
        $sql_params = array(
            ":" . DocumentTemplateDBObject::COL_ID => $id,
            ":" . DocumentTemplateDBObject::COL_UPLOAD_ID => $uploadId,
            ":" . DocumentTemplateDBObject::COL_NAME => $name,
            ":" . DocumentTemplateDBObject::COL_TYPE => $type);
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentTemplateDBObject::TABL_DOCTEMPLATE)->GetUPDATEQuery();
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __delete_document_template($id)
    {
        // create sql params
        $sql_params = array(":" . DocumentTemplateDBObject::COL_ID => $id);
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentTemplateDBObject::TABL_DOCTEMPLATE)->GetDELETEQuery();
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
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
        // no static data to init for this object
    }

}

/**
 * @brief DocumentTemplate object interface
 */
class DocumentTemplateDBObject extends AbstractDBObject
{

    // -- consts
    // --- object name
    const OBJ_NAME = "document_template";
    // --- tables
    const TABL_DOCTEMPLATE = "dol_document_template";
    // --- columns
    const COL_ID = "id";
    const COL_NAME = "name";
    const COL_UPLOAD_ID = "upload_id";
    const COL_TYPE = "type";
    // -- attributes

    // -- functions

    public function __construct($module)
    {
        // -- construct parent
        parent::__construct($module, DocumentTemplateDBObject::OBJ_NAME);
        // -- create tables
        // --- dol_document_template table
        $dol_document_template = new DBTable(DocumentTemplateDBObject::TABL_DOCTEMPLATE);
        $dol_document_template
            ->AddColumn(DocumentTemplateDBObject::COL_ID, DBTable::DT_INT, 11, false, "", true, true)
            ->AddColumn(DocumentTemplateDBObject::COL_UPLOAD_ID, DBTable::DT_INT, 11, false)
            ->AddColumn(DocumentTemplateDBObject::COL_NAME, DBTable::DT_VARCHAR, 255, false)
            ->AddColumn(DocumentTemplateDBObject::COL_TYPE, DBTable::DT_VARCHAR, 255, false);

        // -- add tables
        parent::addTable($dol_document_template);
    }

    /**
     * @brief Returns all services associated with this object
     */
    public function GetServices($currentUser)
    {
        return new DocumentTemplateServices($currentUser, $this, $this->getDBConnection());
    }

    /**
     *    Initialize static data
     */
    public function ResetStaticData()
    {
        $services = new DocumentTemplateServices(null, $this, $this->getDBConnection());
        $services->ResetStaticData();
    }

}
