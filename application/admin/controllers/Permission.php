<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Admin
 *
 * @author Admin
 */
class Permission extends CI_Controller {

    var $controller;
    var $viewData;
    var $STATUS, $MSG, $RESP;
    var $prePath;

    public function __construct() {
        parent::__construct();
        $this->prePath = 'app/';
        $this->controller = 'permission';
        $this->viewData = array();

        $this->load->model('permission_model');

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

    public function adminType($isHtml = 'n') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
                    $this->viewData['pagePermission'] = addslashes(json_encode($this->default_model->pagePermission('app.permission.type')));
                    $this->load->view($this->prePath . $this->controller . '/type/list', $this->viewData);
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

    public function getAdminTypeRecord() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
             */
            $response = $this->permission_model->getAdminTypeRecord();
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
            throw new Exception('User Controller : Error in getRecord function - ' . $ex);
        }
    }

    function adminTypeFormRecord() {
        try {
            
        } catch (Exception $ex) {
            throw new Exception('Error in adminTypeFormRecord function - ' . $ex);
        }
    }

    /*
     * TO LOAD THE HTML
     */

    public function adminTypeForm($isHtml = 'n', $requestId = '') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
                    $this->viewData['pagePermission'] = addslashes(json_encode($this->default_model->pagePermission('app.permission.type')));
                    $this->viewData['adminTypes'] = $this->permission_model->getAdminTypeRecord()['aaData'];
                    $this->load->view($this->prePath . $this->controller . '/type/form', $this->viewData);
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

    public function adminTypeFormData() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
             */
            $response = $this->permission_model->getAdminTypeRecord($request->requestId, true);
            //_print_r($response);
            if (!empty($response)) {
                $this->RESP = array(
                    'STATUS' => SUCCESS_STATUS,
                    'MSG' => REC_FOUND,
                    'RECORD' => $response
                );
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
     * -----------------------------------------
     * PERMISSION RECORD
     * TO LOAD THE HTML
     */

    public function adminPermission($isHtml = 'n') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
                    $this->viewData['pagePermission'] = addslashes(json_encode($this->default_model->pagePermission('app.permission.list')));
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

    public function getAdminPermissionRecord() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
             */
            $response = $this->permission_model->getAdminPermissionRecord();
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
            throw new Exception('User Controller : Error in getRecord function - ' . $ex);
        }
    }

    /*
     * TO LOAD THE HTML
     */

    public function adminPermissionForm($isHtml = 'n', $requestId = '') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
                    $this->viewData['pagePermission'] = addslashes(json_encode($this->default_model->pagePermission('app.permission.list')));
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

    public function adminPermissionFormData() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
             */
            $response = $this->permission_model->getAdminPermissionRecord($request->requestId, true);
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

    function savePermission() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        $res = $this->permission_model->updatePermission($request);

        echo json_encode($res);
    }

    /*
     * TO LOAD THE HTML
     */

    public function adminModules($isHtml = 'n') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
                    $this->viewData['pagePermission'] = addslashes(json_encode($this->default_model->pagePermission('app.modules.list')));
                    $this->load->view($this->prePath . $this->controller . '/modules/list', $this->viewData);
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

    public function getAdminModulesRecord() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
             */
            $response = $this->permission_model->getAdminModulesRecord();
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
            throw new Exception('User Controller : Error in getRecord function - ' . $ex);
        }
    }

    /*
     * TO LOAD THE HTML
     */

    public function adminModulesForm($isHtml = 'n', $requestId = '') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
                    $this->viewData['pagePermission'] = addslashes(json_encode($this->default_model->pagePermission('app.modules.list')));
                    $this->load->view($this->prePath . $this->controller . '/modules/form', $this->viewData);
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

    public function adminModulesFormData() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
             */
            $response = $this->permission_model->getAdminModulesRecord($request->requestId, true);
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

    public function adminPages($isHtml = 'n') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
                    $this->viewData['pagePermission'] = addslashes(json_encode($this->default_model->pagePermission('app.pages.list')));
                    $this->load->view($this->prePath . $this->controller . '/pages/list', $this->viewData);
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

    public function getAdminPagesRecord() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
             */
            $response = $this->permission_model->getAdminPagesRecord();
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
            throw new Exception('User Controller : Error in getRecord function - ' . $ex);
        }
    }

    /*
     * TO LOAD THE HTML
     */

    public function adminPagesForm($isHtml = 'n', $requestId = '') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
                    $this->viewData['pagePermission'] = addslashes(json_encode($this->default_model->pagePermission('app.pages.list')));
                    $this->viewData['modulesData'] = $this->permission_model->getAdminModulesRecord()['aaData'];
                    $this->load->view($this->prePath . $this->controller . '/pages/form', $this->viewData);
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

    public function adminPagesFormData() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
             */
            $response = $this->permission_model->getAdminPagesRecord($request->requestId, true);
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

}
