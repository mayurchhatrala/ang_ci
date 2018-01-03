<?php

/**
 * Description of login_model
 * @author Admin
 */
class Login_Model extends CI_Model {

    var $tbl;

    function __construct() {
        parent::__construct();

        $this->tbl = 'tbl_admin';
    }

    /*
     * TO CHECK USERNAME AND PASSWORD ARE CORRECT OR NOT...
     */

    public function loginCheck($postValues) {
        try {
            if (!empty($postValues)) {
                @$username = $postValues->email;
                @$password = $postValues->password;

                $fields[] = 'iAdminID';
                $fields[] = 'iAdminTypeID';
                $fields[] = 'vEmail';
                $fields[] = 'CONCAT(vFirstName," ",vLastName) AS fullName';

                $condition[] = 'vEmail = "' . $username . '"';
                $condition[] = 'vPassword = "' . md5($password) . '"';

                $fields = implode(',', $fields);
                $condition = ' WHERE ' . implode(' AND ', $condition);

                $qry = 'SELECT ' . $fields . ' FROM ' . $this->tbl . $condition;
                $res = $this->db->query($qry);
                if ($res->num_rows() > 0) {
                    $row = $res->row_array();

                    $userdata = array(
                        'ADMINLOGIN' => TRUE,
                        'LOCKED' => FALSE,
                        'ADMINID' => $row['iAdminID'],
                        'ADMINTYPE' => (int) $row['iAdminTypeID'],
                        'ADMINTYPENAME' => $this->db->get_where('tbl_admin_type', array('iAdminTypeID' => $row['iAdminTypeID']))->row_array()['vAdminTitle'],
                        'ADMINFULLNAME' => $row['fullName'],
                        'ADMINEMAIL' => $row['vEmail'],
                        'LAST_ACTIVITY' => time()
                    );

                    $userdata['LAST_LOGIN'] = time();
                    $userdata['LAST_IP'] = getIPAddress();

                    /*
                     * UPDATE LAST LOGIN AND LAST LOGIN IP ADDRESS
                     */
                    $this->db->update('tbl_admin', array('tLastLogin' => $userdata['LAST_LOGIN'], 'vLastIP' => $userdata['LAST_IP']), array('iAdminID' => $row['iAdminID']));

                    // STORE SESSION
                    $this->session->set_userdata($userdata);

                    return $row['iAdminID'];
                } 
            } return 0;
        } catch (Exception $ex) {
            throw new Exception('Login Model : Error in loginCheck function - ' . $ex);
        }
    }

    /*
     * TO SEND RESET PASSWORD LINK...
     */

    public function forgotpwdSubmitCheck($postValues) {
        try {
            if (!empty($postValues)) {

                /*
                 * TO CHECK THAT FIRST THIS EMAIL ADSRESS IS EXISTS IN 
                 * ADMIN TABLE OR NOT...
                 */

                @$username = $postValues->email;

                $res = $this->db->get_where($this->tbl, array('vEmail' => $username));

                if ($res->num_rows() > 0) {
                    $row = $res->row_array();

                    $this->_sendPWDMail($username);

                    return $row['iAdminID'];
                } else {
                    $res = $this->db->get_where('tbl_user', array('vEmail' => $username));

                    if ($res->num_rows() > 0) {
                        $row = $res->row_array();

                        $this->_sendPWDMail($username);

                        return $row['iUserID'];
                    } return -1;
                }
            } return 0;
        } catch (Exception $ex) {
            throw new Exception('Login Model : Error in loginCheck function - ' . $ex);
        }
    }

    /*
     * TO SENT A RESET PASSWORD LINK 
     */

    private function _sendPWDMail($email = '', $reset = FALSE) {
        try {
            if ($email != '') {

                $mailTo = $email;

                $mailParam = array(
                    '{%PROJECT_LOGO%}' => UPLD_URL . 'images/common/logo.png',
                    '{%PROJECT_TITLE%}' => PROJ_TITLE,
                    '{%PROJECT_URL%}' => BASE_URL
                );
                if (!$reset)
                    $mailParam['{%RESET_LINK%}'] = BASE_URL . 'login/#/access/resetpwd/' . base64_encode($email);
                else
                    $mailParam['{%LOGIN_LINK%}'] = BASE_URL . 'login';

                $sendINS = array(
                    'vEmailAddress' => $mailTo,
                    'vContentObject' => serialize($mailParam),
                    'vTemplatePath' => $reset ? 'user/resetpwd.php' : 'user/forgotpwd.php',
                    'tCreatedAt' => date('Y-m-d H:i:s')
                );
                $this->db->insert('tbl_email_send', $sendINS);
                $mailId = $this->db->insert_id();

                $mailParam['{%EMAIL_BROWSE_URL%}'] = BASE_URL . 'email/view/' . base64_encode($mailId);

                $this->load->library('maillib');

                $mailSubject = $reset ? 'Password Reset Successfully' : 'Reset Password';
                $mailTemplate = VIEW_DIR_EMAIL . ($reset ? 'user/resetpwd.php' : 'user/forgotpwd.php');

                $this->maillib->sendMail($mailTo, $mailSubject, $mailTemplate, $mailParam);
            }
        } catch (Exception $ex) {
            throw new Exception('Error in _sendPWDMail function _sendPWDMail function - ' . $ex);
        }
    }

    /*
     * TO SEND RESET PASSWORD LINK...
     */

    public function resetpwdSubmitCheck($postValues) {
        try {
            if (!empty($postValues)) {
                $postValues = (array) $postValues;
                extract($postValues);

                @$email = base64_decode(@$email);

                /*
                 * TO CHECK THAT REQUESTED EMAIL ADDRESS IS COORECT OR NOT
                 */
                if (@$email !== '') {
                    $rows = $this->db->get_where($this->tbl, array('vEmail' => $email))->num_rows();
                    if ($rows > 0) {
                        $this->db->update($this->tbl, array('vPassword' => md5(@$pwd)), array('vEmail' => $email));

                        $this->_sendPWDMail(@$email, TRUE);

                        return 1;
                    } else {
                        $rows = $this->db->get_where('tbl_user', array('vEmail' => $email))->num_rows();
                        if ($rows > 0) {
                            $this->db->update('tbl_user', array('vPassword' => md5(@$pwd)), array('vEmail' => $email));

                            $this->_sendPWDMail(@$email, TRUE);

                            return 1;
                        }
                    } return -1;
                } return -1;
            } return 0;
        } catch (Exception $ex) {
            throw new Exception('Login Model : Error in loginCheck function - ' . $ex);
        }
    }

}
