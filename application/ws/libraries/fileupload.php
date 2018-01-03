<?php

/**
 * Description of pickup_model
 * @author OpenXcell Technolabs
 */
class FileUpload {

    var $config, $thumbConfig;
    var $defaultpath, $fileType, $maxSize, $requireThumb;

    function __construct($fileType = array()) {
        $this->CI = &get_instance();

        $this->CI->load->library('upload');

        if (!empty($fileType)) {
            $this->_initialize($fileType);
        }
    }

    /*
     * JUST CREATE THE THUMBNAIL...
     * PARAM
     *      - IMAGES    :   array(
     *                          0   =>      array(
     *                                          'name' => 'abc.jpg',
     *                                          'path' => 'D:/xampp/htdocs/project/images/'
     *                                      )
     *                          ....
     *                      )
     */

    function genThumb($images = array(), $ratio = 150) {
        try {
            //mprd($images);
            if (!empty($images)) {
                $thumbConfig['image_library'] = 'gd2';
                $thumbConfig['maintain_ratio'] = TRUE;
                $thumbConfig['create_thumb'] = FALSE;

                for ($i = 0; $i < count($images); $i++) {

                    $imageName = $images[$i]['name'];
                    $imagePath = $images[$i]['path'];

                    $actualPath = $imagePath . $imageName;
                    $thumbPath = $imagePath . 'thumb/' . $imageName;

                    $img_list = list($img_w, $img_h) = getimagesize($actualPath);
                    $img_ratio = $ratio / min($img_w, $img_h);

                    $new_size = array(
                        'width' => $img_w * $img_ratio,
                        'height' => $img_h * $img_ratio
                    );

                    $thumbConfig['source_image'] = $actualPath;
                    $thumbConfig['new_image'] = $thumbPath;
                    $thumbConfig['width'] = $new_size['width'];
                    $thumbConfig['height'] = $new_size['height'];

                    $this->CI->load->library('image_lib', $thumbConfig);
                    $this->CI->image_lib->clear();
                    $this->CI->image_lib->initialize($thumbConfig);

                    if (!$this->CI->image_lib->resize()) {
                        //echo $this->CI->image_lib->display_errors();
                    }
                }
            }
        } catch (Exception $ex) {
            exit('FileUpload Library : Error in genThumb function - ' . $ex);
        }
    }

    /*
     * PREPARE FUNCTION WHICH UPLOADS THE FILE(S)...
     * PARAM
     *      - FILE_ARRY     :   file array that we are uploading...
     *      - FILE_ARRY_KEY :   file array key for using we preparing a array...
     */

    function upload($fileArry = array(), $fileArryKey = '') {
        try {
            $uploadedFiles = array();
            $fileArry = $this->_prepareArry($fileArry[$fileArryKey]);

            //mprd($fileArry);

            $this->CI->upload->initialize($this->config);

            //mprd($this->CI->upload);



            for ($i = 0; $i < count($fileArry); $i++) {
                $_FILES['image_file'] = $fileArry[$i];
                if ($this->CI->upload->do_upload('image_file')) {
                    extract($this->CI->upload->data('image_file'));
                    $uploadedFiles[] = $file_name;
                } else {
                    //echo 'in';
                    //echo $this->CI->upload->display_errors();
                }
            }

            /*
             * COPYRIGHT TEXT WILL BE HERE....
             * WATER-MARK
             */


            /*
             * TO CREATE A THUMBNAIL...
             */
            if ($this->requireThumb) {
                $this->_createThumbNail($uploadedFiles);
            }

            return $uploadedFiles;
        } catch (Exception $ex) {
            exit('FileUpload Model : Error in upload function - ' . $ex);
        }
    }

    /*
     * TO REMOVE FILES
     */

    function removeFile() {
        $this->CI->load->helper("file");
        delete_files($this->defaultpath . "/");
    }

    /*
     * CREATE THUMBNAIL...
     */

    private function _createThumbNail($fileArry, $ratio = 200) {
        $this->_thumbConfig();
        for ($i = 0; $i < count($fileArry); $i++) {
            $actualPath = $this->defaultpath . $fileArry[$i];
            $thumbPath = $this->defaultpath . 'thumb/' . $fileArry[$i];

            $img_list = list($img_w, $img_h) = getimagesize($actualPath);
            $img_ratio = $ratio / min($img_w, $img_h);

            $new_size = array(
                'width' => $img_w * $img_ratio,
                'height' => $img_h * $img_ratio
            );

            $this->thumbConfig['source_image'] = $actualPath;
            $this->thumbConfig['new_image'] = $thumbPath;
            $this->thumbConfig['width'] = $new_size['width'];
            $this->thumbConfig['height'] = $new_size['height'];

            $this->CI->load->library('image_lib', $this->thumbConfig);
            $this->CI->image_lib->clear();
            $this->CI->image_lib->initialize($this->thumbConfig);

            if (!$this->CI->image_lib->resize()) {
                //echo $this->CI->image_lib->display_errors();
            }
        }
    }

