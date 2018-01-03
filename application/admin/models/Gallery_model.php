<?php

/**
 * Description of admin_model
 * @author Admin
 */
class Gallery_Model extends CI_Model {

    var $tbl;

    function __construct() {
        parent::__construct();
    }

    /*
     * TO GET LIST OF EMAIL TEMPLATES ...
     */

    public function getGalleryRecord($requestId = '', $isEdit = FALSE) {
        try {
            $fields[] = 'tg.iGalleryID AS galleryId';
            $fields[] = 'tg.iGalleryID AS DT_RowId';
            $fields[] = 'tg.vGalleryName AS galleryName';
            $fields[] = '(SELECT COUNT(*) FROM tbl_gallery_image AS tgi WHERE tg.iGalleryID IN(tgi.iGalleryID) )AS totalImage';
            $fields[] = 'eStatus AS status';

            $fields = implode(',', $fields);

            $condition = array();
            if ($requestId !== '')
                $condition[] = 'tg.iGalleryID = "' . $requestId . '"';

            $condition = !empty($condition) ? ' WHERE ' . implode(' AND ', $condition) : '';

            $tbl = 'tbl_gallery AS tg';

            $qry = 'SELECT ' . $fields . ' FROM ' . $tbl . $condition;
            $res = $this->db->query($qry);

            if ($requestId !== '' && $isEdit) {
                $row = $res->row_array();
                return $row;
            } else if ($requestId == '' && $isEdit == TRUE)
                return array();

            return $this->datatableshelper->query($qry);
        } catch (Exception $ex) {
            throw new Exception('User Model : Error in getEmailRecord function - ' . $ex);
        }
    }

    /*
     * TO SAVE THE GALLERY NAME
     */

    function saveGalleryName($galleryName = '', $saveId = 0) {
        try {
            if ($galleryName != '') {
                if ($saveId > 0) {
                    /*
                     * UPDATE THE GALLERY RECORD  
                     */
                    $updt = array(
                        'vGalleryName' => $galleryName
                    );

                    $this->db->update('tbl_gallery', $updt, array('iGalleryID' => $saveId));
                    return (int) $saveId;
                } else {
                    /*
                     * INSERT THE GALLERY RECORD
                     */
                    $ins = array(
                        'vGalleryName' => $galleryName,
                        'tCreatedAt' => date('Y-m-d H:i:s', time())
                    );
                    $this->db->insert('tbl_gallery', $ins);
                    return $this->db->insert_id();
                }
            } return 0;
        } catch (Exception $ex) {
            throw new Exception('Error in ' . __CLASS__ . ' : ' . __FUNCTION__ . ' - ' . $ex);
        }
    }

    /*
     * TO SAVE THE GALLERY IMAGE TO THE 
     * EXPECTED GALLERY 
     */

    function saveGalleryImage($imageName = '', $galleryId = 0) {
        try {
            if ($imageName != '' && $galleryId > 0) {
                $ins = array(
                    'iGalleryID' => $galleryId,
                    'vImageName' => $imageName,
                    'tCreatedAt' => date('y-m-d H:i:s', time())
                );
                $this->db->insert('tbl_gallery_image', $ins);

                return array(
                    'image' => UPLD_URL . 'gallery/' . $galleryId . '/thumb/512/' . $imageName,
                    'url' => UPLD_URL . 'gallery/' . $galleryId . '/thumb/512/' . $imageName,
                    'id' => $this->db->insert_id()
                );
            }
        } catch (Exception $ex) {
            throw new Exception('Error in ' . __CLASS__ . ' : ' . __FUNCTION__ . ' - ' . $ex);
        }
    }

    /*
     * DELETE THE IMAGE
     */

    function deleteImage($imageId = 0) {
        try {
            if ($imageId > 0) {
                $rec = $this->db->get_where('tbl_gallery_image', array('iImageID' => $imageId))->row_array();
                if (isset($rec['iGalleryID'])) {
                    $galleryId = $rec['iGalleryID'];
                    $imageName = $rec['vImageName'];
                    $this->db->delete('tbl_gallery_image', array('iImageID' => $imageId));

                    /*
                     * REMOVE IMAGE 
                     */
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
                    $this->fupload->fDelete($imageName);

                    return 1;
                } return 1;
            } return -1;
        } catch (Exception $ex) {
            throw new Exception('Error in ' . __CLASS__ . ' : ' . __FUNCTION__ . ' - ' . $ex);
        }
    }

    /*
     * TO GET ALL THE IMAGES
     */

    function getFormData($galleryId = 0) {
        try {
            if ($galleryId != 0) {
                $Grec = $this->db->get_where('tbl_gallery', array('iGalleryID' => $galleryId))->result_array();
                $rec = $this->db->get_where('tbl_gallery_image', array('iGalleryID' => $galleryId))->result_array();

                $return = array();

                if (!empty($Grec)) {
                    foreach ($Grec as $key => $val) {
                        $return['info'] = array(
                            'galleryId' => $val['iGalleryID'],
                            'galleryName' => $val['vGalleryName']
                        );
                    }
                }
                if (!empty($rec)) {
                    foreach ($rec as $key => $val) {
                        $return['files'][] = array(
                            'id' => (int) $val['iImageID'],
                            'image' => UPLD_URL . 'gallery/' . $galleryId . '/thumb/512/' . $val['vImageName'],
                            'url' => UPLD_URL . 'gallery/' . $galleryId . '/thumb/512/' . $val['vImageName']
                        );
                    }

                    return $return;
                } return array();
            } return array();
        } catch (Exception $ex) {
            throw new Exception('Error in ' . __CLASS__ . ' : ' . __FUNCTION__ . ' - ' . $ex);
        }
    }

}
