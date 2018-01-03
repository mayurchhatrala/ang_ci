<div class="bg-light lter b-b wrapper-md" ng-controller="AdminModulesDataCtrl">
    <h1 class="m-n font-thin h3">Manage Admin Modules</h1>
    <div class="m-t-sm">
        <h5 class="m-n font-bold h5 text-uppercase text-dark text-xs">
            <a href="<?= BASE_URL ?>#/app/dashboard">
                <i class="fa fa-home fa-fw"></i>Dashboard</a> /
            <a href="<?= BASE_URL ?>#/app/modules/list">Manage Admin Modules</a> /
            <span>{{operationName}}</span>
        </h5>
    </div>
</div>
<div class="wrapper-md" ng-controller="AdminModulesDataCtrl" >
    <div id="permissions" ng-init='setPermission("<?= $pagePermission; ?>")'></div>
    <div class="panel panel-default">     
        <div class="panel-heading font-bold">
            <div class="row padding-0 margin-0">
                <div class="pull-left">Admin Modules Information</div>
                <div class="pull-right">The sign with <span class="text-danger">*</span> are mandatory fields.</div>
            </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" name="form"
                  enctype="multipart/form-data" 
                  data-file-upload="options" >
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vModuleName">Module Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" 
                               class="form-control" 
                               id="vModuleName" 
                               name="vModuleName" 
                               placeholder="Module Name" 
                               ng-model="permission.vModuleName" 
                               required />

                        <div class="clearfix">
                            <div ng-show="form.$submitted || form.vModuleName.$touched">
                                <div class="error-red" ng-show="form.vModuleName.$error.required">Please enter module name</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vModuleIcon">Module Icon<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" 
                               class="form-control" 
                               id="vModuleIcon" 
                               name="vModuleIcon" 
                               placeholder="Module Icon" 
                               ng-model="permission.vModuleIcon" 
                               required />

                        <div class="clearfix">
                            <div ng-show="form.$submitted || form.vModuleIcon.$touched">
                                <div class="error-red" ng-show="form.vModuleIcon.$error.required">Please enter module icon name</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="iOrderVal">Module Order<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" 
                               class="form-control" 
                               id="iOrderVal" 
                               name="iOrderVal" 
                               placeholder="Order Value" 
                               ng-model="permission.iOrderVal" 
                               required />

                        <div class="clearfix">
                            <div ng-show="form.$submitted || form.iOrderVal.$touched">
                                <div class="error-red" ng-show="form.iOrderVal.$error.required">Please enter module order value</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="isDeveloper">For Development</label>
                    <div class="col-sm-10">
                        <label class="i-checks">
                            <input type="checkbox" 
                                   ng-model="permission.isDeveloper" 
                                   id="isDeveloper"
                                   name="isDeveloper" 
                                   ng-value="permission.isDeveloper"
                                   ng-init="permission.isDeveloper"/>
                            <i></i>
                        </label>
                        <div class="clearfix">
                        <label class="text-info-dk text-md"><strong>Note: </strong>If checked, the module will be used for development purpose.</label>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a class="btn btn-default" ui-sref="app.modules.list">Cancel</a>
                        <input type="submit" class="btn btn-info" value="Save Changes" ng-click="saveFormClick()" ng-disabled="form.$invalid"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>