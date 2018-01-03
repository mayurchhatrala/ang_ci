<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of login_model
 * @author OpenXcell Technolabs
 */
class Craw_model extends CI_Model {

    var $tableb, $tablec, $tabler, $tableca, $tablew, $tablep, $tableRead, $tableUser;
    var $tblKey, $tblKeyc, $tblKeyr, $tblKeyca, $tblKeyw, $tblKeyp, $tblKeyRead, $tblKeyU;
    var $fUploadFolder, $tblImage;
    var $tblDateKey;

    function __construct() {
        parent::__construct();

        $this->tableb = 'db_banner';
        $this->tablec = 'db_category';
        $this->tabler = 'db_retailer';
        $this->tableca = 'db_catalog';
        $this->tablew = 'db_weekly_ads';
        $this->tablep = 'db_pages';
        $this->tableRead = 'db_rcw_read';
        $this->tableUSER = 'tbl_user';
        $this->tblKeyU = 'iUserID';
        $this->tblKey = 'iBannerID';
        $this->tblKeyc = 'iCategoryID';
        $this->tblKeyr = 'iRetailerID';
        $this->tblKeyca = 'iCatalogID';
        $this->tblKeyw = 'iAdsID';
        $this->tblKeyp = 'iPagesID';
        $this->tblKeyRead = 'iRcwID';

        $this->tables = 'tbl_settings';
        $this->tblKeyS = 'iSettingID';

        // SERVER TIME
        date_default_timezone_set('Asia/Kolkata');
    }

    /*
     *      ADS BANNER
     */

