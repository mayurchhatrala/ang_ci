<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of login_model
 * @author OpenXcell Technolabs
 */
class General_model extends CI_Model {

    var $table;

    function __construct() {
        parent::__construct();

        $this->table = 'pruser';
        // date_default_timezone_set('America/New_York');
    }

    function getUserByid($postValues) {

        @$userID = $postValues;

        $fields[] = 'iUserID as iUserID';
        $fields[] = 'vDeviceID as vDeviceID';


        $fields = implode(',', $fields);

        $condition[] = ' iUserID = "' . $userID . '"';

        $condition = ' WHERE ' . implode(' AND ', $condition);

        $qry = 'SELECT ' . $fields . ' FROM ' . $this->table . $condition;

        $result = $this->db->query($qry);

        if ($result->num_rows() > 0) {

            return $result->row_array();
        } else {
            return '';
        }
    }

}

?>
