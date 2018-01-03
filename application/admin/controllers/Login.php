<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}/** * Description of Dashboard * * @author Admin 

*/class Login extends CI_Controller {

    var $controller;
    var $viewData;
    var $STATUS, $MSG, $RESP;
    var $prePath;

    public function __construct() {
        parent::__construct();
        $this->prePath = 'access/';
        $this->controller = 'login';
        $this->viewData = array();
        $this->load->model('login_model');
        $this->STATUS = FAIL_STATUS;
        $this->MSG = INSUFF_DATA;
        $this->RESP = array('STATUS' => $this->STATUS, 'MSG' => $this->MSG);
    }

/*     * TO LOAD THE HTML     */

    public function index($isHtml = 'n') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' : $this->load->view($this->prePath . $this->controller . '/index', $this->viewData);
                    break;
                default : $this->load->view('default', $this->viewData);
                    break;
            }
        } catch (Exception $ex) {
            throw new Exception('Login Controller : Error in index function - ' . $ex);
        }
    }

/*     * WHEN FORM IS SUBMIT     */

    public function submit() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);            /*             * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT             */ $response = $this->login_model->loginCheck($request);
            switch ($response) {
                case -1 : $this->MSG = INVALID_LOGIN;
                    break;
                default : $this->STATUS = SUCCESS_STATUS;
                    $this->MSG = SUCCESS_LOGIN;
                    break;
            } $this->RESP = array('STATUS' => $this->STATUS, 'MSG' => $this->MSG);
            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Login Controller : Error in submit function - ' . $ex);
        }
    }

/*     * TO LOAD THE FORGOT PASSWORD HTML     */

    public function forgotpwd($isHtml = 'n') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' : $this->load->view($this->prePath . 'forgotpwd/index', $this->viewData);
                    break;
                default : $this->load->view('default', $this->viewData);
                    break;
            }
        } catch (Exception $ex) {
            throw new Exception('Login Controller : Error in forgotpwd function - ' . $ex);
        }
    }

/*     * WHEN FORGOT FORM IS SUBMIT OR NOT     */

    public function forgotpwdSubmit() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);            /*             * TO CHECK THAT EMAIL ID IS EXISTS OR NOT             */ $response = $this->login_model->forgotpwdSubmitCheck($request);
            switch ($response) {
                case -1 : $this->MSG = INVALID_PWD_EMAIL;
                    break;
                default : $this->STATUS = SUCCESS_STATUS;
                    $this->MSG = SUCCESS_PWD;
                    break;
            } $this->RESP = array('STATUS' => $this->STATUS, 'MSG' => $this->MSG);
            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Login Controller : Error in forgotpwdSubmit function - ' . $ex);
        }
    }

/*     * HTML FOR RESET PASSWORD FORM     */

    public function resetpwd($isHtml = 'n') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' : $this->load->view($this->prePath . 'resetpwd/index', $this->viewData);
                    break;
                default : $this->load->view('default', $this->viewData);
                    break;
            }
        } catch (Exception $ex) {
            throw new Exception('Login Controller : Error in forgotpwdSubmit function - ' . $ex);
        }
    }

/*     * WHEN FORGOT FORM IS SUBMIT OR NOT     */

    public function resetpwdSubmit() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);            /*             * TO CHECK THAT EMAIL ID IS EXISTS OR NOT             */ $response = $this->login_model->resetpwdSubmitCheck($request);
            switch ($response) {
                case -1 : $this->MSG = INVALID_RESET_PWD_EMAIL;
                    break;
                default : $this->STATUS = SUCCESS_STATUS;
                    $this->MSG = SUCCESS_RESET_PWD;
                    break;
            } $this->RESP = array('STATUS' => $this->STATUS, 'MSG' => $this->MSG);
            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Login Controller : Error in forgotpwdSubmit function - ' . $ex);
        }
    }

/*     * TO CHECK SESSION IS ALREADY AVAILABLE OR NOT     */

    function sessionCheck() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $lock = $this->session->userdata('LOCKED');
            $echo = -1;
            if (time() - $this->session->userdata('LAST_ACTIVITY') > 3600) { /*             * IF ANY USER NOT ACTIVE FROM LAST ONE HOUR                  * HE / SHE WILL TIME-OUT AUTOMATICALLY AND REDIRECT TO THE LOGIN PAGE...                 * .....                 * DESTROY SESSION AND REDIRECT TO THE LOGIN PAGE                 */
                $this->default_model->chk_admin_session(TRUE);
                $echo = -1;
                $lock = FALSE;
            } else { /*             * SET LAST ACTIVITY TIME TO MAINTAIN SESSION TIME-OUT                 */
                $this->session->set_userdata(array('LAST_ACTIVITY' => time()));                /*                 * TO CHECK THAT USER IS LOGGED IN OR NOT??                 */ if ($this->session->userdata('ADMINLOGIN') == TRUE && $this->session->userdata('ADMINID') !== '') {
                    $echo = $this->session->userdata('ADMINID');
                }
            } echo json_encode(array('value' => (int) $echo, 'lock' => $lock));
        } catch (Exception $ex) {
            throw new Exception('Login Controller : Error in sessionCheck function - ' . $ex);
        }
    }

}