    private function _thumbConfig() {
        $this->thumbConfig['image_library'] = 'gd2';
        $this->thumbConfig['maintain_ratio'] = TRUE;
        $this->thumbConfig['create_thumb'] = FALSE;
    }

    /*
     * PREPARE ARRAY TO POST TO THE UPLOAD CLASS...
     */

    private function _prepareArry($arry) {
        $returnArry = array();

        $isMultiple = gettype($arry['name']) === 'string' ? FALSE : TRUE;
        if ($isMultiple) {
            $arryLen = count($arry['name']);
            for ($i = 0; $i < $arryLen; $i++) {
                $returnArry[$i]['name'] = $arry['name'][$i];
                $returnArry[$i]['type'] = $arry['type'][$i];
                $returnArry[$i]['tmp_name'] = $arry['tmp_name'][$i];
                $returnArry[$i]['error'] = $arry['error'][$i];
                $returnArry[$i]['size'] = $arry['size'][$i];
            }
        } else {
            $returnArry[0]['name'] = $arry['name'];
            $returnArry[0]['type'] = $arry['type'];
            $returnArry[0]['tmp_name'] = $arry['tmp_name'];
            $returnArry[0]['error'] = $arry['error'];
            $returnArry[0]['size'] = $arry['size'];
        }

        return $returnArry;
    }

    /*
     * TO SET THE VALUE OF REQUESTED VARIABLE...
     */

    private function _initialize($arry) {

        /*
         * TO CREATE THE DYNAMIC VARIABLE...
         */

        foreach ($arry as $key => $val) {
            $this->$key = $val;
        }

        /*
         * INITIALIZE CONFIGURATION....
         */
        $this->_initConfig();
    }

    /*
     * TO INITIALIZE CONFIGURATION...
     */

    private function _initConfig() {

        /*
         * TO SET TARGETED PATH...
         */
        $this->_setTargetedPath();

        /*
         * TO SET THE FILE TYPE...
         */
        $this->_setFileUploadType();

        /*
         * TO SET THE CONFIGURATION VALUE...
         */
        $this->config['upload_path'] = $this->defaultpath;
        $this->config['allowed_types'] = $this->uploadType;
        $this->config['max_size'] = 1024 * (int) $this->maxSize;
        $this->config['encrypt_name'] = TRUE;
    }

    /*
     * TO SET THE DEFAULT TARGETED PATH...
     */

    private function _setTargetedPath() {
        extract($this->uploadFor);

        $this->defaultpath = UPLOADS;

        switch ($key) {

            case 'restaurant' :
                $this->defaultpath .= 'restaurant/';
                $this->_createDIR();

                $this->defaultpath .= $id . '/';
                $this->_createDIR(TRUE);
                break;

            case 'restaurantPhoto' :
                $this->defaultpath .= 'restaurantPhoto/';
                $this->_createDIR();

                $this->defaultpath .= $id . '/';
                $this->_createDIR(TRUE);
                break;

            case 'restaurantMenu' :
                $this->defaultpath .= 'restaurantMenu/';
                $this->_createDIR();

                $this->defaultpath .= $id . '/';
                $this->_createDIR(TRUE);
                break;

            default :
                $this->defaultpath .= 'restaurant/';
                $this->_createDIR();

                $this->defaultpath .= $id . '/';
                $this->_createDIR(TRUE);
                break;
        }
    }

    /*
     * TO CREATE THE DIRECTORY...
     */

    private function _createDIR($thumb = FALSE) {

        !is_dir($this->defaultpath) ? mkdir($this->defaultpath, 0777, TRUE) : '';

        if ($thumb) {
            !is_dir($this->defaultpath . 'thumb/') ? mkdir($this->defaultpath . 'thumb/', 0777, TRUE) : '';
        }
    }

    /*
     * TO SET THE FILE UPLOAD TYPE...
     */

    private function _setFileUploadType() {
        switch ($this->fileType) {
            case 'image' :
                $this->uploadType = 'gif|jpg|png|jpeg';   // image file allow only...
                break;

            case 'text' :
                $this->uploadType = 'txt';   // text file allow only...
                break;

            case 'video' :
                $this->uploadType = 'mp4|wmv|mkv|3gp|avi';   // video file allow only...
                break;

            default :
                $this->uploadType = 'gif|jpg|png|jpeg';   // image file allow only...
                break;
        }
    }

}
