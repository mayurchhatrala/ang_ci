<div class="bg-light lter b-b wrapper-md" ng-controller="AdminPermissionDataCtrl">
    <h1 class="m-n font-thin h3">Manage Admin Type Permission</h1>
    <div class="m-t-sm">
        <h5 class="m-n font-bold h5 text-uppercase text-dark text-xs">
            <a href="<?= BASE_URL ?>#/app/dashboard">
                <i class="fa fa-home fa-fw"></i>Dashboard</a> /
            <a href="<?= BASE_URL ?>#/app/permission/list">Manage Admin Type Permission</a> /
            <span>{{operationName}}</span>
        </h5>
    </div>
</div>
<div class="wrapper-md" ng-controller="AdminPermissionDataCtrl" >
    <div id="permissions" ng-init='setPermission("<?= $pagePermission; ?>")'></div>
    <div class="panel panel-default">     
        <div class="panel-heading font-bold">
            <div class="row padding-0 margin-0">
                <div class="pull-left">Admin Type Permission</div>
                <div class="pull-right">The sign with <span class="text-danger">*</span> are mandatory fields.</div>
            </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" name="form"
                  enctype="multipart/form-data" 
                  data-file-upload="options" >
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vAdminTitle">Admin Type Name</label>
                    <div class="col-sm-10">
                        <label class="control-label text-uppercase font-bold">{{permission.adminTypeName}}</label>
                    </div>
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>

                <div class="form-group">
                    <table class="table table-striped table-bordered b-t b-b">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center">Page</th>
                                <th colspan="7" class="text-center">Action</th>
                            </tr>
                            <tr>
                                <th class="text-center">Insert</th>
                                <th class="text-center">Update</th>
                                <th class="text-center">Delete</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">View</th>
                                <th class="text-center">No Access</th>
                                <th class="text-center">All Access</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="pageVal in pages">
                                <td class="text-center">{{pageVal.title}}</td>
                                <td class="text-center" ng-repeat="actionVal in pageVal.action">
                                    <div class="checkbox">
                                        <label class="i-checks">
                                            <input type="checkbox" 
                                                   ng-init="permission.action[pageVal.id][actionVal.actionId] = actionVal.actionPermission"
                                                   ng-model="permission.action[pageVal.id][actionVal.actionId]"
                                                   ng-value="{{actionVal.actionId}}" 
                                                   ng-click="checkUncheck(pageVal.id, actionVal.actionId)"
                                                   ng-checked="{{actionVal.actionPermission}}">
                                            <i></i>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a class="btn btn-default" ui-sref="app.permission.list">Cancel</a>
                        <input type="submit" class="btn btn-info" value="Save Changes" ng-click="saveFormClick()" ng-disabled="form.$invalid"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>