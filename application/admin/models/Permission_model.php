<?php

/**
 * Description of admin_model
 * @author Admin
 */
class Permission_Model extends CI_Model {

    var $tbl;

    function __construct() {
        parent::__construct();

        $this->tbl = 'tbl_admin_type';
    }

    /*
     * TO GET LIST OF USERS...
     */

    public function getAdminTypeRecord($requestId = '', $isEdit = FALSE) {
        try {
            $fields[] = 'tat.iAdminTypeID AS adminTypeId';
            $fields[] = 'tat.iAdminTypeID AS DT_RowId';
            $fields[] = 'tat.vAdminTitle AS adminTitle';
            $fields[] = '(IFNULL((SELECT GROUP_CONCAT(tata.iAdminAccessID) FROM tbl_admin_type_access AS tata WHERE tat.iAdminTypeID IN(tata.iAdminTypeID)),"") ) AS adminAccess';
            $fields[] = '(IFNULL((SELECT GROUP_CONCAT(DISTINCT(tpp.iPageID)) FROM tbl_page_permission AS tpp WHERE tat.iAdminTypeID IN(tpp.iAdminTypeID)),"") ) AS adminPages';
            $fields[] = 'tat.eStatus AS status';

            $fields = implode(',', $fields);

            $condition = array();
            //$condition[] = 'tat.iAdminTypeID IN(SELECT tata.iAdminAccessID FROM tbl_admin_type_access AS tata WHERE tata.iAdminTypeID IN(' . $this->session->userdata('ADMINTYPE') . '))';
            $condition[] = 'tat.iAdminTypeID NOT IN(' . $this->session->userdata('ADMINTYPE') . ')';
            if ($requestId !== '')
                $condition[] = 'iAdminTypeID = "' . $requestId . '"';

            $condition[] = 'tat.tDeletedAt IS NULL';
            $condition[] = 'tat.isDeveloper IN(\'no\')';
            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->tbl . ' AS tat ';

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;
            $res = $this->db->query($qry);

            if ($requestId !== '' && $isEdit) {
                $row = $res->row_array();
                $adminAccess = $row['adminAccess'] != '' ? explode(',', $row['adminAccess']) : array();
                if (!empty($adminAccess)) {
                    foreach ($adminAccess as $key => $val) {
                        if ($val != '')
                            $adminAccess[$key] = $val;
                    }
                }
                $row['adminAccess'] = $adminAccess;

                $adminPages = $row['adminPages'] != '' ? explode(',', $row['adminPages']) : array();
                if (!empty($adminPages)) {
                    foreach ($adminPages as $key => $val) {
                        if ($val != '')
                            $adminPages[$key] = $val;
                    }
                }
                $row['adminPages'] = $adminPages;

                return $row;
            } else if ($requestId == '' && $isEdit == TRUE)
                return array();

            return $this->datatableshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     * TO GET LIST OF USERS...
     */

    public function getAdminPermissionRecord($requestId = '', $isEdit = FALSE) {
        try {
            $fields[] = 'iAdminTypeID AS adminTypeId';
            $fields[] = 'iAdminTypeID AS DT_RowId';
            $fields[] = 'vAdminTitle AS adminTitle';
            $fields[] = 'eStatus AS status';

            $fields = implode(',', $fields);

            $condition = array();
//$condition[] = 'iAdminTypeID > ' . $this->session->userdata('ADMINTYPE');
            if ($this->session->userdata('ADMINTYPE') != 1)
                $condition[] = 'isDeveloper IN(\'no\')';
            if ($requestId !== '')
                $condition[] = 'iAdminTypeID = "' . $requestId . '"';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->tbl;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;
            $res = $this->db->query($qry);
//echo $this->db->last_query();

            if ($requestId !== '' && $isEdit) {
                $row = $res->row_array();
                $row['pages'] = getAllPagesWithPermission($row['adminTypeId']);
                return $row;
            } else if ($requestId == '' && $isEdit == TRUE) {
                return array();
            }

            return $this->datatableshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     * UPDATE THE ADMIN PERMISSION
     */

    function updatePermission($request = array()) {
        try {
            $STATUS = FAIL_STATUS;
            $MSG = INSUFF_DATA;
            if (!empty($request)) {
                /*
                 * FIRST DELETE EXISTING PAGE PERMISSION RECORD
                 */
                $this->db->delete('tbl_page_permission', array('iAdminTypeID' => $request->adminTypeId));

                /*
                 * NOW ADD UPDATED ENTRY TO THE DATABASE
                 */
                $action = (array) $request->action;

                foreach ($action as $pageId => $pageAction) {
                    $pageAction = (array) $pageAction;
                    foreach ($pageAction as $actionId => $actionVal) {
                        if ($actionVal) {
                            $ins = array(
                                'iAdminTypeID' => $request->adminTypeId,
                                'iPageID' => $pageId,
                                'iPageActionID' => $actionId
                            );
                            $this->db->insert('tbl_page_permission', $ins);
                        }
                    }
                } $STATUS = SUCCESS_STATUS;
                $MSG = 'User Permission Updated Successfully';
            } return array(
                'STATUS' => $STATUS,
                'MSG' => $MSG
            );
        } catch (Exception $ex) {
            throw new Exception('Error in updatePermission function - ' . $ex);
        }
    }

    /*
     * TO GET LIST OF USERS...
     */

    public function getAdminModulesRecord($requestId = '', $isEdit = FALSE) {

        try {
            $fields[] = 'tpm.iPageModuleID AS moduleId';
            $fields[] = 'tpm.iPageModuleID AS DT_RowId';
            $fields[] = 'tpm.vModuleName AS moduleName';
            $fields[] = 'tpm.vModuleIcon AS moduleIcon';
            $fields[] = 'tpm.iOrderVal AS moduleOrder';
            $fields[] = 'tpm.isDeveloper AS isDevelopment';
            $fields[] = 'tpm.eStatus AS status';

            $fields = implode(',', $fields);

            $condition = array();
            if ($requestId !== '')
                $condition[] = 'tpm.iPageModuleID = "' . $requestId . '"';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = 'tbl_page_module AS tpm ';

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;
            $res = $this->db->query($qry);

            if ($requestId !== '' && $isEdit) {
                $row = $res->row_array();
                return $row;
            } else if ($requestId == '' && $isEdit == TRUE)
                return array();

            return $this->datatableshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     * TO GET LIST OF ADMIN PAGES...
     */

    public function getAdminPagesRecord($requestId = '', $isEdit = FALSE) {

        try {
            $fields[] = 'tp.iPageID AS pageId';
            $fields[] = 'tp.iPageID AS DT_RowId';
            $fields[] = 'tp.vPageTitle AS pageTitle';
            $fields[] = 'tp.vPageState AS pageState';
            $fields[] = 'tp.iOrderVal AS pageOrder';
            $fields[] = 'tpm.iPageModuleID AS moduleId';
            $fields[] = 'tpm.vModuleName AS moduleName';
            $fields[] = 'tp.eStatus AS status';

            $fields = implode(',', $fields);

            $condition = array();
            $condition[] = 'tp.iPageModuleID IN (tpm.iPageModuleID)';
            $condition[] = 'tp.tDeletedAt IS NULL';
            if ($requestId !== '')
                $condition[] = 'tp.iPageID = "' . $requestId . '"';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = 'tbl_page AS tp';
            $tbl .= ',tbl_page_module AS tpm ';

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;
            $res = $this->db->query($qry);

            if ($requestId !== '' && $isEdit) {
                $row = $res->row_array();
                return $row;
            } else if ($requestId == '' && $isEdit == TRUE)
                return array();

            return $this->datatableshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

}
