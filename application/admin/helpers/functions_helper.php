<?php

function _print_r($arry = array(), $need_exit = FALSE) {
    try {

        if (empty($arry))
            echo 'No Record available. !!';
        else {
            echo '<pre>';
            print_r($arry);
            echo '<pre>';
        }

        if ($need_exit)
            exit;
    } catch (Exception $ex) {
        exit('Error in _print_r function - ' . $ex);
    }
}

function _dump($value, $needExit = FALSE) {
    try {
        var_dump($value);

        if ($needExit)
            exit;
    } catch (Exception $ex) {
        exit('Error in _dump function - ' . $ex);
    }
}

function objToArray($obj) {
    if (!is_array($obj) && !is_object($obj))
        return $obj;
    if (is_object($obj))
        $obj = get_object_vars($obj);
    return array_map(__FUNCTION__, $obj);
}

/*
 * TO GET THE CURRENT IP ADDRESS
 */

function getIPAddress() {
    try {
        $ip = $_SERVER['REMOTE_ADDR'];

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } return $ip;
    } catch (Exception $ex) {
        exit('Error in getIPAddress function - ' . $ex);
    }
}

/*
 * TO GET THE SIDEBAR MENU WITH PERMISSION ARRAY
 */

function getMenuListWithPermission() {
    try {
        $ci = & get_instance();
        $field[] = 'tp.iPageID AS pageId';
        $field[] = 'tp.vPageTitle AS pageTitle';
        $field[] = 'tp.vPageState AS pageState';
        $field[] = 'tp.vTableName AS pageTable';
        $field[] = 'tpm.vModuleName AS moduleName';
        $field[] = 'tpm.vModuleIcon AS moduleIcon';

        $tbl[] = 'tbl_page AS tp';
        $tbl[] = 'tbl_page_module AS tpm';

        $condition[] = 'tpm.iPageModuleID IN(tp.iPageModuleID)';
        $condition[] = 'tp.eStatus IN(\'active\')';
        $condition[] = 'tpm.eStatus IN(\'active\')';
        $condition[] = 'tpm.tDeletedAt IS NULL';
        $condition[] = 'tp.tDeletedAt IS NULL';
        if ($ci->session->userdata('ADMINTYPE') != 1)
            $condition[] = 'tpm.isDeveloper IN(\'no\')';

        $orderBy = ' ORDER BY tpm.iOrderVal,tp.iOrderVal ASC ';

        $field = 'SELECT ' . implode(',', $field);
        $tbl = ' FROM ' . implode(',', $tbl);
        $condition = ' WHERE ' . implode(' AND ', $condition);

        $qry = $field . $tbl . $condition . $orderBy;

        $row = $ci->db->query($qry)->result_array();
        
        $returnArry = array();
        for ($i = 0; $i < count($row); $i++) {
            $pagePermission = _pagePermission($row[$i]['pageId']);
            if ($ci->session->userdata('ADMINTYPE') == 1 || !empty($pagePermission)) {
                $tmp['name'] = $row[$i]['pageTitle'];
                $tmp['state'] = $row[$i]['pageState'];
                $tmp['id'] = $row[$i]['pageId'];
                $tmp['rec_count'] = _getTotalTrashCount($row[$i]['pageTable']);
                $tmp['permission'] = $pagePermission;
                $returnArry[$row[$i]['moduleName']]['moduleName'] = $row[$i]['moduleName'];
                $returnArry[$row[$i]['moduleName']]['moduleIcon'] = $row[$i]['moduleIcon'];
                $returnArry[$row[$i]['moduleName']]['pages'][] = $tmp;
            }
        } //_print_r($returnArry,true);

        return $returnArry;
    } catch (Exception $ex) {
        throw new Exception('Error in getMenuListWithPermission function - ' . $ex);
    }
}

function _getTotalTrashCount($tableName = '') {
    try {
        if ($tableName != '') {
            $ci = & get_instance();
            return array(
                'trash' => (int) $ci->db->query('SELECT COUNT(*) AS count_val FROM ' . $tableName . ' WHERE tDeletedAt IS NOT NULL')->row_array()['count_val'],
                'fresh' => (int) $ci->db->query('SELECT COUNT(*) AS count_val FROM ' . $tableName . ' WHERE 1')->row_array()['count_val']
            );
        }
    } catch (Exception $ex) {
        throw new Exception('Error in _getTotalTrashCount function - ' . $ex);
    }
}

function _pagePermission($pageId = '') {
    try {
        if ($pageId != '') {
            $ci = & get_instance();

            $field[] = 'DISTINCT(tpa.iPageActionID) AS actionId';
            $field[] = 'tpa.vActionName AS actionName';

            $tbl[] = 'tbl_page_permission AS tpp';
            $tbl[] = 'tbl_page_action AS tpa';

            $condition[] = 'tpa.iPageActionID IN(tpp.iPageActionID)';
            $condition[] = 'tpa.iPageActionID NOT IN(6)';
            $condition[] = 'tpp.iPageID IN(' . $pageId . ')';
            if ($ci->session->userdata('ADMINTYPE') != '')
                $condition[] = 'tpp.iAdminTypeID IN(' . $ci->session->userdata('ADMINTYPE') . ')';

            $field = 'SELECT ' . implode(',', $field);
            $tbl = ' FROM ' . implode(',', $tbl);
            $condition = ' WHERE ' . implode(' AND ', $condition);

            $qry = $field . $tbl . $condition;

            return $ci->db->query($qry)->result_array();
        }
    } catch (Exception $ex) {
        throw new Exception('Error in _menuPermission function - ' . $ex);
    }
}

