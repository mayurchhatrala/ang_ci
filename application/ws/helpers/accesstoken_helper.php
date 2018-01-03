<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('genratemac')) {


    function genratemac($userid) {

        $api_key_variable = config_item('rest_key_name');
        $key_name = 'HTTP_' . strtoupper(str_replace('-', '_', $api_key_variable));
        $key = $_SERVER[$key_name];

        $mac = hash_hmac('md5', $key, $userid);
        $ci = &get_instance();

        $key_id = $ci->db->get_where('keys', array('key' => $key))->row()->id;

        $userHmac = array("prHmac" => $mac);
        $insertData = array(
            'prUserID' => $userid,
            'vHmac' => $mac,
            'key_id' => $key_id,
            'dtCreated' => date('Y-m-d h:i:s')
        );
        $ci->db->insert('tbl_hmac', $insertData);

        if ($ci->db->affected_rows() > 0) {
            // UPDATE USER
            $ci->db->update('pruser', array('prHmac' => $mac), array('prUserID' => $userid));
            return $mac;
        } else {
            return "";
        }
    }

    function checkmac() {
        // mprd($_SERVER);
        // mprd($_SERVER);

        /* $ci = &get_instance();
          $q = $ci->db->get_where('tbl_hmac', array('prUserID' => $_SERVER['HTTP_' . strtoupper(str_replace('-', '_', 'prUserID'))], 'vHmac' => $_SERVER['HTTP_' . strtoupper(str_replace('-', '_', 'accesstoken'))]));
          echo $ci->db->last_query();
          exit; */

        if (isset($_SERVER['HTTP_' . strtoupper(str_replace('-', '_', 'prUserID'))]) && $_SERVER['HTTP_' . strtoupper(str_replace('-', '_', 'prUserID'))] != "" && isset($_SERVER['HTTP_' . strtoupper(str_replace('-', '_', 'accesstoken'))]) && $_SERVER['HTTP_' . strtoupper(str_replace('-', '_', 'accesstoken'))] != "") {
            $ci = & get_instance();
            $q = $ci->db->get_where('tbl_hmac', array('prUserID' => $_SERVER['HTTP_' . strtoupper(str_replace('-', '_', 'prUserID'))], 'vHmac' => $_SERVER['HTTP_' . strtoupper(str_replace('-', '_', 'accesstoken'))]));
            if ($q->num_rows() > 0) {
                $q = $q->row_array();
                $api_key_variable = config_item('rest_key_name');

                if (hash_hmac('md5', $_SERVER['HTTP_' . strtoupper(str_replace('-', '_', $api_key_variable))], $q['prUserID']) == $_SERVER['HTTP_' . strtoupper(str_replace('-', '_', 'accesstoken'))]) {
                    return true;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function getuserid() {
        return $_SERVER['HTTP_' . strtoupper(str_replace('-', '_', 'prUserID'))];
    }

    function delete_key() {
        $key = $_SERVER['HTTP_X_API_KEY'];
        $ci = & get_instance();
        if ($ci->db->get_where('keys', array('key' => $key))->num_rows() > 0) {
            $ci->db->delete('keys', array('key' => $key));
        }
    }

    function getEmailFromUserID() {
        $ci = & get_instance();
        return $ci->db->get_where('pruser', array('prUserID' => getuserid()))->row()->prEmail;
    }
    
    function getUserTypeFromUserID() {
        $ci = & get_instance();
        return $ci->db->get_where('pruser', array('prUserID' => getuserid()))->row()->prLoginType;
    }

}