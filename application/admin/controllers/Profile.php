<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Dashboard
 * @author Admin
 */
class Profile extends CI_Controller {

    var $controller;
    var $viewData;
    var $STATUS, $MSG, $RESP;
    var $prePath;

    public function __construct() {
        parent::__construct();
        $this->prePath = 'app/';
        $this->controller = 'profile';
        $this->viewData = array();

        $this->load->model('profile_model');

        $this->STATUS = FAIL_STATUS;
        $this->MSG = INSUFF_DATA;
        $this->RESP = array(
            'STATUS' => $this->STATUS,
            'MSG' => $this->MSG
        );
    }

    /*
     * TO LOAD THE HTML
     */

    public function index($isHtml = 'n') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :

                    $this->load->view($this->prePath . $this->controller . '/index', $this->viewData);
                    break;

                default :
                    $this->load->view('default', $this->viewData);
                    break;
            }
        } catch (Exception $ex) {
            throw new Exception('Page Controller : Error in index function - ' . $ex);
        }
    }

    /*
     * TO GET THE PROFILE RECORD
     */

    public function getProfileRecord() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            $recData = $this->profile_model->getProfileRecord($request->requestId);
            if (!empty($recData)) {
                $this->STATUS = SUCCESS_STATUS;
            }
            $this->RESP = array(
                'STATUS' => $this->STATUS,
                'RECORD' => $recData
            );

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Profile Controler : Error in getProfileRecord function - ' . $ex);
        }
    }

    /*
     * SUBMIT PROFILE
     * WILL UPDATE THE PROFILE
     */

    public function updateProfile() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * SUBMIT THE RECORD
             */
            $response = $this->profile_model->updateProfile($request);
            switch ($response) {
                case 0 :
                    $this->MSG = EMAIL_EXIST_ALREADY;
                    break;

                case 1 :
                    $this->MSG = PROFILE_UPDT_SUCCESS;
                    $this->STATUS = SUCCESS_STATUS;
                    break;
            }

            $this->RESP = array(
                'STATUS' => $this->STATUS,
                'MSG' => $this->MSG
            );

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Profile Controller : Error in updateProfile function - ' . $ex);
        }
    }

    /*
     * TO LOAD THE PASSWORD HTML
     */

    public function password($isHtml = 'n') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
                    $this->load->view($this->prePath . $this->controller . '/password', $this->viewData);
                    break;

                default :
                    $this->load->view('default', $this->viewData);
                    break;
            }
        } catch (Exception $ex) {
            throw new Exception('Page Controller : Error in password function - ' . $ex);
        }
    }

    /*
     * SUBMIT PROFILE
     * WILL UPDATE THE PASSWORD
     */

    public function updatePassword() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * SUBMIT THE RECORD
             */
            $response = $this->profile_model->updatePassword($request);
            switch ($response) {
                case -1 :
                    $this->MSG = INSUFF_DATA;
                    break;

                case 0 :
                    $this->MSG = WRONG_PASSWORD;
                    break;

                case 1 :
                    $this->MSG = PASS_NOT_MATCH;
                    break;

                case 2 :
                    $this->MSG = PASS_CHANGE_SUCC;
                    $this->STATUS = SUCCESS_STATUS;
                    break;
            }

            $this->RESP = array(
                'STATUS' => $this->STATUS,
                'MSG' => $this->MSG
            );

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Profile Controller : Error in updatePassword function - ' . $ex);
        }
    }

    /*
     * TO LOAD THE SETTINGS HTML
     */

    public function settings($isHtml = 'n') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
                    $this->load->view($this->prePath . $this->controller . '/settings', $this->viewData);
                    break;

                default :
                    $this->load->view('default', $this->viewData);
                    break;
            }
        } catch (Exception $ex) {
            throw new Exception('Page Controller : Error in password function - ' . $ex);
        }
    }

    /*
     * TO GET THE SETTINGS RECORD...
     */

    function getSettingsRecord() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            $recData = $this->profile_model->getSettingsRecord($request->requestId);
            if (!empty($recData)) {
                $this->STATUS = SUCCESS_STATUS;
            }
            $this->RESP = array(
                'STATUS' => $this->STATUS,
                'RECORD' => $recData
            );

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Profile Controller : Error in getSettingsRecord function - ' . $ex);
        }
    }

    /*
     * TO UPDATE THE SETTINGS VALUE
     */

    function updateSettings() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * SUBMIT THE RECORD
             */
            $response = $this->profile_model->updateSettings($request);
            switch ($response) {
                case -1 :
                    $this->MSG = INSUFF_DATA;
                    break;

                case 1 :
                    $this->MSG = SETTINGS_UPDT_SUCCESS;
                    $this->STATUS = SUCCESS_STATUS;
                    break;
            }

            $this->RESP = array(
                'STATUS' => $this->STATUS,
                'MSG' => $this->MSG
            );

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Profile Controller : Error in updateSettings function - ' . $ex);
        }
    }

}
