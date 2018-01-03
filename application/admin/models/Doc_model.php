<?php

/**
 * Description of admin_model
 * @author Admin
 */
class Doc_Model extends CI_Model {

    var $tbl;

    function __construct() {
        parent::__construct();
    }

    /*
     * GET ALL SUPPORTED TYPE
     */

    function getSupportType() {
        try {
            $record = $this->db->get_where('tbl_ws_format')->result_array();

            $return = array();
            foreach ($record as $key => $val) {
                $return[$key]['formatId'] = (int) $val['iFormatID'];
                $return[$key]['formatName'] = $val['vFormatName'];
            }

            if (!empty($return)) {
                return array(
                    'RECORD' => $return,
                    'STATUS' => SUCCESS_STATUS,
                    'MSG' => REC_FOUND
                );
            } return array(
                'STATUS' => FAIL_STATUS,
                'MSG' => NO_RECORD
            );
        } catch (Exception $ex) {
            throw new Exception('Error in getSupportType function - ' . $ex);
        }
    }

    /*
     * GET ALL SUPPORTED TYPE
     */

    function getSupportInputFormat() {
        try {
            $record = $this->db->get_where('tbl_ws_input_format')->result_array();

            $return = array();
            foreach ($record as $key => $val) {
                $return[$key]['formatId'] = (int) $val['iInputFormatID'];
                $return[$key]['formatName'] = $val['vInputFormatName'];
            }

            if (!empty($return)) {
                return array(
                    'RECORD' => $return,
                    'STATUS' => SUCCESS_STATUS,
                    'MSG' => REC_FOUND
                );
            } return array(
                'STATUS' => FAIL_STATUS,
                'MSG' => NO_RECORD
            );
        } catch (Exception $ex) {
            throw new Exception('Error in getSupportInputFormat function - ' . $ex);
        }
    }

    /*
     * GET ALL WEB SERVICES LIST
     */

    function getAllWS() {
        try {
            $record = $this->db->get_where('tbl_ws_info')->result_array();

            $return = array();
            foreach ($record as $key => $val) {
                $return[$key]['wsId'] = (int) $val['iWSID'];
                $return[$key]['wsTitle'] = $val['vWSTitle'];
                $return[$key]['wsDesc'] = $val['vWSDesc'];
                $return[$key]['wsType'] = $val['eWSType'];
                $return[$key]['wsURL'] = $val['vWSURL'];
            }

            if (!empty($return)) {
                return array(
                    'RECORD' => $return,
                    'STATUS' => SUCCESS_STATUS,
                    'MSG' => REC_FOUND
                );
            } return array(
                'STATUS' => FAIL_STATUS,
                'MSG' => NO_RECORD
            );
        } catch (Exception $ex) {
            throw new Exception('Error in getAllWS function - ' . $ex);
        }
    }

    /*
     * TO GET THE SELECTED 
     * WEB SERVICE RECORD...
     */

    function getWSRecord($wsId) {
        try {
            if ($wsId != '') {

                return array(
                    'info' => $this->_basicInfo($wsId),
                    'header' => $this->_headerInfo($wsId),
                    'input' => $this->_inputInfo($wsId),
                    'output' => $this->_outputInfo($wsId)
                );
            } return -1;
        } catch (Exception $ex) {
            throw new Exception('Error in getWSRecord function - ' . $ex);
        }
    }

    /*
     * TO GET WEB SERVICE 
     * BASIC INFORMATIONS...
     */

    private function _basicInfo($wsId = 0) {
        try {
            if ($wsId != 0) {
                $rec = $this->db->get_where('tbl_ws_info', array('iWSID' => $wsId))->row_array();
                $return = array();
                if (!empty($rec)) {
                    $return['id'] = $wsId;
                    $return['title'] = $rec['vWSTitle'];
                    $return['type'] = $rec['eWSType'];
                    $return['url'] = $rec['vWSURL'];
                    $return['desc'] = $rec['vWSDesc'];
                    $return['format'] = $this->_getSelectSupportFormat($wsId);
                }
                return $return;
            }
        } catch (Exception $ex) {
            throw new Exception('Error in _basicInfo function - ' . $ex);
        }
    }

    /*
     * TO GET SELECTED SUPPORTED FORMAT
     */

