<?php

require_once "interfaces/AbstractDBObject.php";
require_once "interfaces/AbstractObjectServices.php";
require_once "objects/DBTable.php";
require_once "objects/DBProcedure.php";
require_once "objects/RightsMap.php";

/**
 * @brief The Document class
 */
class Document implements \JsonSerializable
{
    // -- consts

    // -- attributes
    private $id = null;
    private $project_number = null;
    private $template_id = null;
    private $upload = null;
    private $valid = null;
    private $checked_by = null;

    private $template_data = [];

    /**
     * Document constructor.
     */
    public function __construct($id, $projectNumber, $templateId, $upload, $valid, $checkedBy, $templateData = [])
    {
        $this->id = $id;
        $this->project_number = $projectNumber;
        $this->template_id = $templateId;
        $this->upload = $upload;
        $this->valid = boolval($valid);
        $this->checked_by = $checkedBy;
        $this->template_data = $templateData;
    }


    public function jsonSerialize()
    {
        return [
            DocumentDBObject::COL_ID => $this->id,
            DocumentDBObject::COL_PROJECT_NUMBER => $this->project_number,
            DocumentDBObject::COL_TEMPLATE_ID => $this->template_id,
            DocumentDBObject::COL_UPLOAD => $this->upload,
            DocumentDBObject::COL_VALID => $this->valid,
            DocumentDBObject::COL_CHECKED_BY => $this->checked_by,
            DocumentDBObject::COL_TEMPLATE_DATA => $this->template_data,
        ];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getProjectNumber()
    {
        return $this->project_number;
    }

    /**
     * @return string
     */
    public function getTemplateId()
    {
        return $this->template_id;
    }

    /**
     * @return string
     */
    public function getUpload()
    {
        return $this->upload;
    }

    /**
     * @return bool
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * @return int
     */
    public function getCheckedBy()
    {
        return $this->checked_by;
    }

}


class DocumentServices extends AbstractObjectServices
{

    // -- consts
    // --- params keys
    const PARAM_ID = "id";
    const PARAM_PROJECT_NUMBER = "projectNumber";
    const PARAM_VALID = "valid";
    const PARAM_CHECKED_BY = "checkedBy";
    const PARAM_LABEL = "label";
    const PARAM_TEMPLATE = "template";
    const PARAM_PREVIOUS = "previous";
    const PARAM_UPLOAD = "upload";

    // --- internal services (actions)
    const GET_ALL = "getall";
    const GET_BY_ID = "getbyid";
    const GET_BY_PROJECT = "byproject";
    const GET_PROJECT_DOCUMENTS = "projdoc";
    const GET_BY_TEMPLATE = "bytemp";
    const GET_BY_PROJECT_AND_TEMPLATE = "byprotemp";
    const GET_ALL_TEMPLATES = "getalltemp";
    const GET_TEMPLATE_BY_LABEL = "tempbylabel";
    const GET_TEMPLATE_BY_ID = "tempbyid";
    const GET_PREVIOUS = "getprev";
    const INSERT = "insert";
    const UPDATE = "update";
    const DELETE = "delete";
    const VALID = "valid";
    const INVALID = "invalid";

    // -- services that should not be used except for data migration
    const FORCE_INSERT = "forins";
    // -- functions

    // -- construct
    public function __construct($currentUser, $dbObject, $dbConnection)
    {
        parent::__construct($currentUser, $dbObject, $dbConnection);
    }

