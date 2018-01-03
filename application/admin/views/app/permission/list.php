<div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Manage Admin Type Permission</h1>
    <div class="m-t-sm">
        <h5 class="m-n font-bold h5 text-uppercase text-dark text-xs">
            <a href="<?= BASE_URL ?>#/app/dashboard">
                <i class="fa fa-home fa-fw"></i>Dashboard</a> /
            <span>Manage Admin Type Permission</span>
        </h5>
    </div>
</div>
<div class="wrapper-md" ng-controller="AdminPermissionTableCtrl" >
    <div class="panel panel-default" >
        <div class="panel-heading">
            <div class="row padding-0 margin-0">
                <div class="pull-left text-lg">Admin Type Permission</div>
            </div>
        </div>
        <div id="permissions" ng-init='setPermission("<?= $pagePermission; ?>")'></div>
        <div class="table-responsive">
            <table  ui-jq="dataTable" ui-options="options" class="table table-striped table-bordered b-t b-b">
                <thead>
                    <tr>
                        <th>Type Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
