<?php

class Dashboard_model extends CI_Model {

    var $table;
    var $content;
    var $admin;

    public function __construct() {
        parent::__construct();
        $this->load->helper('cookie');
    }

    /*
     * TOTAL NUMBER OF COURIER BOY
     */

    function total_courier_boys() {
        $rec = $this->db->query("SELECT * FROM tbl_courier_boy");
        return $rec->num_rows();
    }

    /*
     * TOTAL NUMBER OF CONTRACT
     */

    function total_contracts() {
        $rec = $this->db->query("SELECT * FROM tbl_contract");
        return $rec->num_rows();
    }

    /*
     * TOTAL NUMBER OF ASSETS
     */

    function total_assets() {
        $rec = $this->db->query("SELECT * FROM tbl_assets");
        return $rec->num_rows();
    }

    /*
     * TOTAL NUMBER OF LOCATIONS
     */

    function total_locations() {
        $rec = $this->db->query("SELECT * FROM tbl_locations");
        return $rec->num_rows();
    }
    
    /*
     * TOTAL NUMBER OF PICKUP
     */

    function total_pickup() {
        $rec = $this->db->query("SELECT * FROM tbl_pickup");
        return $rec->num_rows();
    }
    
    /*
     * TOTAL NUMBER OF PICKUP
     */

    function total_category() {
        $rec = $this->db->query("SELECT * FROM db_category");
        return $rec->num_rows();
    }
    
    /*
     * TOTAL NUMBER OF PICKUP
     */

    function total_retailer() {
        $rec = $this->db->query("SELECT * FROM db_retailer");
        return $rec->num_rows();
    }
    
    /*
     * TOTAL NUMBER OF PICKUP
     */

    function total_banner() {
        $rec = $this->db->query("SELECT * FROM db_banner");
        return $rec->num_rows();
    }
    
    /*
     * TOTAL NUMBER OF PICKUP
     */

    function total_weeklyads() {
        $rec = $this->db->query("SELECT * FROM db_weekly_ads");
        return $rec->num_rows();
    }
    

}

?>