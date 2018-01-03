<?php

/**
 * Description of admin_model
 * @author Admin
 */
class Template_Model extends CI_Model {

    var $tbl;

    function __construct() {
        parent::__construct();
    }

    /*
     * TO GET LIST OF EMAIL TEMPLATES ...
     */

    public function getEmailRecord($requestId = '', $isEdit = FALSE) {

        try {
            $fields[] = 'tet.iEmailTemplateID AS templateId';
            $fields[] = 'tet.iEmailTemplateID AS DT_RowId';
            $fields[] = 'tet.vTemplateName AS templateName';
            $fields[] = 'tet.vTemplateAlias AS templateAlias';
            $fields[] = 'tet.tTemplateContent AS templateContent';
            $fields[] = 'tet.eStatus AS status';

            $fields = implode(',', $fields);

            $condition = array();
            if ($requestId !== '')
                $condition[] = 'tet.iEmailTemplateID = "' . $requestId . '"';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = 'tbl_email_templates AS tet ';

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;
            $res = $this->db->query($qry);

            if ($requestId !== '' && $isEdit) {
                $row = $res->row_array();
                return $row;
            } else if ($requestId == '' && $isEdit == TRUE)
                return array();

            return $this->datatableshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getEmailRecord function - ' . $ex);
        }
    }

}
