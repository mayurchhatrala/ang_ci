<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require(APPPATH . '/libraries/REST_Controller.php');

/**
 * Description of login
 * @author OpenXcell Technolabs
 */
class Craw extends REST_Controller {

    var $MSG;
    var $STATUS;
    var $resp;

    function __construct() {
        parent::__construct();
        // require 'aws.phar';

        $this->MSG = INSUFF_DATA;
        $this->STATUS = FAIL_STATUS;
        $this->resp = array('MESSAGE' => $this->MSG, 'STATUS' => $this->STATUS);
        $this->load->model('craw_model');
    }

    /*
     *      ADS BANNER LISTTING
     */

    function banner_post() {

        /*
         * TO CHECK ALL THE PARAMETER ARE BEING PASSED OR NOT ?
         */

        $allowParam = array("size");

        if (checkselectedparams($this->post(), $allowParam)) {

            /*
             *      TO CHECK WETHEAR USER IS LOGGED IN OR NOT..
             */

            $result = $this->craw_model->bannerList($this->post());

            if (!empty($result)) {

                $this->resp = array(
                    'MESSAGE' => BANNER_LIST_SUCC,
                    'STATUS' => SUCCESS_STATUS,
                    'DATA' => $result
                );
            } else {

                $this->resp = array(
                    'MESSAGE' => NO_DATA,
                    'STATUS' => FAIL_STATUS
                );
            }
        }

        $this->response($this->resp, 200);
    }

    /*
     *      CATALOG LIST, WEEKLY ADS LIST FOR HOME
     */

    function home_post() {

        /*
         * TO CHECK ALL THE PARAMETER ARE BEING PASSED OR NOT ?
         */

        $allowParam = array("pageid", "size", "vDeviceID");

        if (checkselectedparams($this->post(), $allowParam)) {

            $weeklyAds = $this->craw_model->weeklyAdsList($this->post());

            $catalogs = $this->craw_model->catalogList($this->post());
            
            if(!empty($catalogs['data']) || !empty($weeklyAds['data'])) {

                $DATA['CATALOG'] = $catalogs['data'];
                $DATA['WEEKLY'] = $weeklyAds['data'];

                $this->resp = array(
                    'MESSAGE' => HOME_LIST_SUCC,
                    'STATUS' => SUCCESS_STATUS,
                    'DATA' => $DATA,
                    'TOTALRECORD_CATALOG' => $catalogs['total'],
                    'TOTALRECORD_WEEKLY' => $weeklyAds['total'],
                );
            } else {

                $this->resp = array(
                    'MESSAGE' => NO_DATA,
                    'STATUS' => FAIL_STATUS
                );
            }
        }
        $this->response($this->resp, 200);
    }

    /*
     *      CATEGORY LIST
     */

    function content_post() {


        $contentS = $this->craw_model->contentList($this->post());

        if (!empty($contentS)) {

            $DATA['CONTENT'] = $contentS;

            $this->resp = array(
                'MESSAGE' => PAGES_LIST_SUCC,
                'STATUS' => SUCCESS_STATUS,
                'DATA' => $DATA,
            );
        } else {

            $this->resp = array(
                'MESSAGE' => NO_DATA,
                'STATUS' => FAIL_STATUS
            );
        }

        $this->response($this->resp, 200);
    }

    /*
     *      CATEGORY LIST
     */

    function category_post() {

        /*
         *      TO CHECK CATEGORY LISTING
         */

        $result = $this->craw_model->categoryList($this->post());

        if (!empty($result)) {

            $this->resp = array(
                'MESSAGE' => CATEGORY_LIST_SUCC,
                'STATUS' => SUCCESS_STATUS,
                'DATA' => $result
            );
        } else {

            $this->resp = array(
                'MESSAGE' => NO_DATA,
                'STATUS' => FAIL_STATUS
            );
        }


        $this->response($this->resp, 200);
    }

    /*
     *      RETAILER LIST
     */

    function retailer_post() {

        /*
         * TO CHECK ALL THE PARAMETER ARE BEING PASSED OR NOT ?
         */

        $allowParam = array("pageid", "size", "vDeviceID");

        if (checkselectedparams($this->post(), $allowParam)) {

            $result = $this->craw_model->retailerList($this->post());

            if (!empty($result['data'])) {

                $this->resp = array(
                    'MESSAGE' => RETAILER_LIST_SUCC,
                    'STATUS' => SUCCESS_STATUS,
                    'DATA' => $result['data'],
                    'TOTALRECORD' => $result['total'],
                );
            } else {

                $this->resp = array(
                    'MESSAGE' => NO_DATA,
                    'STATUS' => FAIL_STATUS
                );
            }
        }
        $this->response($this->resp, 200);
    }

