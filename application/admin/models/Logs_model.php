<?php

/**
 * Description of admin_model
 * @author Admin
 */
class Logs_Model extends CI_Model {

    var $tbl;

    function __construct() {
        parent::__construct();
    }

    /*
     * TO GET LIST OF EMAIL TEMPLATES ...
     */

    public function getActivityRecord($requestId = '', $isEdit = FALSE) {
        try {
            $qry = getRecentActivity($requestId, FALSE, TRUE);

            if ($requestId !== '' && $isEdit) {
                $row = $res->row_array();
                return $row;
            } else if ($requestId == '' && $isEdit == TRUE)
                return array();

            return $this->datatableshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getEmailRecord function - ' . $ex);
        }
    }

}
