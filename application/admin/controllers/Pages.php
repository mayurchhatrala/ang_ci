<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Dashboard
 *
 * @author Admin
 */
class Pages extends CI_Controller {

    var $controller;
    var $viewData;
    var $STATUS, $MSG, $RESP;
    var $prePath;

    public function __construct() {
        parent::__construct();
        $this->prePath = 'app/';
        $this->controller = 'pages';
        $this->viewData = array();

        $this->load->model('pages_model');

        $this->STATUS = FAIL_STATUS;
        $this->MSG = INSUFF_DATA;
        $this->RESP = array(
            'STATUS' => $this->STATUS,
            'MSG' => $this->MSG
        );
    }

    /*
     * 	TO LOAD THE DEFAULT LISTING
     */

    public function index($isHtml = 'n') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
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
     * TO LOAD THE HTML
     */

    public function form($isHtml = 'n', $requestId = '') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
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
     * TO GET THE LIST PRODUCT RECORDS...
     */

    public function formData() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
             */
            $response = $this->pages_model->getPagesRecord($request->requestId, true);
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

    public function PagesRecord() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * 	TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
             */
            $response = $this->pages_model->PagesRecord();
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
     *      Check Page is alredy exists or not
     */
    public function checkPageName() {
            try {
                $postdata = file_get_contents("php://input");
                $request = json_decode($postdata);

                /*
                 * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
                 */
                $response = $this->pages_model->checkPageName($request, true);
                //_print_r($response);
                if (!empty($response)) {
                    $this->RESP = $response;
                } else {
                    $this->RESP = array(
                        'STATUS' => $this->STATUS,
                        'MSG' => "No Record"
                    );
                }

                echo json_encode($this->RESP);
            } catch (Exception $ex) {
                throw new Exception('User Controller : Error in userRecord function - ' . $ex);
            }
    }

    /*
     * CRUD OPERATION FOR PRODUCT CATEGORY
     */

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

                /*
                 * A CASE TO DELETE THE RECORDS..
                 */
                case 'A':
                    $response = $this->_activeRecord($requestFor, $requestId);
                    if ($response !== false)
                        $this->RESP = $response;
                    break;

                /* case 'AP':
                  $response = $this->_amazonProduct($requestFor, $requestId);
                  if ($response !== false)
                  $this->RESP = $response;
                  break; */
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
                return $this->pages_model->deleteRecord($requestFor, $requestId);
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
                return $this->pages_model->addRecord($requestFor, $request);
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
               
			   	if (isset($_POST) && !empty($_POST)) {
                    $request = $_POST;
                } else {
                    $postdata = file_get_contents("php://input");
                    $request = json_decode($postdata);
                }
                /*
                 * SAVE IN THE DATABASE
                 */
                return $this->pages_model->updateRecord($requestFor, $request, $requestId);
            } return false;
        } catch (Exception $ex) {
            throw new Exception('Crud Controller : Error in _updateRecord function - ' . $ex);
        }
    }

    private function _activeRecord($requestFor, $requestId) {
        try {
            if ($requestFor !== '' && $requestId !== '') {
                $postdata = file_get_contents("php://input");
                // $request = json_decode($postdata);

                /*
                 * SAVE IN THE DATABASE
                 */
                return $this->pages_model->activeRecord($requestFor, $postdata, $requestId);
            } return false;
        } catch (Exception $ex) {
            throw new Exception('Crud Controller : Error in _updateRecord function - ' . $ex);
        }
    }

    /* private function _amazonProduct($requestFor, $requestId) {
      try {
      if ($requestFor !== '' && $requestId !== '') {
      $postdata = file_get_contents("php://input");

      return $this->pages_model->amazonProduct($requestFor, $postdata, $requestId);
      } return false;
      } catch (Exception $ex) {
      throw new Exception('Crud Controller : Error in _updateRecord function - ' . $ex);
      }
      } */
}
