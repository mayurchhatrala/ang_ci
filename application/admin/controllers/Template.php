<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of General
 * @author Admin
 */
class Template extends CI_Controller {

    var $controller;
    var $viewData;
    var $STATUS, $MSG, $RESP;
    var $prePath;

    public function __construct() {
        parent::__construct();
        $this->prePath = 'template/';
        $this->controller = 'email';
        $this->viewData = array();
        
        $this->load->model('template_model');

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

    public function emailList($isHtml = 'n') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
                    $this->viewData['pagePermission'] = addslashes(json_encode($this->default_model->pagePermission('template.email.list')));
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

    public function getEmailRecord() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
             */
            $response = $this->template_model->getEmailRecord();
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
            throw new Exception('User Controller : Error in getEmailRecord function - ' . $ex);
        }
    }

    /*
     * TO LOAD THE HTML
     */

    public function emailForm($isHtml = 'n', $requestId = '') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
                    $this->viewData['pagePermission'] = addslashes(json_encode($this->default_model->pagePermission('app.permission.type')));
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
     * TO GET THE LIST USERS RECORDS...
     */

    public function emailFormData() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
             */
            $response = $this->template_model->getEmailRecord($request->requestId, true);
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

}
