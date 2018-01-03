<div class="hbox hbox-auto-xs hbox-auto-sm">
    <div class="col">
        <?php $this->load->view('app/profile/banner'); ?>
        <?php
        $data['tabs'] = 1;
        $this->load->view('app/profile/tabs', $data);
        ?>
        <div class="wrapper-md" ng-controller="ProfileUpdateCtrl">
            <!-- toaster directive -->
            <toaster-container toaster-options="{'position-class': 'toast-top-right', 'close-button':true}"></toaster-container>
            <!-- / toaster directive -->
            <div class="panel panel-default">     
                <div class="panel-heading font-bold">Update Profile</div>
                <div class="panel-body">
                    <form class="form-horizontal" name="form">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="firstName">First Name</label>
                            <div class="col-sm-10">
                                <input type="text" 
                                       class="form-control" 
                                       id="firstName" 
                                       name="firstName" 
                                       placeholder="First Name" 
                                       ng-model="profile.firstName" 
                                       required>

                                <div class="clearfix">
                                    <div ng-show="form.$submitted || form.firstName.$touched">
                                        <div class="error-red" ng-show="form.firstName.$error.required">Please enter first name</div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="lastName">Last Name</label>
                            <div class="col-sm-10">
                                <input type="text" 
                                       class="form-control" 
                                       id="lastName" 
                                       name="lastName" 
                                       placeholder="Last Name" 
                                       ng-model="profile.lastName" 
                                       required>

                                <div class="clearfix">
                                    <div ng-show="form.$submitted || form.lastName.$touched">
                                        <div class="error-red" ng-show="form.lastName.$error.required">Please enter last name</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="emailId">Email Address</label>
                            <div class="col-sm-10">
                                <input type="email" 
                                       class="form-control" 
                                       id="emailId" 
                                       name="emailId" 
                                       placeholder="Email Address" 
                                       ng-model="profile.emailId" 
                                       required>

                                <div class="clearfix">
                                    <div ng-show="form.$submitted || form.emailId.$touched">
                                        <div class="error-red" ng-show="form.emailId.$error.required">Please enter email address</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <input type="hidden" value="<?= $this->session->userdata('ADMINID'); ?>" id="requestId" />
                                <input type="submit" class="btn btn-info" value="Save changes" ng-click="updateProfileClick()" ng-disabled="form.$invalid" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>