    private function _getSelectSupportFormat($wsId = 0) {
        try {
            if ($wsId != 0) {
                $this->db->select('*');
                $this->db->from('tbl_ws_supp_format');
                $this->db->join('tbl_ws_format', 'tbl_ws_supp_format.iFormatID = tbl_ws_format.iFormatID');
                $this->db->where('tbl_ws_supp_format.iWSID', $wsId);

                $rec = $this->db->get()->result_array();
                $return = array();
                if (!empty($rec)) {
                    foreach ($rec as $key => $val) {
                        $return[$key]['id'] = (int) $val['iFormatID'];
                        $return[$key]['name'] = $val['vFormatName'];
                    }
                }

                return $return;
            }
        } catch (Exception $ex) {
            throw new Exception('Error in _getSelectSupportFormat function - ' . $ex);
        }
    }

    /*
     * TO GET WEB SERVICE 
     * BASIC INFORMATIONS...
     */

    private function _headerInfo($wsId = 0) {
        try {
            if ($wsId != 0) {
                $rec = $this->db->get_where('tbl_ws_header', array('iWSID' => $wsId))->result_array();
                $return = array();
                if (!empty($rec)) {
                    foreach ($rec as $key => $val) {
                        $return[$key]['id'] = $val['iHeaderID'];
                        $return[$key]['title'] = $val['vHeaderName'];
                        $return[$key]['value'] = $val['vHeaderValue'];
                    }
                }

                return $return;
            }
        } catch (Exception $ex) {
            throw new Exception('Error in _headerInfo function - ' . $ex);
        }
    }

    /*
     * TO GET WEB SERVICE 
     * BASIC INFORMATIONS...
     */

    private function _inputInfo($wsId = 0) {
        try {
            if ($wsId != 0) {
                $rec = $this->db->get_where('tbl_ws_input', array('iWSID' => $wsId))->result_array();
                $return = array();
                if (!empty($rec)) {
                    foreach ($rec as $key => $val) {
                        $return[$key]['id'] = $val['iWSInputID'];
                        $return[$key]['name'] = $val['vInputName'];
                        $return[$key]['value'] = $val['vInputDefaultValue'];
                        $return[$key]['type'] = $this->db->get_where('tbl_ws_input_format', array('iInputFormatID' => $val['iInputFormatID']))->row_array()['vInputFormatName'];
                        $return[$key]['typeId'] = $val['iInputFormatID'];
                        $return[$key]['require'] = $val['eInputRequire'];
                        $return[$key]['desc'] = $val['tInputDesc'];
                    }
                }

                return $return;
            }
        } catch (Exception $ex) {
            throw new Exception('Error in _inputInfo function - ' . $ex);
        }
    }

    /*
     * TO GET WEB SERVICE 
     * BASIC INFORMATIONS...
     */

    private function _outputInfo($wsId = 0) {
        try {
            if ($wsId != 0) {
                $rec = $this->db->get_where('tbl_ws_output', array('iWSID' => $wsId))->row_array();
                $return = array();
                if (!empty($rec)) {
                    $return['id'] = $rec['iOutputID'];
                    $return['success'] = $rec['tSuccValue'];
                    $return['fail'] = $rec['tFailValue'];
                }

                return $return;
            }
        } catch (Exception $ex) {
            throw new Exception('Error in _outputInfo function - ' . $ex);
        }
    }

    /*
     * TO DELETE THE WEB SERVICE
     */

    function deleteWS($wsId = 0) {
        try {
            if ($wsId != 0) {
                $this->db->delete('tbl_ws_info', array('iWSID' => $wsId));
                return 1;
            } return -1;
        } catch (Exception $ex) {
            throw new Exception('Error in deleteWS function - ' . $ex);
        }
    }

    /*
     * TO ADD A NEW WEB SERVICE
     */

    function addWS($record) {
        try {
            if (!empty($record)) {
                $record = objToArray($record);
                $wsRequestedId = $record['wsId'];
                $record = $record['object'];


                $info = $record['info'];
                $head = $record['head'];
                $input = $record['input'];
                $output = $record['output'];

//                if ($wsId != 0) {
//                    $this->db->delete('tbl_ws_info', array('iWSID' => $wsId));
//                }

                /* SAVE BASIC INFO */
                $wsId = $this->_saveBasicInfo($info, $wsRequestedId);

                /* SAVE SUPPORT FOMAT */
                $this->_saveSupportFormat($info, $wsId, $wsRequestedId);

                /* SAVE HEADER DATA */
                $this->_saveHeaderInfo($head, $wsId, $wsRequestedId);

                /* SAVE INPUT DATA */
                $this->_saveInputInfo($input, $wsId, $wsRequestedId);

                /* SAVE OUTPUT DATA */
                $this->_saveOutputInfo($output, $wsId, $wsRequestedId);

                return 1;
            } return -1;
        } catch (Exception $ex) {
            throw new Exception('Error in addWS function - ' . $ex);
        }
    }

    /*
     * TO SAVE BASIC INFO
     */

