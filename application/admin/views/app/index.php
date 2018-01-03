<!-- navbar -->
<div class="app-header navbar">
    <?php $this->load->view('include/header'); ?>
</div>
<!-- / navbar -->

<!-- menu -->
<div class="app-aside hidden-xs bg-black">
    <?php $this->load->view('include/sidebar'); ?>
</div>
<!-- / menu -->

<!-- content -->
<div class="app-content">
    <div ui-butterbar></div>
    <a href class="off-screen-toggle hide" ui-toggle-class="off-screen" data-target=".app-aside" ></a>
    <div class="app-content-body fade-in-up" ui-view></div>
</div>
<!-- /content -->

<!-- footer -->
<div class="app-footer wrapper b-t bg-light">
    <span class="pull-right">{{app.version}} <a href ui-scroll-to="app" class="m-l-sm text-muted"><i class="fa fa-long-arrow-up"></i></a></span>
    &copy; 2016 Copyright.
</div>
<!-- / footer -->
