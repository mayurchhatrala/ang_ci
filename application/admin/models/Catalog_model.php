<?php

/**
 * Description of login_model
 * @author Admin
 */
class Catalog_Model extends CI_Model {

    var $tbl, $subTbl;
    var $tblKey, $subTblKey, $tblStatus, $tblImage;
    var $tblMD5Key, $tblDateKey, $tblModifyDateKey;
    var $delMSG, $insMSG, $updtMSG;
    var $STATUS, $MSG, $RESP;
    var $fUploadFolder;

    function __construct() {
        parent::__construct();

        ini_set('memory_limit', '200M');
        ini_set('upload_max_filesize', '200M');
        ini_set('post_max_size', '200M');
        ini_set('max_input_time', 3600);
        ini_set('max_execution_time', 3600);
        ini_set('max_file_uploads', 500);

        $this->tbl = 'db_catalog';
        $this->subTbl = 'db_catalog_sub';
        $this->STATUS = FAIL_STATUS;
        $this->MSG = INSUFF_DATA;
        $this->RESP = array(
            'STATUS' => $this->STATUS,
            'MSG' => $this->MSG
        );
        $this->dateColumn = array(
            'dtDate', 'dtModifiedDate'
        );
    }

    /*
     * TO SET THE TABLE NAME
     */

    private function _setTableName($caseValue) {
        try {
            switch ($caseValue) {
                case 1 :
                    $this->tblKey = 'iCatalogID';
                    $this->subTblKey = 'iCatalogImagesID';
                    $this->tblStatus = 'eStatus';
                    $this->tblDateKey = 'dtDate';
                    $this->tblModifyDateKey = 'dtModifiedDate';
                    $this->fUploadFolder = 'Catalog';
                    $this->tblImage = 'vCatalogImages';

                    date_default_timezone_set('Asia/Kolkata');

                    $this->delMSG = CATALOG_DEL_SUCC;
                    $this->insMSG = CATALOG_INS_SUCC;
                    $this->updtMSG = CATALOG_UPDT_SUCC;
                    $this->actMSG = CATALOG_UPDT_SUCC;
                    break;
            }
        } catch (Exception $ex) {
            throw new Exception('Crud Model : Error in _setTableName function - ' . $ex);
        }
    }

    /*
     *      TO GET LIST OF USERS...
     */

