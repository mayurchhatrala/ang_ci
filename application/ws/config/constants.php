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
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '192.168.1.96') {
    $project_path = '/DealBase/';
} else {
    $project_path = '/';
}

define('PROJ_TITLE', 'Catalogee');

define('BASEURL', 'http://' . $_SERVER['SERVER_NAME'] . $project_path );

define('BASEDIR', $_SERVER['DOCUMENT_ROOT'] . '/');
define('ASSET', BASEURL . 'assets/');
define('IMG_URL', ASSET . 'image/');
define('SIGN_URL', IMG_URL . 'signature/');
define('CSS_URL', ASSET . 'css/');
define('JS_URL', ASSET . 'js/');
define('ENCRYPTION_KEY', 'cps.openxcell.key');

define('DIR_VIEW', BASEDIR . 'application/ws/views/');
define('DIR_LIB', BASEDIR . 'application/ws/libraries/');
define('DIR_PDF', BASEDIR . 'assets/pdf/');

// new constant
define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/');
define('UPLD_DIR', DOC_ROOT . 'upload/');
define('IMAGE_COPYRIGHT_TEXT', '© ' . date('Y') . ' copyright by ' . PROJ_TITLE);

// image path
define('IMAGE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/upload/');
define('IMAGE_Hight', 50);
define('IMAGE_Width', 50);

// SUCCESS
define('SUCCESS_STATUS', 200);
// FAIL 
define('NO_DATA', 'No Record Found.');
define('INSUFF_DATA', 'Insufficient Data.');
define('FAIL_STATUS', 101);

// warning message
define('DELETE_WARN', 'Something is missing to delete this record!');
define('INSERT_WARN', 'Something is missing to insert the record!');
define('UPDATE_WARN', 'Something is missing to update the record!');


// LOGIN
define('LOGIN_INVALID', 'You Have Entered Wrong User Name And Password.');
define('LOG_SUCCESS', 'You are logged in Successfully.');
// LOGOUT
define('LOGOUT_SUCCESS', 'You are logged out Successfully.');
define('LOGOUT_ERROR', 'Something Wrong with logout.!!');


// INSERT, UPDATE, DELETE
define('USER_UPDT_SUCC', 'User record updated successfully.');
define('USER_INS_SUCC', 'User record inserted successfully.');
define('USER_DEL_SUCC', 'User record deleted successfully.');
define('USER_LIST_SUCC', 'User Record listing.');

define('HOME_LIST_SUCC', 'Record listing.');

define('CATEGORY_UPDT_SUCC', 'Category updated successfully.');
define('CATEGORY_INS_SUCC', 'Category record inserted successfully.');
define('CATEGORY_DEL_SUCC', 'Category record deleted successfully.');
define('CATEGORY_LIST_SUCC', 'Category Record listing.');

define('RETAILER_UPDT_SUCC', 'Retailer updated successfully.');
define('RETAILER_INS_SUCC', 'Retailer record inserted successfully.');
define('RETAILER_DEL_SUCC', 'Retailer record deleted successfully');
define('RETAILER_LIST_SUCC', 'Retailer Record listing.');

define('BANNER_UPDT_SUCC', 'Banner updated successfully.');
define('BANNER_INS_SUCC', 'Banner record inserted successfully.');
define('BANNER_DEL_SUCC', 'Banner record deleted successfully');
define('BANNER_LIST_SUCC', 'Banner Record listing.');

define('WEEKLY_UPDT_SUCC', 'Weekly Ads updated successfully.');
define('WEEKLY_INS_SUCC', 'Weekly Ads record inserted successfully.');
define('WEEKLY_DEL_SUCC', 'Weekly Ads record deleted successfully');
define('WEEKLY_LIST_SUCC', 'Weekly Ads Record listing.');

define('PAGES_UPDT_SUCC', 'Content updated successfully.');
define('PAGES_INS_SUCC', 'Content record inserted successfully.');
define('PAGES_DEL_SUCC', 'Content record deleted successfully');
define('PAGES_LIST_SUCC', 'Content Record listing.');

define('CATALOG_UPDT_SUCC', 'Catalog updated successfully.');
define('CATALOG_INS_SUCC', 'Catalog record inserted successfully.');
define('CATALOG_DEL_SUCC', 'Catalog record deleted successfully');
define('CATALOG_LIST_SUCC', 'Catalog Record listing.');

define('NOTIFICATION_STATUS_CHANGE', 'Notification status updated successfully.');
define('LOCATION_UPDATE', 'Location updated successfully.');