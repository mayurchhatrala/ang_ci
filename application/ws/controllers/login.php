<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require(APPPATH . '/libraries/REST_Controller.php');

/**
 * Description of login
 * @author OpenXcell Technolabs
 */
class Login extends REST_Controller {

    var $MSG;
    var $STATUS;
    var $resp;

    function __construct() {
        parent::__construct();
        $this->MSG = INSUFF_DATA;
        $this->STATUS = FAIL_STATUS;
        $this->resp = array('MESSAGE' => $this->MSG, 'STATUS' => $this->STATUS);
        $this->load->model('login_model');

    }

    /*
     * WHEN USER POST LOGIN TO
     * URL : http://www.your-site/ws/login/index/
     * WITH REQUIRE PARAMETER
     *      - PIN-ID*
     *      - DEVICE-ID
     */

    function index_post() {
        /*
         * TO CHECK ALL THE PARAMETER ARE BEING PASSED OR NOT ?
         */

        $allowParam = array("prUserName", "prPassword");


        if (checkselectedparams($this->post(), $allowParam)) {

            /*
             * TO CHECK WETHEAR USER IS LOGGED IN OR NOT..
             *  PARAMATER
             *      PINID*
             *      DEVICE-ID
             */
            $result = $this->login_model->checkAuthentication($this->post());

            if (!empty($result)) {

                $id = $result;

                $this->load->model('general_model');
                $row = $this->general_model->getUserByid($id);
                $this->_returnStatus($row, $row['prStatus']);
            } else {
                $this->resp = array(
                    'MESSAGE' => LOGIN_INVALID,
                    'STATUS' => FAIL_STATUS
                );
            }
        }

        $this->response($this->resp, 200);
    }

    /*
     * WHEN USER POST LOGIN TO
     * URL : http://www.your-site/ws/login/index/
     * WITH REQUIRE PARAMETER
     *      - PIN-ID*
     *      - DEVICE-ID
     */

    function fb_post() {
        /*
         * TO CHECK ALL THE PARAMETER ARE BEING PASSED OR NOT ?
         */

        $allowParam = array("prFbID");


        if (checkselectedparams($this->post(), $allowParam)) {

            /*
             * TO CHECK WETHEAR USER IS LOGGED IN OR NOT..
             *  PARAMATER
             *      PINID*
             *      DEVICE-ID
             */
            $result = $this->login_model->checkFBAuthentication($this->post());

            if (!empty($result)) {

                $id = $result;

                $this->load->model('general_model');
                $row = $this->general_model->getUserByid($id);
                $this->_returnStatus($row, $row['prStatus']);
            } else {
                $this->resp = array(
                    'MESSAGE' => LOGIN_INVALID,
                    'STATUS' => FAIL_STATUS
                );
            }
        }

        $this->response($this->resp, 200);
    }

    /*
     * YOU MAY GOT THE STATUS FROM THIS FUNCTION...
     *  actually line of code is increasing so, better option is that we have to define another function...
     */

    private function _returnStatus($result, $status = 'Inactive') {
        try {
            switch ($status) {
                case 'Inactive' :
                    $this->resp = array(
                        'MESSAGE' => ACCOUNT_DEACTIVE,
                        'STATUS' => FAIL_STATUS
                    );
                    break;

                case 'Active' :
                    $this->resp = array(
                        'MESSAGE' => LOG_SUCCESS,
                        'STATUS' => SUCCESS_STATUS,
                        'USERDATA' => $result
                    );
                    break;
            }
        } catch (Exception $ex) {
            exit('Login Controll : Error in _returnFunction : ' . $ex);
        }
    }

}
