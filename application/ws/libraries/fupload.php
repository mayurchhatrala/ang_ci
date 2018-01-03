<?php

/**
 * Description of fupload
 * @author Chintan Goswami
 */
class FUpload {

    protected $CI, $defaultRatio;
    protected $fConfig, $fThumbConfig, $fBasePath, $fUploadType;
    protected $fType, $fLimit, $fLoc, $fThumb, $fCopyText;
    protected $fUploaded, $fGenUploadValue, $fUploadError;
    protected $fHeight, $fWidth;

    public function __construct($fileObj = array()) {
        $this->CI = &get_instance();
        $this->fBasePath = UPLD_DIR;
        $this->defaultRatio = 150;
        /*
         * TO LOAD UPLOAD LIBRARY
         */
        $this->CI->load->library('upload');

        /*
         * TO INITIALIZE THE CONFIGURATION
         * 1.0
         */
        $this->_fConfig($fileObj);
    }

    /*
     * CONFIGURATION OF THE FILE UPLOAD REQUIRE VALUE...
     * 1.0
     */

    private function _fConfig($fileObj = array()) {
        try {
            /*
             * TO CREATE THE DYNAMIC VARIABLES...
             * WHICH ARE ACTUALLY PASS FROM THE REQUESTED SIDE...
             */
            foreach ($fileObj AS $K => $V) {
                $this->$K = $V;
            }

            /*
             * INITIALIZE THE UPLOAD LIBRARY VALUES...
             * 1.0.1
             */
            $this->_fInit();

            /*
             * SET FILE UPLOADING CONFIGURATION VALUE
             * 1.0.2
             */
            $this->_fConfigValue();
        } catch (Exception $ex) {
            throw new Exception('FUpload Library : Error in _config function');
        }
    }

    /*
     * INITIALIZE THE UPLOAD LIBRARY OBJECT / VALUES...
     * 1.0.1
     */

    private function _fInit() {
        try {
            /*
             * INITIALIZE THE UPLOAD PATH
             * 1.0.1.1
             */
            $this->_fInitPath();

            /*
             * SET FILE-TYPE
             * 1.0.1.2
             */
            $this->_fInitFileType();
        } catch (Exception $ex) {
            throw new Exception('FUpload Library : Error in _init function - ' . $ex);
        }
    }

    /*
     * INITIALIZE THE UPLAOD PATH [ DEFAULT ]
     * 1.0.1.1
     */

    private function _fInitPath() {
        try {
            extract($this->fLoc);
            //_print_r($this->fLoc);

            /*
             * TO CREATE THE DIRECTORY...
             * 1.0.1.1.1 
             */
            $this->_fCreateDir($key, $id);
        } catch (Exception $ex) {
            throw new Exception('FUpload Library : Error in _fInitPath function - ' . $ex);
        }
    }

    /*
     * TO CREATE THE NEW DIRECTORY... 
     * 1.0.1.1.1
     */

    private function _fCreateDir($baseDir, $subDir = '') {
        try {
            $this->fBasePath .= $baseDir . '/';
            if (!is_dir($this->fBasePath))
                mkdir($this->fBasePath, 0777, TRUE);

            if ($subDir != '') {
                $this->fBasePath .= $subDir . '/';
                if (!is_dir($this->fBasePath))
                    mkdir($this->fBasePath, 0777, TRUE);
            }
        } catch (Exception $ex) {
            throw new Exception('FUpload Library : Error in _fCreateDir function - ' . $ex);
        }
    }

    /*
     * SET THE FILE TYPE
     * 1.0.1.2
     */

    private function _fInitFileType() {
        try {
            switch ($this->fType) {
                case 'image' :
                    $this->fUploadType = 'gif|jpg|png|jpeg';
                    break;

                case 'video' :
                    $this->fUploadType = 'mp4|wmv|mkv|3gp|avi';
                    break;

                case 'files' :
                    $this->fUploadType = 'txt|pdf|doc|docx|ppt';
                    break;

                case 'other' :
                    $this->fUploadType = 'rar|jar|exe|zip';
                    break;

                default :
                    $this->fUploadType = 'gif|jpg|png|jpeg';
                    break;
            }
        } catch (Exception $ex) {
            throw new Exception('FUpload Library : Error in _fInitFileType function - ' . $ex);
        }
    }

    /*
     * SET CONFIGURATION VALUE
     * 1.0.2
     */

    private function _fConfigValue() {
        try {
            /*
             * SET UPLOAD FILE PATH
             */
            $this->fConfig['upload_path'] = $this->fBasePath;

            /*
             * ALLOW FILE TYPE
             */
            $this->fConfig['allowed_types'] = $this->fUploadType;

            /*
             * ALLOW MAXIMU FILE SIZE...
             * CONVER INTO BYTES...
             */
            $this->fConfig['max_size'] = 1024 * (int) $this->fLimit;

            /*
             * ENCRYPT YOUR FILE NAME
             * IF NEEDED, SET IT 'TRUE'
             * OTHER-WISE SET IT 'FALSE'
             */
            $this->fConfig['encrypt_name'] = TRUE;
        } catch (Exception $ex) {
            throw new Exception('FUpload Library : Error in _fConfigValue function - ' . $ex);
        }
    }

