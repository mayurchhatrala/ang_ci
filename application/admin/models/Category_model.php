<?php

/**

 * Description of login_model

 * @author Admin

 */
class Category_Model extends CI_Model {

    var $tbl;
    var $tblKey, $tblStatus, $tblImage;
    var $tblMD5Key, $tblDateKey, $tblModifyDateKey;
    var $delMSG, $insMSG, $updtMSG;
    var $STATUS, $MSG, $RESP;
    var $fUploadFolder;

    function __construct() {

        parent::__construct();



        $this->tbl = 'db_category';

        $this->STATUS = FAIL_STATUS;

        $this->MSG = INSUFF_DATA;

        $this->RESP = array(
            'STATUS' => $this->STATUS,
            'MSG' => $this->MSG
        );

        $this->dateColumn = array(
            'dtCategoryDate', 'dtModifiedDate'
        );
    }

    /*

     * TO SET THE TABLE NAME

     */

    private function _setTableName($caseValue) {

        try {

            switch ($caseValue) {

                case 1 :

                    $this->tblKey = 'iCategoryID';

                    $this->tblStatus = 'eCategoryStatus';

                    $this->tblDateKey = 'dtCategoryDate';

                    $this->tblModifyDateKey = 'dtModifiedDate';

                    $this->fUploadFolder = 'Category';

                    $this->tblImage = 'vCategoryIcon';



                    date_default_timezone_set('Asia/Kolkata');



                    $this->delMSG = CATEGORY_DEL_SUCC;

                    $this->insMSG = CATEGORY_INS_SUCC;

                    $this->updtMSG = CATEGORY_UPDT_SUCC;

                    $this->actMSG = CATEGORY_UPDT_SUCC;

                    break;
            }
        } catch (Exception $ex) {

            throw new Exception('Crud Model : Error in _setTableName function - ' . $ex);
        }
    }

    /*

     *      TO GET LIST OF USERS...

     */

