<div class="hbox hbox-auto-xs hbox-auto-sm">
    <div class="col">
        <?php $this->load->view('app/profile/banner'); ?>
        <?php
        $data['tabs'] = 3;
        $this->load->view('app/profile/tabs', $data);
        ?>
        <div class="wrapper-md" ng-controller="SettingsUpdateCtrl">
            <!-- toaster directive -->
            <toaster-container toaster-options="{'position-class': 'toast-top-right', 'close-button':true}"></toaster-container>
            <!-- / toaster directive -->
            <div class="panel panel-default">     
                <div class="panel-heading font-bold">Change Settings</div>
                <div class="panel-body">
                    <form class="form-horizontal" name="form">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="contactEmail">Contact Email</label>
                            <div class="col-sm-10">
                                <input type="email" 
                                       class="form-control" 
                                       id="contactEmail" 
                                       name="contactEmail" 
                                       placeholder="Contact Email" 
                                       ng-model="settings.contactEmail" 
                                       required>

                                <div class="clearfix">
                                    <div ng-show="form.$submitted || form.contactEmail.$touched">
                                        <div class="error-red" ng-show="form.contactEmail.$error.required">Please enter contact email address</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group" ng-class="{'has-error': form.iRadius.$invalid}">
                            <label class="col-sm-2 control-label" for="companyEmail">Radius</label>
                            <div class="col-sm-10">
                                <input type="number" 
                                       class="form-control" 
                                       id="iRadius" 
                                       name="iRadius" 
                                       placeholder="Radius" 
                                       ng-model="settings.iRadius" 
                                       ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" 
                                       step="0.01"
                                       required />

                                <div class="clearfix">
                                    <div ng-show="form.$submitted || form.iRadius.$touched">
                                        <div class="error-red" ng-show="form.iRadius.$error.required">Please enter radius</div>
                                    </div>
                                    <span class="help-block" ng-show="!form.iRadius.$valid"> Invalid! </span>
                                </div>
                            </div>
                        </div>

                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <input type="hidden" value="<?= $this->session->userdata('ADMINID'); ?>" id="requestId" />
                                <input type="submit" class="btn btn-info" value="Save changes" ng-click="updateSettingsClick()" ng-disabled="form.$invalid" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>