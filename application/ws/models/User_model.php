<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of login_model
 * @author OpenXcell Technolabs
 */
class User_model extends CI_Model {

    var $table, $fUploadFolder, $tblImage, $tblKey;
    var $tblDateKey;

    function __construct() {
        parent::__construct();

        $this->table = 'tbl_user';
        $this->tblKey = 'iUserID';

        // SERVER TIME
        date_default_timezone_set('Asia/Kolkata');
    }

    /*
     *  REGISTER USER
     */

    function addUser($requestObject) {

        try {
            $fields[] = 'iUserID AS iUserID';
            $fields[] = 'vDeviceToken AS vDeviceToken';
            $fields[] = 'vDeviceID AS vDeviceID';
            $fields[] = 'vLatitude AS vLatitude';
            $fields[] = 'vLongtitude AS vLongtitude';
            $fields[] = 'tEndpointArn AS tEndpointArn';
            $fields[] = 'eStatus AS eStatus';

            $fields = implode(',', $fields);

            if (isset($requestObject['vDeviceID']) && $requestObject['vDeviceID'] != '')
                $condition[] = ' vDeviceID = "' . $requestObject['vDeviceID'] . '" ';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->table;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;

            $res = $this->db->query($qry);

            $insData = array(
                'vDeviceID' => $requestObject['vDeviceID']
            );
            if (isset($requestObject['vLongtitude']) && $requestObject['vLongtitude'] != '' && isset($requestObject['vLatitude']) && $requestObject['vLatitude'] != '') {
                $insData['vLongtitude'] = $requestObject['vLongtitude'];
                $insData['vLatitude'] = $requestObject['vLatitude'];
            }

            if ($res->num_rows() > 0) {

                if ($requestObject['vDeviceID'] != '' && isset($requestObject['vDeviceID'])) {

                    $id = $res->row_array()['iUserID'];
                    $insData['eStatus'] = $requestObject['vNotificationStatus'];

                    if (empty($res->row_array()['tEndpointArn']) && $res->row_array()['vDeviceToken'] != $requestObject['vDeviceToken']) {

                        // echo "1"; exit;
                        $snsNoti = $this->load->library('Sns', array('PLATEFORM_TYPE' => 'ios'));
                        $insData['vDeviceToken'] = $requestObject['vDeviceToken'];
                        $insData['tEndpointArn'] = $this->sns->createPlatFormEndPointARN($requestObject['vDeviceToken'], $id);
                    } elseif (!empty($res->row_array()['tEndpointArn']) && $res->row_array()['vDeviceToken'] != $requestObject['vDeviceToken']) {

                        // echo "2"; exit;
                        $snsNoti = $this->load->library('Sns', array('PLATEFORM_TYPE' => 'ios'));
                        $this->sns->deleteEndPointARN($res->row_array()['tEndpointArn']);
                        $insData['tEndpointArn'] = $this->sns->createPlatFormEndPointARN($requestObject['vDeviceToken'], $id);
                        $insData['vDeviceToken'] = $requestObject['vDeviceToken'];
                    } else {
                        // echo "3"; 
                        if (!empty($res->row_array()['tEndpointArn']) && $res->row_array()['vDeviceID'] != $requestObject['vDeviceID']) {

                            // echo "4"; exit;
                            /*
                             *  DELETE ARN OF OLD DEVICE TOKEN AND GENERATE NEW ARN FOR NEW DEVICE
                             */
                            $snsNoti = $this->load->library('Sns', array('PLATEFORM_TYPE' => 'ios'));
                            $this->sns->deleteEndPointARN($res->row_array()['tEndpointArn']);
                            $insData['tEndpointArn'] = $this->sns->createPlatFormEndPointARN($requestObject['vDeviceToken'], $id);
                            $insData['vDeviceToken'] = $requestObject['vDeviceToken'];
                        } else {
                            // echo "5"; exit;
                            $insData['vDeviceToken'] = $requestObject['vDeviceToken'];
                        }
                    }

                    $this->db->update($this->table, $insData, array($this->tblKey => $id));
                    $res = $this->db->query($qry);
                    return 1;
                } else {
                    return array();
                }
            } else {

                // echo "1.1";
                if ($requestObject['vDeviceID'] != '' && isset($requestObject['vDeviceID'])) {
                    // echo "1.2"; exit;
                    $insData['vDeviceToken'] = $requestObject['vDeviceToken'];
                    $insData['eStatus'] = $requestObject['vNotificationStatus'];
                    $this->db->insert($this->table, $insData);
                    $insData['iUserID'] = $this->db->insert_id();

                    if (isset($requestObject['vDeviceToken']) && $requestObject['vDeviceToken'] != '') {
                        // echo "1.3"; exit;
                        // GENERATE ARN.
                        $snsNoti = $this->load->library('Sns', array('PLATEFORM_TYPE' => 'ios'));
                        $arn = $this->sns->createPlatFormEndPointARN($requestObject['vDeviceToken'], $insData['iUserID']);

                        // SAVE ARN.
                        $update = array("tEndpointArn" => $arn);
                        $this->db->update($this->table, $update, array($this->tblKey => $insData['iUserID']));
                        $res = $this->db->query($qry);
                    }
                    return 0;
                } else {
                    return array();
                }
            }

            return $this->datatablebshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in UPDATE USER LOCATION function - ' . $ex);
        }
    }

