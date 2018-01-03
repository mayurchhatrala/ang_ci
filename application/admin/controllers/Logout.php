<?php



if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}



/**

 * Description of Dashboard

 *

 * @author Admin

 */

class Logout extends CI_Controller {



    var $controller;

    var $viewData;

    var $STATUS, $MSG, $RESP;

    var $prePath;



    public function __construct() {

        parent::__construct();

        $this->prePath = 'access/';

        $this->controller = 'logout';

        $this->viewData = array();



        $this->load->model('login_model');



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
			
			 $this->session->unset_userdata();
            $this->session->sess_destroy();
            
            redirect($this->controller,'refresh');

            

        } catch (Exception $ex) {

            throw new Exception('Login Controller : Error in index function - ' . $ex);

        }

    }



}

