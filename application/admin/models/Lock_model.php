<?php

/**
 * Description of login_model
 * @author Admin
 */
class Lock_Model extends CI_Model {

    var $tbl;

    function __construct() {
        parent::__construct();

        $this->tbl = 'tbl_admin';
    }

    /*
     * TO CHECK USERNAME AND PASSWORD ARE CORRECT OR NOT...
     */

    public function lockCheck($postValues) {
        try {
            if (!empty($postValues)) {
                @$password = $postValues->password;

                $fields[] = 'iAdminID';

                $condition[] = 'iAdminID = "' . $this->session->userdata('ADMINID') . '"';
                $condition[] = 'vPassword = "' . md5($password) . '"';

                $fields = implode(',', $fields);
                $condition = ' WHERE ' . implode(' AND ', $condition);

                $qry = 'SELECT ' . $fields . ' FROM ' . $this->tbl . $condition;
                $res = $this->db->query($qry);
                if ($res->num_rows() > 0) {
                    $this->session->set_userdata(array('LOCKED' => FALSE));
                    return 1;
                } else {
                    $fields = $condition = array();
                    $fields[] = 'iUserID';

                    $condition[] = 'iUserID = "' . $this->session->userdata('ADMINID') . '"';
                    $condition[] = 'vPassword = "' . md5($password) . '"';

                    $fields = implode(',', $fields);
                    $condition = ' WHERE ' . implode(' AND ', $condition);

                    $qry = 'SELECT ' . $fields . ' FROM tbl_user ' . $condition;
                    $res = $this->db->query($qry);
                    if ($res->num_rows() > 0) {
                        $this->session->set_userdata(array('LOCKED' => FALSE));
                        return 1;
                    }
                } return -1;
            } return 0;
        } catch (Exception $ex) {
            throw new Exception('Login Model : Error in loginCheck function - ' . $ex);
        }
    }

}
