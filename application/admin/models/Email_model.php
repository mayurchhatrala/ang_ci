<?php

/**
 * Description of login_model
 * @author Admin
 */
class Email_Model extends CI_Model {

    var $tbl;

    function __construct() {
        parent::__construct();

        $this->tbl = 'tbl_email_send';
    }

    /*
     * TO CHECK USERNAME AND PASSWORD ARE CORRECT OR NOT...
     */

    public function getEmailContent($target) {
        try {
            if ($target != '') {
                $target = base64_decode($target);

                /*
                 * TO GET THE OBJECT VALUE OF THE REQUESTED VALUE...
                 */
                return $this->db->get_where($this->tbl, array('iEmailSendID' => $target))->row_array();
            } return array();
        } catch (Exception $ex) {
            throw new Exception('Login Model : Error in loginCheck function - ' . $ex);
        }
    }

}
