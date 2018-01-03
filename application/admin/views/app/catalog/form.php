<div class="wrapper-md" ng-controller="CatalogDataCtrl">
    <!-- toaster directive -->
    <toaster-container toaster-options="{'position-class': 'toast-top-right', 'close-button':true}"></toaster-container>
    <!-- / toaster directive -->
    <div class="panel panel-default">     
        <div class="panel-heading font-bold">Catalogs Information

            <div class="pull-right"> * are mandatory fields. </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" name="form" enctype="multipart/form-data">

                <!-- div class="form-group">
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
                </div-->

                <!--div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group" ng-init=checkCategoryList()>
                    <label class="col-sm-2 control-label" for="iCategoryID">Category Name<span class="required">*</span></label>
                    <div class="col-sm-10" >
                        <select id="iCategoryID" name="iCategoryID" ng-model="catalog.iCategoryID" class="form-control" 
                                ng-options="item.categoryId as item.categoryName for item in categoryList"
                                ng-change="checkRetailerList(catalog.iCategoryID)"
                                ng-selected="catalog.iCategoryID == item.categoryId"
                                <option>Select Category</option>
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
                        <select id="iRetailerID" name="iRetailerID" ng-model="catalog.iRetailerID" class="form-control" 
                                ng-options="rItem.retailerId as rItem.retailerName for rItem in retailerList"
                                ng-selected="catalog.iRetailerID == item.retailerId"
                                ng-disabled="!catalog.iCategoryID" required >
                            <option value="">Select Retailer</option>
                        </select>
                        <div class="required" ng-show="form.$submitted || form.iRetailerID.$touched">
                            <span ng-show="form.iRetailerID.$error.required">Retailer is required.</span>
                        </div>
                    </div>
                </div-->

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vCatalogName"> Catalog Name <span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" 
                               class="form-control" 
                               id="vCatalogName" 
                               name="vCatalogName" 
                               placeholder="Enter Catalog Name" 
                               ng-model="catalog.vCatalogName" 
                               required>

                        <div class="required" ng-show="form.$submitted || form.vCatalogName.$touched">
                            <span ng-show="form.vCatalogName.$error.required">Catalog Name is required.</span>
                        </div> 
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="iCategoryID">Category Name<span class="required">*</span></label>
                    <div class="col-sm-10" ng-init=checkCategoryList()>
                        <ui-select id="iCategoryID" ng-change="checkRetailerList($select.selected.categoryId)" ng-model="catalog.iCategoryID" theme="bootstrap" style="width:300px;">
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
                        <ui-select ng-disabled="!catalog.iCategoryID && retailerList.STATUS == '101'" ng-model="catalog.iRetailerID" theme="bootstrap" style="width:300px;">
                            <ui-select-match placeholder="Select Retailer">{{$select.selected.retailerName}}</ui-select-match>
                            <ui-select-choices ng-disabled="retailerList.STATUS == '101'" repeat="ritem in retailerList | propsFilter: {retailerName: $select.search}">
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
                            <input type="text" class="form-control" name="dtDate" ng-model="catalog.dtEndDate" datepicker-popup="{{format}}" is-open="opened" min="minStartDate" max="maxStartDate" datepicker-options="dateOptions" close-text="Close" title="Expiry date is required" />
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
                    <label class="col-sm-2 control-label" for="vCategoryIcon"> Catalog Icon </label>
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

                    <div class="col-lg-2"></div>
                    <div ng-if="adsImageArray" ng-show="adsImageArray" class="col-lg-9 padding-0 margin-5">
                        <div ng-repeat="(key, value) in adsImageArray" class="col-lg-3">
                            <div class="col-lg-12">
                                <img src="<?= IMAGE_URL; ?>Catalog/{{catalog.iCatalogID}}/thumb/292/{{value}}" height="<?= IMAGE_Hight; ?>" width="<?= IMAGE_Width ?>" />
                            </div>                            
                            <div class="col-lg-12">
                                <button class="btn btn-danger btn-xs" ng-click="removeImage({{key}})">
                                    <i class="fa fa-times fa-fw"></i> Delete
                                </button>
                            </div>                            
                        </div>
                    </div>
                </div>
                


                <!--div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vCategoryIcon"></label>
                    <label class="col-lg-10 control-label" for="vCategoryIcon"> <button class="btn btn-success" ng-click="add()">Add More</button> </label>
                    <div ng-repeat="item in items">
                        <div class="col-sm-10">
                            <input type="file" class="form-control" name="myImage_{{$index}}" multiple image-with-preview ng-model="image" accept="image/jpeg,image/png" dimensions="height < 656">
                            <input type="button" class="btn btn-info form-control" name="check" value="Remove Image" /> 
                        </div>
                    </div>
                </div-->


                <!--div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vCategoryIcon"> Catalog Icon </label>
                    <div class="col-sm-1" ng-if="catalog.catalogImage" ng-show="catalog.catalogImage"> 
                        <img src="<?= IMAGE_URL; ?>Category/{{catalog.iCategoryID}}/{{catalog.catalogImage}}" height="<?= IMAGE_Hight; ?>" width="<?= IMAGE_Width ?>" />
                    </div>
                    <div class="col-sm-9" >
                        <input type="file" file="file" 
                               ng-model="weekly.file"
                               name="image" 
                               accept="image/*" 
                               multiple
                               ng-class="{'has-error': form.image.$invalid && form.image.$dirty }" /> 
                    </div>

                    <div ng-if="adsImageArray" ng-show="adsImageArray" class="col-lg-9 padding-0 margin-5">
                        <div ng-repeat="(key, value) in adsImageArray" class="col-lg-3">
                            <div class="col-lg-12">
                                <img src="<?= IMAGE_URL; ?>Catalog/{{catalog.iCatalogID}}/thumb/292/{{value}}" height="<?= IMAGE_Hight; ?>" width="<?= IMAGE_Width ?>" />
                            </div>                            
                            <div class="col-lg-12">
                                <button class="btn btn-danger btn-xs" ng-click="removeImage({{key}})">
                                    <i class="fa fa-times fa-fw"></i> Delete
                                </button>
                            </div>                            
                        </div>
                    </div>
                </div-->
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vCategoryIcon"></label>
                    <label class="col-sm-8" for="vCategoryIcon"> Note: Image size should be bigger than 960 X 1704. Upload only png, jpg, jpeg.
You can upload multiple images at once by clicking on and pressing shift key and selecting multiple at once. </label>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a class="btn btn-default" ui-sref="app.catalog.list">Cancel</a>
                        <button type="submit"  id="saveBtn" ng-disabled="form.$invalid"
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