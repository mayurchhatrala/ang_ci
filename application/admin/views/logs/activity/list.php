<div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">User Activity List</h1>
    <div class="m-t-sm">
        <h5 class="m-n font-bold h5 text-uppercase text-dark text-xs">
            <a href="<?= BASE_URL ?>#/app/dashboard">
                <i class="fa fa-home fa-fw"></i>Dashboard</a> /
            <span>User Activity List</span>
        </h5>
    </div>
</div>
<div class="wrapper-md" ng-controller="UserActivityTableCtrl" >
    <div class="panel panel-default" >
        <div class="panel-heading">
            <div class="row padding-0 margin-0">
                <div class="pull-left text-lg">User Activity List</div>
                <div class="pull-right"></div>
            </div>
        </div>
        <div id="permissions" ng-init='setPermission("<?= $pagePermission; ?>")'></div>
        <div class="table-responsive">
            <table  ui-jq="dataTable" ui-options="options" class="table table-striped table-bordered b-t b-b">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Count</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
