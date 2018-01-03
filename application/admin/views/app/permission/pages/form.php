<div class="bg-light lter b-b wrapper-md" ng-controller="AdminPagesDataCtrl">
    <h1 class="m-n font-thin h3">Manage Admin Pages</h1>
    <div class="m-t-sm">
        <h5 class="m-n font-bold h5 text-uppercase text-dark text-xs">
            <a href="<?= BASE_URL ?>#/app/dashboard">
                <i class="fa fa-home fa-fw"></i>Dashboard</a> /
            <a href="<?= BASE_URL ?>#/app/pages/list">Manage Admin Pages</a> /
            <span>{{operationName}}</span>
        </h5>
    </div>
</div>
<div class="wrapper-md" ng-controller="AdminPagesDataCtrl" >
    <div id="permissions" ng-init='setPermission("<?= $pagePermission; ?>")'></div>
    <div class="panel panel-default">     
        <div class="panel-heading font-bold">
            <div class="row padding-0 margin-0">
                <div class="pull-left">Admin Pages Information</div>
                <div class="pull-right">The sign with <span class="text-danger">*</span> are mandatory fields.</div>
            </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" name="form"
                  enctype="multipart/form-data" 
                  data-file-upload="options" >

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vPageTitle">Page Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" 
                               class="form-control" 
                               id="vPageTitle" 
                               name="vPageTitle" 
                               placeholder="Page Name" 
                               ng-model="permission.vPageTitle" 
                               required />

                        <div class="clearfix">
                            <div ng-show="form.$submitted || form.vPageTitle.$touched">
                                <div class="error-red" ng-show="form.vPageTitle.$error.required">Please enter page title</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vPageState">Page State<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" 
                               class="form-control" 
                               id="vPageState" 
                               name="vPageState" 
                               placeholder="Page State" 
                               ng-model="permission.vPageState" 
                               required />

                        <div class="clearfix">
                            <div ng-show="form.$submitted || form.vPageState.$touched">
                                <div class="error-red" ng-show="form.vPageState.$error.required">Please enter page state</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="iPageModuleID">Module Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select class="form-control" 
                                id="iPageModuleID"
                                ng-model="permission.iPageModuleID"
                                required 
                                placeholder="Select Admin Modules" >
                            <option value="">Select any admin module</option>
                            <?php
                            for ($i = 0; $i < count($modulesData); $i++) {
                                echo '<option value="' . $modulesData[$i]['moduleId'] . '">' . $modulesData[$i]['moduleName'] . '</option>';
                            }
                            ?>
                        </select>

                        <div class="clearfix">
                            <div ng-show="form.$submitted || form.iPageModuleID.$touched">
                                <div class="error-red" ng-show="form.iPageModuleID.$error.required">Please select any admin module</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="iOrderVal">Page Order<span class="text-danger">*</span></label>
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
                                <div class="error-red" ng-show="form.iOrderVal.$error.required">Please enter page order value</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a class="btn btn-default" ui-sref="app.pages.list">Cancel</a>
                        <input type="submit" class="btn btn-info" value="Save Changes" ng-click="saveFormClick()" ng-disabled="form.$invalid"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>