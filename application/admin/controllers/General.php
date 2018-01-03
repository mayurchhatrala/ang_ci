<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of General
 * @author Admin
 */
class General extends CI_Controller {

    var $controller;
    var $viewData;
    var $STATUS, $MSG, $RESP;
    var $prePath;

    public function __construct() {
        parent::__construct();
        $this->prePath = 'app/';
        $this->controller = 'general';
        $this->viewData = array();

        $this->STATUS = FAIL_STATUS;
        $this->MSG = INSUFF_DATA;
        $this->RESP = array(
            'STATUS' => $this->STATUS,
            'MSG' => $this->MSG
        );
    }

    function getAllAdminTypes() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            $this->load->model('permission_model');
            $adminTypes = $this->default_model->getAdminTypes();

            $json = array(
                'STATUS' => SUCCESS_STATUS,
                'MSG' => 'Record found successfully',
                'DATA' => $adminTypes
            );

            echo json_encode($json);
        } catch (Exception $ex) {
            throw new Exception('Error in getAllAdminTypes function - ' . $ex);
        }
    }

    /*
     * GET ALL PAGES
     */

    function getAllPages() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            $allPages = getMenuListWithPermission();
            //_print_r($allPages, TRUE);
            
            $returnArr = array();
            foreach ($allPages AS $mKey => $mVal) {
                $mPages = $mVal['pages'];
                for ($i = 0; $i < count($mPages); $i++) {
                    $permissionsArr = $mPages[$i]['permission'];
                    if ($this->session->userdata('ADMINTYPE') == 1 || !empty($permissionsArr)) {
                        $tmp['id'] = $mPages[$i]['id'];
                        $tmp['name'] = $mPages[$i]['name'];

                        $returnArr[] = $tmp;
                    }
                }
            }

            $json = array(
                'STATUS' => SUCCESS_STATUS,
                'MSG' => 'Record found successfully',
                'DATA' => $returnArr
            );

            echo json_encode($json);
        } catch (Exception $ex) {
            throw new Exception('Error in getAllPages function - ' . $ex);
        }
    }

}