    public function getCategoryRecord($requestId = '', $isEdit = FALSE) {



        try {

            $fields[] = 'c.iCategoryID AS categoryId';

            $fields[] = 'c.iCategoryID AS DT_RowId';

            $fields[] = 'c.vCategoryName AS categoryName';

            $fields[] = 'c.vCategoryIcon AS categoryIcon';

            $fields[] = 'c.dtCategoryDate AS createDate';

            $fields[] = 'c.dtModifiedDate AS modifiedDate';

            $fields[] = 'c.eCategoryStatus AS categoryStatus';

            $fields[] = 'DATE_FORMAT(c.dtCategoryDate, "%d %b %Y %h:%i %p") AS createDate1';

            $fields[] = 'DATE_FORMAT(c.dtModifiedDate, "%d %b %Y %h:%i %p") AS modifiedDate1';



            $fields = implode(',', $fields);



            $condition = array();

            if ($requestId !== '')
                $condition[] = 'c.iCategoryID = "' . $requestId . '"';



            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';



            $tbl = $this->tbl;



            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . ' AS c ' . $condition . '';



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

    function CategoryName($postValue) {



        try {

            $fields[] = 'vCategoryName AS categoryName';

            $fields = implode(',', $fields);



            $condition[] = 'vCategoryName = "' . $postValue->CategoryName . '"';



            if (isset($postValue->userId) && $postValue->userId != '')
                $condition[] = ' iUserID NOT IN ("' . $postValue->userId . '") ';



            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';



            $tbl = $this->tbl;



            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;



            $res = $this->db->query($qry);



            return $res->num_rows();



            return $this->datatableshelper->query($qry);
        } catch (Exception $ex) {

            throw new Exception('User Model : Error in CategoryName function - ' . $ex);
        }
    }

    // CRUD OPERATIONS



    /*

     * TO SET MD5 CONTENT

     */



    private function _setMD5($objectVal = array(), $keyVal = '') {

        try {

            if (!empty($objectVal)) {

                $keyVal = explode(',', $keyVal);

                foreach ($objectVal as $k => $v) {

                    if (in_array($k, $keyVal))
                        $objectVal[$k] = md5($v);
                }
            } return $objectVal;
        } catch (Exception $ex) {

            throw new Exception('CRUD Model : Error in _setMD5 function - ' . $ex);
        }
    }

    /*

     * TO SET CURRENT DATE CONTENT

     */

    private function _setCurrDate($objectVal = array(), $keyVal = '', $isUpdate = 0) {

        try {

            if (!empty($objectVal)) {

                $keyVal = explode(',', $keyVal);

                foreach ($objectVal as $k => $v) {

                    if (!in_array($k, $keyVal)) {

                        // $objectVal[$k] = date('Y-m-d H:i:s');

                        if (isset($this->dateColumn[$isUpdate]))
                            $objectVal[$this->dateColumn[$isUpdate]] = date('Y-m-d H:i:s'); // strtotime('+1 months')
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

                $insData['eCategoryStatus'] = 'Active';

                $insData = $this->_setCurrDate($insData, $this->tblModifyDateKey, 0);

                if (isset($insData['vCategoryIcon']) && empty($_FILES)) {

                    $insData['vCategoryIcon'] = '';
                }



                /*

                 * INSERT INTO THE DATABASE...

                 */

                $this->db->insert($this->tbl, $insData);

                $insId = $this->db->insert_id();

                if ($insId > 0) {

                    if (isset($_FILES) && !empty($_FILES)) {



                        $PARAM = array(
                            'fType' => 'image',
                            'fLimit' => 20,
                            'fLoc' => array(
                                'key' => $this->fUploadFolder,
                                'id' => $insId
                            ),
                            'fThumb' => TRUE,
                            'fCopyText' => FALSE,
                            'fWidth' => array(100),
                            'fHeight' => array(100),
                            'fTrans' => FALSE,
                        );

                        $this->load->library('fupload', $PARAM);



                        // fUpload($file array, input file name)

                        foreach ($_FILES as $key => $val) {

                            $resp = $this->fupload->fUpload(array($key => $val), $key);
                        }



                        // UPLOAD IMAGE NAME : 

                        $updateData = array('vCategoryIcon' => $resp[0]);



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

                 * TO SET TABLE NAME 

                 */

                $this->_setTableName($requestFor);



                $updateData = (array) $requestObject;

                $updateData = $this->_setCurrDate($updateData, $this->tblModifyDateKey, 1);



                //_print_r($_FILES);
                //_print_r($updateData, TRUE);



                /*

                 * INSERT INTO THE DATABASE...

                 */

                // $this->db->update($this->tbl, $updateData, array($this->tblKey => $requestId));



                if (!isset($updateData['vCategoryIcon']) || $updateData['vCategoryIcon'] !== 'undefined') {



                    if (isset($_FILES) && !empty($_FILES)) {



                        $PARAM = array(
                            'fType' => 'image',
                            'fLimit' => 20,
                            'fLoc' => array(
                                'key' => $this->fUploadFolder,
                                'id' => $requestId
                            ),
                            'fThumb' => TRUE,
                            'fCopyText' => FALSE,
                            'fWidth' => array(100),
                            'fHeight' => array(100),
                            'fTrans' => FALSE,
                        );

                        $this->load->library('fupload', $PARAM);



                        // fUpload($file array, input file name)

                        $resp = $this->fupload->fUpload($_FILES, 'vCategoryIcon');



                        // UPLOAD IMAGE NAME : 

                        $updateFileData = array('vCategoryIcon' => $resp[0]);



                        if ($updateFileData) {

                            // To get old image

                            $query = $this->db->query("SELECT " . $this->tblImage . " FROM " . $this->tbl . " WHERE " . $this->tblKey . " = " . $requestId);

                            $updatedRec = $query->row_array();

                            // to remove old image

                            if (isset($updatedRec['vCategoryIcon'])) {

                                @unlink(UPLD_DIR . $this->fUploadFolder . "/" . $requestId . '/' . $updatedRec[$this->tblImage]);

                                @unlink(UPLD_DIR . $this->fUploadFolder . "/" . $requestId . '/thumb/' . $updatedRec[$this->tblImage]);
                            }
                        }

                        $uploadImage = $this->db->update($this->tbl, $updateFileData, array($this->tblKey => $requestId));
                    }



                    $this->db->update($this->tbl, $updateData, array($this->tblKey => $requestId));
                } else {



                    $query = $this->db->query("SELECT " . $this->tblImage . " FROM " . $this->tbl . " WHERE " . $this->tblKey . " = " . $requestId);

                    $updatedRec = $query->row_array();

                    $this->db->update($this->tbl, $updateData, array($this->tblKey => $requestId));

                    $this->db->update($this->tbl, $updatedRec, array($this->tblKey => $requestId));
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
