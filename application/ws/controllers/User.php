<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require(APPPATH . '/libraries/REST_Controller.php');

/**
 * Description of login
 * @author OpenXcell Technolabs
 */
class User extends REST_Controller {

    var $MSG;
    var $STATUS;
    var $resp;

    function __construct() {
        parent::__construct();
        $this->MSG = INSUFF_DATA;
        $this->STATUS = FAIL_STATUS;
        $this->resp = array('MESSAGE' => $this->MSG, 'STATUS' => $this->STATUS);
        $this->load->model('user_model');
    }

    /*
     * WHEN USER POST LOGIN TO
     * URL : http://www.your-site/ws/login/index/
     * WITH REQUIRE PARAMETER
     *      - PIN-ID*
     *      - DEVICE-ID
     */

    function add_post() {

        /*
         * TO CHECK ALL THE PARAMETER ARE BEING PASSED OR NOT ?
         */

        $allowParam = array("vDeviceToken", "vDeviceID");

        if (checkselectedparams($this->post(), $allowParam)) {

            /*
             *      TO CHECK WETHEAR USER IS LOGGED IN OR NOT..
             */
            // if ($this->user_model->checkDeviceID($this->post('vDeviceToken'), $this->post('vDeviceID'))) {

            $result = $this->user_model->addUser($this->post());

            if (!empty($result)) {
                $this->resp = array(
                    'MESSAGE' => USER_UPDT_SUCC,
                    'STATUS' => SUCCESS_STATUS,
                );
            } else {
                $this->resp = array(
                    'MESSAGE' => USER_INS_SUCC,
                    'STATUS' => SUCCESS_STATUS
                );
            }
            /* } else {
              $this->resp = array(
              'MESSAGE' => 'Device alredy in use.',
              'STATUS' => FAIL_STATUS
              );
              } */
        }

        $this->response($this->resp, 200);
    }
    
    /*
     *  CHECK USER 
     */
    function add1_post() {

        /*
         * TO CHECK ALL THE PARAMETER ARE BEING PASSED OR NOT ?
         */

        $allowParam = array("vDeviceToken", "vDeviceID");

        if (checkselectedparams($this->post(), $allowParam)) {

            /*
             *      TO CHECK WETHEAR USER IS LOGGED IN OR NOT..
             */
            $result = $this->user_model->addUser1($this->post());
            
            $this->resp = array(
                    'MESSAGE' => USER_UPDT_SUCC,
                    'STATUS' => SUCCESS_STATUS,
                );
            
            /* if ($result == '2') {
                $this->resp = array(
                    'MESSAGE' => USER_UPDT_SUCC,
                    'STATUS' => SUCCESS_STATUS,
                );
            } else if ($result == '1') {
                $this->resp = array(
                    'MESSAGE' => USER_INS_SUCC,
                    'STATUS' => SUCCESS_STATUS
                );
            } else {
                $this->resp = array(
                    'MESSAGE' => INSUFF_DATA,
                    'STATUS' => FAIL_STATUS
                );
            } */
        }
        $this->response($this->resp, 200);
    }
    
    /*
     *  CHECK USER 
     */
    function add2_post() {

        /*
         * TO CHECK ALL THE PARAMETER ARE BEING PASSED OR NOT ?
         */

        $allowParam = array("vDeviceToken", "vDeviceID");

        if (checkselectedparams($this->post(), $allowParam)) {

            /*
             *      TO CHECK WETHEAR USER IS LOGGED IN OR NOT..
             */
            $result = $this->user_model->addUser2($this->post());
            
            $this->resp = array(
                    'MESSAGE' => USER_UPDT_SUCC,
                    'STATUS' => SUCCESS_STATUS,
                );
            
            /* if ($result == '2') {
                $this->resp = array(
                    'MESSAGE' => USER_UPDT_SUCC,
                    'STATUS' => SUCCESS_STATUS,
                );
            } else if ($result == '1') {
                $this->resp = array(
                    'MESSAGE' => USER_INS_SUCC,
                    'STATUS' => SUCCESS_STATUS
                );
            } else {
                $this->resp = array(
                    'MESSAGE' => INSUFF_DATA,
                    'STATUS' => FAIL_STATUS
                );
            } */
        }
        $this->response($this->resp, 200);
    }

    /*
     * YOU MAY GOT THE STATUS FROM THIS FUNCTION...
     *  actually line of code is increasing so, better option is that we have to define another function...
     */

    private function _returnStatus($result, $status = 'Inactive', $MESSAGE) {
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
                        'MESSAGE' => $MESSAGE,
                        'STATUS' => SUCCESS_STATUS,
                        'USERDATA' => $result,
                    );
                    break;
            }
        } catch (Exception $ex) {
            exit('Login Controll : Error in _returnFunction : ' . $ex);
        }
    }

}
