<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Email
 *
 * @author Admin
 */
class Email extends CI_Controller {

    var $controller;
    var $viewData;
    var $STATUS, $MSG, $RESP;
    var $prePath;

    public function __construct() {
        parent::__construct();
        $this->prePath = 'email/';
        $this->controller = 'email';
        $this->viewData = array();

        $this->load->model('email_model');

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

    public function view($target = '') {
        try {
            if ($target != '') {
                $obj = $this->email_model->getEmailContent($target);

                $templatePath = $obj['vTemplatePath'];
                $mailObj = unserialize($obj['vContentObject']);
                //_print_r($mailObj);

                $templateContent = $this->db->get_where('tbl_email_templates', array('vTemplateAlias' => $templatePath))->row_array()['tTemplateContent'];

                foreach ($mailObj as $key => $val) {
                    $templateContent = str_replace($key, $val, $templateContent);
                }
                echo $templateContent;
                exit;
            }
        } catch (Exception $ex) {
            throw new Exception('Login Controller : Error in index function - ' . $ex);
        }
    }

}
