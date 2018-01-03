<div class="wrapper-md" ng-controller="RetailerDataCtrl">
    <!-- toaster directive -->
    <toaster-container toaster-options="{'position-class': 'toast-top-right', 'close-button':true}"></toaster-container>
    <!-- / toaster directive -->
    <div class="panel panel-default">     
        <div class="panel-heading font-bold">Retailer Information

            <div class="pull-right"> * are mandatory fields. </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" name="form" enctype="multipart/form-data">

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="RetailerName">Retailer Name <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" 
                               class="form-control" 
                               id="vRetailerName" 
                               name="vRetailerName" 
                               placeholder="Enter Retailer Name" 
                               ng-model="retailer.vRetailerName" 
                               required>

                        <div class="required" ng-show="form.$submitted || form.vRetailerName.$touched">
                            <span ng-show="form.vRetailerName.$error.required">Retailer name is required.</span>
                        </div> 
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group" ng-init=checkCategoryList()>
                    <label class="col-sm-2 control-label" for="iCategoryID">Category Name<span class="required">*</span></label>
                    <div class="col-sm-10" >
                        <select id="prCategoryID" name="iCategoryID" ng-model="retailer.iCategoryID" class="form-control" 
                                ng-options="item.categoryId as item.categoryName for item in categoryList"
                                ng-selected="retailer.iCategoryID == item.categoryId"
                                ng-disabled="!retailer.vRetailerName" required >
                            <option value="">Select Category</option>
                        </select>
                        <div class="required" ng-show="form.$submitted || form.iCategoryID.$touched">
                            <span ng-show="form.iCategoryID.$error.required">Category is required.</span>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vRetailerEmail"> Email <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="email" 
                               class="form-control" 
                               id="vRetailerEmail" 
                               name="vRetailerEmail" 
                               placeholder="Enter Email Address" 
                               ng-model="retailer.vRetailerEmail" 
                               required>

                        <div class="required" ng-show="form.$submitted || form.vRetailerEmail.$touched">
                            <span ng-show="form.vRetailerEmail.$error.required">Email Address is required.</span>
                            <span ng-show="form.vRetailerEmail.$error.email">Invalid email address.</span>
                        </div> 
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vRetailerPhone"> Phone <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="number" 
                               class="form-control" 
                               id="vRetailerPhone" 
                               name="vRetailerPhone" 
                               placeholder="Enter Phone Number" 
                               ng-model="retailer.vRetailerPhone" 
                               required />

                        <div class="required" ng-show="form.$submitted || form.vRetailerPhone.$touched">
                            <span ng-show="form.vRetailerPhone.$error.required">Phone is required.</span>
                            <span ng-show="form.vRetailerPhone.$error.number">Invalid phone number.</span>
                        </div> 
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vRetailerLink"> Website Link <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" 
                               class="form-control" 
                               id="vRetailerLink" 
                               name="vRetailerLink" 
                               placeholder="Enter Website Link" 
                               ng-model="retailer.vRetailerLink" 
                               required>

                        <div class="required" ng-show="form.$submitted || form.vRetailerLink.$touched">
                            <span ng-show="form.vRetailerLink.$error.required">Link is required.</span>
                        </div> 
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vRetailerLogo"> Retailer Icon </label>

                    <div class="col-sm-1" ng-if="retailer.vRetailerLogo != ''" ng-show="retailer.vRetailerLogo != ''"> 
                        <img src="<?= IMAGE_URL; ?>Retailer/{{retailer.iRetailerID}}/{{retailer.vRetailerLogo}}" height="<?= IMAGE_Hight; ?>" 
                             width="<?= IMAGE_Width ?>" />
                    </div>
                    <div class="col-lg-8">
                        <input type="file" 
                               class="col-lg-12"
                               name="retailerImage" 
                               ng-model="retailer.file"
                               accept="image/jpeg,image/png"
                               image-with-preview
                               dimensions="width >= 400 && height >= 200" /> 

                        <span class="error col-lg-12" ng-show="form.retailerImage.$error.image"> Upload only png, jpg, jpeg. </span>
                        <span class="error col-lg-12" ng-show="form.retailerImage.$error.dimensions">
                            Image size should be bigger than 400 x 200.
                        </span>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vCategoryIcon"></label>
                    <label class="col-sm-4" for="iCategoryID">Note: Image size should be bigger than 400 X 200 </label>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" style="text-align:right;font-weight:bold">Map</label>
                </div>
                
                <!-- CITY, STATE, COUNTRY DETAIL -->                
                <div class="form-group">
                    <input type="hidden" 
                           class="form-control" 
                           id="vRetailerstreetName" 
                           name="vRetailerstreetName" 
                           placeholder="Enter Website Link" 
                           ng-model="retailer.vRetailerstreetName" >
                </div>
                <div class="form-group">
                    <input type="hidden" 
                           class="form-control" 
                           id="vRetailerstreetNumber" 
                           name="vRetailerstreetNumber" 
                           placeholder="Enter Website Link" 
                           ng-model="retailer.vRetailerstreetNumber" >
                </div>
                <div class="form-group">
                    <input type="hidden" 
                           class="form-control" 
                           id="vRetailerAddressLine" 
                           name="vRetailerAddressLine" 
                           placeholder="Enter Website Link" 
                           ng-model="retailer.vRetailerAddressLine" >
                </div>
                <div class="form-group">
                    <input type="hidden" 
                           class="form-control" 
                           id="vRetailerCity" 
                           name="vRetailerCity" 
                           placeholder="Enter Website Link" 
                           ng-model="retailer.vRetailerCity" >
                </div>
                <div class="form-group">
                    <input type="hidden" 
                           class="form-control" 
                           id="vRetailerDistrict" 
                           name="vRetailerDistrict" 
                           placeholder="Enter Website Link" 
                           ng-model="retailer.vRetailerDistrict" >
                </div>

                <div class="form-group">
                    <input type="hidden" 
                           class="form-control" 
                           id="vRetailerState" 
                           name="vRetailerState" 
                           placeholder="Enter Website Link" 
                           ng-model="retailer.vRetailerState" >
                </div>

                <div class="form-group">
                    <input type="hidden" 
                           class="form-control" 
                           id="vRetailerCountry" 
                           name="vRetailerCountry" 
                           placeholder="Enter Website Link" 
                           ng-model="retailer.vRetailerCountry" >
                </div>
                <!-- CITY, STATE, COUNTRY DETAIL --> 

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vRetailerAddress"> Address <span class="required error-red">*</span></label>
                    <div class="col-sm-4">
                        <textarea 
                            class="form-control" 
                            id="vRetailerAddress" 
                            name="vRetailerAddress"
                            placeholder="Enter Retailer Address" 
                            ng-model="retailer.vRetailerAddress" 
                            required> </textarea>
                        <div class="required" ng-show="form.$submitted || form.vRetailerAddress.$touched">
                            <span ng-show="form.vRetailerAddress.$error.required">Address is required.</span>
                        </div>
                    </div>

                    <label class="col-sm-2 control-label" for="Latitude"> Latitude <span class="required error-red">*</span></label>
                    <div class="col-sm-4">
                        <div class="input-group w-md">
                            <input text-angular class="form-control" id="vLatitude" name="vLatitude" ng-model="retailer.vLatitude" placeholder="Select Latitude" style="width:100%" />
                            <div class="clearfix">
                                <div ng-show="form.$submitted">
                                    <div class="error-red" ng-show="form.vState.$error.required">Please select Latitude</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <label class="col-sm-2 control-label" for="vLongtitude"> Longitude <span class="required error-red">*</span></label>
                    <div class="col-sm-4">
                        <div class="input-group w-md">
                            <input text-angular class="form-control" id="vLongitude" name="vLongtitude" ng-model="retailer.vLongtitude" placeholder="Select Longitude" style="width:100%" />
                            <div class="clearfix">
                                <div ng-show="form.$submitted">
                                    <div class="error-red" ng-show="form.vCity.$error.required">Please select Longitude</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                        <div id="map" style="height:450px"></div>
                    </div>  
                </div> 

                <!--div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vRetailerAddress"> Address <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <textarea 
                            class="form-control" 
                            id="vRetailerAddress" 
                            name="vRetailerAddress"
                            placeholder="Enter Retailer Address" 
                            ng-model="retailer.vRetailerAddress" 
                            required> </textarea>
                        <div class="required" ng-show="form.$submitted || form.vRetailerAddress.$touched">
                            <span ng-show="form.vRetailerAddress.$error.required">Address is required.</span>
                        </div>
                    </div>
                </div-->

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="tRetailerDesc">Description <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <textarea 
                            class="form-control" 
                            id="tRetailerDesc" 
                            name="tRetailerDesc"
                            placeholder="Enter Retailer Description" 
                            ng-model="retailer.tRetailerDesc" 
                            required> </textarea>
                        <div class="required" ng-show="form.$submitted || form.tRetailerDesc.$touched">
                            <span ng-show="form.tRetailerDesc.$error.required">Description is required.</span>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a class="btn btn-default" ui-sref="app.retailer.list">Cancel</a>
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