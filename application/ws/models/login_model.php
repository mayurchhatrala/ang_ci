<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of login_model
 * @author OpenXcell Technolabs
 */
class Login_model extends CI_Model {

    var $table;

    function __construct() {
        parent::__construct();

        $this->table = 'pruser';
        // date_default_timezone_set('America/New_York');
    }

    /*
     * CHECK WHETHER USERNAME AND PASSWORD ARE CORRECT
     * OR NOT...
     */

    function checkAuthentication($postValues) {

        @$emailID = $postValues['prUserName'];
        @$password = $postValues['prPassword'];

        $fields[] = 'prUserID as prUserID';

        $fields = implode(',', $fields);

        $condition[] = 'prUserName = "' . $emailID . '"';
        $condition[] = 'prPassword = "' . md5($password) . '"';

        $condition = ' WHERE ' . implode(' AND ', $condition);

        $qry = 'SELECT ' . $fields . ' FROM ' . $this->table . $condition;
        $result = $this->db->query($qry);

        //  GENERATE HMAC KEY.
        genratemac($result->row_array()['prUserID']);
        
        
        if ($result->num_rows() > 0) {
            $userID = $result->row_array();
            return $userID['prUserID'];
        } else {
            return '';
        }
    }

    /*
     * CHECK WHETHER USERNAME AND PASSWORD ARE CORRECT
     * OR NOT...
     */

    function checkFBAuthentication($postValues) {

        @$prFbID = $postValues['prFbID'];

        $fields[] = 'prUserID as prUserID';

        $fields = implode(',', $fields);

        $condition[] = 'prFbID = "' . $prFbID . '"';

        $condition = ' WHERE ' . implode(' AND ', $condition);

        $qry = 'SELECT ' . $fields . ' FROM ' . $this->table . $condition;
        $result = $this->db->query($qry);

        if ($result->num_rows() > 0) {
            $userID = $result->row_array();
            return $userID['prUserID'];
        } else {
            return '';
        }
    }

    /*
     * WHEN USER IS LOGGING OUT FROM THE SYSTEM...
     */

    function userLogOut() {
        try {
            delete_key();
            return 1;
        } catch (Exception $ex) {
            return 0;
        }
    }

}

?>
