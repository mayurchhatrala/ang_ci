<div class="wrapper-md" ng-controller="BannerDataCtrl">

    <!-- toaster directive -->

    <toaster-container toaster-options="{'position-class': 'toast-top-right', 'close-button':true}"></toaster-container>

    <!-- / toaster directive -->

    <div class="panel panel-default">     

        <div class="panel-heading font-bold">Banner Ads Information



            <div class="pull-right"> * are mandatory fields. </div>

        </div>

        <div class="panel-body">

            <form class="form-horizontal" name="form" enctype="multipart/form-data">



                <div class="form-group">

                    <label class="col-sm-2 control-label" for="RetailerName">Website Link <span class="required">*</span></label>

                    <div class="col-sm-10">

                        <input type="text" 

                               class="form-control" 

                               id="vRetailerName" 

                               name="vRetailerName" 

                               placeholder="Enter Website Link" 

                               ng-model="banner.vBannerLink" 

                               required>



                        <div class="required" ng-show="form.$submitted || form.vRetailerName.$touched">

                            <span ng-show="form.vRetailerName.$error.required">Website link is required.</span>

                        </div> 

                    </div>

                </div>



                <div class="line line-dashed b-b line-lg pull-in"></div>

                <div class="form-group">

                    <label class="col-sm-2 control-label" for="vRetailerLogo"> Banner Image </label>



                    <div class="col-sm-1" ng-if="banner.vBannerIcon != ''" ng-show="banner.vBannerIcon != ''"> 

                        <img src="<?= IMAGE_URL; ?>Banner/{{banner.iBannerID}}/{{banner.vBannerIcon}}" height="<?= IMAGE_Hight; ?>" 

                             width="<?= IMAGE_Width ?>" />

                    </div>

                    <div class="col-sm-9" >

                        <input type="file" file="file" ng-model="retailer.file" name="image" accept="image/*" />

                        <div id="retailerImage" class="error-red" style="display: none"> Please select any small image. </div>

                    </div>

                    <span ng-show="form.image.$error.file">Image size should be bigger than 920 X 350. Upload only png, jpg, jpeg.</span>
                    
                    <label class="col-sm-4" for="vCategoryIcon"> Note: Image size should be bigger than 920 X 350 </label>

                </div> 



                <div class="line line-dashed b-b line-lg pull-in"></div>

                <div class="form-group">

                    <div class="col-sm-4 col-sm-offset-2">

                        <a class="btn btn-default" ui-sref="app.banner.list">Cancel</a>

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