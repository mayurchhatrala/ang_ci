<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Dashboard
 *
 * @author Admin
 */
class Lock extends CI_Controller {

    var $controller;
    var $viewData;
    var $STATUS, $MSG, $RESP;
    var $prePath;

    public function __construct() {
        parent::__construct();
        $this->prePath = 'access/';
        $this->controller = 'lock';
        $this->viewData = array();

        $this->load->model('lock_model');

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
            throw new Exception('Login Controller : Error in index function - ' . $ex);
        }
    }

    /*
     * WHEN FORM IS SUBMIT
     */

    public function submit() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
             */
            $response = $this->lock_model->lockCheck($request);
            switch ($response) {
                case -1 :
                    $this->MSG = INVALID_PASS;
                    break;

                case 0 :
                    $this->MSG = INSUFF_DATA;
                    break;

                default :
                    $this->STATUS = SUCCESS_STATUS;
                    $this->MSG = SUCCESS_LOGIN;
                    break;
            }

            $this->RESP = array(
                'STATUS' => $this->STATUS,
                'MSG' => $this->MSG
            );

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Login Controller : Error in submit function - ' . $ex);
        }
    }

    /*
     * TO CHECK SESSION IS ALREADY AVAILABLE OR NOT
     */

    function sessionLock() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            $this->session->set_userdata(array('LOCKED' => $request->screenLock));
        } catch (Exception $ex) {
            throw new Exception('Login Controller : Error in sessionCheck function - ' . $ex);
        }
    }

}
