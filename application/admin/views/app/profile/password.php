<div class="hbox hbox-auto-xs hbox-auto-sm">
    <div class="col">
        <?php $this->load->view('app/profile/banner'); ?>
        <?php
        $data['tabs'] = 2;
        $this->load->view('app/profile/tabs', $data);
        ?>
        <div class="wrapper-md" ng-controller="PasswordUpdateCtrl">
            <!-- toaster directive -->
            <toaster-container toaster-options="{'position-class': 'toast-top-right', 'close-button':true}"></toaster-container>
            <!-- / toaster directive -->
            <div class="panel panel-default">     
                <div class="panel-heading font-bold">Change Password</div>
                <div class="panel-body">
                    <form class="form-horizontal" name="form">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="oldPassword">Current Password</label>
                            <div class="col-sm-10">
                                <input type="password" 
                                       class="form-control" 
                                       id="oldPassword" 
                                       name="oldPassword" 
                                       placeholder="Current Password" 
                                       ng-model="password.oldPassword" 
                                       required />

                                <div class="clearfix">
                                    <div ng-show="form.$submitted || form.oldPassword.$touched">
                                        <div class="error-red" ng-show="form.oldPassword.$error.required">Please enter current password</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="newPassword">New Password</label>
                            <div class="col-sm-10">
                                <input type="password" 
                                       class="form-control" 
                                       id="newPassword" 
                                       name="newPassword" 
                                       placeholder="New Password" 
                                       ng-model="password.newPassword" 
                                       equals="{{password.confirmPassword}}" 
                                       required />

                                <div class="clearfix">
                                    <div ng-show="form.$submitted || form.newPassword.$touched">
                                        <div class="error-red" ng-show="form.newPassword.$error.required">Please enter new password</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="confirmPassword">Confirm Password</label>
                            <div class="col-sm-10">
                                <input type="password" 
                                       class="form-control" 
                                       id="confirmPassword" 
                                       name="confirmPassword" 
                                       placeholder="Confirm Password" 
                                       ng-model="password.confirmPassword" 
                                       equals="{{password.newPassword}}" 
                                       required />

                                <div class="clearfix">
                                    <div ng-show="form.$submitted || form.confirmPassword.$touched">
                                        <div class="error-red" ng-show="form.confirmPassword.$error.required">Please enter confirm password</div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <input type="hidden" value="<?= $this->session->userdata('ADMINID'); ?>" id="requestId" />
                                <input type="submit" class="btn btn-info" value="Save changes" ng-click="updatePasswordClick()" ng-disabled="form.$invalid"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>