<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of General
 * @author Admin
 */
class Gallery extends CI_Controller {

    var $controller;
    var $viewData;
    var $STATUS, $MSG, $RESP;
    var $prePath;

    public function __construct() {
        parent::__construct();
        $this->prePath = 'app/';
        $this->controller = 'gallery';
        $this->viewData = array();

        $this->load->model('gallery_model');

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

    public function galleryList($isHtml = 'n') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
                    $this->viewData['pagePermission'] = addslashes(json_encode($this->default_model->pagePermission('app.gallery.list')));
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

    public function galleryRecord() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
             */
            $response = $this->gallery_model->getGalleryRecord();
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
            throw new Exception('User Controller : Error in getEmailRecord function - ' . $ex);
        }
    }

    /*
     * TO LOAD THE HTML
     */

    public function galleryForm($isHtml = 'n', $requestId = '') {
        try {
            $this->viewData['pagename'] = $this->controller;
            switch ($isHtml) {
                case 'y' :
                    $this->viewData['pagePermission'] = addslashes(json_encode($this->default_model->pagePermission('app.gallery.list')));
                    $this->load->view($this->prePath . $this->controller . '/form', $this->viewData);
                    break;

                default :
                    $this->load->view('default', $this->viewData);
                    break;
            }
        } catch (Exception $ex) {
            throw new Exception('User Controller : Error in activityView function - ' . $ex);
        }
    }

    /*
     * TO GET THE LIST USERS RECORDS...
     */

    public function galleryLogData() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * TO CHECK THAT USERNAME AND PASSWORD ARE CORRECT OR NOT
             */
            $response = getRecentActivity($request->requestId, FALSE, FALSE, $request->pageId);
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
     * TO SAVE UPLOADED IMAGE
     */

    public function saveData() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            /*
             * STEP 1 
             * SAVE GALLERY NAME 
             */
            extract($_POST);
            $galleryId = $this->gallery_model->saveGalleryName($galleryName, $saveId);

            if ($galleryId > 0) {
                if ($_FILES) {
                    $DEFAULT_PARAM = array(
                        'fType' => 'image', // file format
                        'fLimit' => 20, // maximum upload file limit 
                        'fLoc' => array(
                            'key' => 'gallery', // user     - user
                            'id' => $galleryId // user-id  - 1
                        ),
                        'fThumb' => TRUE, // only for image format
                        'fCopyText' => FALSE // only for image format
                    );

                    $this->load->library('fupload', $DEFAULT_PARAM);
                    $uploaded_files = $this->fupload->fUpload($_FILES, 'file');

                    if (!empty($uploaded_files)) {
                        for ($i = 0; $i < count($uploaded_files); $i++)
                            $images = $this->gallery_model->saveGalleryImage($uploaded_files[$i], $galleryId);
                    }
                }
            }

            echo json_encode(array('galleryId' => $galleryId, 'images' => $images));
        } catch (Exception $ex) {
            throw new Exception('Error in - ' . __CLASS__ . ' : ' . __FUNCTION__ . ' - ');
        }
    }

    /*
     * TO DELETE THE IMAGE
     */

    function deleteImage() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            $resp = $this->gallery_model->deleteImage($request->requestId);
            if ($resp == 1) {
                $this->RESP = array(
                    'MSG' => REC_DELETED,
                    'STATUS' => SUCCESS_STATUS
                );
            }

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Error in - ' . __CLASS__ . ' : ' . __FUNCTION__ . ' - ');
        }
    }

    /*
     * TO GET ALL UPLOADED IMAGES
     */

    function getFormData() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);

            if ($request->requestId != '') {
                $resp = $this->gallery_model->getFormData($request->requestId);
                if (!empty($resp)) {
                    $this->RESP = array(
                        'MSG' => REC_FOUND,
                        'STATUS' => SUCCESS_STATUS,
                        'RECORD' => $resp
                    );
                } else {
                    $this->RESP['MSG'] = NO_RECORD;
                }
            }

            echo json_encode($this->RESP);
        } catch (Exception $ex) {
            throw new Exception('Error in ' . __CLASS__ . ' : ' . __FUNCTION__ . ' - ' . $ex);
        }
    }

}