    public function GetResponseData($action, $params)
    {
        $data = null;
        if (!strcmp($action, DocumentServices::GET_ALL)) {
            $data = $this->__get_all_documents();
        } else if (!strcmp($action, DocumentServices::GET_BY_ID)) {
            $data = $this->__get_document_by_id($params[DocumentServices::PARAM_ID]);
        } else if (!strcmp($action, DocumentServices::GET_BY_PROJECT)) {
            $data = $this->__get_documents_by_project($params[DocumentServices::PARAM_PROJECT_NUMBER]);
        } else if (!strcmp($action, DocumentServices::GET_PROJECT_DOCUMENTS)) {
            $data = $this->__get_project_documents($params[DocumentServices::PARAM_PROJECT_NUMBER]);
        } else if (!strcmp($action, DocumentServices::GET_BY_TEMPLATE)) {
            $data = $this->__get_documents_by_template($params[DocumentServices::PARAM_TEMPLATE]);
        } else if (!strcmp($action, DocumentServices::GET_BY_PROJECT_AND_TEMPLATE)) {
            $data = $this->__get_document_by_project_and_template(
                $params[DocumentServices::PARAM_PROJECT_NUMBER],
                $params[DocumentServices::PARAM_TEMPLATE]
            );
        } else if (!strcmp($action, DocumentServices::GET_ALL_TEMPLATES)) {
            $data = $this->__get_all_templates();
        } else if (!strcmp($action, DocumentServices::GET_TEMPLATE_BY_LABEL)) {
            $data = $this->__get_template_by_label($params[DocumentServices::PARAM_LABEL]);
        } else if (!strcmp($action, DocumentServices::GET_TEMPLATE_BY_ID)) {
            $data = $this->__get_template_by_id($params[DocumentServices::PARAM_ID]);
        } else if (!strcmp($action, DocumentServices::GET_PREVIOUS)) {
            $data = $this->__get_previous_document($params[DocumentServices::PARAM_LABEL]);
        } else if (!strcmp($action, DocumentServices::INSERT)) {
            $data = $this->__insert_document(
                $params[DocumentServices::PARAM_PROJECT_NUMBER],
                $params[DocumentServices::PARAM_TEMPLATE],
                $params[DocumentServices::PARAM_UPLOAD]
            );
        } else if (!strcmp($action, DocumentServices::UPDATE)) {
            $data = $this->__update_document(
                $params[DocumentServices::PARAM_ID],
                $params[DocumentServices::PARAM_TEMPLATE]
            );
        } else if (!strcmp($action, DocumentServices::DELETE)) {
            $data = $this->__delete_document($params[DocumentServices::PARAM_ID]);
        } else if (!strcmp($action, DocumentServices::VALID)) {
            $data = $this->__valid_document($params[DocumentServices::PARAM_ID]);
        } else if (!strcmp($action, DocumentServices::INVALID)) {
            $data = $this->__invalid_document($params[DocumentServices::PARAM_ID]);
        }
        return $data;
    }

# PROTECTED & PRIVATE ####################################################

