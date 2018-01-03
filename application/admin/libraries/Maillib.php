<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require(APPPATH . '/libraries/phpmailer/PHPMailerAutoload.php');

/**
 * Description of maillib
 * @author Admin
 */
class MailLib extends PHPMailer {

    var $default;
    var $mailObj;

    public function __construct() {
        parent::__construct();

        $this->mailObj = new PHPMailer();

        $this->_constantConfig();
        $this->_initConfig();
    }

    private function _constantConfig() {
        try {
            define('MAIL_PROTOCOL', 'smtp');
            define('MAIL_HOST', 'ssl://smtp.googlemail.com');
            //define('MAIL_USERNAME', 'blacklist.openxcell@gmail.com');
            //define('MAIL_PASSWORD', 'blacklist.openxcell!@#');
            define('MAIL_PORT', '465');
            define('MAIL_TIMEOUT', '5');
            define('MAIL_MAIL_TYPE', 'html');
            define('MAIL_CHARSET', 'utf-8');
            define('MAIL_VALIDATE_EMAIL_ID', FALSE);
            define('MAIL_EMAIL_PRIORITY', 3);
            define('MAIL_BCC_BATCH_MODE', FALSE);
            define('MAIL_BCC_BATCH_SIZE', 200);

            define('MAIL_FROM_EMAIL', 'info@cms.com');
            define('MAIL_FROM_NAME', 'CMS Team');
            define('MAIL_SUBJECT', 'CMS');
        } catch (Exception $ex) {
            throw new Exception('Erorr in _constantConfig function - ' . $ex);
        }
    }

    /*
     * FIRST WE HAVE TO INITAIALIZE THE BASIC VARIBALES 
     * THAT WE USING IN THE SEND MAIL...
     */

    private function _initConfig() {
        try {
            //$this->mailObj->Host = MAIL_HOST;
            //$this->mailObj->SMTPDebug = 2;
            //$this->mailObj->SMTPAuth = true;
            //$this->mailObj->Port = MAIL_PORT;
            /*
             * THE MAIL WHICH IS SEND FROM THE USER EMAIL ADDRESS WITH HIS / HER NAME
             */
            $this->mailObj->From = MAIL_FROM_EMAIL;
            $this->mailObj->FromName = MAIL_FROM_NAME;

            /*
             * TO ADD THE REPLY TO EMAIL ADDRESS 
             *  IF AVAILABLE THEN AND THEN YOU HAVE TO ADD
             */
            //$this->mailObj->ReplyTo = MAIL_FROM_EMAIL;

            /*
             * SET DEFAULT WORD WRAP VALUE THAT HAVE TO SET 
             */
            $this->mailObj->WordWrap = 50;

            /*
             * SET IS HTML CONTENT EITHER IT WILL TRUE OR FALSE
             */
            $this->mailObj->isHTML(MAIL_MAIL_TYPE == 'html' ? TRUE : FALSE);
        } catch (Exception $ex) {
            throw new Exception('Error in _init function - ' . $ex);
        }
    }

    /*
     * TO SEND A MAIL...
     * PARAM
     *      - RECIEVER*         - to which user do you want T O  S E N D  the mail...
     *      - SUBJECT*          - the  S U B J E C T  of the content mail...
     *      - TEMPLATE*         - the absolute  D I R E C T O R Y  P A T H  of the template file...
     *      - PARAM             - the array with key and values
     *                              e.g. 
     *                              array(
     *                                  0 => array('%PARAM_WORD_REPLACE%','PARAM_WORD_VALUE')
     *                                  ...
     *                              )
     *      - ATTACHMENT        - the array with the values of  A B S O L U T E  path
     *                              e.g.
     *                              array(
     *                                  'D:/xampp/htdocs/project/folder/file.attachment'
     *                                  ....
     *                              )
     *
     *       - CC               - the array with the values of senders
     *                              e.g.
     *                              array(
     *                                  'example@example.com'
     *                                  ....
     *                              )
     */

    function sendMail($RECIEVER = array(), $SUBJECT = MAIL_SUBJECT, $TEMPLATE = '', $PARAM = array(), $isHTML = FALSE, $ATTACHMENT = array(), $CC = array()) {
        try {

            /*
             * TO USER'S EMAIL ARRAY....
             */

            if (is_string($RECIEVER)) {
                $RECIEVER = explode(',', $RECIEVER);
            }


            /*
             * TO ADD RECIEVER TO WHOM WE WANT TO SEND A MAIL
             */

            foreach ($RECIEVER as $k => $v) {
                if ($v !== '')
                    $this->mailObj->addAddress($v, '');
            }

            /*
             * DEFAULT SUBJECT NAME THAT I HAVE TO SET
             */

            $this->mailObj->Subject = $SUBJECT;

            /*
             * TO LOAD THE MESSAGE...
             *  USING EMAIL TEMPLATING...
             */

            $this->mailObj->Body = !$isHTML ? $this->_template($TEMPLATE, $PARAM) : $TEMPLATE;

            /*
             * ADD ATTACHMENT TO THE MAIL BODY
             */

            if (!empty($ATTACHMENT)) {
                foreach ($ATTACHMENT as $v) {
                    $this->mailObj->addAttachment($v);
                }
            }

            /*
             * SET THE CC
             */

            if (!empty($CC)) {
                foreach ($CC as $v) {
                    if ($v !== '')
                        $this->mailObj->addCC($v, '');
                }
            }

            /*
             * TO SEND A MAIL...
             */

            //_print_r($this->mailObj);


            if ($this->mailObj->send()) {
                //_print_r($this->mailObj, TRUE);
                return 1;
            } else {
                //return 0;
                echo $this->mailObj->ErrorInfo;
                exit;
            }
        } catch (Exception $ex) {
            throw new Exception('Error in send function - ' . $ex);
        }
    }

    /*
     * TO LOAD THE MAIL TEMPLATE...
     * REQUIRE PARAM...
     *      - mailTemplate          - the absolute path of the mail 
     *      - mailParam         - the array with key and values
     *                              e.g. 
     *                              array(
     *                                  0 => array('%PARAM_WORD_REPLACE%','PARAM_WORD_VALUE')
     *                                  ...
     *                              )
     */

    private function _template($mailTemplate, $mailParam = array()) {
        try {
            /*
             * TO LOAD THE HTML CONTENT FROM THE TEMPLATE FILE...
             */
            $ci = &get_instance();
            //$mailMsg = file_get_contents($mailTemplate, TRUE);
            $mailMsg = $ci->db->get_where('tbl_email_templates', array('vTemplateAlias' => $mailTemplate))->row_array()['tTemplateContent'];
            
            /*
             * REPLACE EACH AND EVERY PARAM WHICH WE ARE GOING TO REPLACE...
             */
            foreach ($mailParam as $key => $val) {
                $mailMsg = str_replace($key, $val, $mailMsg);
            }
            return $mailMsg . ' -- ' . $mailTemplate;
        } catch (Exception $ex) {
            exit('MailLib Library : Error in _template function - ' . $ex);
        }
    }

}
