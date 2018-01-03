<div class="bg-light lter b-b wrapper-md" ng-controller="GalleryDataCtrl">
    <h1 class="m-n font-thin h3">Manage Gallery</h1>
    <div class="m-t-sm">
        <h5 class="m-n font-bold h5 text-uppercase text-dark text-xs">
            <a href="<?= BASE_URL ?>#/app/dashboard">
                <i class="fa fa-home fa-fw"></i>Dashboard</a> /
            <a href="<?= BASE_URL ?>#/app/gallery/list">Manage Gallery</a> /
            <span>{{operationName}}</span>
        </h5>
    </div>
</div>
<div class="wrapper-md" ng-controller="GalleryDataCtrl" >
    <div id="permissions" ng-init='setPermission("<?= $pagePermission; ?>")'></div>
    <div class="panel panel-default">     
        <div class="panel-heading font-bold">
            <div class="row padding-0 margin-0">
                <div class="pull-left">Gallery Information</div>
                <div class="pull-right">The sign with <span class="text-danger">*</span> are mandatory fields.</div>
            </div>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" name="form"
                  enctype="multipart/form-data" 
                  data-file-upload="options" >

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="vGalleryName">Gallery Name<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" 
                               class="form-control" 
                               id="vImageName" 
                               name="vImageName" 
                               placeholder="Gallery Name" 
                               ng-model="gallery.vGalleryName" 
                               required />

                        <div class="clearfix">
                            <div ng-show="form.$submitted || form.vGalleryName.$touched">
                                <div class="error-red" ng-show="form.vGalleryName.$error.required">Please enter gallery name</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <div nv-file-drop="" uploader="uploader" filters="customFilter">
                        <label class="col-sm-2 control-label" for="vGalleryImage">Upload Gallery Images</label>
                        <div class="col-sm-10">
                            <input ui-jq="filestyle" 
                                   type="file" 
                                   data-icon="false" 
                                   id="vGalleryImage" 
                                   data-classButton="btn btn-default" 
                                   data-classInput="form-control inline v-middle input-s" 
                                   ng-model="gallery.vGalleryImage" 
                                   nv-file-select="" 
                                   accept="image/*" 
                                   multiple
                                   uploader="uploader" >

                            <table class="table bg-white-only b-a m-t">
                                <thead>
                                    <tr>
                                        <th width="50%">Name</th>
                                        <th ng-show="uploader.isHTML5">Size</th>
                                        <th ng-show="uploader.isHTML5">Progress</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in uploader.queue">

                                        <td><strong>{{item.file.name}}</strong></td>
                                        <td ng-show="uploader.isHTML5" nowrap>{{item.file.size / 1024 / 1024|number:2}} MB</td>
                                        <td ng-show="uploader.isHTML5">
                                            <div class="progress progress-sm m-b-none m-t-xs">
                                                <div class="progress-bar bg-info" role="progressbar" ng-style="{'width': item.progress + '%' }"></div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span ng-show="item.isSuccess" class="text-success"><i class="glyphicon glyphicon-ok"></i></span>
                                            <span ng-show="item.isCancel" class="text-warning"><i class="glyphicon glyphicon-ban-circle"></i></span>
                                            <span ng-show="item.isError" class="text-danger"><i class="glyphicon glyphicon-remove"></i></span>
                                        </td>
                                        <td nowrap>
                                            <button type="button" class="btn btn-info btn-xs" 
                                                    ng-show="false" 
                                                    ng-click="item.upload()" 
                                                    ng-disabled="item.isReady || item.isUploading || item.isSuccess">
                                                <span class="glyphicon glyphicon-upload"></span> Upload
                                            </button>
                                            <a type="button" class="btn btn-danger btn-xs" ng-click="removeFile(item)" ng-disabled="item.isReady || item.isUploading || item.isSuccess">
                                                <i class="fa fa-trash"></i>&nbsp; Remove
                                            </a>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>

                            <div class="m-t-sm col-lg-12 padding-0">

                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 padding-0" ng-repeat="uploaded in uploadedItem">

                                    <div class="col-lg-12 p-a-5">

                                        <div class="col-lg-12 padding-0 bg-light b-a">

                                            <div class="col-lg-12 text-center min-h-1 padding-0">
                                                <a ng-click="openLightboxModal($index)">
                                                    <img ng-src="{{uploaded.url}}"/>
                                                </a>
                                            </div>

                                            <div class="col-lg-12 m-t-sm m-b-sm">
                                                <button class="btn btn-danger btn-xs" ng-click="removeImage($index, {{uploaded.id}} )">
                                                    <i class="fa fa-times fa-fw"></i> Delete
                                                </button>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>


                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a class="btn btn-default" ui-sref="app.gallery.list">Cancel</a>
                        <input type="submit" class="btn btn-info" value="Save Changes" ng-click="uploader.uploadAll()" id="addRecord"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>