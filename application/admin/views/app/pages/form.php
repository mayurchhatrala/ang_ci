<div class="wrapper-md" ng-controller="PagesDataCtrl">
    <!-- toaster directive -->
    <toaster-container toaster-options="{'position-class': 'toast-top-right', 'close-button':true}"></toaster-container>
    <!-- / toaster directive -->
    <div class="panel panel-default">     
        <div class="panel-heading font-bold">
            Page Content Information <div class="pull-right"> * are mandatory fields. </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" name="form" enctype="multipart/form-data">

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="prProductName">Name<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" 
                               class="form-control" 
                               id="prPageName" 
                               name="prPageName"
                               placeholder="Enter Page Name" 
                               ng-model="pages.vPageName" 
                               ui-event="{ keyup : 'checkPageName($event)'}"
                               autocomplete="off"
                               required>

                        <div id="emailError" style="display:none"> Page Name already in use. </div> 
                        <div class="required" ng-show="form.$submitted || form.prPageName.$touched">
                            <span ng-show="form.prPageName.$error.required">Page name is required.</span>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="prProductName">Content<span class="required">*</span></label>
                    <div class="col-sm-10">
                        <div text-angular ng-model="pages.tContent" class="btn-groups"></div>                            
                    </div>
                </div>


                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a class="btn btn-default" ui-sref="app.content.list">Cancel</a>
                        <button type="submit" id="saveBtn" ng-disabled="form.$invalid"
                                class="btn btn-info" value="Save Changes" ng-click="saveSubCategory()"> 
                            <i class="fa fa-refresh fa-spin" ng-if="SubmitDisPlay" ng-show="SubmitDisPlay"> </i> 
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>