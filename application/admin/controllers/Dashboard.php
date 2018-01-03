<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Dashboard
 *
 * @author Admin
 */
class Dashboard extends CI_Controller {

    var $controller;
    var $viewData;
    var $prePath;

    public function __construct() {
        parent::__construct();
        $this->prePath = 'app/';
        $this->controller = 'dashboard';
        $this->viewData = array();
        $this->load->model('dashboard_model');
    }

    public function index($isHtml = 'n') {
        
        $response['category'] = $this->dashboard_model->total_category();
        $response['retailer'] = $this->dashboard_model->total_retailer();
        $response['banner'] = $this->dashboard_model->total_banner();
        $response['weeklyads'] = $this->dashboard_model->total_weeklyads();
        
        $this->viewData['pagename'] = $this->controller;
        $this->viewData['data'] = $response;
        
        switch ($isHtml) {
            case 'y' :
                $this->viewData['userPermission'] = $this->default_model->pagePermission('app.user.list');
                $this->viewData['adminTypePermission'] = $this->default_model->pagePermission('app.permission.type');
                $this->load->view($this->prePath . $this->controller . '/index', $this->viewData);
                break;

            default :
                $this->load->view('default', $this->viewData);
                break;
        }
    }

}
