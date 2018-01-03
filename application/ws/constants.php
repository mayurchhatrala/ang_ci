<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */

define('BASEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
define('BASEDIR', $_SERVER['DOCUMENT_ROOT'] . '/');
define('PROJECT_TITLE', 'Smart Swap');
define('ASSET', BASEURL . 'assets/');
define('IMG_URL', ASSET . 'image/');
define('SIGN_URL', IMG_URL . 'signature/');
define('CSS_URL', ASSET . 'css/');
define('JS_URL', ASSET . 'js/');
define('ENCRYPTION_KEY', 'cps.openxcell.key');

define('DIR_VIEW', BASEDIR . 'application/ws/views/');
define('DIR_LIB', BASEDIR . 'application/ws/libraries/');
define('DIR_PDF', BASEDIR . 'assets/pdf/');


define('ACCOUNT_DEACTIVE', 'Your Account Is Inactivated Now.');
define('LOGIN_INVALID', 'You Have Entered Wrong User Name And Password.');
define('LOG_SUCCESS', 'You are logged in Successfully.');
define('LOGOUT_SUCCESS', 'You are logged out Successfully.');
define('INSUFF_DATA', 'Insufficient Data.');
define('LOGOUT_ERROR', 'Something Wrong with logout.!!');

define('FAIL_STATUS', 101);
define('SUCCESS_STATUS', 200);

/* EMAIL CONSTANTS */
define('EMAIL_SUBJECT', 'Smart Swap Courier');
define('FROM_EMAIL_ID', 'noreply@icpcorp.com');
define('FROM_EMAIL_NAME', 'Smart Swap');
define('MAIL_PROTOCOL', 'smtp');
/*
define('MAIL_HOST', 'ssl://smtp.googlemail.com');
define('MAIL_USERNAME', 'cps.openxcell@gmail.com');
define('MAIL_PASSWORD', 'cps.openxcell!@#');
define('MAIL_PORT', '465');
*/
define('MAIL_HOST', 'smtp://mail.icpcorp.com');
define('MAIL_PORT', '25');
define('MAIL_TIMEOUT', '5');
define('MAIL_MAIL_TYPE', 'html');
define('MAIL_CHARSET', 'utf-8');
define('MAIL_VALIDATE_EMAIL_ID', FALSE);
define('MAIL_EMAIL_PRIORITY', 3);
define('MAIL_BCC_BATCH_MODE', FALSE);
define('MAIL_BCC_BATCH_SIZE', 200);


define('CONTRACT_DATA_SUCCESS', 'Contract Record found successfully.');

define('ASSET_DEACTIVE', 'Asset Record is deactivated.');
define('ASSET_SUCCESS', 'Asset Record found successfully.');
define('ASSET_NOT_FOUND', 'Asset Record not found.');

define('PICKUP_SUCCESS', 'Pickup record found successfully.');
define('PICKUP_FAIL', 'Pickup record not found.');
define('PICKUP_INSERTED', 'Pickup order saved successfully.');
define('PICKUP_UPDATED', 'Pickup order updated successfully.');

