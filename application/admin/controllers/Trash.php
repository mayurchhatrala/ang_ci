<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Dashboard
 *
 * @author Admin
 */
class Trash extends CI_Controller {

    var $controller;
    var $viewData;
    var $prePath;

    public function __construct() {
        parent::__construct();
        $this->prePath = 'app/';
        $this->controller = 'trash';
        $this->viewData = array();
    }

    public function index($isHtml = 'n') {
        $this->viewData['pagename'] = $this->controller;
        switch ($isHtml) {
            case 'y' :
                $this->load->view($this->prePath . $this->controller . '/index', $this->viewData);
                break;

            default :
                $this->load->view('default', $this->viewData);
                break;
        }
    }

}
