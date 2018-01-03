<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Dashboard
 *
 * @author Admin
 */
class Crud extends CI_Controller {

    var $controller;
    var $STATUS, $MSG, $RESP;
    var $prePath;

    public function __construct() {
        parent::__construct();
        $this->prePath = 'access/';
        $this->controller = 'login';

        $this->load->model('crud_model');

        $this->STATUS = FAIL_STATUS;
        $this->MSG = INSUFF_DATA;
        $this->RESP = array(
            'STATUS' => $this->STATUS,
            'MSG' => $this->MSG
        );
    }

    function operation($type = 'I', $requestFor, $requestId = '') {
        try {
            switch ($type) {
                /*
                 * A CASE TO INSERT THE RECORDS...
                 */
                case 'I':
                    $this->RESP = $this->_addRecord($requestFor);
                    break;

                /*
                 * A CASE TO UPDATE THE RECORDS...
                 */
                case 'U':
                    $this->RESP = $this->_updateRecord($requestFor, $requestId);
                    break;

                /*
                 * A CASE TO DELETE THE RECORDS..
                 */
                case 'D':
                    $response = $this->_deleteRecord($requestFor, $requestId);
                    if ($response !== false)
                        $this->RESP = $response;
                    break;
            }

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Crud Controller : Error in operation function - ' . $ex);
        }
    }

    /*
     * A FUNCTION TO DELETE THE RECORD
     */

    private function _deleteRecord($requestFor, $requestId) {
        try {
            if ($requestFor !== '' && $requestId !== '') {
                return $this->crud_model->deleteRecord($requestFor, $requestId);
            } return false;
        } catch (Exception $ex) {
            throw new Exception('Crud Controller : Error in _deleteRecord function - ' . $ex);
        }
    }

    /*
     * TO CREATE A NEW ENTRY
     */

    private function _addRecord($requestFor) {
        try {
            if ($requestFor !== '') {

                if (isset($_POST) && !empty($_POST)) {
                    $request = $_POST;
                } else {
                    $postdata = file_get_contents("php://input");
                    $request = json_decode($postdata);
                }


                /*
                 * SAVE IN THE DATABASE
                 */
                return $this->crud_model->addRecord($requestFor, $request);
            } return false;
        } catch (Exception $ex) {
            throw new Exception('Crud Controller : Error in _addRecord function - ' . $ex);
        }
    }

    /*
     * TO UPDATE A ENTRY
     */

    private function _updateRecord($requestFor, $requestId) {
        try {
            if ($requestFor !== '' && $requestId !== '') {
                if ($_POST) {
                    $request = $_POST;
                } else {
                    $postdata = file_get_contents("php://input");
                    $request = json_decode($postdata);
                }

                /*
                 * SAVE IN THE DATABASE
                 */
                return $this->crud_model->updateRecord($requestFor, $request, $requestId);
            } return false;
        } catch (Exception $ex) {
            throw new Exception('Crud Controller : Error in _updateRecord function - ' . $ex);
        }
    }

}