    /*
     *      RETAILER LIST
     */

    function weekly_post() {

        /*
         * TO CHECK ALL THE PARAMETER ARE BEING PASSED OR NOT ?
         */

        $allowParam = array("pageid", "size", "vDeviceID");

        if (checkselectedparams($this->post(), $allowParam)) {

            $result = $this->craw_model->weeklyAdsList($this->post());

            if (!empty($result['data'])) {

                $this->resp = array(
                    'MESSAGE' => WEEKLY_LIST_SUCC,
                    'STATUS' => SUCCESS_STATUS,
                    'DATA' => $result['data'],
                    'TOTALRECORD' => $result['total'],
                );
            } else {

                $this->resp = array(
                    'MESSAGE' => NO_DATA,
                    'STATUS' => FAIL_STATUS
                );
            }
        }
        $this->response($this->resp, 200);
    }

    /*
     *      CATALOG LIST
     */

    function catalog_post() {

        /*
         * TO CHECK ALL THE PARAMETER ARE BEING PASSED OR NOT ?
         */

        $allowParam = array("pageid", "size", "vDeviceID");

        if (checkselectedparams($this->post(), $allowParam)) {

            $result = $this->craw_model->catalogList($this->post());

            if (!empty($result['data'])) {

                $this->resp = array(
                    'MESSAGE' => CATALOG_LIST_SUCC,
                    'STATUS' => SUCCESS_STATUS,
                    'DATA' => $result['data'],
                    'TOTALRECORD' => $result['total'],
                );
            } else {

                $this->resp = array(
                    'MESSAGE' => NO_DATA,
                    'STATUS' => FAIL_STATUS
                );
            }
        }
        $this->response($this->resp, 200);
    }

    /*
     *      CATALOG LIST
     */

    function retailerLocation_post() {

        /*
         * TO CHECK ALL THE PARAMETER ARE BEING PASSED OR NOT ?
         */

        $allowParam = array("vLocationName");

        if (checkselectedparams($this->post(), $allowParam)) {

            $result = $this->craw_model->locationList($this->post());

            if (!empty($result)) {

                $this->resp = array(
                    'MESSAGE' => CATALOG_LIST_SUCC,
                    'STATUS' => SUCCESS_STATUS,
                    'DATA' => $result
                );
            } else {

                $this->resp = array(
                    'MESSAGE' => NO_DATA,
                    'STATUS' => FAIL_STATUS
                );
            }
        }
        $this->response($this->resp, 200);
    }

    /*
     *      READ RETAILER, CATALOG, WEEKLY ADS LIST
     */

    function read_post() {

        /*
         * TO CHECK ALL THE PARAMETER ARE BEING PASSED OR NOT ?
         */

        $allowParam = array("vDeviceID");

        if (checkselectedparams($this->post(), $allowParam)) {

            $result = $this->craw_model->rcwList($this->post());

            if (!empty($result)) {

                $this->resp = array(
                    'MESSAGE' => WEEKLY_LIST_SUCC,
                    'STATUS' => SUCCESS_STATUS,
                    'DATA' => $result
                );
            } else {

                $this->resp = array(
                    'MESSAGE' => NO_DATA,
                    'STATUS' => FAIL_STATUS
                );
            }
        }
        $this->response($this->resp, 200);
    }

    /*
     *      READ RETAILER, CATALOG, WEEKLY ADS LIST
     */

    function favorites_post() {

        /*
         * TO CHECK ALL THE PARAMETER ARE BEING PASSED OR NOT ?
         */

        $allowParam = array("vDeviceID", "eStatus");

        if (checkselectedparams($this->post(), $allowParam)) {

            $result = $this->craw_model->favList($this->post());

            if (!empty($result)) {

                $this->resp = array(
                    'MESSAGE' => WEEKLY_LIST_SUCC,
                    'STATUS' => SUCCESS_STATUS,
                    'DATA' => $result
                );
            } else {

                $this->resp = array(
                    'MESSAGE' => NO_DATA,
                    'STATUS' => FAIL_STATUS
                );
            }
        }
        $this->response($this->resp, 200);
    }

