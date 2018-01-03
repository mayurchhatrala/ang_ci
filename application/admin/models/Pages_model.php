<?php

/**
 * Description of login_model
 * @author Admin
 */
class Pages_Model extends CI_Model {

    var $tbl;
    var $tblKey, $tblStatus, $tblImage;
    var $tblDateKey, $tblModifyDateKey;
    var $delMSG, $insMSG, $updtMSG;
    var $STATUS, $MSG, $RESP;
    var $fUploadFolder;

    function __construct() {
        parent::__construct();

        $this->STATUS = FAIL_STATUS;
        $this->MSG = INSUFF_DATA;
        $this->RESP = array(
            'STATUS' => $this->STATUS,
            'MSG' => $this->MSG
        );

        $this->tbl = 'db_pages';
    }

    /*
     * 		TO SET THE TABLE NAME
     */

    private function _setTableName($caseValue) {
        try {
            switch ($caseValue) {
                case 1 :
                    $this->tblKey           = 'iPagesID';
                    $this->tblStatus        = 'eStatus';
                    $this->tblDateKey       = 'dtDate';
                    $this->tblModifyDateKey = 'dtDate';
                    $this->userID           = 'prUserID';
                    $this->delMSG           = PAGES_DEL_SUCC;
                    $this->insMSG           = PAGES_INS_SUCC;
                    $this->updtMSG          = PAGES_UPDT_SUCC;
                    $this->actMSG           = PAGES_UPDT_SUCC;
                    break;
            }
        } catch (Exception $ex) {
            throw new Exception('Crud Model : Error in _setTableName function - ' . $ex);
        }
    }

    /*
     * TO SET CURRENT DATE CONTENT
     */

    private function _setCurrDate($objectVal = array(), $keyVal = '') {
        try {
            if (!empty($objectVal)) {
                $keyVal = explode(',', $keyVal);
                foreach ($objectVal as $k => $v) {
                    if (!in_array($k, $keyVal)) {
                        // $objectVal[$k] = date('Y-m-d H:i:s');
                        $objectVal['dtDate'] = date('Y-m-d H:i:s');
                    }
                }
            } return $objectVal;
        } catch (Exception $ex) {
            throw new Exception('CRUD Model : Error in _setCurrDate function - ' . $ex);
        }
    }
    
    /*
     * TO SET CURRENT DATE CONTENT
     */

    private function _setModifyDate($objectVal = array(), $keyVal = '') {
        try {
            if (!empty($objectVal)) {
                $keyVal = explode(',', $keyVal);
                foreach ($objectVal as $k => $v) {
                    if (!in_array($k, $keyVal)) {
                        // $objectVal[$k] = date('Y-m-d H:i:s');
                        $objectVal['dtModifiedDate'] = date('Y-m-d H:i:s');
                    }
                }
            } return $objectVal;
        } catch (Exception $ex) {
            throw new Exception('CRUD Model : Error in _setCurrDate function - ' . $ex);
        }
    }

    /*
     * TO CURRENT USER ID
     */

    private function _setCurrUser($objectVal = array(), $keyVal = '') {

        try {
            if (!empty($objectVal)) {
                $keyVal = explode(',', $keyVal);
                foreach ($objectVal as $k => $v) {
                    if (!in_array($k, $keyVal)) {
                        // $this->session->userdata['ADMINLOGIN']
                        $objectVal['prUserID'] = $this->session->userdata['ADMINLOGIN'];
                    }
                }
            } return $objectVal;
        } catch (Exception $ex) {
            throw new Exception('CRUD Model : Error in _setCurrDate function - ' . $ex);
        }
    }

    /*
     * TO SET THE RESPONSE ARRAY
     */

    private function _setReponseArray($record = array()) {
        try {
            $this->RESP = array(
                'MSG' => $this->MSG,
                'STATUS' => $this->STATUS,
                'RECORD' => $record
            );
        } catch (Exception $ex) {
            throw new Exception('Crud Model : Error in _setReponseArray function - ' . $ex);
        }
    }

    /*
     * TO GET LIST OF ALL CATEGORY FROM DATABASE.
     */

