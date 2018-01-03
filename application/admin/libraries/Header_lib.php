<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of header_lib
 * @author Admin
 * 
 * IF YOU WANT TO CHANGE IN THE FILE CONTENT SO CHANGE WHERE 
 * >> 'CHANGE-IT' PLACED IN THE COMMENT...
 */
class Header_lib {

    private $doc_type, $doc_type_value;
    private $meta_tag, $content_meta_tag_value, $http_meta_tag_value;
    private $title;
    private $css, $css_value;
    private $js, $js_value;
    private $favicon;

    public function __construct() {
        $this->_loadFields();
    }

    /*
     * TO GET THE LIST OF FIELDS...
     */

    public function data() {
        return array(
            'doctype' => $this->doc_type,
            'title' => $this->title,
            'metatag' => $this->meta_tag,
            'css' => $this->css,
            'js' => $this->js,
            'favicon' => $this->favicon,
        );
    }

    /*
     * TO LOAD ALL THE FIELDS...
     */

    private function _loadFields() {
        $this->title = PROJ_TITLE;
        $this->_setDocType();
        $this->_setMetaTags();
        $this->_setCSS();
        $this->_setJS();
        $this->_setFaviconIcon();
    }

    /*
     * TO SET DOC TYPE
     * 
     * CHANGE-IT
     */

    private function _setDocType() {
        if (@$this->doc_type_value != '') {
            switch ($this->doc_type_value) {
                case 'Strict':
                    $this->doc_type = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"' . "\n" . '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">' . "\n";
                    break;

                case 'Transitional':
                    $this->doc_type = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"' . "\n" . '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">' . "\n";
                    break;

                case 'Frameset':
                    $this->doc_type = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"' . "\n" . '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">' . "\n";

                case 'XHTML':
                    $this->doc_type = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"' . "\n" . '"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">' . "\n";

                case 'XHTML1.0':
                    $this->doc_type = '<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">' . "\n";

                case 'XHTML1.1':
                    $this->doc_type = '<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' . "\n";
            }
        }
    }

    /*
     * TO SET THE META TAGS
     */

    private function _setMetaTags() {
        $this->_setMetaTagsValue();

        foreach ($this->http_meta_tag_value as $key => $val)
            $this->meta_tag .= '<meta http-equiv="' . $key . '" content="' . $val . '"/>' . PHP_EOL;

        foreach ($this->content_meta_tag_value as $key => $val)
            $this->meta_tag .= '<meta http-equiv="' . $key . '" content="' . $val . '"/>' . PHP_EOL;
    }

    /*
     * TO SET THE META TAG VALUES
     * 
     * CHANGE-IT
     */

    private function _setMetaTagsValue() {
        $this->http_meta_tag_value = array();
        $this->content_meta_tag_value = array(
            'apple-mobile-web-app-capable' => 'yes',
            'apple-mobile-web-app-status-bar-style' => 'black',
            'viewport' => 'width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no'
        );
    }

    /*
     * TO SET THE CSS
     */

    private function _setCSS() {
        $this->_setCSSValue();
        foreach ($this->css_value as $key => $val)
            $this->css .= '<link rel="stylesheet" id="' . $key . '" href="' . $val . '" type="text/css" media="all" />' . PHP_EOL;
    }

    /*
     * TO SET THE CSS VALUE
     * 
     * CHANGE-IT
     */

    private function _setCSSValue() {
        $this->css_value = array(
            'bootstrap' => COMP_URL . 'bootstrap/dist/css/bootstrap.min.css',
            'animate' => COMP_URL . 'animate.css/animate.min.css',
            //'common' => CSS_URL . 'common.min.css',
            'font-awesome' => COMP_URL . 'font-awesome/css/font-awesome.min.css',
            'line-icon' => COMP_URL . 'simple-line-icons/css/simple-line-icons.min.css',
            'default' => CSS_URL . 'font.min.css',
            //'ui-tree' => COMP_URL . 'angular-ui-tree/dist/angular-ui-tree.min.css',
            'app' => CSS_URL . 'app.min.css',
            'sweetalert' => COMP_URL . 'sweet-alert/css/sweet-alert.min.css',
            'sweetalert-ie9' => COMP_URL . 'sweet-alert/css/ie9.min.css'
        );
    }

    /*
     * TO SET THE JS
     */

    private function _setJS() {
        $this->_setJSValue();
        $this->js .= '<script type="text/javascript">var BASEURL = "' . BASE_URL . '"; </script>' . PHP_EOL;
        $this->js .= '<script type="text/javascript"  >var IMAGE_URL = "' . IMAGE_URL . '"; </script>' . PHP_EOL;
        $this->js .= '<script type="text/javascript">var JS_CNTRL = BASEURL + "/application/js/controllers/"; </script>' . PHP_EOL;
        foreach ($this->js_value as $key => $val)
            $this->js .= '<script src="' . $val . '" type="text/javascript" charset="utf-8"></script>' . PHP_EOL;
    }