    /*
     * CHECK WHETHER Device ID IS exists
     * OR NOT...
     */

    function checkDeviceID($DeviceToken, $DeviceID) {

        try {
            $fields[] = 'vDeviceToken AS vDeviceToken';

            $fields = implode(',', $fields);

            // if (isset($DeviceToken) && $DeviceToken != '')
            $condition[] = ' vDeviceToken = "' . $DeviceToken . '" AND vDeviceID NOT IN ("' . $DeviceID . '")';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->table;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;

            $res = $this->db->query($qry);

            if ($res->num_rows() >= 1) {
                return 0;
            } else {
                return 1;
            }

            return $this->datatableshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    function addUser1($requestObject) {

        try {
            $snsNoti = $this->load->library('Sns', array('PLATEFORM_TYPE' => 'ios'));
            $Device = $this->checkUserDevice($requestObject['vDeviceToken'], $requestObject['vDeviceID'], $requestObject);

            return $Device;
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in UPDATE USER LOCATION function - ' . $ex);
        }
    }

    /*
     *  CHECK DEVICE ID AND DIVETOKEN RECORD
     */

    function checkUserDevice($DeviceToken, $DeviceID, $UserData) {


        $fields[] = 'vDeviceToken AS vDeviceToken';
        $fields[] = 'vDeviceID AS vDeviceID';
        $fields[] = 'tEndpointArn AS tEndpointArn';
        $fields[] = 'iUserID AS iUserID';

        $fields = implode(',', $fields);

        $condition[] = ' vDeviceToken = "' . $DeviceToken . '" ';
        $condition[] = ' vDeviceID = "' . $DeviceID . '" ';

        $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

        $tbl = $this->table;

        $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;

        $res = $this->db->query($qry);

        if (isset($requestObject['vLongtitude']) && $requestObject['vLongtitude'] != '' && isset($requestObject['vLatitude']) && $requestObject['vLatitude'] != '') {
            $UserData['vLongtitude'] = $UserData['vLongtitude'];
            $UserData['vLatitude'] = $UserData['vLatitude'];
        }

        if ($res->num_rows() > 0) {

            $UserID = $res->row_array()['iUserID'];
            $UserData['vDeviceToken'] = $DeviceToken;
            $UserData['vDeviceID'] = $DeviceID;
            $UserData['eStatus'] = $UserData['vNotificationStatus'];
            unset($UserData['vNotificationStatus']);

            if (empty($res->row_array()['vDeviceToken']) && $DeviceToken != '') {
                /*
                 *  DELETE ARN OF OLD DEVICE TOKEN AND GENERATE NEW ARN FOR NEW DEVICE
                 */
                $snsNoti = $this->load->library('Sns', array('PLATEFORM_TYPE' => 'ios'));
                $UserData['tEndpointArn'] = $this->sns->createPlatFormEndPointARN($UserData['vDeviceToken'], $UserID);
                $this->db->update($this->table, $UserData, array($this->tblKey => $UserID));
                return 2;
            } else if ($DeviceID != '' && isset($DeviceID) && $DeviceToken == '') {

                $this->db->update($this->table, $UserData, array($this->tblKey => $UserID));

                return 2;
                // echo "Token and id same, Update OTHER detail";
            }
        } else {

            $fields_n[] = 'vDeviceToken AS vDeviceToken';
            $fields_n[] = 'vDeviceID AS vDeviceID';
            $fields_n[] = 'iUserID AS iUserID';

            $fields_n = implode(',', $fields_n);

            $condition_n[] = ' vDeviceID = "' . $DeviceID . '" ';

            $condition_n = !empty($condition_n) ? ' WHERE ' . implode(' AND ', $condition_n) : '';

            $tbl = $this->table;

            $qry = 'SELECT ' . $fields_n . ' FROM ' . $tbl . $condition_n;

            $res = $this->db->query($qry);

            if ($res->num_rows() > 0) {

                if ($DeviceID == $res->row_array()['vDeviceID'] && $DeviceID != '') {

                    // ECHO "IF"; EXIT;
                    $UserData['vDeviceToken'] = $DeviceToken;
                    $UserData['vDeviceID'] = $DeviceID;
                    $UserData['eStatus'] = $UserData['vNotificationStatus'];
                    unset($UserData['vNotificationStatus']);
                    $this->db->update($this->table, $UserData, array($this->tblKey => $DeviceID));
                    // echo "UPDATE DEVICE TOKEN WITH DB DATA";
                    return 2;
                } else if ($DeviceID != $res->row_array()['vDeviceID']) {

                    // || $res->row_array()['vDeviceToken'] == ''
                    if ($DeviceID != '' && isset($DeviceID) && $DeviceToken != '' && isset($DeviceToken)) {
                        $UserData['vDeviceToken'] = $DeviceToken;
                        $UserData['vDeviceID'] = $DeviceID;
                        $UserData['eStatus'] = $UserData['vNotificationStatus'];
                        unset($UserData['vNotificationStatus']);

                        $snsNoti = $this->load->library('Sns', array('PLATEFORM_TYPE' => 'ios'));
                        $arn = $this->sns->createPlatFormEndPointARN($DeviceToken, $res->row_array()['iUserID']);

                        // SAVE ARN.
                        $UserData['tEndpointArn'] = $arn;
                        $this->db->update($this->table, $UserData, array($this->tblKey => $res->row_array()['iUserID']));
                        // echo "UPDATE DEVICE TOKEN WITH NEW ARN AND AWS CALL";
                        return 2;
                    }
                }
            } else {
                $fields_t[] = 'vDeviceToken AS vDeviceToken';
                $fields_t[] = 'vDeviceID AS vDeviceID';
                $fields_t[] = 'iUserID AS iUserID';

                $fields_t = implode(',', $fields_t);

                $condition_t[] = ' vDeviceToken = "' . $DeviceToken . '" ';

                $condition_t = !empty($condition_t) ? ' WHERE ' . implode(' AND ', $condition_t) : '';

                $tbl = $this->table;

                $qry = 'SELECT ' . $fields_t . ' FROM ' . $tbl . $condition_t;

                $res = $this->db->query($qry);

                if ($res->num_rows() > 0) {

                    $UserID = $res->row_array()['iUserID'];
                    $snsNoti = $this->load->library('Sns', array('PLATEFORM_TYPE' => 'ios'));

                    if (empty($res->row_array()['tEndpointArn']) && $res->row_array()['vDeviceToken'] != $DeviceToken) {
                        $UserData['vDeviceToken'] = $DeviceToken;
                        $UserData['vDeviceID'] = $DeviceID;
                        $UserData['eStatus'] = $UserData['vNotificationStatus'];
                        unset($UserData['vNotificationStatus']);

                        $UserData['tEndpointArn'] = $this->sns->createPlatFormEndPointARN($DeviceToken, $UserID);
                        $this->db->update($this->table, $UserData, array('vDeviceToken' => $DeviceToken));
                        return 2;
                    } else if (!empty($res->row_array()['tEndpointArn']) && $res->row_array()['vDeviceToken'] != $DeviceToken) {

                        $UserData['vDeviceToken'] = $DeviceToken;
                        $UserData['vDeviceToken'] = $DeviceToken;
                        $UserData['vDeviceID'] = $DeviceID;
                        $UserData['eStatus'] = $UserData['vNotificationStatus'];
                        unset($UserData['vNotificationStatus']);

                        $this->sns->deleteEndPointARN($res->row_array()['tEndpointArn']);
                        $UserData['tEndpointArn'] = $this->sns->createPlatFormEndPointARN($DeviceToken, $UserID);
                        $this->db->update($this->table, $UserData, array($this->tblKey => $UserID));
                        return 2;
                    } else {
                        $UserData['vDeviceID'] = $DeviceID;
                        $UserData['eStatus'] = $UserData['vNotificationStatus'];
                        unset($UserData['vNotificationStatus']);
                        $this->db->update($this->table, $UserData, array($this->tblKey => $UserID));
                        return 2;
                    }
                } else {

                    if ($DeviceID != '' && isset($DeviceID) && $DeviceToken != '' && isset($DeviceToken)) {

                        $UserData['eStatus'] = $UserData['vNotificationStatus'];
                        unset($UserData['vNotificationStatus']);
                        $this->db->insert($this->table, $UserData);
                        $UserID = $this->db->insert_id();
                        $snsNoti = $this->load->library('Sns', array('PLATEFORM_TYPE' => 'ios'));
                        $UserData['tEndpointArn'] = $this->sns->createPlatFormEndPointARN($DeviceToken, $UserID);
                        $this->db->update($this->table, $UserData, array($this->tblKey => $UserID));
                        // echo "New Entry with aws";
                        return 1;
                    } else {
                        $UserData['eStatus'] = $UserData['vNotificationStatus'];
                        unset($UserData['vNotificationStatus']);
                        $this->db->insert($this->table, $UserData);
                        // echo "With Blank Device Token ---";
                        return 1;
                    }
                }
            }
        }
    }

    function addUser2($requestObject) {

        try {
            $snsNoti = $this->load->library('Sns_Test', array('PLATEFORM_TYPE' => 'ios'));
            $Device = $this->checkUserDevice2($requestObject['vDeviceToken'], $requestObject['vDeviceID'], $requestObject);

            return $Device;
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in UPDATE USER LOCATION function - ' . $ex);
        }
    }

    /*
     *  CHECK DEVICE ID AND DIVETOKEN RECORD
     */

    function checkUserDevice2($DeviceToken, $DeviceID, $UserData) {


        $fields[] = 'vDeviceToken AS vDeviceToken';
        $fields[] = 'vDeviceID AS vDeviceID';
        $fields[] = 'tEndpointArn AS tEndpointArn';
        $fields[] = 'iUserID AS iUserID';

        $fields = implode(',', $fields);

        $condition[] = ' vDeviceToken = "' . $DeviceToken . '" ';
        $condition[] = ' vDeviceID = "' . $DeviceID . '" ';

        $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

        $tbl = $this->table;

        $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;

        $res = $this->db->query($qry);

        if (isset($requestObject['vLongtitude']) && $requestObject['vLongtitude'] != '' && isset($requestObject['vLatitude']) && $requestObject['vLatitude'] != '') {
            $UserData['vLongtitude'] = $UserData['vLongtitude'];
            $UserData['vLatitude'] = $UserData['vLatitude'];
        }
        
        if ($res->num_rows() > 0) {

            $UserID = $res->row_array()['iUserID'];
            $UserData['vDeviceToken'] = $DeviceToken;
            $UserData['vDeviceID'] = $DeviceID;
            $UserData['eStatus'] = $UserData['vNotificationStatus'];
            unset($UserData['vNotificationStatus']);

            if (empty($res->row_array()['tEndpointArn']) && $DeviceToken != '') {
                /*
                 *  DELETE ARN OF OLD DEVICE TOKEN AND GENERATE NEW ARN FOR NEW DEVICE
                 */
                $snsNoti = $this->load->library('Sns_Test', array('PLATEFORM_TYPE' => 'ios'));
                $UserData['tEndpointArn'] = $this->sns_test->createPlatFormEndPointARN($UserData['vDeviceToken'], $UserID);
                $this->db->update($this->table, $UserData, array($this->tblKey => $UserID));
                return 2;
            } else if ($DeviceID != '' && isset($DeviceID) && $DeviceToken == '') {

                $this->db->update($this->table, $UserData, array($this->tblKey => $UserID));

                return 2;
                // echo "Token and id same, Update OTHER detail";
            }
        } else {

            $fields_n[] = 'vDeviceToken AS vDeviceToken';
            $fields_n[] = 'vDeviceID AS vDeviceID';
            $fields_n[] = 'iUserID AS iUserID';

            $fields_n = implode(',', $fields_n);

            $condition_n[] = ' vDeviceID = "' . $DeviceID . '" ';

            $condition_n = !empty($condition_n) ? ' WHERE ' . implode(' AND ', $condition_n) : '';

            $tbl = $this->table;

            $qry = 'SELECT ' . $fields_n . ' FROM ' . $tbl . $condition_n;

            $res = $this->db->query($qry);

            if ($res->num_rows() > 0) {

                if ($DeviceID == $res->row_array()['vDeviceID'] && $DeviceID != '') {

                    // ECHO "IF"; EXIT;
                    $UserData['vDeviceToken'] = $DeviceToken;
                    $UserData['vDeviceID'] = $DeviceID;
                    $UserData['eStatus'] = $UserData['vNotificationStatus'];
                    unset($UserData['vNotificationStatus']);
                    $this->db->update($this->table, $UserData, array($this->tblKey => $DeviceID));
                    // echo "UPDATE DEVICE TOKEN WITH DB DATA";
                    return 2;
                } else if ($DeviceID != $res->row_array()['vDeviceID']) {

                    // || $res->row_array()['vDeviceToken'] == ''
                    if ($DeviceID != '' && isset($DeviceID) && $DeviceToken != '' && isset($DeviceToken)) {
                        $UserData['vDeviceToken'] = $DeviceToken;
                        $UserData['vDeviceID'] = $DeviceID;
                        $UserData['eStatus'] = $UserData['vNotificationStatus'];
                        unset($UserData['vNotificationStatus']);

                        $snsNoti = $this->load->library('Sns_Test', array('PLATEFORM_TYPE' => 'ios'));
                        $arn = $this->sns_test->createPlatFormEndPointARN($DeviceToken, $res->row_array()['iUserID']);

                        // SAVE ARN.
                        $UserData['tEndpointArn'] = $arn;
                        $this->db->update($this->table, $UserData, array($this->tblKey => $res->row_array()['iUserID']));
                        // echo "UPDATE DEVICE TOKEN WITH NEW ARN AND AWS CALL";
                        return 2;
                    }
                }
            } else {
                $fields_t[] = 'vDeviceToken AS vDeviceToken';
                $fields_t[] = 'vDeviceID AS vDeviceID';
                $fields_t[] = 'iUserID AS iUserID';

                $fields_t = implode(',', $fields_t);

                $condition_t[] = ' vDeviceToken = "' . $DeviceToken . '" ';

                $condition_t = !empty($condition_t) ? ' WHERE ' . implode(' AND ', $condition_t) : '';

                $tbl = $this->table;

                $qry = 'SELECT ' . $fields_t . ' FROM ' . $tbl . $condition_t;

                $res = $this->db->query($qry);

                if ($res->num_rows() > 0) {

                    $UserID = $res->row_array()['iUserID'];
                    $snsNoti = $this->load->library('Sns_Test', array('PLATEFORM_TYPE' => 'ios'));

                    if (empty($res->row_array()['tEndpointArn']) && $res->row_array()['vDeviceToken'] != $DeviceToken) {
                        $UserData['vDeviceToken'] = $DeviceToken;
                        $UserData['vDeviceID'] = $DeviceID;
                        $UserData['eStatus'] = $UserData['vNotificationStatus'];
                        unset($UserData['vNotificationStatus']);

                        $UserData['tEndpointArn'] = $this->sns_test->createPlatFormEndPointARN($DeviceToken, $UserID);
                        $this->db->update($this->table, $UserData, array('vDeviceToken' => $DeviceToken));
                        return 2;
                    } else if (!empty($res->row_array()['tEndpointArn']) && $res->row_array()['vDeviceToken'] != $DeviceToken) {

                        $UserData['vDeviceToken'] = $DeviceToken;
                        $UserData['vDeviceToken'] = $DeviceToken;
                        $UserData['vDeviceID'] = $DeviceID;
                        $UserData['eStatus'] = $UserData['vNotificationStatus'];
                        unset($UserData['vNotificationStatus']);

                        $this->sns_test->deleteEndPointARN($res->row_array()['tEndpointArn']);
                        $UserData['tEndpointArn'] = $this->sns_test->createPlatFormEndPointARN($DeviceToken, $UserID);
                        $this->db->update($this->table, $UserData, array($this->tblKey => $UserID));
                        return 2;
                    } else {
                        $UserData['vDeviceID'] = $DeviceID;
                        $UserData['eStatus'] = $UserData['vNotificationStatus'];
                        unset($UserData['vNotificationStatus']);
                        $this->db->update($this->table, $UserData, array($this->tblKey => $UserID));
                        return 2;
                    }
                } else {

                    if ($DeviceID != '' && isset($DeviceID) && $DeviceToken != '' && isset($DeviceToken)) {

                        $UserData['eStatus'] = $UserData['vNotificationStatus'];
                        unset($UserData['vNotificationStatus']);
                        $this->db->insert($this->table, $UserData);
                        $UserID = $this->db->insert_id();
                        $snsNoti = $this->load->library('Sns_Test', array('PLATEFORM_TYPE' => 'ios'));
                        $UserData['tEndpointArn'] = $this->sns_test->createPlatFormEndPointARN($DeviceToken, $UserID);
                        $this->db->update($this->table, $UserData, array($this->tblKey => $UserID));
                        // echo "New Entry with aws";
                        return 1;
                    } else {
                        $UserData['eStatus'] = $UserData['vNotificationStatus'];
                        unset($UserData['vNotificationStatus']);
                        $this->db->insert($this->table, $UserData);
                        // echo "With Blank Device Token ---";
                        return 1;
                    }
                }
            }
        }
    }

}

?>