    /*
     *      STORE LIST
     */

    function retailerStore_post() {

        /*
         * TO CHECK ALL THE PARAMETER ARE BEING PASSED OR NOT ?
         */

        $allowParam = array("vRetailerName", "vLatitude", "vLongtitude", "Range");

        if (checkselectedparams($this->post(), $allowParam)) {

            $result = $this->craw_model->retailerStoreList($this->post());

            if (!empty($result)) {

                $this->resp = array(
                    'MESSAGE' => RETAILER_LIST_SUCC,
                    'STATUS' => SUCCESS_STATUS,
                    'DATA' => $result
                );
            } else {

                $this->resp = array(
                    'MESSAGE' => NO_DATA,
                    'STATUS' => FAIL_STATUS
                );
            }
        }
        $this->response($this->resp, 200);
    }

    /*
     *      STORE LIST
     */

    function notificationStatus_post() {

        /*
         * TO CHECK ALL THE PARAMETER ARE BEING PASSED OR NOT ?
         */

        $allowParam = array("vDeviceID", "vNotificationStatus", "vDeviceToken");

        if (checkselectedparams($this->post(), $allowParam)) {

            $result = $this->craw_model->notificationStatus($this->post());

            if (!empty($result)) {

                $this->resp = array(
                    'MESSAGE' => NOTIFICATION_STATUS_CHANGE,
                    'STATUS' => SUCCESS_STATUS,
                    'DATA' => $result
                );
            } else {

                $this->resp = array(
                    'MESSAGE' => NO_DATA,
                    'STATUS' => FAIL_STATUS
                );
            }
        }
        $this->response($this->resp, 200);
    }

    /*
     *      FEED BACK
     */

    function feedBack_post() {

        /*
         * TO CHECK ALL THE PARAMETER ARE BEING PASSED OR NOT ?
         */

        $allowParam = array("vSubject", "vComment");

        if (checkselectedparams($this->post(), $allowParam)) {

            $result = $this->craw_model->feedBack($this->post());

            if (!empty($result)) {

                $this->resp = array(
                    'MESSAGE' => "Mail Sent Successfully",
                    'STATUS' => SUCCESS_STATUS,
                );
            } else {

                $this->resp = array(
                    'MESSAGE' => "Mail Not Sent.",
                    'STATUS' => FAIL_STATUS
                );
            }
        }
        $this->response($this->resp, 200);
    }

    /*
     *      UPDATE USER LOCATION
     */

    public function UpdateUserLocation_post() {

        $allowParam = array("vLatitude", "vLongtitude", "vDeviceID");

        if (checkselectedparams($this->post(), $allowParam)) {

            $result = $this->craw_model->UpdateLocation($this->post());

            if (!empty($result)) {

                $this->resp = array(
                    'MESSAGE' => LOCATION_UPDATE,
                    'STATUS' => SUCCESS_STATUS,
                );
            } else {

                $this->resp = array(
                    'MESSAGE' => NO_DATA,
                    'STATUS' => FAIL_STATUS
                );
            }
        }
        $this->response($this->resp, 200);
    }

    /*
     *      testing pushnotication
     */

    function pushNotification_post() {


        $allowParam = array("arn");

        if (checkselectedparams($this->post(), $allowParam)) {

            $snsNoti = $this->load->library('Sns_Test', array('PLATEFORM_TYPE' => 'ios'));
            $USERDATA = array(
                'iRetailerID' => '1',
                'iAdsID' => '1'
            );
            $abc = $this->sns_test->broadCast("Hi...", '', $this->post()['arn'], '', $USERDATA);
            if ($abc) {
                $this->resp = array(
                    'MESSAGE' => "Success",
                );
            } else {
                $this->resp = array(
                    'MESSAGE' => "Fail"
                );
            }
        }
        $this->response($this->resp, 200);
    }

    /*
     *   delete push notification
     */

    function pushNotificationDelete_post() {


        $allowParam = array("arn");

        if (checkselectedparams($this->post(), $allowParam)) {

            $snsNoti = $this->load->library('Sns_Test', array('PLATEFORM_TYPE' => 'ios'));
            $abc = $this->sns_test->deleteEndPointARN($this->post()['arn']);
            if ($abc) {
                $this->resp = array(
                    'MESSAGE' => "Success",
                );
            } else {
                $this->resp = array(
                    'MESSAGE' => "Fail"
                );
            }
        }
        $this->response($this->resp, 200);
    }

}
