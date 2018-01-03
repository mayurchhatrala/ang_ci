<?php

/**
 * Description of profile_model
 * @author Admin
 */
class Profile_Model extends CI_Model {

    var $tbl;

    function __construct() {
        parent::__construct();

        $this->tbl = 'tbl_admin';
    }

    /*
     * TO GET THE PROFILE RECORD
     */

    function getProfileRecord($recordId) {
        try {
            if ($recordId === '')
                $recordId = $this->session->userdata('ADMINID');

            $qry = 'SELECT * FROM ' . $this->tbl . ' WHERE iAdminID = "' . $recordId . '"';
            $res = $this->db->query($qry);

            return $res->row_array();
        } catch (Exception $ex) {
            throw new Exception('Profile Model : Error in getProfileRecord function - ' . $ex);
        }
    }

    /*
     * UPDATE THE PROFILE INFORMATION
     */

    function updateProfile($postValue) {
        try {
            if (!empty($postValue)) {
                @$adminId = $this->session->userdata('ADMINID');
                @$firstName = $postValue->firstName;
                @$lastName = $postValue->lastName;
                @$emailId = $postValue->emailId;

                /*
                 * CHECK FIRST THAT THE EMAIL ID IS ALREADY EXISTS FOR OTHER USERS OR NOT...
                 */
                $isExits = $this->_isEmailExists($emailId, $adminId);
                if ($isExits) {
                    /*
                     * NEED TO UPDATE THE RECORD
                     */
                    $data = array(
                        'vFirstName' => $firstName,
                        'vLastName' => $lastName,
                        'vEmail' => $emailId
                    );
                    $condition = array(
                        'iAdminID' => $adminId
                    );

                    $this->db->update($this->tbl, $data, $condition);

                    $this->session->set_userdata(array('ADMINFULLNAME' => $firstName . ' ' . $lastName));

                    return 1;
                } return 0;
            } return -1;
        } catch (Exception $ex) {
            throw new Exception('Profile Model : Error in updateProfile function - ' . $ex);
        }
    }

    /*
     * NEED TO CHECK THIS EMAIL ADDRESS IS EXISTS OR NOT...
     */

    private function _isEmailExists($email, $userId) {
        try {
            if ($email !== '' && $userId !== '') {
                $qry = 'SELECT iAdminID FROM ' . $this->tbl . ' WHERE vEmail = "' . $email . '" AND iAdminID NOT IN(' . $userId . ')';
                $res = $this->db->query($qry);
                if ($res->num_rows() > 0) {
                    return false;
                } return true;
            } return false;
        } catch (Exception $ex) {
            throw new Exception('Profile Model : Error in _isEmailExists function - ' . $ex);
        }
    }

    /*
     * NEED TO UPDATE THE PASSWORD
     */

    function updatePassword($postValue) {
        try {
            if (!empty($postValue)) {
                @$oldPassword = $postValue->oldPassword;
                @$newPassword = $postValue->newPassword;
                @$confirmPassword = $postValue->confirmPassword;
                @$adminId = $this->session->userdata('ADMINID');

                /*
                 * NEED TO CHECK THE OLD PASSWORD IS CORRECT OR NOT..??
                 */
                $isCorrect = $this->db->query('SELECT iAdminID FROM ' . $this->tbl . ' WHERE vPassword = "' . md5($oldPassword) . '" AND iAdminID = "' . $adminId . '"');
                if ($isCorrect->num_rows() > 0) {
                    if ($newPassword === $confirmPassword) {
                        $updt = array(
                            'vPassword' => md5($newPassword)
                        );

                        $this->db->update($this->tbl, $updt, array('iAdminID' => $adminId));

                        return 2;
                    } return 1;
                } return 0;
            } return -1;
        } catch (Exception $ex) {
            throw new Exception('Profile Model : Error in updatePassword function - ' . $ex);
        }
    }

    /*
     * TO GET THE PROFILE RECORD
     */

    function getSettingsRecord($postValue) {
        try {
            if (!empty($postValue)) {
                $res = $this->db->query('SELECT * FROM tbl_settings');
                return $res->row_array();
            } return array();
        } catch (Exception $ex) {
            throw new Exception('Profile Model : Error in getSettingsRecord function - ' . $ex);
        }
    }

    /*
     * TO UPDATE THE SETTINGS RECORDS
     */

    function updateSettings($postValue) {
        try {
            if (!empty($postValue)) {
                
                @$contactEmail = $postValue->contactEmail;
                @$iRadius = $postValue->iRadius;

                $this->db->update('tbl_settings', array('vSettingValue' => $contactEmail, 'iRadius' => $iRadius), array('iSettingID' => 1));

                return 1;
            } return -1;
        } catch (Exception $ex) {
            throw new Exception('Profile Model : Error in updateSettings function - ' . $ex);
        }
    }

}
