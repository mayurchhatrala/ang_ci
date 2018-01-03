<?php
/*
 * STEP 1.
 * DEFAULT YOU HAVE TO LOAD THE HEADER LIBRARY...
 */
$data['headerlib'] = $this->header_lib->data();

/*
 * STEP 2.
 * VIEW HTML + HEAD + BODY DEFAULT TAGS WHICH 
 * WE HAVE WRITE IN ALL THE FILES BY DEFAULT...
 * 
 * CSS ALSO LOADS FROM HERE..
 */
$data['headerBoolean'] = isset($headerBoolean) ? $headerBoolean : TRUE;
$this->load->view('include/top', $data);


/*
 * STEP 3. 
 * WRITE THE HTML CODE WHICH IS REQUIRE FOR THIS CURRENT PAGE...
 * ANY OF THE CODE OF THIS CURRENT PAGE WILL BE START FROM HERE..
 * 
 * VARIABLES + FORM-VARIABLES + ETC...
 */
?>

<div class="app" 
     id="app" 
     ng-class="{'app-header-fixed':app.settings.headerFixed, 'app-aside-fixed':app.settings.asideFixed, 'app-aside-folded':app.settings.asideFolded, 'app-aside-dock':app.settings.asideDock, 'container':app.settings.container}" 
     ui-view></div>

<?php
/*
 * STEP 4.
 * VIEW HTML + BODY ENDING TAGS 
 * JAVASCRIPT ALSO LOADS FROM HERE...
 */
$this->load->view('include/bottom', $data);


/*
 * STEP 5. 
 * ANY OF THE NEW SCRIPT AND ANY OF THE 
 * NEW STYLESHEETS WILL BE LOAD FROM HERE [ AFTER ENDING PHP TAG :P ;) ]..
 */
?>
