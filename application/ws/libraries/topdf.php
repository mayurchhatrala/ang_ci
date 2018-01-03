<?php

require_once DIR_LIB . 'dom-pdf/dompdf_config.inc.php';

/**
 * Description of pickup
 * @author OpenXcell Technolabs
 */
class ToPDF {

    var $PDF_OBJ;

    function __construct() {
        ini_set('memory_limit', "2048M");
        ini_set("max_execution_time", "9999");

        //ob_start();
        /*
         * FIRST WE HAVE LOAD HTML2PDF CLASS FILE...
         */

        //require_once DIR_LIB . 'dom-pdf/dompdf_config.inc.php';
        //$this->PDF_OBJ = new HTML2PDF('P', 'A4', 'en');
        $this->PDF_OBJ = new DOMPDF();
    }

    function create($CONTENT = '', $REPLACE_VALUES = array(), $fileName = '') {
        /*
         * WHICH ONE FILE I NEED TO READ IT DOWN...
         */
        $CONTENT = $CONTENT; // file_get_contents(DIR_VIEW . 'pdf/' . $FILE_NAME, TRUE);

        /*
         * REPLACE THE VALUES WHICH ARE PASSED FROM THE REQUESTED SIDE...
         */
        foreach ($REPLACE_VALUES AS $K => $V) {
            $CONTENT = str_replace($K, $V, $CONTENT);
        }

        //echo $CONTENT;
        //exit;

        /*
         * WRITE THE HTML TO THE PDF FILE...
         */
        //$this->PDF_OBJ->WriteHTML($CONTENT);
        $this->PDF_OBJ->load_html($CONTENT);

        /*
         * SAVE IT TO THE EXISTING LOCATION...
         */
        //$this->PDF_OBJ->Output(DIR_PDF . 'finalized-order-' . $fileName . '.pdf', 'F');
        $this->PDF_OBJ->render();

        //$this->PDF_OBJ->stream('sample.pdf');
        //$this->PDF_OBJ->set_base_path(SITE_URL);

        $output = $this->PDF_OBJ->output();


        //chmod(DIR_PDF, 0777);
        //$this->PDF_OBJ->stream('finalized-order-' . $fileName . '.pdf');
        file_put_contents(DIR_PDF . 'finalized-order-' . $fileName . '.pdf', $output);
        //ob_end_clean();
    }

}
