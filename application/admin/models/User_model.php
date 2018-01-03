<?php

/**
 * Description of login_model
 * @author Admin
 */
class User_Model extends CI_Model {

    var $tbl;

    function __construct() {
        parent::__construct();

        $this->tbl = 'tbl_user';
    }

    /*
     * TO GET LIST OF USERS...
     */

    public function getUserRecord($requestId = '', $isEdit = FALSE) {

        try {
            $fields[] = 'tu.iUserID AS userId';
            $fields[] = 'tu.iUserID AS DT_RowId';
            $fields[] = 'tu.vFirstName AS userFirstName';
            $fields[] = 'tu.vLastName AS userLastName';
            $fields[] = 'CONCAT(tu.vFirstName,\' \',tu.vLastName) AS userName';
            $fields[] = 'tu.vEmail AS userEmail';
            $fields[] = 'tu.iAdminTypeID AS userAdminId';
            $fields[] = '(SELECT vAdminTitle FROM tbl_admin_type AS tat WHERE tat.iAdminTypeID IN(tu.iAdminTypeID)) AS adminTypeName';
            $fields[] = 'tu.eStatus AS status';

            $fields = implode(',', $fields);

            $condition = array();
            //$condition[] = 'tu.iAdminTypeID IN(SELECT iAdminAccessID FROM tbl_admin_type_access AS tata WHERE tata.iAdminTypeID IN(' . $this->session->userdata('ADMINTYPE') . '))';
            $condition[] = 'tu.tDeletedAt IS NULL';
            $condition[] = 'tat.isDeveloper IN(\'no\')';
            $condition[] = 'tat.iAdminTypeID IN(tu.iAdminTypeID)';
            $condition[] = 'tu.iUserID NOT IN(' . $this->session->userdata('ADMINID') . ')';
            if ($requestId !== '')
                $condition[] = 'iUserID = "' . $requestId . '"';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->tbl . ' AS tu';
            $tbl .= ',tbl_admin_type AS tat';

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;
            $res = $this->db->query($qry);

            if ($requestId !== '' && $isEdit)
                return $res->row_array();
            else if ($requestId == '' && $isEdit == TRUE)
                return array();

            return $this->datatableshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

}