    private function _saveBasicInfo($info, $wsRequestedId = 0) {
        try {
            if (!empty($info)) {
                if ($wsRequestedId > 0) {
                    $updt = array(
                        'vWSTitle' => $info['wsTitle'],
                        'eWSType' => $info['wsType'],
                        'vWSURL' => $info['wsURL'],
                        'vWSDesc' => isset($info['wsDesc']) ? $info['wsDesc'] : '',
                    );

                    $this->db->update('tbl_ws_info', $updt, array('iWSID' => $wsRequestedId));
                    return $wsRequestedId;
                } else {
                    $ins = array(
                        'vWSTitle' => $info['wsTitle'],
                        'eWSType' => $info['wsType'],
                        'vWSURL' => $info['wsURL'],
                        'vWSDesc' => isset($info['wsDesc']) ? $info['wsDesc'] : '',
                        'tCreatedAt' => date('Y-m-d H:i:s')
                    );

                    $this->db->insert('tbl_ws_info', $ins);
                    return $this->db->insert_id();
                }
            } return 0;
        } catch (Exception $ex) {
            throw new Exception('Error in _saveBasicInfo function - ' . $ex);
        }
    }

    /*
     * TO SAVE BASIC INFO
     */

    private function _saveSupportFormat($info, $wsId, $wsRequestedId = 0) {
        try {
            if (!empty($info) && $wsId != 0) {

                if ($wsRequestedId > 0) {
                    $this->db->delete('tbl_ws_supp_format', array('iWSID' => $wsRequestedId));
                }
                //_print_r($info['wsSuportedFormat'], TRUE);

                if (isset($info['wsSuportedFormat'])) {
                    foreach ($info['wsSuportedFormat'] as $key => $val) {
                        if ($key != 0 && (bool) $val) {
                            $ins = array(
                                'iWSID' => $wsId,
                                'iFormatID' => $key
                            );

                            $this->db->insert('tbl_ws_supp_format', $ins);
                        }
                    }
                }
            } return 0;
        } catch (Exception $ex) {
            throw new Exception('Error in _saveBasicInfo function - ' . $ex);
        }
    }

    /*
     * TO SAVE HEADER INFO
     */

    private function _saveHeaderInfo($header, $wsId, $wsRequestedId = 0) {
        try {
            if (!empty($header) && $wsId != 0) {

                if ($wsRequestedId > 0) {
                    $this->db->delete('tbl_ws_header', array('iWSID' => $wsRequestedId));
                }

                $ins = array(
                    'iWSID' => $wsId
                );
                foreach ($header as $key => $val) {
                    $ins['vHeaderName'] = $val['title'];
                    $ins['vHeaderValue'] = isset($val['value']) ? $val['value'] : NULL;

                    $this->db->insert('tbl_ws_header', $ins);
                } return 1;
            } return 0;
        } catch (Exception $ex) {
            throw new Exception('Error in _saveHeaderInfo function - ' . $ex);
        }
    }

    /*
     * TO SAVE INPUT INFO
     */

    private function _saveInputInfo($input, $wsId, $wsRequestedId = 0) {
        try {
            if (!empty($input) && $wsId != 0) {

                if ($wsRequestedId > 0) {
                    $this->db->delete('tbl_ws_input', array('iWSID' => $wsRequestedId));
                }

                $ins = array(
                    'iWSID' => $wsId
                );
                foreach ($input as $key => $val) {
                    $ins['vInputName'] = $val['name'];
                    $ins['iInputFormatID'] = $val['typeId'];
                    $ins['vInputDefaultValue'] = $val['value'];
                    $ins['eInputRequire'] = $val['require'];
                    $ins['tInputDesc'] = $val['desc'];

                    $this->db->insert('tbl_ws_input', $ins);
                } return 1;
            } return 0;
        } catch (Exception $ex) {
            throw new Exception('Error in _saveInputInfo function - ' . $ex);
        }
    }

    /*
     * TO SAVE OUTPUT INFO
     */

    private function _saveOutputInfo($output, $wsId, $wsRequestedId = 0) {
        try {
            if (!empty($output) && $wsId != 0) {
                if ($wsRequestedId > 0) {
                    $this->db->delete('tbl_ws_output', array('iWSID' => $wsRequestedId));
                }

                $ins = array(
                    'iWSID' => $wsId,
                    'tSuccValue' => $output['success'],
                    'tFailValue' => $output['fail']
                );

                $this->db->insert('tbl_ws_output', $ins);
                return 1;
            } return 0;
        } catch (Exception $ex) {
            throw new Exception('Error in _saveOutputInfo function - ' . $ex);
        }
    }

}