    function bannerList($phoneNo) {

        try {
            $fields[] = 'iBannerID AS iBannerID';
            $fields[] = 'vBannerLink AS vBannerLink';
            $fields[] = 'vBannerIcon AS vBannerIcon';
            $fields[] = 'dtDate AS dtDate';
            $fields[] = 'eStatus AS eStatus';

            $fields = implode(',', $fields);

            $OrderBy = ' ORDER BY dtDate DESC ';

            empty($OrderBy) == $OrderBy = '';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->tableb;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition . $OrderBy;

            $res = $this->db->query($qry);

            if ($res->num_rows() >= 0) {
                $array = array();
                foreach ($res->result() as $row) {

                    if ($row->vBannerIcon != '' && $row->vBannerIcon != 'undefined') {
                        $row->vBannerIcon = IMAGE_URL . 'Banner/' . $row->iBannerID . "/thumb/" . $phoneNo['size'] . "/" . $row->vBannerIcon;
                    } else {
                        $row->vBannerIcon = '';
                    }

                    $array[] = (array) $row;
                }
                return $array;
            } else {
                return array();
            }

            return $this->datatablebshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     *      CONTENT LIST
     */

    function contentList($content = array()) {

        try {
            $fields[] = 'iPagesID AS iPagesID';
            $fields[] = 'vPageName AS vPageName';
            $fields[] = 'tContent AS tContent';
            $fields[] = 'dtDate AS dtDate';
            $fields[] = 'eStatus AS eStatus';

            $fields = implode(',', $fields);

            $OrderBy = ' ORDER BY dtDate DESC ';

            if (isset($content['iPagesID']) && $content['iPagesID'] != '')
                $condition[] = ' iPagesID = "' . $content['iPagesID'] . '" ';

            $condition[] = ' eStatus = "Active" ';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $OrderBy != '' ? $OrderBy : '';

            $tbl = $this->tablep;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition . $OrderBy;

            $res = $this->db->query($qry);

            if ($res->num_rows() >= 0) {
                return $res->result_array();
            } else {
                return array();
            }

            return $this->datatablebshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     *      CATEGORY LIST
     */

    function categoryList($categoryID = array()) {

        try {
            $fields[] = 'iCategoryID AS iCategoryID';
            $fields[] = 'vCategoryName AS vCategoryName';
            $fields[] = 'vCategoryIcon AS vCategoryIcon';
            $fields[] = 'dtCategoryDate AS dtCategoryDate';
            $fields[] = 'eCategoryStatus AS eCategoryStatus';

            $fields = implode(',', $fields);

            $OrderBy = ' ORDER BY dtCategoryDate DESC ';

            if (isset($categoryID['vCategoryName']) && $categoryID['vCategoryName'] != '')
                $condition[] = ' vCategoryName = "' . $categoryID['vCategoryName'] . '" ';

            $condition[] = ' eCategoryStatus = "Active" ';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $OrderBy != '' ? $OrderBy : '';

            $tbl = $this->tablec;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition . $OrderBy;

            $res = $this->db->query($qry);

            if ($res->num_rows() >= 0) {
                foreach ($res->result() as $row) {

                    if ($row->vCategoryIcon != '' && $row->vCategoryIcon != 'undefined') {
                        $row->vCategoryIcon = IMAGE_URL . 'Category/' . $row->iCategoryID . "/" . $row->vCategoryIcon;
                    } else {
                        $row->vCategoryIcon = '';
                    }

                    $array[] = (array) $row;
                }
                return $array;
            } else {
                return array();
            }

            return $this->datatablebshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     *      RETAILER LIST
     */

    function retailerList($categoryID = array()) {

        try {

            $fields[] = 'r.iRetailerID AS iRetailerID';
            $fields[] = 'r.iCategoryID AS iCategoryID';
            $fields[] = 'r.vRetailerName AS vRetailerName';
            $fields[] = 'r.vRetailerAddress AS vRetailerAddress';
            $fields[] = 'r.vRetailerLogo AS vRetailerLogo';
            $fields[] = 'r.vRetailerPhone AS vRetailerPhone';
            $fields[] = 'r.tRetailerDesc AS tRetailerDesc';
            $fields[] = 'r.vRetailerEmail AS vRetailerEmail';
            $fields[] = 'r.vRetailerLink AS websiteLink';
            $fields[] = 'r.vLatitude AS vLatitude';
            $fields[] = 'r.vLongtitude AS vLongtitude';
            $fields[] = 'r.dtDate AS dtDate';
            $fields[] = 'r.eRetailerStatus AS eRetailerStatus';
            $fields[] = ' IFNULL(w.iRetailerStatus, 0)  AS isReadable ';
            $fields[] = ' IFNULL(w.iRetailerFavStatus, 0)  AS isFavorite ';

            if (!empty($categoryID['vLatitude']) && !empty($categoryID['vLongtitude']) && !empty($categoryID['Range'])) {

                $RadiusData = $this->db->select("iRadius")
                                ->from($this->tables)
                                ->where($this->tblKeyS, 1)
                                ->get()->row_array()['iRadius'];

                if ($RadiusData > 0) {
                    $fields[] = '((ACOS(SIN(' . $categoryID['vLatitude'] . ' * PI() / 180) * SIN(r.vLatitude * PI() / 180) + COS(' . $categoryID['vLatitude'] . ' * PI() / 180) * COS(r.vLatitude * PI() / 180) * COS((' . $categoryID['vLongtitude'] . ' - r.vLongtitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance';
                    $HavingBy = ' HAVING distance <= ' . $RadiusData;
                } else {
                    return array();
                }
            }

            $fields = implode(',', $fields);

            $OrderBy = ' ORDER BY r.dtDate DESC ';

            $limit = $this->pagination($categoryID['pageid']);

            $condition[] = ' r.eRetailerStatus = "Active" ';

            if (isset($categoryID['iCategoryID']) && $categoryID['iCategoryID'] != '')
                $condition[] = ' r.iCategoryID IN  ( ' . $categoryID['iCategoryID'] . ')';

            if (isset($categoryID['iRetailerID']) && $categoryID['iRetailerID'] != '')
                $condition[] = ' r.iRetailerID IN  ( ' . $categoryID['iRetailerID'] . ')';

            if (isset($categoryID['vRetailerName']) && $categoryID['vRetailerName'] != '') {
                $categoryID['vRetailerName'] = addslashes($categoryID['vRetailerName']);
                $condition[] = ' r.vRetailerName like "%' . addslashes($categoryID['vRetailerName']) . '%" ';
            }

            //  GET FAVORITE LIST
            if (isset($categoryID['favStatus']) && $categoryID['favStatus'] != '')
                $condition[] = ' w.iRetailerFavStatus = "' . $categoryID['favStatus'] . '" ';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $OrderBy != '' ? $OrderBy : '';

            // !empty($HavingBy) ? $HavingBy : '';
            if (isset($categoryID['Range']) && $categoryID['Range'] != '') {
                $HavingBy;
            } else {
                $HavingBy = '';
            }

            $tbl = $this->tabler;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . " as r LEFT JOIN db_rcw_read as w ON r.iRetailerID = w.iRetailerID AND vDeviceID = '" . $categoryID['vDeviceID'] . "' " . $condition . $HavingBy . $OrderBy . $limit;

            $res = $this->db->query($qry);
            
            $num_row = $this->db->query($qry = 'SELECT ' . $fields . ' FROM ' . $tbl . " as r LEFT JOIN db_rcw_read as w ON r.iRetailerID = w.iRetailerID AND vDeviceID = '" . $categoryID['vDeviceID'] . "' " . $condition . $HavingBy . $OrderBy)->num_rows();

            $array = array();
            
            $array['total'] = (int) $num_row;

            if ($res->num_rows() >= 0) {
                
                $array['data'] = array();
                
                foreach ($res->result() as $row) {

                    if ($row->vRetailerLogo != '' && $row->vRetailerLogo != 'undefined') {
                        $row->vRetailerLogo = IMAGE_URL . 'Retailer/' . $row->iRetailerID . "/thumb/" . $categoryID['size'] . "/" . $row->vRetailerLogo;
                    } else {
                        $row->vRetailerLogo = '';
                    }

                    $array['data'][] = (array) $row;
                }
                return $array;
            } else {
                $array = array();
                $array['total'] = (int) $num_rows;;
                $array['data'] = array();
                return $array;
            }

            return $this->datatablebshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     *      RETAILER LIST
     */

    function catalogList($catalog = array(), $RetailerID = null, $DeviceID = null, $imageSize = null, $isPageValid = "") {
        try {

            $fields[] = 'c.iCatalogID AS iCatalogID';
            $fields[] = 'r.iRetailerID AS iRetailerID';
            $fields[] = 'r.vRetailerName AS vRetailerName';
            $fields[] = 'r.vLatitude AS vLatitude';
            $fields[] = 'r.vLongtitude AS vLongtitude';
            $fields[] = 'c.iCategoryID AS iCategoryID';
            $fields[] = 'c.vCatalogName AS vCatalogName';
            // $fields[] = 'c.dtDate AS dtDate';
            $fields[] = 'c.dtEndDate AS dtDate';
            $fields[] = 'c.eStatus AS eStatus';
            $fields[] = ' IFNULL(w.iCatalogStatus, 0) AS isReadable';
            $fields[] = ' IFNULL(w.iCatalogFavStatus, 0) AS isFavorite';

            if (!empty($catalog['vLatitude']) && !empty($catalog['vLongtitude']) && !empty($catalog['Range'])) {

                $RadiusData = $this->db->select("iRadius")
                                ->from($this->tables)
                                ->where($this->tblKeyS, 1)
                                ->get()->row_array()['iRadius'];

                if ($RadiusData > 0) {
                    $fields[] = '((ACOS(SIN(' . $catalog['vLatitude'] . ' * PI() / 180) * SIN(r.vLatitude * PI() / 180) + COS(' . $catalog['vLatitude'] . ' * PI() / 180) * COS(r.vLatitude * PI() / 180) * COS((' . $catalog['vLongtitude'] . ' - r.vLongtitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance';
                    $HavingBy = ' HAVING distance <= ' . $RadiusData;
                } else {
                    return array();
                }
            }

            $fields = implode(',', $fields);

            $OrderBy = ' ORDER BY c.dtDate DESC ';

            if ($isPageValid == '')
                $limit = $this->pagination($catalog['pageid']);
            else
                $limit = '';

            $condition[] = ' c.eStatus = "Active" ';

            if (isset($catalog['iCategoryID']) && $catalog['iCategoryID'] != '')
                $condition[] = ' c.iCategoryID IN  ( ' . $catalog['iCategoryID'] . ')';

            if (isset($catalog['iRetailerID']) && $catalog['iRetailerID'] != '')
                $condition[] = ' r.iRetailerID IN  ( ' . $catalog['iRetailerID'] . ')';

            if (isset($catalog['iCatalogID']) && $catalog['iCatalogID'] != '')
                $condition[] = ' c.iCatalogID IN  ( ' . $catalog['iCatalogID'] . ')';

            if (isset($catalog['vCatalogName']) && $catalog['vCatalogName'] != '')
                $condition[] = ' c.vCatalogName LIKE "%' . addslashes($catalog['vCatalogName']) . '%" ';

            // FOR SEARCH IN THE HOME PAGE
            if (isset($catalog['vName']) && $catalog['vName'] != '')
                $condition[] = ' c.vCatalogName like "%' . addslashes($catalog['vName']) . '%" ';

            //  GET FAVORITE LIST
            if (isset($catalog['favStatus']) && $catalog['favStatus'] != '')
                $condition[] = ' w.iCatalogFavStatus = "' . $catalog['favStatus'] . '" ';

            // RETIALE STORE WS
            if ($RetailerID != '' && isset($RetailerID)) {
                $condition[] = ' r.iRetailerID IN  ( ' . $RetailerID . ')';
                $catalog['vDeviceID'] = $DeviceID;
                $catalog['size'] = $imageSize;
            }

            $condition[] = '  DATEDIFF(NOW(), c.dtEndDate) < 1 ';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $OrderBy != '' ? $OrderBy : '';

            // !empty($HavingBy) ? $HavingBy : '';
            if (!empty($catalog['Range']) && $catalog['Range'] != '') {
                $HavingBy;
            } else {
                $HavingBy = '';
            }

            $tbl = $this->tableca;
            
            $num_rows = $this->db->query('SELECT ' . $fields . ' FROM ' . $tbl . " as c LEFT JOIN db_retailer as r ON c.iRetailerID = r.iRetailerID LEFT JOIN db_rcw_read as w ON c.iCatalogID = w.iCatalogID AND vDeviceID = '" . $catalog['vDeviceID'] . "' " . $condition . " GROUP BY c.iCatalogID " . $HavingBy . $OrderBy )->num_rows();

            // SELECT r.iRetailerID, c.*, ((ACOS(SIN(23.0347566030597 * PI() / 180) * SIN(r.vLatitude * PI() / 180) + COS(23.0347566030597 * PI() / 180) * COS(r.vLatitude * PI() / 180) * COS((72.50927825520023 - r.vLongtitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance FROM db_catalog as c LEFT JOIN db_retailer as r ON c.iRetailerID = r.iRetailerID GROUP BY c.iCatalogID HAVING distance<='34' 
            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . " as c LEFT JOIN db_retailer as r ON c.iRetailerID = r.iRetailerID LEFT JOIN db_rcw_read as w ON c.iCatalogID = w.iCatalogID AND vDeviceID = '" . $catalog['vDeviceID'] . "' " . $condition . " GROUP BY c.iCatalogID " . $HavingBy . $OrderBy . $limit;
            // echo $qry; exit;

            $res = $this->db->query($qry);
            
            $array = array();
            $array['total'] = (int) $num_rows;

            if ($res->num_rows() > 0) {

                $array['data'] = array();
                
                foreach ($res->result() as $row) {
                    $row->vCatalogImages = $this->ImagesList("db_catalog_sub", $row->iCatalogID, array('iCatalogID', 'vCatalogImages', 'Catalog'), $catalog['size']);
                    $array['data'][] = (array) $row;
                }
                return $array;
            } else {
                $array = array();
                $array['total'] = (int) $num_rows;;
                $array['data'] = array();
                return $array;
            }

            return $this->datatablebshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     *      RETAILER LIST
     */

    function weeklyAdsList($catalog = array(), $RetailerID = null, $DeviceID = null, $imageSize = null, $isPageValid = "") {
        try {

            $fields[] = 'c.iAdsID AS iAdsID';
            $fields[] = 'r.iRetailerID AS iRetailerID';
            $fields[] = 'r.vRetailerName AS vRetailerName';
            $fields[] = 'r.vLatitude AS vLatitude';
            $fields[] = 'r.vLongtitude AS vLongtitude';
            $fields[] = 'c.iCategoryID AS iCategoryID';
            $fields[] = 'c.vAdsName AS vAdsName';
            // $fields[] = 'c.dtStartDate AS dtStartDate';
            $fields[] = 'c.dtEndDate AS dtStartDate';
            $fields[] = 'c.vAdsLink AS websiteLink';
            $fields[] = 'c.eStatus AS eStatus';
            $fields[] = ' IFNULL(w.iAdsStatus, 0)  AS isReadable';
            $fields[] = ' IFNULL(w.iAdsFavStatus, 0)  AS isFavorite';

            if (!empty($catalog['vLatitude']) && !empty($catalog['vLongtitude']) && !empty($catalog['Range'])) {
                $RadiusData = $this->db->select("iRadius")
                                ->from($this->tables)
                                ->where($this->tblKeyS, 1)
                                ->get()->row_array()['iRadius'];

                if ($RadiusData > 0) {
                    $fields[] = '((ACOS(SIN(' . $catalog['vLatitude'] . ' * PI() / 180) * SIN(r.vLatitude * PI() / 180) + COS(' . $catalog['vLatitude'] . ' * PI() / 180) * COS(r.vLatitude * PI() / 180) * COS((' . $catalog['vLongtitude'] . ' - r.vLongtitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance';
                    $HavingBy = ' HAVING distance <= ' . $RadiusData;
                } else {
                    $HavingBy = '';
                    return array();
                }
            }

            $fields = implode(',', $fields);

            $OrderBy = ' ORDER BY c.dtStartDate DESC ';

            if ($isPageValid == '')
                $limit = $this->pagination($catalog['pageid']);
            else
                $limit = '';

            $condition[] = ' c.eStatus = "Active" ';

            if (isset($catalog['iCategoryID']) && $catalog['iCategoryID'] != '')
                $condition[] = ' c.iCategoryID IN  ( ' . $catalog['iCategoryID'] . ')';

            if (isset($catalog['iRetailerID']) && $catalog['iRetailerID'] != '')
                $condition[] = ' r.iRetailerID IN  ( ' . $catalog['iRetailerID'] . ')';

            if (isset($catalog['iAdsID']) && $catalog['iAdsID'] != '')
                $condition[] = ' c.iAdsID IN  ( ' . $catalog['iAdsID'] . ')';

            if (isset($catalog['vAdsName']) && $catalog['vAdsName'] != '')
                $condition[] = ' c.vAdsName LIKE "%' . addslashes($catalog['vAdsName']) . '%" ';

            // FOR SEARCH IN THE HOME PAGE
            if (isset($catalog['vName']) && $catalog['vName'] != '')
                $condition[] = ' c.vAdsName like "%' . addslashes($catalog['vName']) . '%" ';

            //  GET FAVORITE LIST
            if (isset($catalog['favStatus']) && $catalog['favStatus'] != '')
                $condition[] = ' w.iAdsFavStatus = "' . $catalog['favStatus'] . '" ';

            // RETIALE STORE WS
            if ($RetailerID != '' && isset($RetailerID)) {
                $condition[] = ' r.iRetailerID IN  ( ' . $RetailerID . ')';
                $catalog['vDeviceID'] = $DeviceID;
                $catalog['size'] = $imageSize;
            }

            $condition[] = '  DATEDIFF(NOW(), c.dtEndDate) < 1 ';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $OrderBy != '' ? $OrderBy : '';

             // !empty($HavingBy) ? $HavingBy : '';
            if (!empty($catalog['Range']) && $catalog['Range'] != '') {
                $HavingBy;
            } else {
                $HavingBy = '';
            }

            $tbl = $this->tablew;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . " as c LEFT JOIN db_retailer as r ON c.iRetailerID = r.iRetailerID LEFT JOIN db_rcw_read as w ON c.iAdsID = w.iAdsID AND vDeviceID = '" . $catalog['vDeviceID'] . "' " . $condition . " GROUP BY c.iAdsID " . $HavingBy . $OrderBy . $limit;

            $res = $this->db->query($qry);
            
            $num_rows = $this->db->query('SELECT ' . $fields . ' FROM ' . $tbl . " as c LEFT JOIN db_retailer as r ON c.iRetailerID = r.iRetailerID LEFT JOIN db_rcw_read as w ON c.iAdsID = w.iAdsID AND vDeviceID = '" . $catalog['vDeviceID'] . "' " . $condition . " GROUP BY c.iAdsID " . $HavingBy . $OrderBy)->num_rows();
            
            $array = array();
            
            $array['total'] = (int) $num_rows;

            if ($res->num_rows() > 0) {

                $array['data'] = array();
                
                foreach ($res->result() as $row) {
                    $row->vAdsImages = $this->ImagesList("db_weekly_ads_sub", $row->iAdsID, array('iAdsID', 'vAdsImages', 'Weekly'), $catalog['size']);
                    $array['data'][] = (array) $row;
                }
                return $array;
            } else {
                $array = array();
                $array['total'] = (int) $num_rows;;
                $array['data'] = array();
                return $array;
            }

            return $this->datatablebshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     *      READ RETAILER, CATALOG, WEEKLY ADS LIST
     */

    function rcwList($rcwData = array()) {

        try {
            $fields[] = 'iRcwID AS iRcwID';
            $fields[] = 'iRetailerID AS iRetailerID';
            $fields[] = 'iRetailerStatus AS iRetailerStatus';
            $fields[] = 'iCatalogID AS iCatalogID';
            $fields[] = 'iCatalogStatus AS iCatalogStatus';
            $fields[] = 'iAdsID AS iAdsID';
            $fields[] = 'iAdsStatus AS iAdsStatus';

            $fields = implode(',', $fields);

            if (isset($rcwData['iRetailerID']) && $rcwData['iRetailerID'] != '')
                $condition[] = ' iRetailerID = "' . $rcwData['iRetailerID'] . '" AND vDeviceID = "' . $rcwData['vDeviceID'] . '" ';

            if (isset($rcwData['iCatalogID']) && $rcwData['iCatalogID'] != '')
                $condition[] = ' iCatalogID = "' . $rcwData['iCatalogID'] . '" AND vDeviceID = "' . $rcwData['vDeviceID'] . '" ';

            if (isset($rcwData['iAdsID']) && $rcwData['iAdsID'] != '')
                $condition[] = ' iAdsID = "' . $rcwData['iAdsID'] . '" AND vDeviceID = "' . $rcwData['vDeviceID'] . '" ';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->tableRead;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;

            $res = $this->db->query($qry);

            if ($res->num_rows() > 0) {
                $ids = array();
                $ids['vDeviceID'] = $rcwData['vDeviceID'];
                
                if (isset($rcwData['iRetailerID']) && $rcwData['iRetailerID'] != '') {    
                    $ids['iRetailerID'] = $rcwData['iRetailerID'];
                    $insData = array(
                        'iRetailerStatus' => "1",
                    );
                }

                if (isset($rcwData['iCatalogID']) && $rcwData['iCatalogID'] != '') {
                    $ids['iCatalogID'] = $rcwData['iCatalogID'];
                    $insData = array(
                        'iCatalogStatus' => "1",
                    );
                }

                if (isset($rcwData['iAdsID']) && $rcwData['iAdsID'] != '') {
                    $ids['iAdsID'] = $rcwData['iAdsID'];
                    $insData = array(
                        'iAdsStatus' => "1",
                    );
                }
                
                $this->db->update($this->tableRead, $insData, $ids);
                
                $res = $this->db->query($qry);
                return $res->result_array();
                
            } else {

                if (isset($rcwData['iRetailerID']) && $rcwData['iRetailerID'] != '') {
                    $insData = array(
                        'iRetailerID' => $rcwData['iRetailerID'],
                        'iRetailerStatus' => "1",
                    );
                }

                if (isset($rcwData['iCatalogID']) && $rcwData['iCatalogID'] != '') {
                    $insData = array(
                        'iCatalogID' => $rcwData['iCatalogID'],
                        'iCatalogStatus' => "1",
                    );
                }

                if (isset($rcwData['iAdsID']) && $rcwData['iAdsID'] != '') {
                    $insData = array(
                        'iAdsID' => $rcwData['iAdsID'],
                        'iAdsStatus' => "1",
                    );
                }

                $insData['vDeviceID'] = $rcwData['vDeviceID'];
                $this->db->insert($this->tableRead, $insData);
                $insData['iRcwID'] = $this->db->insert_id();

                $res = $this->db->query($qry);
                return $res->result_array();

                // return array($insData);
            }

            return $this->datatablebshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     *      READ RETAILER, CATALOG, WEEKLY ADS LIST
     */

    function favList($favData = array()) {

        try {
            $fields[] = 'iRcwID AS iRcwID';
            $fields[] = 'iRetailerID AS iRetailerID';
            $fields[] = 'iRetailerFavStatus AS iRetailerFavStatus';
            $fields[] = 'iCatalogID AS iCatalogID';
            $fields[] = 'iCatalogFavStatus AS iCatalogFavStatus';
            $fields[] = 'iAdsID AS iAdsID';
            $fields[] = 'iAdsFavStatus AS iAdsFavStatus';

            $fields = implode(',', $fields);

            if (isset($favData['iRetailerID']) && $favData['iRetailerID'] != '')
                $condition[] = ' iRetailerID = "' . $favData['iRetailerID'] . '" AND vDeviceID = "' . $favData['vDeviceID'] . '" ';

            if (isset($favData['iCatalogID']) && $favData['iCatalogID'] != '')
                $condition[] = ' iCatalogID = "' . $favData['iCatalogID'] . '" AND vDeviceID = "' . $favData['vDeviceID'] . '"  ';

            if (isset($favData['iAdsID']) && $favData['iAdsID'] != '')
                $condition[] = ' iAdsID = "' . $favData['iAdsID'] . '" AND vDeviceID = "' . $favData['vDeviceID'] . '"  ';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->tableRead;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;

            $res = $this->db->query($qry);

            /*
             *      Fav DATA INSERT OR UPDATE
             */
            if (isset($favData['iRetailerID']) && $favData['iRetailerID'] != '') {
                $insData = array(
                    'iRetailerID' => $favData['iRetailerID'],
                    'iRetailerFavStatus' => $favData['eStatus'],
                );
            }

            if (isset($favData['iCatalogID']) && $favData['iCatalogID'] != '') {
                $insData = array(
                    'iCatalogID' => $favData['iCatalogID'],
                    'iCatalogFavStatus' => $favData['eStatus'],
                );
            }

            if (isset($favData['iAdsID']) && $favData['iAdsID'] != '') {
                $insData = array(
                    'iAdsID' => $favData['iAdsID'],
                    'iAdsFavStatus' => $favData['eStatus'],
                );
            }

            if ($res->num_rows() > 0) {

                $id = $res->row_array()['iRcwID'];

                $this->db->update($this->tableRead, $insData, array($this->tblKeyRead => $id));
                $res = $this->db->query($qry);
                return $res->result_array();
            } else {
                $insData['vDeviceID'] = $favData['vDeviceID'];
                $this->db->insert($this->tableRead, $insData);
                $insData['iRcwID'] = $this->db->insert_id();
                $res = $this->db->query($qry);
                return $res->result_array();
            }

            return $this->datatablebshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     *      RETAILER LIST
     */

    function locationList($categoryID = array()) {

        try {

            $fields[] = 'r.iRetailerID AS iRetailerID';
            $fields[] = 'r.vRetailerLink AS websiteLink';
            $fields[] = 'r.vRetailerCity AS vRetailerCity';
            $fields[] = 'r.vRetailerState AS vRetailerState';
            $fields[] = 'r.vRetailerCountry AS vRetailerCountry';
            $fields[] = 'r.vLatitude AS vLatitude';
            $fields[] = 'r.vLongtitude AS vLongtitude';

            $fields = implode(',', $fields);

            $condition[] = ' r.eRetailerStatus = "Active" ';

            if (isset($categoryID['vLocationName']) && $categoryID['vLocationName'] != '')
                $condition[] = ' r.vRetailerState like "%' . addslashes($categoryID['vLocationName']) . '%" '
                        . 'OR r.vRetailerCountry like "%' . addslashes($categoryID['vLocationName']) . '%"';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->tabler;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . " as r " . $condition;

            $res = $this->db->query($qry);

            $array = array();

            if ($res->num_rows() > 0) {
                return $res->result();
            } else {

                $fieldsNew[] = 'GROUP_CONCAT(r.iRetailerID) AS iRetailerID';
                $fieldsNew[] = 'r.vRetailerAddress as vRetailerAddress';
                $fieldsNew[] = 'r.vLatitude AS vLatitude';
                $fieldsNew[] = 'r.vLongtitude AS vLongtitude';
                //$fieldsNew[] = 'SUBSTRING_INDEX(SUBSTRING_INDEX(r.vRetailerAddress, ", ", -3), ", ", 1) as ADDRESS';

                $fieldsNew = implode(',', $fieldsNew);
                $conditionNew[] = ' r.eRetailerStatus = "Active" ';

                /* if (isset($categoryID['vLocationName']) && $categoryID['vLocationName'] != '')
                  $conditionNew[] = ' SUBSTRING_INDEX(SUBSTRING_INDEX(r.vRetailerAddress, ", ", -3), ", ", 1) LIKE "%' . $categoryID['vLocationName'] . '%" '; */

                if (isset($categoryID['vLocationName']) && $categoryID['vLocationName'] != '')
                    $conditionNew[] = ' r.vRetailerAddress LIKE "%' . addslashes($categoryID['vLocationName']) . '%" ';

                $conditionNew = !empty($conditionNew) ? ' WHERE ' . implode(' AND ', $conditionNew) : '';

                $tbl = $this->tabler;

                $qry = 'SELECT ' . $fieldsNew . ' FROM ' . $tbl . " as r " . $conditionNew . " GROUP BY r.vRetailerAddress DESC  ";

                // Sarkhej - Gandhinagar Hwy,   Bodakdev, Ahmedabad, Gujarat 380054, India
                // 761-767 5th Ave,             New York, NY 10153, USA
                // 43 Trinity Square,           London EC3N 4DJ, UK

                $res = $this->db->query($qry);

                if ($res->num_rows() > 0) {
                    return $res->result();
                } else {
                    return array();
                }
            }

            return $this->datatablebshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     *      RETAILER STORE LIST.
     */

    /*
     *      RETAILER LIST
     */

    function retailerStoreList($categoryID = array()) {

        try {

            $fields[] = 'r.iRetailerID AS iRetailerID';
            // $fields[] = 'r.iCategoryID AS iCategoryID';
            $fields[] = 'r.vRetailerName AS vRetailerName';
            $fields[] = 'r.vRetailerAddress AS vRetailerAddress';
            $fields[] = 'r.vRetailerLogo AS vRetailerLogo';
            $fields[] = 'r.vRetailerPhone AS vRetailerPhone';
            $fields[] = 'r.tRetailerDesc AS tRetailerDesc';
            $fields[] = 'r.vRetailerEmail AS vRetailerEmail';
            $fields[] = 'r.vRetailerLink AS websiteLink';
            $fields[] = 'r.vLatitude AS vLatitude';
            $fields[] = 'r.vLongtitude AS vLongtitude';
            $fields[] = 'r.dtDate AS dtDate';
            $fields[] = 'r.eRetailerStatus AS eRetailerStatus';
            $fields[] = ' IFNULL(w.iRetailerFavStatus, 0)  AS isFavorite ';

            if (!empty($categoryID['vLatitude']) && !empty($categoryID['vLongtitude']) && !empty($categoryID['Range'])) {

                $RadiusData = $this->db->select("iRadius")
                                ->from($this->tables)
                                ->where($this->tblKeyS, 1)
                                ->get()->row_array()['iRadius'];

                if ($RadiusData > 0) {
                    $fields[] = '((ACOS(SIN(' . $categoryID['vLatitude'] . ' * PI() / 180) * SIN(r.vLatitude * PI() / 180) + COS(' . $categoryID['vLatitude'] . ' * PI() / 180) * COS(r.vLatitude * PI() / 180) * COS((' . $categoryID['vLongtitude'] . ' - r.vLongtitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance';
                    $HavingBy = ' HAVING distance <= ' . $RadiusData;
                } else {
                    $HavingBy = '';
                    return array();
                }
            }

            $fields = implode(',', $fields);

            $OrderBy = ' ORDER BY r.dtDate DESC ';

            $condition[] = ' r.eRetailerStatus = "Active" ';

            if (isset($categoryID['iCategoryID']) && $categoryID['iCategoryID'] != '')
                $condition[] = ' r.iCategoryID IN  ( ' . $categoryID['iCategoryID'] . ')';

            if (isset($categoryID['iRetailerID']) && $categoryID['iRetailerID'] != '')
                $condition[] = ' r.iRetailerID IN  ( ' . $categoryID['iRetailerID'] . ')';

            if (isset($categoryID['vRetailerName']) && $categoryID['vRetailerName'] != '')
                $condition[] = ' r.vRetailerName like "%' . addslashes($categoryID['vRetailerName']) . '%" ';

            //  GET FAVORITE LIST
            if (isset($categoryID['favStatus']) && $categoryID['favStatus'] != '')
                $condition[] = ' w.iRetailerFavStatus = "' . $categoryID['favStatus'] . '" ';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $OrderBy != '' ? $OrderBy : '';

            /* if (isset($categoryID['Range']) && $categoryID['Range'] != '') {
                $HavingBy;
            } else {
                $HavingBy = '';
            } */

            $tbl = $this->tabler;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . " as r LEFT JOIN db_rcw_read as w ON r.iRetailerID = w.iRetailerID AND vDeviceID = '" . $categoryID['vDeviceID'] . "' " . $condition . $HavingBy . $OrderBy;

            $res = $this->db->query($qry);

            $array = array();

            if ($res->num_rows() >= 0) {
                foreach ($res->result() as $row) {

                    if ($row->vRetailerLogo != '' && $row->vRetailerLogo != 'undefined') {
                        $row->vRetailerLogo = IMAGE_URL . 'Retailer/' . $row->iRetailerID . "/thumb/" . $categoryID['size'] . "/" . $row->vRetailerLogo;
                    } else {
                        $row->vRetailerLogo = '';
                    }

                    $catalogData = $this->catalogList('', $row->iRetailerID, $categoryID['vDeviceID'], $categoryID['size'], 1);

                    if (count($catalogData) > 0) {
                        $row->CATALOG = $catalogData;
                    } else {
                        $row->CATALOG = array();
                    }

                    $weeklyData = $this->weeklyAdsList('', $row->iRetailerID, $categoryID['vDeviceID'], $categoryID['size'], 1);

                    if (count($weeklyData) > 0) {
                        $row->WEEKLY = $weeklyData;
                    } else {
                        $row->WEEKLY = array();
                    }

                    $array[] = (array) $row;
                }
                return $array;
            } else {
                return array();
            }

            return $this->datatablebshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     *      TURN ON OR TURN OFF STATUS OF NOTIFICATION
     */

    function notificationStatus($favData = array()) {

        try {
            $fields[] = 'iUserID AS iUserID';
            $fields[] = 'vDeviceToken AS vDeviceToken';
            $fields[] = 'vDeviceID AS vDeviceID';
            $fields[] = 'eStatus AS eStatus';

            $fields = implode(',', $fields);

            if (isset($favData['vDeviceID']) && $favData['vDeviceID'] != '')
                $condition[] = ' vDeviceID = "' . $favData['vDeviceID'] . '" ';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->tableUSER;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;

            $res = $this->db->query($qry);

            if ($res->num_rows() > 0) {

                if (isset($favData['vNotificationStatus']) && $favData['vNotificationStatus'] != '') {
                    $insData = array(
                        'vDeviceID' => $favData['vDeviceID'],
                        'vDeviceToken' => $favData['vDeviceToken'],
                        'eStatus' => $favData['vNotificationStatus'],
                    );

                    $id = $res->row_array()['iUserID'];
                    $this->db->update($this->tableUSER, $insData, array($this->tblKeyU => $id));
                    $res = $this->db->query($qry);
                    return $res->result_array();
                } else {
                    return array();
                }
            } else {
                return array();
            }

            return $this->datatablebshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     *      UPDATE USER LOCATION FOR NOTIFICATION
     */

    function UpdateLocation($favData = array()) {

        try {
            $fields[] = 'iUserID AS iUserID';
            $fields[] = 'vDeviceToken AS vDeviceToken';
            $fields[] = 'vDeviceID AS vDeviceID';
            $fields[] = 'vLatitude AS vLatitude';
            $fields[] = 'vLongtitude AS vLongtitude';
            $fields[] = 'eStatus AS eStatus';

            $fields = implode(',', $fields);

            if (isset($favData['vDeviceID']) && $favData['vDeviceID'] != '')
                $condition[] = ' vDeviceID = "' . $favData['vDeviceID'] . '" ';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = $this->tableUSER;

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;

            $res = $this->db->query($qry);

            if ($res->num_rows() > 0) {

                $insData = array(
                    'vLongtitude' => $favData['vLongtitude'],
                    'vLatitude' => $favData['vLatitude'],
                );

                $id = $res->row_array()['iUserID'];
                $this->db->update($this->tableUSER, $insData, array($this->tblKeyU => $id));
                $res = $this->db->query($qry);
                return $res->result_array();
            } else {
                return array();
            }

            return $this->datatablebshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in UPDATE USER LOCATION function - ' . $ex);
        }
    }

    /*
     *      TURN ON OR TURN OFF STATUS OF NOTIFICATION
     */

    function feedBack($feedBackData = array()) {

        try {

            $this->load->library('email', array('mailtype' => 'html'));
            // fot the template
            $tmpltPath = DOC_ROOT . 'application/ws/views/mail_template/feedback.php';
            $mailSubject = $feedBackData['vSubject'];

            $tmpltParam['%COMMENT%'] = $feedBackData['vComment'];
            $tmpltParam['%EMAIL%'] = 'mayur.chhatrala@openxcell.com';
            $tmpltParam['%MAINTITLE%'] = 'Catalogee';
            $tmpltParam['%LOGO%'] = IMAGE_URL . "images/common/logo.png";
            $msg = $this->_template($tmpltPath, $tmpltParam);

            $this->email->to('feedback@catalogee.com');
            $this->email->from($feedBackData['vEmail']);
            $this->email->subject($mailSubject);
            $this->email->message($msg);
            $this->email->set_newline("\n");
            $this->email->set_newline("\n");

            if ($this->email->send()) {
                return "Mail Sent Successfully";
            } else {
                return "";
            }
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    private function _template($mailTemplate, $mailParam = array()) {
        try {
            /*
             * TO LOAD THE HTML CONTENT FROM THE TEMPLATE FILE...
             */
            $mailMsg = file_get_contents($mailTemplate, TRUE);

            /*
             * REPLACE EACH AND EVERY PARAM WHICH WE ARE GOING TO REPLACE...
             */
            foreach ($mailParam as $key => $val) {
                $mailMsg = str_replace($key, $val, $mailMsg);
            }
            return $mailMsg;
        } catch (Exception $ex) {
            exit('SMTPMail Model : Error in _template function - ' . $ex);
        }
    }

    /*
     *  GET MULTIPLE IMAGE
     */

    public function ImagesList($tblName, $reqID, $columnlist = array(), $thumbSize) {

        try {

            $fields[] = $columnlist[0] . " as ID ";
            $fields[] = $columnlist[1] . " as Image ";

            $fields = implode(',', $fields);

            $condition[] = ' eStatus = "Active" ';

            if (isset($reqID) && $reqID != '')
                $condition[] = $columnlist[0] . ' = ' . $reqID;

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $qry = 'SELECT ' . $fields . ' FROM ' . $tblName . $condition;

            $res = $this->db->query($qry);

            if ($res->num_rows() > 0) {
                foreach ($res->result_array() as $row) {

                    if ($row['Image'] != '' && $row['Image'] != 'undefined') {
                        $row['Thumb'] = IMAGE_URL . $columnlist[2] . '/' . $row['ID'] . "/thumb/" . $thumbSize . "/" . $row['Image'];
                        $row['Image'] = IMAGE_URL . $columnlist[2] . '/' . $row['ID'] . "/" . $row['Image'];
                    } else {
                        $row['Image'] = '';
                        $row['Thumb'] = '';
                    }
                    unset($row["ID"]);
                    $array[] = (array) $row;
                }
                return $array;
            } else {
                return array();
            }

            return $this->datatablebshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getUserRecord function - ' . $ex);
        }
    }

    /*
     *      PAGINATION 
     */

    public function pagination($pageId = 0) {

        $zeroPageRecord = 10;
        $otherPageRecord = 10;
        if ($pageId == 0) {
            /* first page load records... */
            $perPageValue = $zeroPageRecord;
        } else {
            /* second to other page records... */
            $perPageValue = $otherPageRecord;
        }
        $pageId = (int) $pageId;
        if ($pageId == 1) {
            $pageId = $zeroPageRecord * $pageId;
        } else if ($pageId > 1) {
            $pageId = (($zeroPageRecord) + ($perPageValue * ($pageId - 1)));
        }

        return ' LIMIT ' . $pageId . ',' . $perPageValue;
    }

}

// http://stylekart.net/2015/dealbase/
//  bcd61ed665742cafbaffe4d16375422f62bf122f
?>