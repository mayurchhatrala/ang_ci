<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Dashboard
 *
 * @author Admin
 */
class User extends CI_Controller {

    var $controller;
    var $viewData;
    var $STATUS, $MSG, $RESP;
    var $prePath;

    public function __construct() {
        parent::__construct();
        $this->prePath = 'app/';
        $this->controller = 'user';
        $this->viewData = array();

        $this->load->model('user_model');

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
                    $this->viewData['pagePermission'] = addslashes(json_encode($this->default_model->pagePermission('app.user.list')));
                    $this->load->view($this->prePath . $this->controller . '/list', $this->viewData);
                    break;

                default :
                    $this->load->view('default', $this->viewData);
                    break;
            }
        } catch (Exception $ex) {
            throw new Exception('User Controller : Error in index function - ' . $ex);
        }
    }

    /*
     * TO GET THE LIST USERS RECORDS...
     */

    public function userRecord() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
             */
            $response = $this->user_model->getUserRecord();
            //_print_r($response);
            if (!empty($response)) {
                $this->RESP = $response;
            } else {
                $this->RESP = array(
                    'STATUS' => $this->STATUS,
                    'MSG' => $this->MSG
                );
            }

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('User Controller : Error in userRecord function - ' . $ex);
        }
    }

    /*
     * TO LOAD THE HTML
     */

    public function form($isHtml = 'n', $requestId = '') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
                    $this->load->model('permission_model');
                    $this->viewData['adminTypeVal'] = $this->permission_model->getAdminTypeRecord()['aaData'];
                    $this->viewData['pagePermission'] = addslashes(json_encode($this->default_model->pagePermission('app.user.list')));
                    $this->load->view($this->prePath . $this->controller . '/form', $this->viewData);
                    break;

                default :
                    $this->load->view('default', $this->viewData);
                    break;
            }
        } catch (Exception $ex) {
            throw new Exception('User Controller : Error in index function - ' . $ex);
        }
    }

    /*
     * TO SAVE THE RECORD
     */

    function saveRecord() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            $response = $this->user_model->saveRecord($request);
            switch ($response) {
                case -1 :
                    $this->STATUS = FAIL_STATUS;
                    $this->MSG = INSUFF_DATA;
                    break;

                case 0 :
                    $this->STATUS = SUCCESS_STATUS;
                    $this->MSG = USER_UPDT_SUCC;
                    break;

                default :
                    $this->STATUS = SUCCESS_STATUS;
                    $this->MSG = USER_INS_SUCC;
                    break;
            }

            $this->RESP = array(
                'STATUS' => $this->STATUS,
                'MSG' => $this->MSG
            );

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('User Controller : Error in saveRecord function - ' . $ex);
        }
    }

    /*
     * TO GET THE LIST USERS RECORDS...
     */

    public function formData() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
             */
            $response = $this->user_model->getUserRecord($request->requestId, true);
            //_print_r($response);
            if (!empty($response)) {
                $this->RESP = $response;
            } else {
                $this->RESP = array(
                    'STATUS' => $this->STATUS,
                    'MSG' => $this->MSG
                );
            }

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('User Controller : Error in userRecord function - ' . $ex);
        }
    }
    
    /*
     * TO LOAD THE HTML
     */

    public function googleMap($isHtml = 'n', $requestId = '') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
                    $this->load->model('permission_model');
                    $this->viewData['pagePermission'] = addslashes(json_encode($this->default_model->pagePermission('app.google.map')));
                    $this->load->view($this->prePath . $this->controller . '/map/view', $this->viewData);
                    break;

                default :
                    $this->load->view('default', $this->viewData);
                    break;
            }
        } catch (Exception $ex) {
            throw new Exception('User Controller : Error in index function - ' . $ex);
        }
    }
    

}
