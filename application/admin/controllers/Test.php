<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of General
 * @author Admin
 */
class Test extends CI_Controller {

    var $controller;
    var $viewData;
    var $STATUS, $MSG, $RESP;
    var $prePath;

    public function __construct() {
        parent::__construct();
        $this->prePath = 'email/';
        $this->controller = '';
        $this->viewData = array();

        $this->STATUS = FAIL_STATUS;
        $this->MSG = INSUFF_DATA;
        $this->RESP = array(
            'STATUS' => $this->STATUS,
            'MSG' => $this->MSG
        );
    }

    function email_template() {
        $view['{%PROJECT_LOGO%}'] = UPLD_URL;

        $this->load->view($this->prePath . 'user/register', $view);
    }

    function send_mail() {


        $to = 'chintan.goswami@openxcelltechnolabs.com';

        $mailId = 1;

        $this->mailParam['{%PROJECT_LOGO%}'] = UPLD_URL . 'images/common/logo.png';
        $this->mailParam['{%PROJECT_TITLE%}'] = PROJ_TITLE;
        $this->mailParam['{%PROJECT_URL%}'] = BASE_URL;
        $this->mailParam['{%REGISTER_USER%}'] = 'Chintan Goswami';
        $this->mailParam['{%REGISTER_TYPE%}'] = 'Sub Admin';
        $this->mailParam['{%USER_NAME%}'] = 'chintan.goswami@openxcelltechnolabs.com';
        $this->mailParam['{%PASSWORD%}'] = '123456789';
        $this->mailParam['{%LOGIN_LINK%}'] = BASE_URL . 'login';
        $this->mailParam['{%EMAIL_BROWSE_URL%}'] = BASE_URL . 'email/view/' . base64_encode($mailId);


        $this->mailSubject = PROJ_TITLE . ' Register User';
        $this->mailTemplate = VIEW_DIR_EMAIL . 'user/register.php';

        $this->load->library('maillib');
        //$this->_setEmailParams($requestFor, $requestObject);
        //$to = $requestFor[$this->mailID];

        $this->maillib->sendMail($to, $this->mailSubject, $this->mailTemplate, $this->mailParam);
    }

}
