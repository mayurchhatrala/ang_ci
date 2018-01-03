<div class="bg-light lter b-b wrapper-md" ng-controller="TemplateEmailFormDataCtrl">
    <h1 class="m-n font-thin h3">Manage Email Templates</h1>
    <div class="m-t-sm">
        <h5 class="m-n font-bold h5 text-uppercase text-dark text-xs">
            <a href="<?= BASE_URL ?>#/app/dashboard">
                <i class="fa fa-home fa-fw"></i>Dashboard</a> /
            <a href="<?= BASE_URL ?>#/template/email/list">Manage Email Templates</a> /
            <span>{{operationName}}</span>
        </h5>
    </div>
</div>
<div class="wrapper-md" ng-controller="TemplateEmailFormDataCtrl" >
    <div id="permissions" ng-init='setPermission("<?= $pagePermission; ?>")'></div>
    <div class="panel panel-default">     
        <div class="panel-heading font-bold">
            <div class="row padding-0 margin-0">
                <div class="pull-left">Email Template Information</div>
                <div class="pull-right">The sign with <span class="text-danger">*</span> are mandatory fields.</div>
            </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" name="form"
                  enctype="multipart/form-data" 
                  data-file-upload="options" >

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vTemplateName">Email Template Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" 
                               class="form-control" 
                               id="vTemplateName" 
                               name="vTemplateName" 
                               placeholder="Template Name" 
                               ng-model="template.vTemplateName" 
                               required />

                        <div class="clearfix">
                            <div ng-show="form.$submitted || form.vTemplateName.$touched">
                                <div class="error-red" ng-show="form.vTemplateName.$error.required">Please enter template name</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vTemplateAlias">Email Template Alias<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" 
                               class="form-control" 
                               id="vTemplateAlias" 
                               name="vTemplateAlias" 
                               placeholder="Template Alias" 
                               ng-pattern="/^[a-zA-Z]*$/"
                               ng-model="template.vTemplateAlias" 
                               required />

                        <div class="clearfix">
                            <div ng-show="form.$submitted || form.vTemplateAlias.$touched">
                                <div class="error-red" ng-show="form.vTemplateAlias.$error.required">Please enter template alias</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="templateContent">Email Content<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <textarea class="ck-editor" 
                                  id="tTemplateContent" 
                                  ng-model="template.tTemplateContent" required=""></textarea>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a class="btn btn-default" ui-sref="template.email.list">Cancel</a>
                        <input type="submit" class="btn btn-info" value="Save Changes" ng-click="saveFormClick()" ng-disabled="form.$invalid"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>