    // -- consult
    private function __get_all_documents()
    {
        // create sql params array
        $sql_params = array();
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentDBObject::TABL_DOCUMENT)->GetSELECTQuery();
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, new Document(
                        $row[DocumentDBObject::COL_ID],
                        $row[DocumentDBObject::COL_PROJECT_NUMBER],
                        $row[DocumentDBObject::COL_TEMPLATE_ID],
                        $row[DocumentDBObject::COL_UPLOAD],
                        $row[DocumentDBObject::COL_VALID],
                        $row[DocumentDBObject::COL_CHECKED_BY]
                    )
                );
            }
        }
        return $data;
    }

    private function __get_document_by_id($id)
    {
        // create sql params array
        $sql_params = array(":" . DocumentDBObject::COL_ID => $id);
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentDBObject::TABL_DOCUMENT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(DocumentDBObject::COL_ID));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = null;
        if (isset($pdos)) {
            if (($row = $pdos->fetch()) !== false) {
                $data = new Document(
                    $row[DocumentDBObject::COL_ID],
                    $row[DocumentDBObject::COL_PROJECT_NUMBER],
                    $row[DocumentDBObject::COL_TEMPLATE_ID],
                    $row[DocumentDBObject::COL_UPLOAD],
                    $row[DocumentDBObject::COL_VALID],
                    $row[DocumentDBObject::COL_CHECKED_BY]
                );
            }
        }
        return $data;
    }

    private function __get_documents_by_project($projectNumber)
    {
        // create sql params array
        $sql_params = array(":" . DocumentDBObject::COL_PROJECT_NUMBER => $projectNumber);
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentDBObject::TABL_DOCUMENT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(DocumentDBObject::COL_PROJECT_NUMBER));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, new Document(
                        $row[DocumentDBObject::COL_ID],
                        $row[DocumentDBObject::COL_PROJECT_NUMBER],
                        $row[DocumentDBObject::COL_TEMPLATE_ID],
                        $row[DocumentDBObject::COL_UPLOAD],
                        $row[DocumentDBObject::COL_VALID],
                        $row[DocumentDBObject::COL_CHECKED_BY]
                    )
                );
            }
        }
        return $data;
    }

    private function __get_project_documents($projectNumber)
    {
        $templates = $this->__get_all_templates();
        foreach ($templates as $key => $template) {
            $template[DocumentDBObject::COL_DOCUMENT] = $this->__get_document_by_project_and_template(
                $projectNumber,
                $template[DocumentDBObject::COL_ID]
            );
            $templates[$key] = $template;
        }
        return $templates;
    }

    private function __get_documents_by_template($template)
    {
        // create sql params array
        $sql_params = array(":" . DocumentDBObject::COL_TEMPLATE_ID => $template);
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentDBObject::TABL_DOCUMENT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(DocumentDBObject::COL_TEMPLATE_ID));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, new Document(
                        $row[DocumentDBObject::COL_ID],
                        $row[DocumentDBObject::COL_PROJECT_NUMBER],
                        $row[DocumentDBObject::COL_TEMPLATE_ID],
                        $row[DocumentDBObject::COL_UPLOAD],
                        $row[DocumentDBObject::COL_VALID],
                        $row[DocumentDBObject::COL_CHECKED_BY]
                    )
                );
            }
        }
        return $data;
    }

    private function __get_document_by_project_and_template($projectNumber, $template)
    {
        // create sql params array
        $sql_params = array(
            ":" . DocumentDBObject::COL_PROJECT_NUMBER => $projectNumber,
            ":" . DocumentDBObject::COL_TEMPLATE_ID => $template
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentDBObject::TABL_DOCUMENT)->GetSELECTQuery(
            array(DBTable::SELECT_ALL),
            array(
                DocumentDBObject::COL_PROJECT_NUMBER,
                DocumentDBObject::COL_TEMPLATE_ID
            ),
            array(),
            array(DocumentDBObject::COL_ID => DBTable::ORDER_DESC),
            1
        );
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = null;
        if (isset($pdos)) {
            if (($row = $pdos->fetch()) !== false) {
                $data = new Document(
                    $row[DocumentDBObject::COL_ID],
                    $row[DocumentDBObject::COL_PROJECT_NUMBER],
                    $row[DocumentDBObject::COL_TEMPLATE_ID],
                    $row[DocumentDBObject::COL_UPLOAD],
                    $row[DocumentDBObject::COL_VALID],
                    $row[DocumentDBObject::COL_CHECKED_BY]
                );
            }
        }
        return $data;
    }

    private function __get_all_templates()
    {
        // create sql params array
        $sql_params = array();
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentDBObject::TABL_TEMPLATE)->GetSELECTQuery();
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = array();
        if (isset($pdos)) {
            while (($row = $pdos->fetch()) !== false) {
                array_push($data, array(
                        DocumentDBObject::COL_ID => $row[DocumentDBObject::COL_ID],
                        DocumentDBObject::COL_LABEL => $row[DocumentDBObject::COL_LABEL],
                        DocumentDBObject::COL_TEMPLATE => $row[DocumentDBObject::COL_TEMPLATE],
                        DocumentDBObject::COL_PREVIOUS => $row[DocumentDBObject::COL_PREVIOUS]
                    )
                );
            }
        }
        return $data;
    }

    private function __get_template_by_id($id)
    {
        // create sql params array
        $sql_params = array(":" . DocumentDBObject::COL_ID => $id);
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentDBObject::TABL_TEMPLATE)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(DocumentDBObject::COL_ID));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = null;
        if (isset($pdos)) {
            if (($row = $pdos->fetch()) !== false) {
                $data = array(
                    DocumentDBObject::COL_ID => $row[DocumentDBObject::COL_ID],
                    DocumentDBObject::COL_LABEL => $row[DocumentDBObject::COL_LABEL],
                    DocumentDBObject::COL_TEMPLATE => $row[DocumentDBObject::COL_TEMPLATE],
                    DocumentDBObject::COL_PREVIOUS => $row[DocumentDBObject::COL_PREVIOUS]
                );
            }
        }
        return $data;
    }

    private function __get_template_by_label($label)
    {
        // create sql params array
        $sql_params = array(":" . DocumentDBObject::COL_LABEL => $label);
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentDBObject::TABL_TEMPLATE)->GetSELECTQuery(
            array(DBTable::SELECT_ALL), array(DocumentDBObject::COL_LABEL));
        // execute SQL query and save result
        $pdos = parent::getDBConnection()->ResultFromQuery($sql, $sql_params);
        // create udata var
        $data = null;
        if (isset($pdos)) {
            if (($row = $pdos->fetch()) !== false) {
                $data = array(
                    DocumentDBObject::COL_ID => $row[DocumentDBObject::COL_ID],
                    DocumentDBObject::COL_LABEL => $row[DocumentDBObject::COL_LABEL],
                    DocumentDBObject::COL_TEMPLATE => $row[DocumentDBObject::COL_TEMPLATE],
                    DocumentDBObject::COL_PREVIOUS => $row[DocumentDBObject::COL_PREVIOUS]
                );
            }
        }
        return $data;
    }

    private function __get_previous_document($id)
    {
        $document = $this->__get_document_by_id($id);
        $template = $this->__get_template_by_label($document->getTemplate());
        return $this->__get_document_by_project_and_template(
            $document->getProjectNumber(),
            $template[DocumentDBObject::COL_PREVIOUS]
        )[0];
    }


    // -- modify
    private function __insert_document($projectNumber, $template, $upload)
    {
        $sql_params = array(
            ":" . DocumentDBObject::COL_ID => null,
            ":" . DocumentDBObject::COL_PROJECT_NUMBER => $projectNumber,
            ":" . DocumentDBObject::COL_TEMPLATE_ID => $template,
            ":" . DocumentDBObject::COL_UPLOAD => $upload,
            ":" . DocumentDBObject::COL_VALID => 0,
            ":" . DocumentDBObject::COL_CHECKED_BY => null
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentDBObject::TABL_DOCUMENT)->GetINSERTQuery();
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __update_document($id, $template)
    {
        $sql_params = array(
            ":" . DocumentDBObject::COL_ID => $id,
            ":" . DocumentDBObject::COL_TEMPLATE_ID => $template
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentDBObject::TABL_DOCUMENT)->GetUPDATEQuery(
            array(DocumentDBObject::COL_TEMPLATE_ID)
        );
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __delete_document($id)
    {
        $sql_params = array(
            ":" . DocumentDBObject::COL_ID => $id
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentDBObject::TABL_DOCUMENT)->GetDELETEQuery();
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __valid_document($id)
    {
        $sql_params = array(
            ":" . DocumentDBObject::COL_ID => $id,
            ":" . DocumentDBObject::COL_VALID => 1,
            ":" . DocumentDBObject::COL_CHECKED_BY => $this->getCurrentUser()->getId()
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentDBObject::TABL_DOCUMENT)->GetUPDATEQuery(
            array(
                DocumentDBObject::COL_VALID,
                DocumentDBObject::COL_CHECKED_BY
            )
        );
        // execute query
        return parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
    }

    private function __invalid_document($id)
    {
        $sql_params = array(
            ":" . DocumentDBObject::COL_ID => $id,
            ":" . DocumentDBObject::COL_VALID => 0
        );
        // create sql request
        $sql = parent::getDBObject()->GetTable(DocumentDBObject::TABL_DOCUMENT)->GetUPDATEQuery(
            array(
                DocumentDBObject::COL_VALID
            )
        );
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
        $templates = array(
            ['Proposition Commerciale', 'Propale.pptx', null],
            ['Convention Entreprise', 'Convention_entreprise.docx', null],
            ['Récapitulatif de Mission', 'RM.docx', null],
            ['PV de fin d\'étude', 'PV_Fin_etude.docx', null],
            ['PV de Livraison', 'PV_Livraison.docx', null],
            ['Avenant Entreprise', 'Avenant_entreprise.docx', null],
            ['Avenant Etudiant', 'Avenant_Etudiant.docx', null],
            ['PV de fin de recette', 'PV_Fin_recette.docx', null],
            ['Accord de confidentialité entreprise', 'Accord_confidentialite_entreprise.docx', null],
            ['Accord de confidentialité étudiant', 'Accord_confidentialite_etudiant.docx', null],
            ['Demande de Bulletin de Versement', 'Demande_BV.docx', null],
            ['Demande de facture', 'Demande_facture.docx', null],
            ['Devis', 'Devis.docx', null],
            ['Lettre d\'envoi avenant', 'Lettre_envoi_avenant.docx', null],
            ['Lettre d\'envoi propale   ', 'Lettre_envoi_propale.docx', null],
        );
        // --- retrieve SQL query
        $sql = parent::getDBObject()->GetTable(DocumentDBObject::TABL_TEMPLATE)->GetINSERTQuery();
        foreach ($templates as $template) {
            // --- create param array
            $sql_params = array(
                ":" . DocumentDBObject::COL_ID => null,
                ":" . DocumentDBObject::COL_LABEL => $template[0],
                ":" . DocumentDBObject::COL_TEMPLATE => $template[1],
                ":" . DocumentDBObject::COL_PREVIOUS => $template[2]
            );
            // --- execute SQL query
            parent::getDBConnection()->PrepareExecuteQuery($sql, $sql_params);
        }
    }

}

/**
 * @brief Document object interface
 */
class DocumentDBObject extends AbstractDBObject
{

    // -- consts
    // --- object name
    const OBJ_NAME = "document";
    // --- tables
    const TABL_TEMPLATE = "dol_template";
    const TABL_DOCUMENT = "dol_document";

    // --- columns
    const COL_ID = "id";
    const COL_DOCUMENT = "document";
    const COL_PROJECT_NUMBER = "project_number";
    const COL_LABEL = "label";
    const COL_UPLOAD = "upload";
    const COL_TEMPLATE = "template";
    const COL_TEMPLATE_ID = "template_id";
    const COL_PREVIOUS = "previous";
    const COL_VALID = "valid";
    const COL_CHECKED_BY = "checked_by";
    const COL_TEMPLATE_DATA = "template_data";
    // -- attributes

    // -- functions

    public function __construct($module)
    {
        // -- construct parent
        parent::__construct($module, DocumentDBObject::OBJ_NAME);

        // -- create tables

        // --- dol_template table
        $dol_template = new DBTable(DocumentDBObject::TABL_TEMPLATE);
        $dol_template
            ->AddColumn(DocumentDBObject::COL_ID, DBTable::DT_INT, 11, false, "", true, true, true)
            ->AddColumn(DocumentDBObject::COL_LABEL, DBTable::DT_VARCHAR, 255, false, "")
            ->AddColumn(DocumentDBObject::COL_TEMPLATE, DBTable::DT_VARCHAR, 50, false, "")
            ->AddColumn(DocumentDBObject::COL_PREVIOUS, DBTable::DT_VARCHAR, 50, true, null);

        // --- dol_document table
        $dol_document = new DBTable(DocumentDBObject::TABL_DOCUMENT);
        $dol_document
            ->AddColumn(DocumentDBObject::COL_ID, DBTable::DT_INT, 11, false, "", true, true)
            ->AddColumn(DocumentDBObject::COL_PROJECT_NUMBER, DBTable::DT_INT, 11, false, "")
            ->AddColumn(DocumentDBObject::COL_TEMPLATE_ID, DBTable::DT_INT, 11, false, "")
            ->AddColumn(DocumentDBObject::COL_UPLOAD, DBTable::DT_INT, 11, true, null)
            ->AddColumn(DocumentDBObject::COL_VALID, DBTable::DT_INT, 1, false, "")
            ->AddColumn(DocumentDBObject::COL_CHECKED_BY, DBTable::DT_INT, 11, true, null)
            ->AddForeignKey(
                DocumentDBObject::TABL_DOCUMENT . '_fk1',
                DocumentDBObject::COL_PROJECT_NUMBER,
                ProjectDBObject::TABL_PROJECT,
                ProjectDBObject::COL_NUMBER,
                DBTable::DT_RESTRICT,
                DBTable::DT_CASCADE
            )
            ->AddForeignKey(
                DocumentDBObject::TABL_DOCUMENT . '_fk2',
                DocumentDBObject::COL_TEMPLATE_ID,
                DocumentDBObject::TABL_TEMPLATE,
                DocumentDBObject::COL_ID,
                DBTable::DT_RESTRICT,
                DBTable::DT_CASCADE
            )
            ->AddForeignKey(
                DocumentDBObject::TABL_DOCUMENT . '_fk3',
                DocumentDBObject::COL_CHECKED_BY,
                UserDataDBObject::TABL_USER_DATA,
                UserDataDBObject::COL_USER_ID,
                DBTable::DT_RESTRICT,
                DBTable::DT_CASCADE
            )
            ->AddForeignKey(
                DocumentDBObject::TABL_DOCUMENT . '_fk4',
                DocumentDBObject::COL_UPLOAD,
                UploadDBObject::TABL_UPLOAD,
                UploadDBObject::COL_ID,
                DBTable::DT_SET_NULL,
                DBTable::DT_CASCADE
            );

        // -- add tables
        parent::addTable($dol_template);
        parent::addTable($dol_document);

    }

    /**
     * @brief Returns all services associated with this object
     */
    public function GetServices($currentUser)
    {
        return new DocumentServices($currentUser, $this, $this->getDBConnection());
    }

    /**
     *    Initialize static data
     */
    public function ResetStaticData()
    {
        $services = new DocumentServices(null, $this, $this->getDBConnection());
        $services->ResetStaticData();
    }

}