    /*
     * TO UPLOAD THE FILE TO THE DESTINATION FOLDER...
     * 2.0
     * 
     * PARAM
     *      fObj        -   FILE ARRAY WHICH IS ACTUALLY SUBMITTED EITHER 
     *                      IT WILL SINGLE OR MULTI DIMENTIONAL...
     * 
     *      fKey        -   KEY NAME OF THE FILE ARRAY
     */

    public function fUpload($fObj, $fKey = '') {
        try {
            if (!empty($fObj) && $fKey !== '') {
                /*
                 * PREPARE A ARRAY TO UPLOAD THE FILES...
                 * 2.0.1
                 */

                $this->_fGenUploadValue($fObj[$fKey]);

                /*
                 * INITIALIZE FILE UPLOADING CONFIGURATION...
                 * WHICH WE HAVE LOADED THE UPLOAD LIBRARY
                 */
                $this->CI->upload->initialize($this->fConfig);


                /*
                 * UPLOAD ALL THE FILES..
                 */
                $len = count($this->fGenUploadValue);
                for ($i = 0; $i < $len; $i++) {

                    $_FILES['uploading'] = $this->fGenUploadValue[$i];

                    if ($this->CI->upload->do_upload('uploading')) {
                        extract($this->CI->upload->data('uploading'));
                        $this->fUploaded[] = $file_name;
                    } else {
                        //echo 'in';
                        $this->fUploadError[] = $this->CI->upload->display_errors();
                    }
                }

                /*
                 * ADD THE COPYRIGHT TEXT
                 * 2.0.2
                 */
                if ($this->fType == 'image') {
                    if ($this->fCopyText) {
                        $this->_fCopyRightText();
                    }
                }

                /*
                 * CREATE THE THUMBNAILS..
                 */
                if ($this->fThumb) {
                    /*
                     * CALL A FUNCTION TO CREATE THE IMAGE THUMBNAIL
                     * 2.0.3
                     */
                    $this->_fThumbsUp();
                }

                return $this->fUploaded;
            } return '';
        } catch (Exception $ex) {
            throw new Exception('FUpload Library : Error in fUpload function - ' . $ex);
        }
    }

    /*
     * CONVERT ANY IMAGE TO JPG
     */

    private function _fToJPG() {
        try {
            
        } catch (Exception $ex) {
            throw new Exception('FUpload Library : Error in _fToJPG function - ' . $ex);
        }
    }

    /*
     * PREPARE A ARRAY TO UPLOAD THE FILES
     * 2.0.1
     */

    private function _fGenUploadValue($fObj) {
        try {
            $isMultiple = gettype($fObj['name']) === 'string' ? FALSE : TRUE;
            if ($isMultiple) {
                $len = count($fObj['name']);
                for ($i = 0; $i < $len; $i++) {
                    $this->fGenUploadValue[$i] = array(
                        'name' => $fObj['name'][$i],
                        'type' => $fObj['type'][$i],
                        'tmp_name' => $fObj['tmp_name'][$i],
                        'error' => $fObj['error'][$i],
                        'size' => $fObj['size'][$i]
                    );
                }
            } else {
                $this->fGenUploadValue[0] = array(
                    'name' => $fObj['name'],
                    'type' => $fObj['type'],
                    'tmp_name' => $fObj['tmp_name'],
                    'error' => $fObj['error'],
                    'size' => $fObj['size']
                );
            }
        } catch (Exception $ex) {
            throw new Exception('FUpload Library : Error in _fGenUploadValue function - ' . $ex);
        }
    }

    /*
     * TO UPLOAD THE COPYRIGHT TEXT
     * 2.0.2
     */

