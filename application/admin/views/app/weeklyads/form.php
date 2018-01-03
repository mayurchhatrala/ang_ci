<div class="wrapper-md" ng-controller="WeeklyDataCtrl">
    <!-- toaster directive -->
    <toaster-container toaster-options="{'position-class': 'toast-top-right', 'close-button':true}"></toaster-container>
    <!-- / toaster directive -->
    <div class="panel panel-default">     
        <div class="panel-heading font-bold">Weekly Ads Information

            <div class="pull-right"> * are mandatory fields. </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" name="form" enctype="multipart/form-data">

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="prFirstName"> Name  <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" 
                               class="form-control" 
                               id="vAdsName" 
                               name="vAdsName" 
                               placeholder="Enter Name" 
                               ng-model="weekly.vAdsName" 
                               required>

                        <div class="required" ng-show="form.$submitted || form.vAdsName.$touched">
                            <span ng-show="form.vAdsName.$error.required">Name is required.</span>
                        </div> 
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="prFirstName"> Website Link <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" 
                               class="form-control" 
                               id="prUserName" 
                               name="prUserName" 
                               placeholder="Enter Website Link" 
                               ng-model="weekly.vAdsLink" 
                               required>

                        <div class="required" ng-show="form.$submitted || form.prUserName.$touched">
                            <span ng-show="form.prUserName.$error.required">Website link is required.</span>
                        </div> 
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <!--div class="form-group" ng-init=checkCategoryList()>
                    <label class="col-sm-2 control-label" for="iCategoryID">Category Name<span class="required">*</span></label>
                    <div class="col-sm-10" >
                        <select id="iCategoryID" name="iCategoryID" ng-model="weekly.iCategoryID" class="form-control" 
                                ng-options="item.categoryId as item.categoryName for item in categoryList"
                                ng-change="checkRetailerList(weekly.iCategoryID)"
                                ng-selected="weekly.iCategoryID == item.categoryId"
                                ng-disabled="!weekly.vAdsLink" required >
                            <option value="">Select Category</option>
                        </select>
                        <div class="required" ng-show="form.$submitted || form.iCategoryID.$touched">
                            <span ng-show="form.iCategoryID.$error.required">Category is required.</span>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group" >
                    <label class="col-sm-2 control-label" for="iCategoryID">Retailer Name<span class="required">*</span></label>
                    <div class="col-sm-10" >
                        <select id="iRetailerID" name="iRetailerID" ng-model="weekly.iRetailerID" class="form-control" 
                                ng-options="rItem.retailerId as rItem.retailerName for rItem in retailerList"
                                ng-selected="weekly.iRetailerID == item.retailerId"
                                ng-disabled="!weekly.iCategoryID" required >
                            <option value="">Select Retailer</option>
                        </select>
                        <div class="required" ng-show="form.$submitted || form.iRetailerID.$touched">
                            <span ng-show="form.iRetailerID.$error.required">Retailer is required.</span>
                        </div>
                    </div>
                </div-->

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="iCategoryID">Category Name<span class="required">*</span></label>
                    <div class="col-sm-10" ng-init=checkCategoryList()>
                        <ui-select ng-change="checkRetailerList($select.selected.categoryId)" ng-model="weekly.iCategoryID" theme="bootstrap" style="width:300px;">
                            <ui-select-match placeholder="Select Category">{{$select.selected.categoryName}}</ui-select-match>
                            <ui-select-choices repeat="citem in categoryList | propsFilter: {categoryName: $select.search}">
                                <small ng-bind-html="citem.categoryName | highlight: $select.search"></small>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="iCategoryID">Retailer Name<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <ui-select  ng-model="weekly.iRetailerID" theme="bootstrap" style="width:300px;">
                            <ui-select-match placeholder="Select Retailer">{{$select.selected.retailerName}}</ui-select-match>
                            <ui-select-choices repeat="ritem in retailerList | propsFilter: {retailerName: $select.search}">
                                <small ng-bind-html="ritem.retailerName | highlight: $select.search"></small>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Expiry Date</label>
                    <div class="col-sm-10" ng-controller="DatepickerDemoCtrl">
                        <div class="input-group w-md">
                            <!-- value="{{weekly.dtEndDate | date: 'yyyy-MM-dd'}}" -->
                            <input type="text" class="form-control" name="dtDate" ng-model="weekly.dtEndDate" datepicker-popup="{{format}}" is-open="opened" min="minStartDate" max="maxStartDate" datepicker-options="dateOptions" close-text="Close" title="Expiry date is required" />
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                            </span>
                        </div>
                        <div class="required" ng-show="form.$submitted || form.dtDate.$touched">
                            <span class="error required" ng-show="form.dtDate.$error.required"> Expiry date is required. </span>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vCategoryIcon"> Category Icon </label>
                    <div class="col-sm-9" ng-init="imageArray.length = 1">
                        <div ng-repeat="choice in imageArray" class="col-lg-8">
                            <div id="image_{{$index}}">
                                <div class="col-lg-8">
                                    <input type="file" multiple
                                           class="col-lg-12"
                                           name="myImage" 
                                           ng-model="user.image"
                                           ngf-select
                                           ngf-min-Height="300"
                                           ngf-min-Width="500"
                                           accept="image/jpeg,image/png" /> 

                                    <span class="error col-lg-12" ng-show="form.myImage.$error.image"> Not a JPEG or a PNG! </span>
                                    <div class="required" ng-show="form.$submitted || form.myImage.$touched">
                                        <span class="error col-lg-12" ng-show="form.myImage.$error.minWidth"> Invalid Width </span>
                                        <span class="error col-lg-12" ng-show="form.myImage.$error.minHeight"> Invalid Height </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div ng-if="adsImageArray" ng-show="adsImageArray" class="col-lg-9 padding-0 margin-5">
                        <div ng-repeat="(key, value) in adsImageArray" class="col-lg-3">
                            <div class="col-lg-12">
                                <img src="<?= IMAGE_URL; ?>Weekly/{{weekly.iAdsID}}/thumb/100/{{value}}" height="<?= IMAGE_Hight; ?>" width="<?= IMAGE_Width ?>" />
                            </div>                            
                            <div class="col-lg-12">
                                <button class="btn btn-danger btn-xs" ng-click="removeImage({{key}})">
                                    <i class="fa fa-times fa-fw"></i> Delete
                                </button>
                            </div>                            
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vCategoryIcon"></label>
                    <label class="col-sm-8" for="vCategoryIcon"> Note: Image size should be bigger than 960 X 1704. If its not in proportion then it will show same in the application.  </label>
                </div>

                <div class="line line-dashed b-b line-lg pull-in" ng-if="weekly.dtEndDate != ''" ng-show="weekly.dtEndDate != ''"></div>
                <div class="form-group" ng-if="weekly.dtEndDate != ''" ng-show="weekly.dtEndDate != ''">
                    <label class="col-sm-2 control-label" for="dtEndDate"></label>
                    <label class="col-sm-8" for="dtEndDate"> This weekly add will expire on {{weekly.dtEndDate}} </label>
                </div>
                
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a class="btn btn-default" ui-sref="app.weeklyads.list">Cancel</a>
                        <button type="submit" id="saveBtn" ng-disabled="form.$invalid"
                                class="btn btn-info" value="Save Changes" ng-click="saveFormClick()"> 
                            <i class="fa fa-refresh fa-spin" ng-if="SubmitDisPlay" ng-show="SubmitDisPlay"> </i> 
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>