function getAllPagesWithPermission($adminTypeId = '') {
    if ($adminTypeId != '') {
        $ci = & get_instance();

        /* $ci->db->order_by('iPageModuleID, iOrderVal', 'ASC');
          $ci->db->where('eStatus', 'active');
          if ($ci->session->userdata('ADMINTYPE') != 1)
          $ci->db->where('eStatus', 'active');
          $pageRec = $ci->db->get('tbl_page')->result_array(); */

        $tbl = $fields = $condition = array();

        $tbl[] = 'tbl_page AS tp';
        $tbl[] = 'tbl_page_module AS tpa';

        $fields[] = 'tp.iPageID AS pageId';
        $fields[] = 'tp.vPageTitle AS pageTitle';

        $condition[] = 'tp.iPageModuleID IN(tpa.iPageModuleID)';
        $condition[] = 'tpa.isDeveloper IN(\'no\')';
        $condition[] = 'tp.eStatus IN(\'active\')';
        $condition[] = 'tp.tDeletedAt IS NULL';

        $tbl = ' FROM ' . implode(',', $tbl);
        $fields = 'SELECT ' . implode(',', $fields);
        $condition = ' WHERE ' . implode(' AND ', $condition);

        $qry = $fields . $tbl . $condition;

        $pageRec = $ci->db->query($qry)->result_array();

        $returnRec = array();
        for ($i = 0; $i < count($pageRec); $i++) {
            $returnRec[$i]['title'] = $pageRec[$i]['pageTitle'];
            $returnRec[$i]['id'] = $pageRec[$i]['pageId'];
            $returnRec[$i]['action'] = getPageActions($adminTypeId, $pageRec[$i]['pageId']);
        }
        //_print_r($returnRec,TRUE);

        return $returnRec;
    }
}

function getPageActions($adminTypeId = '', $pageId = '') {
    if ($adminTypeId != '' && $pageId != '') {
        $ci = & get_instance();

        $field[] = 'tpa.iPageActionID AS actionId';
        $field[] = 'tpa.vActionName AS actionName';
        $field[] = 'IF((SELECT COUNT(*) FROM tbl_page_permission AS tpp WHERE tpp.iAdminTypeID IN(' . $adminTypeId . ') AND tpp.iPageID IN(' . $pageId . ') AND tpp.iPageActionID IN(tpa.iPageActionID)) = 0, 0,1) AS actionPermission';

        $tbl[] = 'tbl_page_action AS tpa';

        $field = 'SELECT ' . implode(',', $field);
        $tbl = ' FROM ' . implode(',', $tbl);

        $qry = $field . $tbl;
        $row = $ci->db->query($qry)->result_array();

        for ($i = 0; $i < count($row); $i++) {
            $row[$i]['actionPermission'] = $row[$i]['actionPermission'] == '1' ? TRUE : FALSE;
        }

        return $row;
    } return array();
}

function getRecentActivity($userId = '', $session = FALSE, $dbHelper = FALSE, $pageId = -1) {
    try {
        $ci = & get_instance();

        $fields[] = 'tl.iLogID AS logId';
        $fields[] = 'tl.iLogID AS DT_RowId';
        $fields[] = ($session ? '"You"' : 'CONCAT(tu.vFirstName," ",vLastName)') . ' AS userName';
        $fields[] = 'tu.iAdminID AS userId';
        $fields[] = 'tla.vLogActivityString AS activityString';
        $fields[] = ($session ? 'vLogActivityBeforeSession' : 'tla.vLogActivityBeforeOther') . ' AS activityBeforeString';
        $fields[] = 'tp.vPageTitle AS pageName';
        $fields[] = 'tl.tCreatedAt AS acitvityDate';
        $fields[] = 'tl.vLogIP AS acitvityIP';
        $fields[] = 'tl.iLogActivityID AS activityId';
        if ($userId == '' && !$session)
            $fields[] = 'COUNT(tl.iLogID) AS logCount';

        $tbl[] = 'tbl_logs AS tl';
        $tbl[] = 'tbl_log_activity AS tla';
        $tbl[] = 'tbl_admin AS tu';
        $tbl[] = 'tbl_page AS tp';

        $condition[] = 'tl.iUserID IN(tu.iAdminID)';
        $condition[] = 'tl.iLogActivityID IN(tla.iLogActivityID)';
        $condition[] = 'tl.iPageID IN(tp.iPageID)';
        if ($userId != '')
            $condition[] = 'tl.iUserID IN(' . $userId . ')';

        //$orderBy = ' ORDER BY tl.iLogID DESC ';
        $orderBy = '';

        $groupBy = '';
        if ($userId == '' && !$session) {
            $groupBy = ' GROUP BY tu.iAdminID ';
        } else {
            $orderBy = ' ORDER BY tl.iLogID DESC ';
        }


        /*
         * PAGINATION LOGIC
         */

        $limit = '';
        $perPage = 6;
        if ($pageId > -1) {
            $startLimit = $pageId * $perPage;
            $limit = ' LIMIT ' . $startLimit . ',' . $perPage;
        }


        $fields = 'SELECT ' . implode(',', $fields);
        $tbl = ' FROM ' . implode(',', $tbl);
        $condition = ' WHERE ' . implode(' AND ', $condition);

        $qry = $fields . $tbl . $condition . $groupBy . $orderBy . $limit;
        if ($dbHelper)
            return $qry;

        $row = $ci->db->query($qry)->result_array();

        for ($i = 0; $i < count($row); $i++) {
            foreach ($row[$i] as $key => $val)
                if ($key === 'acitvityDate')
                    $row[$i][$key] = date(DATE_OBJ_FORMAT, (int) $val);
        }

        //_print_r($row, TRUE);
        return $row;
    } catch (Exception $ex) {
        throw new Exception('Error in getRecentActivity function - ' . $ex);
    }
}

?>
