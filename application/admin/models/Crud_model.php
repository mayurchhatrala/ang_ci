<?php

/**
 * Description of crud_model
 * @author Admin
 */
class Crud_Model extends CI_Model {

    var $tbl;
    var $tblKey, $tblDelKey;
    var $tblMD5Key, $tblDateKey, $tblStatusKey, $tblValidateKey;
    var $delMSG, $insMSG, $updtMSG, $validateMSG;
    var $STATUS, $MSG, $RESP;
    var $fUploadFolder, $fUploadKey;
    var $pageStateName, $sendEmailID;
    var $mailRequire, $mailID, $mailTemplate, $mailParam, $mailSubject;

    function __construct() {
        parent::__construct();

        $this->mailRequire = FALSE;
        $this->tblDelKey = 'tDeletedAt';
        $this->mailParam = array(
            '{%PROJECT_LOGO%}' => UPLD_URL . 'images/common/logo.png',
            '{%PROJECT_TITLE%}' => PROJ_TITLE,
            '{%PROJECT_URL%}' => BASE_URL
        );

        $this->STATUS = FAIL_STATUS;
        $this->MSG = INSUFF_DATA;
        $this->RESP = array(
            'STATUS' => $this->STATUS,
            'MSG' => $this->MSG
        );

        /*
         * IF USER IS NOT LOGGED IN THAT IT SHOUDL BE STAY OUT...
         */
        $this->default_model->stayOutOthers();
    }

    /*
     * TO SET THE TABLE NAME
     */

