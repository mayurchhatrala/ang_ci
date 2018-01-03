<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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

/*
 * URL PATH
 */
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '192.168.1.96') {
    $project_path = '/DealBase/';
}else {
    $project_path = '/';
}

define('PROJ_TITLE', 'Catalogee');

define('BASE_URL', 'http://' . $_SERVER['SERVER_NAME'] . $project_path . 'admin/');
define('APP_URL', BASE_URL . 'application/');
define('COMP_URL', BASE_URL . 'components/');

define('CSS_URL', APP_URL . 'css/');
define('IMG_URL', APP_URL . 'img/');
define('JS_URL', APP_URL . 'js/');
define('UPLD_URL', 'http://' . $_SERVER['SERVER_NAME'] . $project_path . 'upload/');
define('DWNLD_URL', 'http://' . $_SERVER['SERVER_NAME'] . $project_path . 'download/');
define('DWNLD_DOC_URL', DWNLD_URL . 'document/');

// image path
define('IMAGE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/upload/');
define('IMAGE_Hight', 50);
define('IMAGE_Width', 50);

/*
 * DOCUMENT PATH
 */
define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT'] . $project_path);
define('APP_DIR', DOC_ROOT . 'application/');
define('COMP_DIR', DOC_ROOT . 'components/');

define('VIEW_DIR', APP_DIR . 'admin/views/');
define('VIEW_DIR_EMAIL', VIEW_DIR . 'email/');

define('CSS_DIR', APP_DIR . 'css/');
define('FONT_DIR', DOC_ROOT . 'admin/application/fonts/');
define('IMG_DIR', APP_DIR . 'img/');
define('JS_DIR', APP_DIR . 'js/');
define('UPLD_DIR', DOC_ROOT . 'upload/');
define('DWNLD_DIR', DOC_ROOT . 'download/');
define('DWNLD_DOC_DIR', DWNLD_DIR . 'document/');

define('IMAGE_COPYRIGHT_TEXT', '© ' . date('Y') . ' copyright by ' . PROJ_TITLE);

define('MYSQL_DATE_FORMAT', '%b %d, %Y');
define('MYSQL_DATE_FORMAT2', '%l:%i %p %M %e, %Y');

define('DATE_OBJ_FORMAT', 'dS F, Y g:i:s A');

/*
 * VALIDATIONS ERROR MESSAGE
 */
define('FAIL_STATUS', 101);
define('SUCCESS_STATUS', 200);
define('INSUFF_DATA', 'You have entered insufficient Data.');
define('NOT_ACCESS', 'You are not allow to complete this operation.');
define('NO_RECORD', 'No record found !!');
define('REC_FOUND', 'Record found !!');
define('REC_ADD', 'Record added successfully !!');
define('REC_DELETED', 'Record deleted successfully !!');

define('INVALID_LOGIN', 'You have entered wrong username and password.');
define('INVALID_PASS', 'You have entered wrong password.');
define('SUCCESS_LOGIN', 'You are successfully logged in.');

define('INVALID_PWD_EMAIL', 'You have entered wrong email address.');
define('SUCCESS_PWD', 'Your updated reset password link has been sent to your email address.');

define('INVALID_RESET_PWD_EMAIL', 'You\'re requesting to reset password for wrong email address.');
define('SUCCESS_RESET_PWD', 'You have successfully reset your password.');

define('EMAIL_EXIST_ALREADY', 'This email address already exists !!');
define('PROFILE_UPDT_SUCCESS', 'Profile information updated successfully.');

define('WRONG_PASSWORD', 'You have entered wrong password.');
define('PASS_NOT_MATCH', 'Password and confirm password are not matched !!');
define('PASS_CHANGE_SUCC', 'Password has been changes successfully.');

define('SETTINGS_UPDT_SUCCESS', 'Setting details has been updated successfully.');

define('DATE_DISPLAY_FORMAT', '');

/*
 * ADMIN TYPE OPERATION MESSAGE
 */
define('ADMINTYPE_UPDT_SUCC', 'Admin Type record updated successfully.');
define('ADMINTYPE_INS_SUCC', 'Admin Type record inserted successfully.');
define('ADMINTYPE_DEL_SUCC', 'Admin Type record deleted successfully.');

/*
 * ADMIN MODULE OPERATION MESSAGE
 */
define('ADMIN_MOD_UPDT_SUCC', 'Admin Module record updated successfully.');
define('ADMIN_MOD_INS_SUCC', 'Admin Module record inserted successfully.');
define('ADMIN_MOD_DEL_SUCC', 'Admin Module record deleted successfully.');

/*
 * ADMIN PAGE OPERATION MESSAGE
 */
define('ADMIN_PAGE_UPDT_SUCC', 'Admin Page record updated successfully.');
define('ADMIN_PAGE_INS_SUCC', 'Admin Page record inserted successfully.');
define('ADMIN_PAGE_DEL_SUCC', 'Admin Page record deleted successfully.');

/*
 * USER OPERATION MESSAGE
 */
define('USER_UPDT_SUCC', 'User record updated successfully.');
define('USER_INS_SUCC', 'User record inserted successfully.');
define('USER_DEL_SUCC', 'User record deleted successfully.');
define('USER_EMAIL_EXISTS', 'User email already exists.');

/*
 * EMAIL TEMPLATE OPERATION MESSAGE
 */
define('EMAIL_TMPLT_UPDT_SUCC', 'Email template record updated successfully.');
define('EMAIL_TMPLT_INS_SUCC', 'Email template record inserted successfully.');
define('EMAIL_TMPLT_DEL_SUCC', 'Email template record deleted successfully.');

/*
 * GALLERY OPERATION MESSAGE
 */
define('GALLERY_IMAGE_UPDT_SUCC', 'Gallery record updated successfully.');
define('GALLERY_IMAGE_INS_SUCC', 'Gallery record inserted successfully.');
define('GALLERY_IMAGE_DEL_SUCC', 'Gallery record deleted successfully.');

/*
 * CRUD OPERATION MESSAGES
 */
define('DELETE_WARN', 'Something is missing to delete this record!');
define('INSERT_WARN', 'Something is missing to insert the record!');
define('UPDATE_WARN', 'Something is missing to update the record!');

/*
 *  Category Manage Messages
 */

define('CATEGORY_UPDT_SUCC', 'Category updated successfully.');
define('CATEGORY_INS_SUCC', 'Category record inserted successfully.');
define('CATEGORY_DEL_SUCC', 'Category record deleted successfully.');

define('RETAILER_UPDT_SUCC', 'Retailer updated successfully.');
define('RETAILER_INS_SUCC', 'Retailer record inserted successfully.');
define('RETAILER_DEL_SUCC', 'Retailer record deleted successfully');

define('BANNER_UPDT_SUCC', 'Banner updated successfully.');
define('BANNER_INS_SUCC', 'Banner record inserted successfully.');
define('BANNER_DEL_SUCC', 'Banner record deleted successfully');

define('WEEKLY_UPDT_SUCC', 'Weekly Ads updated successfully.');
define('WEEKLY_INS_SUCC', 'Weekly Ads record inserted successfully.');
define('WEEKLY_DEL_SUCC', 'Weekly Ads record deleted successfully');


define('PAGES_UPDT_SUCC', 'Content updated successfully.');
define('PAGES_INS_SUCC', 'Content record inserted successfully.');
define('PAGES_DEL_SUCC', 'Content record deleted successfully');

define('CATALOG_UPDT_SUCC', 'Catalog updated successfully.');
define('CATALOG_INS_SUCC', 'Catalog record inserted successfully.');
define('CATALOG_DEL_SUCC', 'Catalog record deleted successfully');
