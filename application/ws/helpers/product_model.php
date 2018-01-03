<?php

/**
 * Description of login_model
 * @author Admin
 */
class Product_Model extends CI_Model {

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

        $this->tbl = 'prproduct';
    }

    /*
     * 		TO SET THE TABLE NAME
     */

    private function _setTableName($caseValue) {
        try {
            switch ($caseValue) {
                case 1 :
                    $this->tblKey = 'prProductID';
                    $this->tblStatus = 'prProductStatus';
                    $this->tblImage = 'prProductImage';
                    $this->tblDateKey = 'prProductDate';
                    $this->tblModifyDateKey = 'prEndDate';
                    $this->userID = 'prUserID';
                    $this->fUploadFolder = 'product';
                    $this->delMSG = PRODUCT_DEL_SUCC;
                    $this->insMSG = PRODUCT_INS_SUCC;
                    $this->updtMSG = PRODUCT_UPDT_SUCC;
                    $this->actMSG = PRODUCT_UPDT_SUCC;
					
					// SERVER TIME
					date_default_timezone_set('Asia/Kolkata');
					
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
                        $objectVal['prProductDate'] = date('Y-m-d H:i:s');
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
                        $objectVal['prEndDate'] = date('Y-m-d H:i:s');
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
                        $objectVal['prLoginType'] = $this->session->userdata['ADMINTYPE'];
                    }
                }
            } return $objectVal;
        } catch (Exception $ex) {
            throw new Exception('CRUD Model : Error in _setCurrDate function - ' . $ex);
        }
    }

    /*
     * TO SET CATEGORY TYPE
     */

    private function _setCateType($objectVal = array(), $keyVal = '') {
        try {
            if (!empty($objectVal)) {

                $qry = $this->db->query('SELECT prCategoryType FROM prproductcategory WHERE prProductCategoryID = ' . $objectVal['prProductCategoryID']);
                $row = $qry->row_array();
                $objectVal['prCategoryType'] = $row['prCategoryType'];
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

    public function getCateRecord($requestId = '', $isEdit = FALSE) {

        try {

            $fields[] = 'p.prProductID AS pID';
            $fields[] = 'p.prProductID AS DT_RowId';
            $fields[] = 'p.prProductCategoryID AS pCateID';
            $fields[] = 'p.prCategoryID AS pSubCateID';
            $fields[] = 'p.prProductName AS pName';
            $fields[] = 'p.prSubTitle AS pSubTitle';
            $fields[] = 'p.prProductDetail AS pDetail';
            $fields[] = 'p.prProductPrice AS pPrice';
            $fields[] = 'p.prProductStatus AS pStatus';
            $fields[] = 'p.prProductImage AS pImage';
            $fields[] = 'c.prSubCategoryName AS subCateName';
            $fields[] = 'sc.prCategoryName AS cateName';
            $fields[] = 'sc.prCategoryType AS cateType';
            $fields[] = 'DATE_FORMAT(p.prEndDate, "%d %b %Y %h:%i %p") AS EndDate';
            $fields[] = 'f.prFeatureID AS fID';
            $fields[] = 'p.prLatitude AS vLat';
            $fields[] = 'p.prLongtitude AS vLog';


            $fields = implode(',', $fields);

            $condition = array();
            if ($requestId !== '') {
                $condition[] = 'p.prProductID = "' . $requestId . '"';
            }

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->tbl;

            $qry = 'SELECT ' . $fields . ' FROM  ' . $tbl . ' as p JOIN prproductcategory AS c ON p.prCategoryID = c.prProductCategoryID JOIN prproductcategory AS sc ON c.prCategoryID = sc.prProductCategoryID AND sc.prCategoryID = 0 LEFT JOIN prsubfeature AS f ON p.prProductID = f.prProductID ' . $condition;

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
     * 		GET MAIN CATEGORY LIST FOR FIRST DROPDOWN
     */

    public function ProductParentlist($response = '') {

        try {

            $this->tbl = 'prproductcategory';

            $fields[] = 'prProductCategoryID';
            $fields[] = 'prCategoryName';

            $fields = implode(',', $fields);

            $condition = array();
            if ($response !== '')
                $condition[] = ' `prCategoryType` = "Product" AND prCategoryName != "NULL" ';
            else
                $condition[] = ' `prCategoryType` = "Product" AND prCategoryName != "NULL" ';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->tbl;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;

            $res = $this->db->query($qry);

            if ($res->num_rows() > 0) {
                // _print_r($res->result_array()); exit;
                return $res->result_array();
            } else {
                return array();
            }

            return $this->datatableshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     * 		GET MAIN CATEGORY LIST FOR FIRST DROPDOWN
     */

    public function ProductChildlist($response = '') {

        try {

            $this->tbl = 'prproductcategory';

            $fields[] = 'prProductCategoryID as prCategoryID';
            $fields[] = 'prSubCategoryName';

            $fields = implode(',', $fields);

            $condition = array();

            $condition[] = ' prCategoryID = "' . $response->subcateID . '" ';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->tbl;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;


            $res = $this->db->query($qry);

            if ($res->num_rows() > 0) {
                // _print_r($res->result_array()); exit;
                return $res->result_array();
            } else {
                return array();
            }

            return $this->datatableshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     * TO GET LIST OF Sub CATEGORY...
     */

    public function ProductRecord($requestId = '', $isEdit = FALSE) {

        try {

            $fields[] = 'p.prProductID AS pID';
            $fields[] = 'p.prProductID AS DT_RowId';
            // $fields[] = 'p.prProductCategoryID AS pCateID';
            // $fields[] = 'p.prUserID AS uID';
            $fields[] = '(case when (ISNULL(a.prAdminID)) THEN CONCAT(u.prFirstName,\' \',u.prLastName) ELSE CONCAT(a.prFirstName,\' \',a.prLastName) END) AS uID';
            $fields[] = 'p.prProductName AS pName';
            $fields[] = 'p.prSubTitle AS pSubTitle';
            $fields[] = 'p.prProductDetail AS pDetail';
            $fields[] = 'p.prProductPrice AS pPrice';
            $fields[] = 'p.prProductStatus AS pStatus';
            $fields[] = 'DATE_FORMAT(p.prProductDate, "%d %b %Y %h:%i %p") AS pDate';
            $fields[] = 'sc.prCategoryName AS pCateName';
            $fields[] = 'c.prSubCategoryName AS pSubCateName';
            $fields[] = 'DATE_FORMAT(p.prEndDate, "%d %b %Y %h:%i %p") AS EndDate';

            $fields = implode(',', $fields);

            $condition = array();
            $condition[] = ' p.prCategoryType = "Product"';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->tbl;

            // $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . ' as p LEFT JOIN pruser as u ON p.prUserID = u.prUserID JOIN prproductcategory as c  ON p.prCategoryID = c.prProductCategoryID LEFT JOIN prproductcategory as sc ON p.prProductCategoryID = sc.prProductCategoryID ' . $condition;
            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . ' as p LEFT JOIN pradmin as a ON p.prUserID = a.prAdminID AND p.prLoginType = a.prAdminType LEFT JOIN pruser as u ON p.prUserID = u.prUserID AND p.prLoginType = u.prUserType JOIN prproductcategory as c  ON p.prCategoryID = c.prProductCategoryID LEFT JOIN prproductcategory as sc ON p.prProductCategoryID = sc.prProductCategoryID ' . $condition;

            /* SELECT c.*, sc.prCategoryName FROM prproduct as p JOIN prproductcategory as c  ON p.prCategoryID = c.prProductCategoryID LEFT JOIN prproductcategory as sc ON p.prProductCategoryID = sc.prProductCategoryID */

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
                $insData = $this->_setCurrUser($insData, $this->userID);
                $insData = $this->_setCateType($insData, $insData['prProductCategoryID']);

                $parentData['prProductCategoryID'] = $insData['prProductCategoryID'];
                $parentData['prCategoryID'] = $insData['prCategoryID'];
                $parentData['prProductName'] = $insData['prProductName'];
                $parentData['prProductDetail'] = $insData['prProductDetail'];
                $parentData['prProductDate'] = $insData['prProductDate'];
                $parentData['prSubTitle'] = $insData['prSubTitle'];
                $parentData['prProductPrice'] = $insData['prProductPrice'];
                $parentData['prUserID'] = $insData['prUserID'];
                $parentData['prLoginType'] = $insData['prLoginType'];
                $parentData['prCategoryType'] = $insData['prCategoryType'];
                $parentData['prLatitude'] = $insData['prLatitude'];
                $parentData['prLongtitude'] = $insData['prLongtitude'];

                /*
                 *  INSERT INTO THE DATABASE...
                 */
                $this->db->insert($this->tbl, $insData);

                $insId = $this->db->insert_id();
                if ($insId > 0) {

                    if ($insData['prFeatureID'] != '' && isset($insData['prFeatureID'])) {
                        $childData['prFeatureID'] = $insData['prFeatureID'];
                        $childData['prProductID'] = $insId;
                        $this->db->insert('prsubfeature', $childData);
                    }

                    if (isset($_FILES) && !empty($_FILES)) {

                        $PARAM = array(
                            'fType' => 'image',
                            'fLimit' => 20,
                            'fLoc' => array(
                                'key' => $this->fUploadFolder,
                                'id' => $insId
                            ),
                            'fThumb' => TRUE,
                            'fCopyText' => FALSE
                        );
                        $this->load->library('fupload', $PARAM);

                        // fUpload($file array, input file name)
                        $resp = $this->fupload->fUpload($_FILES, 'prProductImage');

                        // UPLOAD IMAGE NAME : 
                        $updateData = array('prProductImage' => $resp[0]);

                        $this->db->update($this->tbl, $updateData, array($this->tblKey => $insId));
                    }

                    $this->RESP['RECORDID'] = $insId;
                    $this->MSG = $this->insMSG;
                    $this->STATUS = SUCCESS_STATUS;
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
                 *      TO SET TABLE NAME 
                 */
                $this->_setTableName($requestFor);

                $updateData = (array) $requestObject;
                $updateData = $this->_setCurrDate($updateData, $this->tblDateKey);
                $updateData = $this->_setModifyDate($updateData, $this->tblModifyDateKey);
                $updateData = $this->_setCurrUser($updateData, $this->userID);
                $updateData = $this->_setCateType($updateData, $updateData['prProductCategoryID']);

                $parentData['prProductCategoryID'] = $updateData['prProductCategoryID'];
                $parentData['prCategoryID'] = $updateData['prCategoryID'];
                $parentData['prProductName'] = $updateData['prProductName'];
                $parentData['prProductDetail'] = $updateData['prProductDetail'];
                $parentData['prEndDate'] = $updateData['prEndDate'];
                $parentData['prSubTitle'] = $updateData['prSubTitle'];
                $parentData['prProductPrice'] = $updateData['prProductPrice'];
                $parentData['prUserID'] = $updateData['prUserID'];
                $parentData['prLoginType'] = $updateData['prLoginType'];
                $parentData['prCategoryType'] = $updateData['prCategoryType'];
                $parentData['prLatitude'] = $updateData['prLatitude'];
                $parentData['prLongtitude'] = $updateData['prLongtitude'];

                /*
                 * UPDATE INTO THE DATABASE...
                 */

                if (!isset($updateData['prProductImage']) || $updateData['prProductImage'] !== 'undefined') {

                    if (isset($_FILES) && !empty($_FILES)) {

                        $PARAM = array(
                            'fType' => 'image',
                            'fLimit' => 20,
                            'fLoc' => array(
                                'key' => $this->fUploadFolder,
                                'id' => $requestId
                            ),
                            'fThumb' => TRUE,
                            'fCopyText' => FALSE
                        );
                        $this->load->library('fupload', $PARAM);

                        // fUpload($file array, input file name)
                        $resp = $this->fupload->fUpload($_FILES, 'prProductImage');

                        // UPLOAD IMAGE NAME : 
                        $updateFileData = array('prProductImage' => $resp[0]);

                        if ($updateFileData) {
                            // To get old image
                            $query = $this->db->query("SELECT " . $this->tblImage . " FROM " . $this->tbl . " WHERE " . $this->tblKey . " = " . $requestId);
                            $updatedRec = $query->row_array();
                            // to remove old image
                            if (isset($updatedRec['prProductImage'])) {
                                @unlink(UPLD_DIR . "product/" . $requestId . '/' . $updatedRec['prProductImage']);
                                @unlink(UPLD_DIR . "product/" . $requestId . '/thumb/' . $updatedRec['prProductImage']);
                            }
                        }
                        $uploadImage = $this->db->update($this->tbl, $updateFileData, array($this->tblKey => $requestId));
                    }

                    $this->db->update($this->tbl, $parentData, array($this->tblKey => $requestId));
                } else {

                    $query = $this->db->query("SELECT " . $this->tblImage . " FROM " . $this->tbl . " WHERE " . $this->tblKey . " = " . $requestId);
                    $updatedRec = $query->row_array();
                    $this->db->update($this->tbl, $parentData, array($this->tblKey => $requestId));
                    $this->db->update($this->tbl, $updatedRec, array($this->tblKey => $requestId));
                }

                // UPDATE SUBFEATURE DATA
                if ($updateData['prFeatureID'] != '' && isset($updateData['prFeatureID'])) {
                    $this->db->delete('prsubfeature', array('prProductID' => $requestId));
                    $childData['prFeatureID'] = $updateData['prFeatureID'];
                    $childData['prProductID'] = $requestId;
                    $this->db->insert('prsubfeature', $childData);
                }

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
