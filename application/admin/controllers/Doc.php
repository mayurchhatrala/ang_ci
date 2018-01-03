<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of General
 * @author Admin
 */
class Doc extends CI_Controller {

    var $controller;
    var $viewData;
    var $STATUS, $MSG, $RESP;
    var $prePath;
    var $generated_file_name;

    public function __construct() {
        parent::__construct();
        $this->prePath = 'app/';
        $this->controller = 'doc';
        $this->viewData = array();

        $this->generated_file_name = 'ws-document.zip';

        $this->load->model('doc_model');

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

    public function ws($isHtml = 'n') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
                    $this->viewData['pagePermission'] = addslashes(json_encode($this->default_model->pagePermission('app.ws.doc')));
                    $this->load->view($this->prePath . $this->controller . '/ws/list', $this->viewData);
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
     * TO GET ALL SUPPORT TYPE
     */

    function getSupportType() {
        try {
            $record = $this->doc_model->getSupportType();

            if (!empty($record)) {
                $this->RESP = $record;
            } else {
                $this->RESP = array(
                    'STATUS' => $this->STATUS,
                    'MSG' => $this->MSG
                );
            }

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Error in getSupportType function - ' . $ex);
        }
    }

    /*
     * TO GET ALL SUPPORT INPUT FORMAT
     */

    function getSupportInputFormat() {
        try {
            $record = $this->doc_model->getSupportInputFormat();

            if (!empty($record)) {
                $this->RESP = $record;
            } else {
                $this->RESP = array(
                    'STATUS' => $this->STATUS,
                    'MSG' => $this->MSG
                );
            }

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Error in getSupportInputFormat function - ' . $ex);
        }
    }

    /*
     * GET ALL WEB SERVICES LIST
     */

    function getAllWS($arry = FALSE) {
        try {
            $record = $this->doc_model->getAllWS();

            if (!empty($record)) {
                $this->RESP = $record;
            } else {
                $this->RESP = array(
                    'STATUS' => $this->STATUS,
                    'MSG' => $this->MSG
                );
            }

            if ($arry)
                return $record;

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Error in getAllWS function - ' . $ex);
        }
    }

    /*
     * TO GET THE SELECTED WEB SERVICE RECORD
     */

    function getWSRecord($wsId = 0) {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            $wsIdVal = $wsId != 0 ? $wsId : $request->wsId;
            $resp = $this->doc_model->getWSRecord($wsIdVal);
            if (!empty($resp)) {
                $this->RESP = array(
                    'STATUS' => SUCCESS_STATUS,
                    'MSG' => REC_FOUND,
                    'RECORD' => $resp
                );
            } else {
                $this->RESP = array(
                    'STATUS' => FAIL_STATUS,
                    'MSG' => NO_RECORD
                );
            }

            if ($wsId != 0)
                return $resp;

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Error in getWSRecord function - ' . $ex);
        }
    }

    /*
     * TO DELETE THE WEB SERVICE
     */

    function deleteWS() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            $resp = $this->doc_model->deleteWS($request->wsId);
            switch ($resp) {
                case -1:
                    break;

                case 1:
                    $this->RESP = array(
                        'STATUS' => SUCCESS_STATUS,
                        'MSG' => REC_DELETED
                    );
                    break;
            }

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Error in deleteWS function - ' . $ex);
        }
    }

    /*
     * TO ADD A NEW WEB SERVICE
     */

    function addWS() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            $resp = $this->doc_model->addWS($request);
            switch ($resp) {
                case -1:
                    break;

                case 1:
                    $this->RESP = array(
                        'STATUS' => SUCCESS_STATUS,
                        'MSG' => REC_ADD
                    );
                    break;
            }

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Error in addWS function - ' . $ex);
        }
    }

    /*
     * TO GET THE PREVIEW OF THE GENRATING 
     * WEB SERVICE DOCUMENTATION...
     */

    function preview() {
        try {
            $allWS = $this->getAllWS(TRUE);
            $data = array();
            foreach ($allWS['RECORD'] as $key => $val) {
                $data[] = $this->getWSRecord($val['wsId']);
            }
            $data['data'] = $data;
            $this->load->view('preview/index', $data);
        } catch (Exception $ex) {
            throw new Exception('Error in ' . __CLASS__ . ' : ' . __FUNCTION__ . ' ' . $ex);
        }
    }

    /*
     * TO DOWNLOAD THE GENERATED WEB SERVICE 
     * DOCUMENTATION AS A ZIP FORMAT...
     */

    function download() {
        try {
            $allWS = $this->getAllWS(TRUE);
            $data = array();
            foreach ($allWS['RECORD'] as $key => $val) {
                $data[] = $this->getWSRecord($val['wsId']);
            }
            $data['data'] = $data;
            $file = $this->load->view('preview/download', $data, TRUE);

            /*
             * GENERATE HTML FILE AND PUT IN IT TO THE 
             * DOWNLOAD /> DOCUMENT /> DESTINATION-FOLDER...
             */
            file_put_contents(DWNLD_DOC_DIR . 'index.html', $file);

            /*
             * DELETE OLDER ONE ZIP FILE...
             */
            unlink(DWNLD_DOC_DIR . $this->generated_file_name);

            /*
             * TO GENERATE THE ZIP FILE AT THE ROOT PATH
             */
            $this->_createZIPFile();

            unlink(DWNLD_DOC_DIR . 'index.html');
            redirect(DWNLD_DOC_URL . $this->generated_file_name);
        } catch (Exception $ex) {
            throw new Exception('Error in ' . __CLASS__ . ' : ' . __FUNCTION__ . ' ' . $ex);
        }
    }

    /*
     * TO CREATE THE ZIP FILE 
     */

    private function _createZIPFile() {
        try {
            // Get real path for our folder
            $rootPath = realpath(DWNLD_DOC_DIR);



            // Initialize archive object
            $zip = new ZipArchive();
            $zip->open(DWNLD_DOC_DIR . $this->generated_file_name, ZipArchive::CREATE | ZipArchive::OVERWRITE);

            //_print_r($zip, TRUE);
            // Create recursive directory iterator
            /** @var SplFileInfo[] $files */
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);

            foreach ($files as $name => $file) {
                // Skip directories (they would be added automatically)
                if (!$file->isDir()) {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($rootPath) + 1);

                    // Add current file to archive
                    $zip->addFile($filePath, $relativePath);
                }
            }

            // Zip archive will be created only after closing object
            $zip->close();
        } catch (Exception $ex) {
            throw new Exception('Error in ' . __CLASS__ . ' : ' . __FUNCTION__ . ' ' . $ex);
        }
    }

}