    private function _fCopyRightText() {
        try {
            /*
             * CREAT THE IMAGE FROM THE FILE EXTENSION
             */
            putenv('GDFONTPATH=' . dirname(__FILE__));
            $len = count($this->fUploaded);
            for ($i = 0; $i < count($len); $i++) {
                $fPath = $this->fBasePath . $this->fUploaded[$i];

                $FILE_EXTENSION = strtolower(pathinfo($fPath, PATHINFO_EXTENSION));
                switch ($FILE_EXTENSION) {
                    case 'jpg' :
                        $IMAGE = imagecreatefromjpeg($fPath);
                        break;

                    case 'jpeg' :
                        $IMAGE = imagecreatefromjpeg($fPath);
                        break;

                    case 'gif' :
                        $IMAGE = imagecreatefromgif($fPath);
                        break;

                    case 'png' :
                        $IMAGE = imagecreatefrompng($fPath);
                        break;
                }

                //_print_r($IMAGE);

                /*
                 * LOAD THE FONT
                 */
                $FONT = FONT_DIR . 'Calibri.ttf';

                /*
                 * SET FONT COLOR CODE
                 */
                //$COLOR1 = imagecolorallocate($IMAGE, 128, 128, 128);
                $TEXT_COLOR = imagecolorallocate($IMAGE, 255, 255, 255);

                /*
                 * ADD TEXT TO THE IMAGE
                 */
                list($fW, $fH) = getimagesize($fPath);
                $FONT_SIZE = 10;
                if ($fW <= 200 || $fH <= 200) {
                    $FONT_SIZE = 8;
                }
                imagettftext($IMAGE, 10, 0, ($fW - (7 * strlen(IMAGE_COPYRIGHT_TEXT))), $fH - 20, $TEXT_COLOR, $FONT, IMAGE_COPYRIGHT_TEXT);

                switch ($FILE_EXTENSION) {
                    case 'jpg' :
                        imagejpeg($IMAGE, $fPath);
                        break;

                    case 'jpeg' :
                        imagejpeg($IMAGE, $fPath);
                        break;

                    case 'gif' :
                        imagegif($IMAGE, $fPath);
                        break;

                    case 'png' :
                        imagepng($IMAGE, $fPath);
                        break;
                }

                /*
                 * DESTROY THE IMAGE
                 */
                imagedestroy($IMAGE);
            }
        } catch (Exception $ex) {
            throw new Exception('FUpload Library : Error in _fCopyRightText function - ' . $ex);
        }
    }

    /*
     * TO CREATE THE IMAGE THUMBNAILS...
     * 2.0.3
     */

    private function _fThumbsUp() {
        try {
            $len = count($this->fUploaded);
            for ($i = 0; $i < $len; $i++) {
                $fPath = $this->fBasePath . $this->fUploaded[$i];
                $fThumbPath = $this->fBasePath . 'thumb/' . $this->fUploaded[$i];

                /*
                 * TO CREATE THE THUMBNAIL FOLDER
                 */
                if (!is_dir($this->fBasePath . 'thumb/'))
                    mkdir($this->fBasePath . 'thumb/', 0777, TRUE);

                /*
                 * FETCH THE HEIGHT AND WIDTH OF THE UPLOADED IMAGE
                 */

                if ((isset($this->fWidth) && $this->fWidth != '') && isset($this->fHeight) && $this->fHeight != '') {
                    $fSize = array(
                        'W' => $this->fWidth,
                        'H' => $this->fHeight
                    );
                } else {
                    $imgList = list($fW, $fH) = getimagesize($fPath);
                    $imgRatio = $this->defaultRatio / min($fW, $fH);

                    $fSize = array(
                        'W' => $fW * $imgRatio,
                        'H' => $fH * $imgRatio
                    );
                }

                /*
                 * CONFIGURE THUMBANIL VALUES
                 * 2.0.3.1
                 */
                $this->_fInitThumbConfig($fPath, $fThumbPath, $fSize);

                /*
                 * LOAD THE IMAGE LIBRARY
                 */
                $this->CI->load->library('image_lib', $this->fThumbConfig);

                /*
                 * CLEAR IMAGE LIBARY VALUE BEFORE INITIALIZE
                 */
                $this->CI->image_lib->clear();

                /*
                 * INITIALIZE THE IMAGE LIBRARY
                 */
                $this->CI->image_lib->initialize($this->fThumbConfig);

                /*
                 * RESIZE THE IMAGE
                 */
                if (!$this->CI->image_lib->resize()) {
                    $this->fUploadError[] = $this->CI->image_lib->display_errors();
                }
            }
        } catch (Exception $ex) {
            throw new Exception('FUpload Library : Error in _fThumbsUp function - ' . $ex);
        }
    }

    /*
     * THUMBNAIL CONFIGURATION...
     * 2.0.3.1
     */

    private function _fInitThumbConfig($fPath, $fThumbPath, $fSize) {
        try {
            if ($fPath !== '' && $fThumbPath !== '' && !empty($fSize)) {
                $this->fThumbConfig = array(
                    'image_library' => 'gd2',
                    'maintain_ratio' => (isset($this->fRatioMaintain) ? $this->fRatioMaintain : TRUE),
                    'create_thumb' => FALSE,
                    'source_image' => $fPath,
                    'new_image' => $fThumbPath,
                    'width' => $fSize['W'],
                    'height' => $fSize['H']
                );
            }
        } catch (Exception $ex) {
            throw new Exception('FUpload Library : Error in _fInitThumbConfig function - ' . $ex);
        }
    }

}