    private function _setTableName($caseValue) {
        try {
            switch ($caseValue) {
                case 1 :
                    $this->tbl = 'tbl_admin_type';
                    $this->tblKey = 'iAdminTypeID';
                    $this->tblStatusKey = 'eStatus';
                    $this->tblMD5Key = '';
                    $this->tblDateKey = '';
                    $this->fUploadFolder = '';
                    $this->pageStateName = 'app.permission.type';

                    $this->delMSG = ADMINTYPE_DEL_SUCC;
                    $this->insMSG = ADMINTYPE_INS_SUCC;
                    $this->updtMSG = ADMINTYPE_UPDT_SUCC;
                    break;

                case 2 :
                    $this->tbl = 'tbl_user';
                    $this->tblKey = 'iUserID';
                    $this->tblValidateKey = 'vEmail';
                    $this->tblMD5Key = 'vPassword';
                    $this->tblDateKey = 'tCreatedAt';
                    $this->fUploadFolder = 'user';
                    $this->tblStatusKey = 'eStatus';
                    $this->pageStateName = 'app.user.list';

                    /*
                     * FOR A MAIL...
                     */
                    $this->mailRequire = TRUE;
                    $this->mailID = 'vEmail';
                    $this->mailSubject = PROJ_TITLE . ' Register User';
                    //$this->mailTemplate = VIEW_DIR_EMAIL . 'user/register.php';
                    $this->mailTemplate = 'registeruser';

                    $this->delMSG = USER_DEL_SUCC;
                    $this->insMSG = USER_INS_SUCC;
                    $this->updtMSG = USER_UPDT_SUCC;
                    $this->validateMSG = USER_EMAIL_EXISTS;
                    break;

                case 3 :
                    $this->tbl = 'tbl_page_module';
                    $this->tblKey = 'iPageModuleID';
                    $this->tblStatusKey = 'eStatus';
                    $this->tblMD5Key = '';
                    $this->tblDateKey = '';
                    $this->fUploadFolder = '';
                    $this->pageStateName = 'app.modules.list';

                    $this->delMSG = ADMIN_MOD_DEL_SUCC;
                    $this->insMSG = ADMIN_MOD_INS_SUCC;
                    $this->updtMSG = ADMIN_MOD_UPDT_SUCC;
                    break;

                case 4 :
                    $this->tbl = 'tbl_page';
                    $this->tblKey = 'iPageID';
                    $this->tblStatusKey = 'eStatus';
                    $this->tblMD5Key = '';
                    $this->tblDateKey = '';
                    $this->fUploadFolder = '';
                    $this->pageStateName = 'app.pages.list';

                    $this->delMSG = ADMIN_PAGE_DEL_SUCC;
                    $this->insMSG = ADMIN_PAGE_INS_SUCC;
                    $this->updtMSG = ADMIN_PAGE_UPDT_SUCC;
                    break;

                case 5 :
                    $this->tbl = 'tbl_email_templates';
                    $this->tblKey = 'iEmailTemplateID';
                    $this->tblStatusKey = 'eStatus';
                    $this->tblMD5Key = '';
                    $this->tblDateKey = 'tCreatedAt';
                    $this->fUploadFolder = '';
                    $this->pageStateName = 'template.email.list';

                    $this->delMSG = EMAIL_TMPLT_DEL_SUCC;
                    $this->insMSG = EMAIL_TMPLT_INS_SUCC;
                    $this->updtMSG = EMAIL_TMPLT_UPDT_SUCC;
                    break;

                case 6 :
                    $this->tbl = 'tbl_gallery';
                    $this->tblKey = 'iGalleryID';
                    $this->fUploadKey = 'vImageName';
                    $this->tblStatusKey = 'eStatus';
                    $this->tblMD5Key = '';
                    $this->tblDateKey = 'tCreatedAt';
                    $this->fUploadFolder = 'gallery';
                    $this->pageStateName = 'app.gallery.list';

                    $this->delMSG = GALLERY_IMAGE_DEL_SUCC;
                    $this->insMSG = GALLERY_IMAGE_INS_SUCC;
                    $this->updtMSG = GALLERY_IMAGE_UPDT_SUCC;
                    break;
                
                case 7 :
                    $this->tbl = 'db_category';
                    $this->tblKey = 'iCategoryID';
                    $this->fUploadKey = 'vCategoryIcon';
                    $this->tblStatusKey = 'eCategoryStatus';
                    $this->tblMD5Key = '';
                    $this->tblDateKey = 'dtCategoryDate';
                    $this->fUploadFolder = 'Category';
                    $this->pageStateName = 'app.category.list';

                    $this->delMSG = CATEGORY_DEL_SUCC;
                    $this->insMSG = CATEGORY_INS_SUCC;
                    $this->updtMSG = CATEGORY_UPDT_SUCC;
                    break;
                
                case 8 :
                    $this->tbl = 'db_retailer';
                    $this->tblKey = 'iRetailerID';
                    $this->fUploadKey = 'vRetailerLogo';
                    $this->tblStatusKey = 'eRetailerStatus';
                    $this->tblMD5Key = '';
                    $this->tblDateKey = 'dtDate';
                    $this->fUploadFolder = 'Retailer';
                    $this->pageStateName = 'app.retailer.list';

                    $this->delMSG = RETAILER_DEL_SUCC;
                    $this->insMSG = RETAILER_INS_SUCC;
                    $this->updtMSG = RETAILER_UPDT_SUCC;
                    break;
                
                case 9 :
                    $this->tbl = 'db_banner';
                    $this->tblKey = 'iBannerID';
                    $this->fUploadKey = 'vBannerIcon';
                    $this->tblStatusKey = 'eStatus';
                    $this->tblMD5Key = '';
                    $this->tblDateKey = 'dtDate';
                    $this->fUploadFolder = 'Banner';
                    $this->pageStateName = 'app.banner.list';

                    $this->delMSG = BANNER_DEL_SUCC;
                    $this->insMSG = BANNER_INS_SUCC;
                    $this->updtMSG = BANNER_UPDT_SUCC;
                    break;
                
                case 10 :
                    $this->tbl = 'db_weekly_ads';
                    // $this->tblKey = 'iAdsImagesID';
                    $this->tblKey = 'iAdsID';
                    $this->fUploadKey = 'vAdsImages';
                    $this->tblStatusKey = 'eStatus';
                    $this->tblMD5Key = '';
                    $this->tblDateKey = 'tCreatedAt';
                    $this->fUploadFolder = 'Weekly';
                    $this->pageStateName = 'app.weeklyads.list';

                    $this->delMSG = WEEKLY_DEL_SUCC;
                    $this->insMSG = WEEKLY_INS_SUCC;
                    $this->updtMSG = WEEKLY_UPDT_SUCC;
                    break;
                
                case 11 :
                    $this->tbl = 'db_catalog';
                    // $this->tblKey = 'iAdsImagesID';
                    $this->tblKey = 'iCatalogID';
                    $this->fUploadKey = 'vCatalogImages';
                    $this->tblStatusKey = 'eStatus';
                    $this->tblMD5Key = '';
                    $this->tblDateKey = 'tCreatedAt';
                    $this->fUploadFolder = 'Weekly';
                    $this->pageStateName = 'app.catalog.list';

                    $this->delMSG = CATALOG_DEL_SUCC;
                    $this->insMSG = CATALOG_INS_SUCC;
                    $this->updtMSG = CATALOG_UPDT_SUCC;
                    break;
                
            }
        } catch (Exception $ex) {
            throw new Exception('Crud Model : Error in _setTableName function - ' . $ex);
        }
    }

