<?php

class Default_model extends CI_Model {

    var $table;
    var $currentLang;
    var $isAdminLogin;

    function __construct() {
        parent::__construct();
        //$this->load->helper('cookie');
        $this->role_tbl = 'admin';
        $this->chk_admin_session();
    }

    /*
     * TO CHECK ADMIN SESSION
     */

    function chk_admin_session($sessionCheck = FALSE) {
        $user = $this->session->userdata('ADMINLOGIN');
        $session_login = $this->session->userdata("ADMINLOGIN");

        if ($this->uri->segment(1) !== 'email' && ($session_login == TRUE && ($this->uri->segment(1) == 'logout' || $sessionCheck))) {
            $this->saveActivity('logout', 'app.logout');

            $this->session->set_userdata(array());
            $this->session->sess_destroy(array());
            !$sessionCheck ? redirect('login/#/access/signin') : '';
        }
    }

    /*
     * TO FETCH THE LOGGED IN USER PAGE PERMISSION
     */

    function pagePermission($stateName = '') {
        if ($stateName != '') {


            if ($this->session->userdata('ADMINTYPE') != '')
                $extraCondition = ' AND tpp.iAdminTypeID IN(' . $this->session->userdata('ADMINTYPE') . ') ';
            else
                $extraCondition = '';

            $inQry = 'SELECT '
                    . 'COUNT(*) '
                    . 'FROM tbl_page_permission tpp '
                    . 'WHERE tpp.iPageID IN(SELECT '
                    . 'DISTINCT(tp.iPageID) '
                    . 'FROM tbl_page AS tp '
                    . 'WHERE tp.vPageState IN(\'' . $stateName . '\') '
                    // . 'AND tp.eStatus IN(\'active\') ) '
                    . 'AND tpp.iPageActionID IN(tpa.iPageActionID) '
                    . $extraCondition;

            $FIELDS[] = 'tpa.iPageActionID AS actionId';
            $FIELDS[] = 'tpa.vActionName AS actionName';
            if ($this->session->userdata('ADMINTYPE') == 1)
                $FIELDS[] = '"yes" AS actionPermission';
            else
                $FIELDS[] = 'IF((' . $inQry . ') = 0), "no", "yes") AS actionPermission';


            $tbl[] = 'tbl_page_action AS tpa';

            $FIELDS = 'SELECT ' . implode(',', $FIELDS);
            $tbl = ' FROM ' . implode(',', $tbl);

            $qry = $FIELDS . $tbl; 
            $row = $this->db->query($qry)->result_array();

            $return = array();
            $returnCount = 0;
            for ($i = 0; $i < count($row); $i++) {
                $actPermission = $row[$i]['actionPermission'];
                $actPermission == 'no' ? $returnCount++ : '';
                $return[$row[$i]['actionId']] = $actPermission == "yes" ? TRUE : FALSE;
            }

            if ($this->session->userdata('ADMINTYPE') == 1) {
                $return['6'] = FALSE;
            } else {
                if ($returnCount == 7)
                    $return['6'] = TRUE;
            }

            //var_dump($return);
            return $return;
        }
    }

    /*
     * SAVE USER ACTIVITY TO DATABASE
     */

    function saveActivity($logName = '', $pageState = '') {
        if ($logName != '' && $pageState != '') {
            $ins = array(
                'iUserID' => $this->session->userdata('ADMINID'),
                'iLogActivityID' => $this->db->get_where('tbl_log_activity', array('vLogActivityAlias' => $logName))->row_array()['iLogActivityID'],
                'iPageID' => $this->db->get_where('tbl_page', array('vPageState' => $pageState))->row_array()['iPageID'],
                'tCreatedAt' => time(),
                'vLogIP' => getIPAddress()
            );
            $this->db->insert('tbl_logs', $ins);
        }
    }

    function getAdminTypes() {
        try {
            $fields[] = 'tat.iAdminTypeID AS adminTypeId';
            $fields[] = 'tat.vAdminTitle AS adminTitle';

            $fields = implode(',', $fields);

            if ($this->session->userdata('ADMINTYPE') != 1)
                $condition[] = 'tat.iAdminTypeID IN(SELECT tata.iAdminAccessID FROM tbl_admin_type_access AS tata WHERE tata.iAdminTypeID IN(' . $this->session->userdata('ADMINTYPE') . '))';
            $condition[] = 'eStatus IN(\'active\')';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = 'tbl_admin_type AS tat';

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;
            $res = $this->db->query($qry);


            if ($res->num_rows() > 0) {
                return $res->result_array();
            } else {
                return array();
            }
        } catch (Exception $ex) {
            throw new Exception('Error in getAdminTypes function - ' . $ex);
        }
    }

    /*
     * TO THROWN OUT THE REQUEST IF ANY REQUEST FROM OTHER DEVICES/SERVERS
     */

    function stayOutOthers() {
        try {
            if ($this->session->userdata('ADMINID') == '') {
                echo json_encode(array(
                    'STATUS' => FAIL_STATUS,
                    'MSG' => NOT_ACCESS
                ));
                exit;
            }
        } catch (Exception $ex) {
            throw new Exception('Error in stayOutOthers function - ' . $ex);
        }
    }

}