    public function getPagesRecord($requestId = '', $isEdit = FALSE) {

        try {

            $fields[] = 'p.iPagesID AS pID';
            $fields[] = 'p.iPagesID AS DT_RowId';
            $fields[] = 'p.vPageName AS pName';
            $fields[] = 'p.tContent AS pContent';
            $fields[] = 'p.dtDate AS pDate';
            $fields[] = 'p.eStatus AS pStatus';
            $fields[] = 'DATE_FORMAT(p.dtModifiedDate, "%d %b %Y %h:%i %p") AS EndDate';

            $fields = implode(',', $fields);

            $condition = array();
            if ($requestId !== '') {
                $condition[] = 'p.iPagesID = "' . $requestId . '"';
            }

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->tbl;

            $qry = 'SELECT ' . $fields . ' FROM  ' . $tbl . ' as p ' . $condition;

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

  

    /*
     * TO GET LIST OF Sub CATEGORY...
     */

    public function PagesRecord($requestId = '', $isEdit = FALSE) {

        try {

            $fields[] = 'p.iPagesID AS pID';
            $fields[] = 'p.iPagesID AS DT_RowId';
            $fields[] = 'p.vPageName AS pName';
            $fields[] = 'p.tContent AS pContent';
            $fields[] = 'p.dtDate AS pDate';
            $fields[] = 'p.eStatus AS pStatus';
            $fields[] = 'DATE_FORMAT(p.dtModifiedDate, "%d %b %Y %h:%i %p") AS EndDate';

            $fields = implode(',', $fields);

            $condition = array();
            // $condition[] = ' c.prCategoryID != "NULL"';	

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->tbl;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . ' as p ' . $condition;

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
    
    /*
    *   Check Email Id is exsist or not ?
    */

    function checkPageName($postValue) {

        try {
            $fields[] = 'vPageName AS aName';
            
            $fields = implode(',', $fields);
               
            if (isset($postValue->prPageName))
                $condition[] = 'vPageName = "' . $postValue->prPageName . '"';
            
            // REPLACE(prPageName, " ", "")

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->tbl;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;
            $res = $this->db->query($qry);

            return $res->num_rows();

            return $this->datatableshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     * TO MAKE A NEW ENTRY
     */

    function addRecord($requestFor, $requestObject = array()) {
		try {
            if ($requestFor !== '' && !empty($requestObject)) {
                /*
                 *  TO SET TABLE NAME 
                 */
                $this->_setTableName($requestFor);

                $insData = (array) $requestObject;
                $insData = $this->_setCurrDate($insData, $this->tblDateKey);
                
                /*
                 *  INSERT INTO THE DATABASE...
                 */
                $this->db->insert($this->tbl, $insData);

                $insId = $this->db->insert_id();
                if ($insId > 0) {
                    
                    $this->RESP['RECORDID'] = $insId;
                    $this->MSG              = $this->insMSG;
                    $this->STATUS           = SUCCESS_STATUS;
                    
                } else {
                    $this->MSG = INSERT_WARN;
                }
            }
            $this->_setReponseArray();

            return $this->RESP;
        } catch (Exception $ex) {
            throw new Exception('Crud Model : Error in addRecord function - ' . $ex);
        }
    }

    /*
     * TO UPDATE A ENTRY
     */

    function updateRecord($requestFor, $requestObject = array(), $requestId) {
        try {
            if ($requestFor !== '' && !empty($requestObject) && $requestId !== '') {
                /*
                 * TO SET TABLE NAME 
                 */
                $this->_setTableName($requestFor);

                $updateData = (array) $requestObject;
                $updateData = $this->_setCurrDate($updateData, $this->tblDateKey);
                $updateData = $this->_setModifyDate($updateData, $this->tblModifyDateKey);
				
                /*
                 * INSERT INTO THE DATABASE...
                 */
                $this->db->update($this->tbl, $updateData, array($this->tblKey => $requestId));

                $this->MSG = $this->updtMSG;
                $this->STATUS = SUCCESS_STATUS;
            }
            $this->_setReponseArray();

            return $this->RESP;
        } catch (Exception $ex) {
            throw new Exception('Crud Model : Error in addRecord function - ' . $ex);
        }
    }
	

    /*
     * TO DELETE A RECORD 
     */

    function deleteRecord($requestFor, $requestId) {

        try {
            if ($requestFor !== '' && $requestId !== '') {
                /*
                 * TO SET TABLE NAME 
                 */
                $this->_setTableName($requestFor);

                if ($this->tbl !== '' && $this->tblKey !== '') {
                    /*
                     * RECORD WILL BE DELETE FROM HERE
                     */
                    $this->db->delete($this->tbl, array($this->tblKey => $requestId));

                    $this->MSG = $this->delMSG;
                    $this->STATUS = SUCCESS_STATUS;
                } else {
                    $this->MSG = DELETE_WARN;
                }
            }
            $this->_setReponseArray();

            return $this->RESP;
        } catch (Exception $ex) {
            throw new Exception('Crud Model : Error in deleteRecord function - ' . $ex);
        }
    }

    function activeRecord($requestFor, $requestObject = array(), $requestId) {
        try {

            $record = array();
            // !empty($requestObject) &&

            if ($requestFor !== '' && $requestId !== '') {

                /*
                 * TO SET TABLE NAME 
                 */
                $this->_setTableName($requestFor);

                $query = $this->db->query("SELECT " . $this->tblStatus . " FROM " . $this->tbl . " WHERE " . $this->tblKey . " = " . $requestId);
                $requestObject = $query->result();
                /*
                 * INSERT INTO THE DATABASE...
                 */

                $this->db->query("UPDATE " . $this->tbl . " SET " . $this->tblStatus . " = IF( " . $this->tblStatus . " = 'Active','Deactive','Active') WHERE " . $this->tblKey . " = " . $requestId);

                // TO GET STATUS
                $query = $this->db->query("SELECT " . $this->tblStatus . " FROM " . $this->tbl . " WHERE " . $this->tblKey . " = " . $requestId);
                $updatedRec = $query->row_array();

                $record = array(
                    'value' => $updatedRec[$this->tblStatus],
                    'id' => $requestId,
                );

                $this->MSG = $this->actMSG;
                $this->STATUS = SUCCESS_STATUS;
            }
            $this->_setReponseArray($record);

            return $this->RESP;
        } catch (Exception $ex) {
            throw new Exception('Crud Model : Error in addRecord function - ' . $ex);
        }
    }
}