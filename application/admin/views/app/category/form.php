<div class="wrapper-md" ng-controller="CategoryDataCtrl">

    <!-- toaster directive -->

    <toaster-container toaster-options="{'position-class': 'toast-top-right', 'close-button':true}"></toaster-container>

    <!-- / toaster directive -->

    <div class="panel panel-default">     

        <div class="panel-heading font-bold">Category Information



            <div class="pull-right"> * are mandatory fields. </div>

        </div>

        <div class="panel-body">

            <form class="form-horizontal" name="form" enctype="multipart/form-data">



                <div class="form-group">

                    <label class="col-sm-2 control-label" for="prFirstName"> Category Name <span class="required">*</span></label>

                    <div class="col-sm-10">

                        <input type="text" 

                               class="form-control" 

                               id="prUserName" 

                               name="prUserName" 

                               placeholder="Enter User Name" 

                               ng-model="category.vCategoryName" 

                               ui-event="{ keyup : 'checkCategoryName($event)'}"

                               required>



                        <div id="UserNameError" style="display:none"> Category name already in use. </div> 

                        <div class="required" ng-show="form.$submitted || form.prUserName.$touched">

                            <span ng-show="form.prUserName.$error.required">Category name is required.</span>

                        </div> 

                    </div>

                </div>



                <div class="line line-dashed b-b line-lg pull-in"></div>

                <div class="form-group">

                    <label class="col-sm-2 control-label" for="vCategoryIcon"> Category Icon </label>

                    <div class="col-sm-1" ng-if="category.vCategoryIcon" ng-show="category.vCategoryIcon"> 

                        <img src="<?= IMAGE_URL; ?>Category/{{category.iCategoryID}}/{{category.vCategoryIcon}}" height="<?= IMAGE_Hight; ?>" width="<?= IMAGE_Width ?>" />

                    </div>

                    <div class="col-sm-9" >

                        <input type="file" file="file" 

                               name="image" 
                               ng-model="image"

                               accept="image/*" 

                               ng-class="{'has-error': form.image.$invalid && form.image.$dirty }" /> 

                    </div>

                </div>



                <div class="line line-dashed b-b line-lg pull-in"></div>

                <div class="form-group">

                    <div class="col-sm-4 col-sm-offset-2">

                        <a class="btn btn-default" ui-sref="app.category.list">Cancel</a>

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