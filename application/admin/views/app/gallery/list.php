<div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Manage Gallery</h1>
    <div class="m-t-sm">
        <h5 class="m-n font-bold h5 text-uppercase text-dark text-xs">
            <a href="<?= BASE_URL ?>#/app/dashboard">
                <i class="fa fa-home fa-fw"></i>Dashboard</a> /
            <span>Manage Gallery</span>
        </h5>
    </div>
</div>
<div class="wrapper-md" ng-controller="GalleryTableCtrl">
    <div class="panel panel-default" >
        <div class="panel-heading">
            <div class="row padding-0 margin-0">
                <div class="pull-left text-lg">Gallery List</div>
                <div class="pull-right">
                    <a ui-sref="app.gallery.form" class="btn btn-default btn-sm btn-addon" id="addRecord">
                        <i class="fa fa-plus text-danger"></i>&nbsp; Add New Record
                    </a>
                </div>
            </div>
        </div>
        <div id="permissions" ng-init='setPermission("<?= $pagePermission; ?>")'></div>
        
        <div class="table-responsive">
            <table  ui-jq="dataTable" ui-options="options" class="table table-striped table-bordered b-t b-b">
                <thead>
                    <tr>
                        <th>Gallery Name</th>
                        <th>Total Images</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
