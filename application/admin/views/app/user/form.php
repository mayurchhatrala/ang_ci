<div class="bg-light lter b-b wrapper-md" ng-controller="UserDataCtrl">
    <h1 class="m-n font-thin h3">Manage User</h1>
    <div class="m-t-sm">
        <h5 class="m-n font-bold h5 text-uppercase text-dark text-xs">
            <a href="<?= BASE_URL ?>#/app/dashboard">
                <i class="fa fa-home fa-fw"></i>Dashboard</a> /
            <a href="<?= BASE_URL ?>#/app/user/list">Manage User</a> /
            <span>{{operationName}}</span>
        </h5>
    </div>
</div>
<div class="wrapper-md" ng-controller="UserDataCtrl" >
    <div id="permissions" ng-init='setPermission("<?= $pagePermission; ?>")'></div>
    <div class="panel panel-default">     
        <div class="panel-heading font-bold">
            <div class="row padding-0 margin-0">
                <div class="pull-left">User Information</div>
                <div class="pull-right">The sign with <span class="text-danger">*</span> are mandatory fields.</div>
            </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" name="form"
                  enctype="multipart/form-data" 
                  data-file-upload="options" >
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vFirstName">First Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" 
                               class="form-control" 
                               id="vFirstName" 
                               name="vFirstName" 
                               placeholder="Paul" 
                               ng-model="user.vFirstName" 
                               required />

                        <div class="clearfix">
                            <div ng-show="form.$submitted || form.vFirstName.$touched">
                                <div class="error-red" ng-show="form.vFirstName.$error.required">Please enter first name</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vLastName">Last Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" 
                               class="form-control" 
                               id="vLastName" 
                               name="vLastName" 
                               placeholder="Walker" 
                               ng-model="user.vLastName" 
                               required />

                        <div class="clearfix">
                            <div ng-show="form.$submitted || form.vLastName.$touched">
                                <div class="error-red" ng-show="form.vLastName.$error.required">Please enter last name</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vEmail">Email<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="email" 
                               class="form-control" 
                               id="vEmail" 
                               name="vEmail" 
                               placeholder="paulwalker@email.com" 
                               ng-model="user.vEmail" 
                               required />

                        <div class="clearfix">
                            <div ng-show="form.$submitted || form.vEmail.$touched">
                                <div class="error-red" ng-show="form.vEmail.$error.required">Please enter email address</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vPassword">Password<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="password" 
                               class="form-control" 
                               id="vPassword" 
                               name="vPassword" 
                               placeholder="Please enter password" 
                               ng-model="user.vPassword" 
                               required />
                        <div class="clearfix">
                            <div ng-show="form.$submitted || form.vPassword.$touched">
                                <div class="error-red" ng-show="form.vPassword.$error.required">Please enter password</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="iAdminTypeID">Admin Type<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select class="form-control" 
                                id="iAdminTypeID" 
                                name="iAdminTypeID" 
                                ng-model="user.iAdminTypeID" 
                                required >
                            <option value="">Select Admin Type</option>
                            <?php
                            for ($i = 0; $i < count($adminTypeVal); $i++) {
                                echo '<option value="' . $adminTypeVal[$i]['adminTypeId'] . '">' . $adminTypeVal[$i]['adminTitle'] . '</option>';
                            }
                            ?>
                        </select>
                        <div class="clearfix">
                            <div ng-show="form.$submitted || form.iAdminTypeID.$touched">
                                <div class="error-red" ng-show="form.iAdminTypeID.$error.required">Please select admin type</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a class="btn btn-default" ui-sref="app.user.list">Cancel</a>
                        <input type="submit" class="btn btn-info" value="Save Changes" ng-click="saveFormClick()" ng-disabled="form.$invalid" id="addRecord"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>