    public function getCatalogRecord($requestId = '', $isEdit = FALSE) {

        try {
            $fields[] = 'w.iCategoryID AS categoryId';
            $fields[] = 'c.vCategoryName AS categoryName';
            $fields[] = 'w.iRetailerID AS retailerId';
            $fields[] = 'r.vRetailerName AS retailerName';
            $fields[] = 'w.iCatalogID AS catalogID';
            $fields[] = 'w.vCatalogName AS catalogName';
            $fields[] = 'w.iCatalogID AS DT_RowId';
            $fields[] = 'w.dtDate AS createDate';
            $fields[] = 'w.dtModifiedDate AS modifiedDate';
            $fields[] = 'w.dtEndDate AS endDate';
            $fields[] = 'w.eStatus AS adsStatus';
            $fields[] = 'DATE_FORMAT(w.dtDate, "%d %b %Y %h:%i %p") AS createDate1';
            $fields[] = 'DATE_FORMAT(w.dtModifiedDate, "%d %b %Y %h:%i %p") AS modifiedDate1';
            $fields[] = 'DATE_FORMAT(w.dtEndDate, "%d %b %Y %h:%i %p") AS endDate1';

            $fields = implode(',', $fields);

            $condition = array();
            if ($requestId !== '')
                $condition[] = 'w.iCatalogID = "' . $requestId . '"';

            // $condition[] = 'w.eStatus = "Active"';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';


            $tbl = $this->tbl;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . ' AS w JOIN db_category  as c ON w.iCategoryID = c.iCategoryID JOIN db_retailer as r ON w.iCategoryID = r.iCategoryID ' . $condition . ' GROUP BY w.iCatalogID ';

            $res = $this->db->query($qry);

            if ($requestId !== '' && $isEdit) {

                foreach ($res->result_array() as $row) {
                    $array['catalogID'] = $row['catalogID'];
                    $array['categoryId'] = $row['categoryId'];
                    $array['retailerId'] = $row['retailerId'];
                    $array['catalogName'] = $row['catalogName'];
                    $array['endDate'] = $row['endDate'];
                    // $array['adsLink'] = $row['adsLink']; 
                }

                $imgDatas = $this->CatalogImages($requestId);
                if (!empty($imgDatas) && $imgDatas != '') {
                    $array['catalogImage'] = $imgDatas;
                }

                return $array;
            } else if ($requestId == '' && $isEdit == TRUE) {
                return array();
            }

            return $this->datatableshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     *   Check Email Id is exsist or not ?
     */

    function CatalogImages($requestId) {

        try {
            $fields[] = 'sub.iCatalogImagesID AS catalogImageId';
            $fields[] = 'sub.vCatalogImages AS catalogImage';

            $fields = implode(',', $fields);

            $condition[] = 'sub.iCatalogID = "' . $requestId . '"';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->tbl;

            $qry = 'SELECT ' . $fields . ' FROM ' . $this->subTbl . ' as sub ' . $condition . '';

            $res = $this->db->query($qry);

            if ($res->num_rows() > 0) {
                foreach ($res->result_array() as $row) {
                    $array[$row['catalogImageId']] = $row['catalogImage'];
                }
                return $array;
            } else {
                return array();
            }


            // return $this->datatableshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in CategoryName function - ' . $ex);
        }
    }

    // CRUD OPERATIONS
    /*
     * TO SET CURRENT DATE CONTENT
     */

    private function _setCurrDate($objectVal = array(), $keyVal = '', $isUpdate = 0) {
        try {
            if (!empty($objectVal)) {
                $keyVal = explode(',', $keyVal);
                foreach ($objectVal as $k => $v) {
                    if (!in_array($k, $keyVal)) {

                        if (isset($this->dateColumn[$isUpdate])) {
                            if ($this->dateColumn[$isUpdate] == 'dtEndDate') {
                                $objectVal[$this->dateColumn[$isUpdate]] = date('Y-m-d H:i:s', strtotime('+7 days')); // strtotime('+1 months')
                            } else {
                                $objectVal[$this->dateColumn[$isUpdate]] = date('Y-m-d H:i:s'); // strtotime('+1 months')
                            }
                        }
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
     * TO DELETE A RECORD 
     */

    function deleteRecord($requestFor, $requestId) {
        try {
            if ($requestFor !== '' && $requestId !== '') {
                /*
                 * TO SET TABLE NAME 
                 */
                $this->_setTableName($requestFor);

                if ($this->subTbl !== '' && $this->subTblKey !== '') {
                    /*
                     * RECORD WILL BE DELETE FROM HERE
                     */

                    $query = $this->db->query("SELECT  " . $this->tblKey . "," . $this->tblImage . " FROM " . $this->subTbl . " WHERE " . $this->subTblKey . " = " . $requestId);
                    $DeleteRec = $query->row_array();

                    // to remove old image
                    if ($DeleteRec[$this->tblImage] != '') {
                        unlink(UPLD_DIR . $this->fUploadFolder . "/" . $DeleteRec[$this->tblKey] . '/' . $DeleteRec[$this->tblImage]);
                        unlink(UPLD_DIR . $this->fUploadFolder . "/" . $DeleteRec[$this->tblKey] . '/thumb/100/' . $DeleteRec[$this->tblImage]);
                        unlink(UPLD_DIR . $this->fUploadFolder . "/" . $DeleteRec[$this->tblKey] . '/thumb/292/' . $DeleteRec[$this->tblImage]);
                        unlink(UPLD_DIR . $this->fUploadFolder . "/" . $DeleteRec[$this->tblKey] . '/thumb/438/' . $DeleteRec[$this->tblImage]);
                        $deleteImages = $this->db->delete($this->subTbl, array($this->subTblKey => $requestId));
                    }


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

    /*
     * TO MAKE A NEW ENTRY
     */

    function addRecord($requestFor, $requestObject = array()) {
        try {
            if ($requestFor !== '' && !empty($requestObject)) {
                /*
                 * TO SET TABLE NAME 
                 */
                $this->_setTableName($requestFor);

                $insData = (array) $requestObject;
                $insData = $this->_setCurrDate($insData, $this->tblModifyDateKey, 0);
                if (isset($insData['vCatalogImages']) || @$insData['vCatalogImages'] != 'undefined') {
                    unset($insData['vCatalogImages']);
                }

                /*
                 * INSERT INTO THE DATABASE...
                 */
                $this->db->insert($this->tbl, $insData);
                $insId = $this->db->insert_id();

                if (isset($insData['iRetailerID'])) {
                    $NotificationQry = $this->db->select("u.tEndpointArn as tEndpointArn, (3959 * acos( cos( radians(r.vLatitude) )
                 * cos( radians(u.vLatitude)) 
                 * cos( radians(u.vLongtitude) - radians(r.vLongtitude)) + sin(radians(r.vLatitude))
                 * sin( radians(u.vLatitude)))) as Distance")
                            ->where("r.iRetailerID", $insData['iRetailerID'])
                            ->from('db_retailer as r')
                            ->join("db_rcw_read as w", "r.iRetailerID = w.iRetailerID", "LEFT")
                            ->join("tbl_user as u", "w.vDeviceID = u.vDeviceID AND u.eStatus = '1' ", "LEFT")
                            ->having('Distance < 5')
                            ->get();

                    // echo $this->db->last_query(); exit;
                    if ($NotificationQry->num_rows() > 0) {
                        foreach ($NotificationQry->result_array() as $NotificationData) {
                            $snsNoti = $this->load->library('Sns', array('PLATEFORM_TYPE' => 'ios'));
                            if (!empty($NotificationData['tEndpointArn'])) {
                                $USERDATA = array(
                                    'iRetailerID' => $insData['iRetailerID'],
                                    'iCatalogID' => $insId
                                );
                                $sendNotification = $this->sns->broadCast("New Catalog Uploaded!", '', $NotificationData['tEndpointArn'], '', $USERDATA);
                            }
                        }
                    }
                }

                if ($insId > 0) {

                    if (isset($_FILES) && !empty($_FILES)) {

                        $PARAM = array(
                            'fType' => 'image',
                            'fLimit' => 200,
                            'fLoc' => array(
                                'key' => $this->fUploadFolder,
                                'id' => $insId
                            ),
                            'fThumb' => TRUE,
                            'fCopyText' => FALSE,
                            'fWidth' => array(292, 438, 100),
                            'fHeight' => array(334, 501, 100)
                        );
                        $this->load->library('fupload', $PARAM);

                        // fUpload($file array, input file name)
                        // foreach ($_FILES as $key => $val) {
                        $resp = '';
                        $resp = $this->fupload->fUpload($_FILES, 'vCatalogImages');
                        //for ($i = 0; $i < count($_FILES); $i++) {
                        foreach ($resp as $fKey => $fVal) {
                            // UPLOAD IMAGE NAME : 
                            $updateData = array('vCatalogImages' => $fVal, $this->tblKey => $insId);
                            $this->db->insert($this->subTbl, $updateData);
                        }
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
                 * TO SET TABLE NAME 
                 */
                $this->_setTableName($requestFor);

                $updateData = (array) $requestObject;
                $updateData = $this->_setCurrDate($updateData, $this->tblModifyDateKey, 1);

                if (isset($updateData['vCatalogImages']) || @$updateData['vCatalogImages'] == 'undefined') {
                    unset($updateData['vCatalogImages']);
                }

                /*
                 * INSERT INTO THE DATABASE...
                 */
                // if (!isset($updateData['vCatalogImages']) || $updateData['vCatalogImages'] !== 'undefined') {

                if (isset($_FILES) && !empty($_FILES)) {

                    $PARAM = array(
                        'fType' => 'image',
                        'fLimit' => 200,
                        'fLoc' => array(
                            'key' => $this->fUploadFolder,
                            'id' => $requestId
                        ),
                        'fThumb' => TRUE,
                        'fCopyText' => FALSE,
                        'fWidth' => array(292, 438, 100),
                        'fHeight' => array(334, 501, 100)
                    );
                    $this->load->library('fupload', $PARAM);

                    /* for ($i = 0; $i < count($_FILES); $i++) {
                        if ($_FILES['vCatalogImages']['error'][$i] == 1) {
                            $this->MSG = "Image size is bigger";
                            $this->STATUS = FAIL_STATUS;
                            return $this->RESP;
                        }
                    } */

                    $resp = '';
                    $resp = $this->fupload->fUpload($_FILES, 'vCatalogImages');
                    //for ($i = 0; $i < count($_FILES); $i++) {
                    foreach ($resp as $fKey => $fVal) {

                        // UPLOAD IMAGE NAME : 
                        $ImageUpdateData = array('vCatalogImages' => $fVal, $this->tblKey => $requestId);
                        $this->db->insert($this->subTbl, $ImageUpdateData);
                    }
                    $this->db->update($this->tbl, $updateData, array($this->tblKey => $requestId));
                } else {

                    $this->db->update($this->tbl, $updateData, array($this->tblKey => $requestId));
                    /* $query = $this->db->query("SELECT " . $this->tblImage . " FROM " . $this->tbl . " WHERE " . $this->tblKey . " = " . $requestId);
                      $updatedRec = $query->row_array();
                      $this->db->update($this->tbl, $updateData, array($this->tblKey => $requestId));
                      $this->db->update($this->tbl, $updatedRec, array($this->tblKey => $requestId)); */
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
     * TO CHANE STATUS A ENTRY
     */

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

                $this->db->query("UPDATE " . $this->tbl . " SET " . $this->tblStatus . " = IF(" . $this->tblStatus . " = 'Active','Deactive','Active') WHERE " . $this->tblKey . " = " . $requestId);

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
