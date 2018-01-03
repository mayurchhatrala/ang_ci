<div class="bg-light lter b-b wrapper-md" ng-controller="AdminTypeDataCtrl">
    <h1 class="m-n font-thin h3">Manage Admin Types</h1>
    <div class="m-t-sm">
        <h5 class="m-n font-bold h5 text-uppercase text-dark text-xs">
            <a href="<?= BASE_URL ?>#/app/dashboard">
                <i class="fa fa-home fa-fw"></i>Dashboard</a> /
            <a href="<?= BASE_URL ?>#/app/permission/type">Manage Admin Types</a> /
            <span>{{operationName}}</span>
        </h5>
    </div>
</div>
<div class="wrapper-md" ng-controller="AdminTypeDataCtrl" >
    <div id="permissions" ng-init='setPermission("<?= $pagePermission; ?>")'></div>
    <div class="panel panel-default">     
        <div class="panel-heading font-bold">
            <div class="row padding-0 margin-0">
                <div class="pull-left">Admin Type Information</div>
                <div class="pull-right">The sign with <span class="text-danger">*</span> are mandatory fields.</div>
            </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" name="form"
                  enctype="multipart/form-data" 
                  data-file-upload="options" >
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vAdminTitle">Admin Type Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" 
                               class="form-control" 
                               id="vAdminTitle" 
                               name="vAdminTitle" 
                               placeholder="Super Admin" 
                               ng-model="admintype.vAdminTitle" 
                               required />

                        <div class="clearfix">
                            <div ng-show="form.$submitted || form.vAdminTitle.$touched">
                                <div class="error-red" ng-show="form.vAdminTitle.$error.required">Please enter admin type name</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="accessPage">Accessible Pages<span class="text-danger">*</span></label>
                    <div class="col-sm-10">

                        <ui-select multiple ng-model="admintype.accessPage" theme="bootstrap">
                            <ui-select-match placeholder="Select Any Page" id="searchField">{{$item.name}}</ui-select-match>
                            <ui-select-choices repeat="types in allPages | propsFilter: {name: $select.search}">
                                <div ng-bind-html="types.name"></div>
                            </ui-select-choices>
                        </ui-select>

                        <div class="clearfix">
                            <div ng-show="form.$submitted || form.accessPage.$touched">
                                <div class="error-red" ng-show="form.accessPage.$error.required">Please select any page.</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="accessType">Administrator Role<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <ui-select multiple ng-model="admintype.accessType" theme="bootstrap">
                            <ui-select-match placeholder="Select Any Page" id="searchField">{{$item.adminTitle}}</ui-select-match>
                            <ui-select-choices repeat="types in allAdminTypes | propsFilter: {adminTitle: $select.search}">
                                <div ng-bind-html="types.adminTitle"></div>
                            </ui-select-choices>
                        </ui-select>
                        
                        <div class="clearfix">
                            <div ng-show="form.$submitted || form.accessType.$touched">
                                <div class="error-red" ng-show="form.accessType.$error.required">Please select any administrator type.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a class="btn btn-default" ui-sref="app.permission.type">Cancel</a>
                        <input type="submit" class="btn btn-info" value="Save Changes" ng-click="saveFormClick()" ng-disabled="form.$invalid"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>