    /*
     * TO SET THE RESPONSE ARRAY
     */

    private function _setReponseArray() {
        try {
            $this->RESP = array(
                'MSG' => $this->MSG,
                'STATUS' => $this->STATUS
            );
        } catch (Exception $ex) {
            throw new Exception('Crud Model : Error in _setReponseArray function - ' . $ex);
        }
    }

    /*
     * TO SET MD5 CONTENT
     */

    private function _setMD5($objectVal = array(), $keyVal = '') {
        try {
            if (!empty($objectVal) && $keyVal !== '') {
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

    private function _setCurrDate($objectVal = array(), $keyVal = '') {
        try {
            if (!empty($objectVal) && $keyVal != '') {
                $keyVal = explode(',', $keyVal);
                foreach ($keyVal as $v) {
                    $objectVal[$v] = date('Y-m-d H:i:s');
                }
            } return $objectVal;
        } catch (Exception $ex) {
            throw new Exception('CRUD Model : Error in _setCurrDate function - ' . $ex);
        }
    }

    /*
     * TO SET STATUS VALUE
     */

    private function _setStatus($objectVal = array(), $keyVal = '') {
        try {
            if (!empty($objectVal) && $keyVal != '') {
                foreach ($objectVal as $k => $v) {
                    if (in_array($k, array('ngstatus'))) {
                        $val = $objectVal[$k] ? 'active' : 'deactive';
                        $objectVal[$keyVal] = $val;
                        unset($objectVal[$k]);
                    }
                } return $objectVal;
            } return $objectVal;
        } catch (Exception $ex) {
            throw new Exception('CRUD Model: Error in _setStatus function - ' . $ex);
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
                    
                    // $this->db->update($this->tbl, array($this->tblStatusKey => "Deactive"), array($this->tblKey => $requestId));
                    $a = $this->db->delete($this->tbl, array($this->tblKey => $requestId));
                    "$('#DT').DataTable().ajax.reload()";
                    
                    /*
                     * SAVE USER ACTIVITY
                     */
                    $this->default_model->saveActivity('delete', $this->pageStateName);

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
     * SET EMAIL PARAMETERS
     */

    private function _setEmailParams($requestFor, $requestObject = array()) {
        try {
            if ($requestFor != '' && !empty($requestObject)) {
                switch ($requestFor) {
                    case 2:
                        $this->mailParam['{%REGISTER_USER%}'] = $requestObject['vFirstName'];
                        $this->mailParam['{%REGISTER_TYPE%}'] = $this->db->get_where('tbl_admin_type', array('iAdminTypeID' => $requestObject['iAdminTypeID']))->row_array()['vAdminTitle'];
                        $this->mailParam['{%USER_NAME%}'] = $requestObject['vEmail'];
                        $this->mailParam['{%PASSWORD%}'] = $requestObject['vPassword'];
                        $this->mailParam['{%LOGIN_LINK%}'] = BASE_URL . 'login';
                        break;
                }
            }
        } catch (Exception $ex) {
            throw new Exception('Error in _setEmailParams function - ' . $ex);
        }
    }

    /*
     * PREPARE FILE ARRAY
     */

    private function _setFileObject() {
        try {
            $fileArry = $_FILES;
            $_FILES = array();

            $fName = $fType = $fTmpName = $fErr = $fSize = array();
            foreach ($fileArry as $key => $val) {
                $fArr = explode('_', $key);
                $fKey = $fArr[0];
                $fPos = $fArr[1];

                $fName[] = $val['name'];
                $fType[] = $val['type'];
                $fTmpName[] = $val['tmp_name'];
                $fErr[] = $val['error'];
                $fSize[] = $val['size'];

                $_FILES[$fKey] = array(
                    'name' => $fName,
                    'type' => $fType,
                    'tmp_name' => $fTmpName,
                    'error' => $fErr,
                    'size' => $fSize
                );
            }
        } catch (Exception $ex) {
            throw new Exception('Error in _setFileObject function - ' . $ex);
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

                $insData = $this->_setMD5($insData, $this->tblMD5Key);
                $insData = $this->_setCurrDate($insData, $this->tblDateKey);

                /*
                 * INSERT INTO THE DATABASE...
                 */
                if (isset($insData['accessPage'])) {
                    $tmpAccessPage = $insData['accessPage'];
                    unset($insData['accessPage']);
                }

                if (isset($insData['accessType'])) {
                    $tmpAccessType = $insData['accessType'];
                    unset($insData['accessType']);
                }

                /*
                 * PUT VALIDATION HERE
                 * IF NEEDED ??
                 */
                $needToInstert = TRUE;
                if ($this->tblValidateKey != '' && isset($insData[$this->tblValidateKey])) {
                    //if ($this->tblValidateKey != '') {
                    $hasRec = $this->db->get_where($this->tbl, array($this->tblValidateKey => $insData[$this->tblValidateKey]))->num_rows();
                    if ($hasRec > 0) {
                        $this->MSG = $this->validateMSG;
                        $needToInstert = !$needToInstert;
                    }
                }
                if ($needToInstert) {
                    $this->db->insert($this->tbl, $insData);

                    $insId = $this->db->insert_id();
                    if ($insId > 0) {

                        if ($this->pageStateName == 'app.permission.type' && !empty($tmpAccessPage)) {
                            foreach ($tmpAccessPage as $val) {
                                $accessPage[] = $val->id;
                            }

                            if ($accessPage != '') {
                                if (is_string($accessPage))
                                    $accessPage = explode(',', $accessPage);

                                $this->db->delete('tbl_page_permission', array($this->tblKey => $insId));
                                $permissionVal = array(1, 2, 3, 4, 5, 7);
                                foreach ($accessPage as $val) {
                                    foreach ($permissionVal as $pVal)
                                        $this->db->insert('tbl_page_permission', array('iAdminTypeID' => $insId, 'iPageID' => $val, 'iPageActionID' => $pVal));
                                }
                            }
                        }

                        if ($this->pageStateName == 'app.permission.type' && isset($insData['accessType'])) {
                            $tmpAccessType = $insData['accessType'];
                            foreach ($tmpAccessType as $val) {
                                $accessType[] = $val->adminTypeId;
                            }
                            unset($insData['accessType']);
                            if ($accessType != '') {
                                if (is_string($accessType))
                                    $accessType = explode(',', $accessType);

                                $this->db->delete('tbl_admin_type_access', array($this->tblKey => $insId));
                                foreach ($accessType as $val) {
                                    $this->db->insert('tbl_admin_type_access', array('iAdminTypeID' => $insId, 'iAdminAccessID' => $val['adminTypeId']));
                                }
                            }
                        }

                        /*
                         * SAVE USER ACTIVITY
                         */
                        $this->default_model->saveActivity('insert', $this->pageStateName);

                        /*
                         * FILE WILL UPLOAD HERE...
                         */
                        if (isset($_FILES) && !empty($_FILES)) {
                            $this->_setFileObject();

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
                            $resp = $this->fupload->fUpload($_FILES, 'file');

                            if (!empty($resp)) {
                                if ($this->pageStateName == 'app.gallery.list') {
                                    /*
                                     * INSERT MULTIPLE IMAGES TO OTHER TABLE
                                     */
                                    $insImg['iGalleryID'] = $insId;
                                    $insImg = $this->_setCurrDate($insImg, 'tCreatedAt');
                                    foreach ($resp as $val) {
                                        $insImg['vImageName'] = $val;
                                        $this->db->insert('tbl_gallery_image', $insImg);
                                    }
                                } else {
                                    foreach ($resp as $val) {
                                        $this->db->update($this->tbl, array($this->fUploadKey => $val), array($this->tblKey => $insId));
                                    }
                                }

                                /*
                                 * SAVE USER ACTIVITY
                                 */
                                $this->default_model->saveActivity('upload', $this->pageStateName);
                            }
                        }

                        /*
                         * SEND A MAIL IF NEEDED
                         */

                        if ($this->mailRequire) {
                            $requestObject = (array) $requestObject;
                            //_print_r($requestObject, TRUE);
                            /*
                             * INSERT A RECORD TO THE DATABASE...
                             */
                            $this->_setEmailParams($requestFor, $requestObject);
                            $to = $requestObject[$this->mailID];
                            $sendINS = array(
                                'vEmailAddress' => $to,
                                'vTemplatePath' => $this->mailTemplate,
                                'vContentObject' => serialize($this->mailParam),
                                'tCreatedAt' => date('Y-m-d H:i:s')
                            );
                            $this->db->insert('tbl_email_send', $sendINS);
                            $mailId = $this->db->insert_id();
                            $this->mailParam['{%EMAIL_BROWSE_URL%}'] = BASE_URL . 'email/view/' . base64_encode($mailId);

                            $this->load->library('maillib');

                            //$to = $requestFor[$this->mailID];

                            $this->maillib->sendMail($to, $this->mailSubject, $this->mailTemplate, $this->mailParam);
                        }

                        $this->RESP['RECORDID'] = $insId;
                        $this->RESP['UPLOADED'] = isset($resp) ? $resp : array();
                        $this->MSG = $this->insMSG;
                        $this->STATUS = SUCCESS_STATUS;
                    } else {
                        $this->MSG = INSERT_WARN;
                    }
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

                $updateData = $this->_setMD5($updateData, $this->tblMD5Key);

                $updateData = $this->_setStatus($updateData, $this->tblStatusKey);

                if (isset($updateData['accessPage'])) {
                    $tmpAccessPage = $updateData['accessPage'];
                    unset($updateData['accessPage']);
                }
                if (isset($updateData['accessType'])) {
                    $tmpAccessType = $updateData['accessType'];
                    unset($updateData['accessType']);
                }

                if ($this->pageStateName == 'app.permission.type' && isset($updateData['accessType'])) {
                    $tmpAccessType = $updateData['accessType'];
                    foreach ($tmpAccessType as $val) {
                        $accessType[] = $val->adminTypeId;
                    }
                    unset($updateData['accessType']);
                    if ($accessType != '') {
                        if (is_string($accessType))
                            $accessType = explode(',', $accessType);

                        $this->db->delete('tbl_admin_type_access', array($this->tblKey => $requestId));
                        foreach ($accessType as $val) {
                            $this->db->insert('tbl_admin_type_access', array('iAdminTypeID' => $requestId, 'iAdminAccessID' => $val['adminTypeId']));
                        }
                    }
                }

                if ($this->pageStateName == 'app.permission.type' && !empty($tmpAccessPage)) {
                    foreach ($tmpAccessPage as $val) {
                        $accessPage[] = $val->id;
                    }

                    if ($accessPage != '') {
                        if (is_string($accessPage))
                            $accessPage = explode(',', $accessPage);

                        $this->db->delete('tbl_page_permission', array($this->tblKey => $requestId));
                        $permissionVal = array(1, 2, 3, 4, 5, 7);
                        foreach ($accessPage as $val) {
                            foreach ($permissionVal as $pVal)
                                $this->db->insert('tbl_page_permission', array('iAdminTypeID' => $requestId, 'iPageID' => $val, 'iPageActionID' => $pVal));
                        }
                    }
                }


                /*
                 * UPDATE THE DATABASE...
                 */
                /*
                 * PUT VALIDATION HERE
                 * IF NEEDED ??
                 */
                $needToUpdate = TRUE;
                if ($this->tblValidateKey != '' && isset($updateData[$this->tblValidateKey])) {
                    $this->db->where_not_in($this->tblKey, array($requestId));
                    $hasRec = $this->db->get_where($this->tbl, array($this->tblValidateKey => $updateData[$this->tblValidateKey]))->num_rows();
                    //echo $hasRec;
                    if ($hasRec > 0) {
                        $this->MSG = $this->validateMSG;
                        $needToUpdate = !$needToUpdate;
                    }
                }
                if ($needToUpdate) {
                    $this->db->update($this->tbl, $updateData, array($this->tblKey => $requestId));

                    /*
                     * SAVE USER ACTIVITY
                     */
                    $this->default_model->saveActivity('update', $this->pageStateName);

                    $this->MSG = $this->updtMSG;
                    $this->STATUS = SUCCESS_STATUS;
                }
            }
            $this->_setReponseArray();

            return $this->RESP;
        } catch (Exception $ex) {
            throw new Exception('Crud Model : Error in addRecord function - ' . $ex);
        }
    }

}