    /*
     * TO SET THE JS VALUE
     * 
     * CHANGE-IT
     */

    private function _setJSValue() {
        $this->js_value = array(
            //'jquery' => COMP_URL . 'jquery/dist/jquery.min.js',
            //'jquery' => COMP_URL . 'jquery/dist/jquery-2.1.4.min.js',
            
            'jquery' => COMP_URL . 'jquery/dist/jquery-1.10.2.js',
            'ng' => COMP_URL . 'angular/angular.min.js',
            'ng-animate' => COMP_URL . 'angular-animate/angular-animate.min.js',
            'ng-coockie' => COMP_URL . 'angular-cookies/angular-cookies.min.js',
            'ng-resource' => COMP_URL . 'angular-resource/angular-resource.min.js',
            'ng-sanitize' => COMP_URL . 'angular-sanitize/angular-sanitize.min.js',
            'ng-touch' => COMP_URL . 'angular-touch/angular-touch.min.js',
            'ng-route' => COMP_URL . 'angular-ui-router/release/angular-ui-router.min.js',
            'ng-storage' => COMP_URL . 'ngstorage/ngStorage.min.js',
            'ng-utils' => COMP_URL . 'angular-ui-utils/ui-utils.min.js',
            'ng-bootstrap' => COMP_URL . 'angular-bootstrap/ui-bootstrap-tpls.min.js',
            'ng-lazyload' => COMP_URL . 'oclazyload/dist/ocLazyLoad.min.js',
            'ng-translate' => COMP_URL . 'angular-translate/angular-translate.min.js',
            'ng-trans-load' => COMP_URL . 'angular-translate-loader-static-files/angular-translate-loader-static-files.min.js',
            'ng-store-coockie' => COMP_URL . 'angular-translate-storage-cookie/angular-translate-storage-cookie.min.js',
            'ng-store-local' => COMP_URL . 'angular-translate-storage-local/angular-translate-storage-local.min.js',
            //'ng-lightbox' => COMP_URL . 'angular-bootstrap-lightbox/dist/angular-bootstrap-lightbox.min.js',
            'app' => JS_URL . 'app.min.js',
            'config' => JS_URL . 'config.min.js',
            'lazyload' => JS_URL . 'config.lazyload.min.js',
            'factory' => JS_URL . 'factory.js',
            'route' => JS_URL . 'config.router.js',
            'main' => JS_URL . 'main.min.js',
            'ui-load' => JS_URL . 'services/ui-load.min.js',
            'filter' => JS_URL . 'filters/fromNow.min.js',
            'stenganimate' => JS_URL . 'directives/setnganimate.min.js',
            'ui-butterbar' => JS_URL . 'directives/ui-butterbar.min.js',
            'ui-focus' => JS_URL . 'directives/ui-focus.min.js',
            'ui-fullscreen' => JS_URL . 'directives/ui-fullscreen.min.js',
            'ui-jq' => JS_URL . 'directives/ui-jq.js',
            'ui-module' => JS_URL . 'directives/ui-module.min.js',
            'ui-nav' => JS_URL . 'directives/ui-nav.min.js',
            'ui-scroll' => JS_URL . 'directives/ui-scroll.min.js',
            'ui-shift' => JS_URL . 'directives/ui-shift.min.js',
            'ui-toggle' => JS_URL . 'directives/ui-toggleclass.min.js',
            //'ng-enter' => JS_URL . 'directives/on-enter.js',
            //'ui-tree' => COMP_URL . 'angular-ui-tree/dist/angular-ui-tree.min.js',
            //'google-map' => 'http://maps.google.com/maps/api/js',
            //'ng-map' => JS_URL . 'directives/ng-map.min.js',
            'ckeditor' => COMP_URL . 'ckeditor/ckeditor.js',
            'ckeditor-dir' => JS_URL . 'directives/ckeditor.js',
            'boostrap' => JS_URL . 'controllers/bootstrap.min.js',
            'sweetalert' => COMP_URL . 'sweet-alert/js/sweet-alert.min.js',
            'cms-app' => JS_URL . 'cms.app.js',
            
            'google' => 'http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places',
            'location' => COMP_URL . 'map/locationpicker.jquery.js',
        );
    }

    /*
     * TO SET FAVICON ICON
     * 
     * CHANGE-IT
     */

    private function _setFaviconIcon() {
        $icon_path = IMG_URL . 'icon.ico';
        $this->favicon = '<link rel="shortcut icon" type="image/x-icon"  href="' . $icon_path . '" />';
    }

}
