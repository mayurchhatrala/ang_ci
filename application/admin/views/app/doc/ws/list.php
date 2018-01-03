<div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Manage Web Services</h1>
    <div class="m-t-sm">
        <h5 class="m-n font-bold h5 text-uppercase text-dark text-xs">
            <a href="<?= BASE_URL ?>#/app/dashboard">
                <i class="fa fa-home fa-fw"></i>Dashboard</a> /
            <span>Manage Web Services</span>
        </h5>
    </div>
</div>

<div class="hbox hbox-auto-xs"  ng-controller="WSmanageCtrl" style="height: 786px ! important;">

    <div id="permissions" ng-init='setPermission("<?= $pagePermission; ?>")'></div>
    <!-- column -->
    <div class="col w-lg lt b-r">
        <div class="vbox">
            <div class="wrapper">
                <a href class="pull-right btn btn-sm btn-info m-t-n-xs btn-addon" ng-click="createWS()" ng-disabled="visibleForm"><i class="fa fa-plus"></i>&nbsp; Add New</a>
                <div class="h4">Web Services</div>
            </div>
            <div class="wrapper b-t m-t-xxs">
                <div class="m-t-sm m-b-sm">
                    <a class="btn btn-default btn-sm btn-addon" 
                       href="<?= BASE_URL; ?>doc/preview" target="_new"
                       ng-disabled="allWS.length <= 0">
                        <i class="fa fa-eye"></i>&nbsp; Preview
                    </a> &nbsp;
                    <a class="btn btn-default btn-sm btn-addon" 
                       href="<?= BASE_URL; ?>doc/download" 
                       ng-disabled="allWS.length <= 0">
                        <i class="fa fa-download"></i>&nbsp; Download 
                    </a>
                </div>
                <div class="input-group m-t-md">
                    <span class="input-group-addon input-sm"><i class="fa fa-search"></i></span>
                    <input type="text" 
                           class="form-control input-sm" 
                           placeholder="search" ng-model="searchWS">
                </div>
            </div>
            <div class="row-row">
                <div class="cell scrollable hover">
                    <div class="cell-inner">
                        <div class="padder">
                            <div class="list-group">

                                <a class="list-group-item b-l-danger b-l-3x hover-anchor" 
                                   ng-repeat="ws in allWS| filter:searchWS"
                                   ng-click="selectWS(ws.wsId)">
                                    <span ng-click='deleteWS(ws.wsId)' 
                                          class="pull-right text-muted hover-action">
                                        <i class="fa fa-times"></i>
                                    </span> 
                                    <span class="block text-ellipsis text-capitalize font-bold">{{ws.wsTitle}}</span>
                                    <small class="text-muted text-lowercase">{{ws.wsURL| limitTo:descLimit}}...</small>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- column -->
    <div class="col">
        <div class="vbox">
            <div class="wrapper bg-light lt b-b">
                <div class="row margin-0 padding-0">
                    <span class="text-dark font-bold text-capitalize">&nbsp;{{doc.info.wsTitle}}</span> <span></span>
                </div>
            </div>
            <div class="row-row white-box">
                <div class="h-auto">
                    <div class="panel-body" ng-show="visibleForm">

                        <script type="text/ng-template" id="previewWebService.html">
<?php $this->load->view('app/doc/ws/preview'); ?>
                        </script>

                        <a class="btn btn-default btn-sm btn-addon m-b-sm m-t-sm" ng-click="open()" ng-show="selectedWSID != 0">
                            <i class="fa fa-eye fa-fw"></i>&nbsp; Preview This Service
                        </a> &nbsp;
                        <a class="btn btn-default btn-sm btn-addon m-b-sm m-t-sm" ng-click="cancelWS()">
                            <i class="fa fa-minus fa-fw"></i>&nbsp; Cancel
                        </a>
                        <?php /* <a class="btn btn-success btn-sm btn-addon m-b-sm m-t-sm">
                          <i class="fa fa-code fa-fw"></i>&nbsp; Execute
                          </a> */ ?>

                        <form class="ng-pristine ng-valid" name="form"
                              enctype="multipart/form-data" >

                            <fieldset>
                                <legend class="text-capitalize">Basic Information</legend>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="wsTitle">Title<span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="wsTitle" 
                                               name="wsTitle" 
                                               placeholder="Web Service Title" 
                                               ng-model="doc.info.wsTitle" 
                                               required />

                                        <div class="clearfix">
                                            <div ng-show="form.$submitted || form.wsTitle.$touched">
                                                <div class="error-red" ng-show="form.wsTitle.$error.required">Please enter web service title</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="wsType">Type<span class="text-danger">*</span></label>
                                        <select class="form-control" 
                                                id="wsType" 
                                                name="wsType" 
                                                ng-model="doc.info.wsType" 
                                                required >
                                            <option value="" > - Select Method Type - </option>
                                            <option value="post">POST</option>
                                            <option value="get">GET</option>
                                        </select>

                                        <div class="clearfix">
                                            <div ng-show="form.$submitted || form.wsType.$touched">
                                                <div class="error-red" ng-show="form.wsType.$error.required">Please enter select web service type</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="wsURL">URL<span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="wsURL" 
                                               name="wsURL" 
                                               ng-model="doc.info.wsURL" 
                                               placeholder="http://api.application.com/apiName" 
                                               required />

                                        <div class="clearfix">
                                            <div ng-show="form.wsURL.touched || form.$submitted">
                                                <div class="error-red" ng-show="form.wsURL.$error.required">Please enter web service URL</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Supported Format<span class="text-danger">*</span></label>

                                        <div class="col-lg-12 margin-0 padding-0">

                                            <div class="col-lg-3" ng-repeat="format in allSupportFormat">
                                                <label class="i-checks">
                                                    <input type="checkbox" 
                                                           ng-model="doc.info.wsSuportedFormat[format.formatId]"
                                                           ng-value="format.formatName" 
                                                           ng-init="doc.info.wsSuportedFormat[format.formatId] = (format.formatId == editFormat[$index]['id'])"
                                                           ng-checked="format.formatId == editFormat[$index]['id']"/>
                                                    <i></i> {{format.formatName}} 
                                                </label> 
                                            </div>

                                        </div>
                                    </div>
                                </div>



                            </fieldset>

                            <fieldset class="m-t-md">
                                <legend class="text-capitalize">Header Parameter</legend>

                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label for="wsHeadName">Name<span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="wsHeadName" 
                                               name="wsHeadName" 
                                               placeholder="Header Name" 
                                               ng-model="doc.head.wsHeadName" ng-keyup="validateHeaderForm()"  />
                                    </div>
                                </div>

                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label for="wsHeadValue">Default Value</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="wsHeadValue" 
                                               name="wsHeadValue" 
                                               placeholder="Default Value" 
                                               ng-model="doc.head.wsHeadValue" />
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <a class="btn btn-info btn-sm btn-addon" 
                                           ng-click="addHeader()" 
                                           ng-enter="addHeader()" 
                                           ng-disabled="!doc.head.wsHeadName">
                                            <i class="fa fa-plus"></i>&nbsp; Add
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="wsDesc">Header Description</label>
                                        <textarea class="form-control" 
                                                  id="wsDesc" 
                                                  rows="5"
                                                  name="wsDesc" 
                                                  placeholder="Header Description" 
                                                  ng-model="doc.info.wsDesc"
                                                  >{{doc.info.wsDesc}}</textarea>

                                    </div>
                                </div>

                                <div class="col-lg-12">

                                    <table class="table table-striped table-bordered b-t b-b" ng-show="headerValues">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th colspan="2">Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="head in headerValues">
                                                <td>{{head.title}}</td>
                                                <td>{{head.value}}</td>
                                                <td>
                                                    <a class="btn btn-xs btn-danger"
                                                       ng-click="removeHeader($index)"><i class="fa fa-times fa-fw"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>

                            </fieldset>

                            <fieldset class="m-t-md">
                                <legend class="text-capitalize">Input Parameter</legend>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="wsFieldName">Name<span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="wsFieldName" 
                                               name="wsFieldName" 
                                               placeholder="Field Name" 
                                               ng-model="doc.field.name" 
                                               required />
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="wsFieldType">Type<span class="text-danger">*</span></label>
                                        <select type="text" 
                                                class="form-control" 
                                                id="wsFieldType" 
                                                name="wsFieldType" 
                                                placeholder="Field Type" 
                                                ng-model="doc.field.type" 
                                                required >
                                            <option value=""> - Select field type - </option>
                                            <option ng-value="format.formatName" 
                                                    ng-repeat="format in allSupportInputFormat">{{format.formatName}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="wsFieldValue">Default Value</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="wsFieldValue" 
                                               name="wsFieldValue" 
                                               placeholder="Default Value" 
                                               ng-model="doc.field.value" />
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="wsFieldRequire">Require<span class="text-danger">*</span></label>
                                        <select type="text" 
                                                class="form-control" 
                                                id="wsFieldRequire" 
                                                name="wsFieldRequire" 
                                                placeholder="Field Type" 
                                                ng-model="doc.field.require" 
                                                required >
                                            <option value=""> - Is Require ? - </option>
                                            <option value="yes">Required</option>
                                            <option value="no">Optional</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="wsFieldDesc">Description</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="wsFieldDesc" 
                                               name="wsFieldDesc" 
                                               placeholder="Description" 
                                               ng-model="doc.field.desc" />
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <a class="btn btn-info btn-sm btn-addon" 
                                           ng-disabled="!(doc.field.name && doc.field.type && doc.field.require)" 
                                           ng-click="addInputParam()">
                                            <i class="fa fa-plus"></i>&nbsp; Add
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-12">

                                    <table class="table table-striped table-bordered b-t b-b table-responsive" ng-show="inputValues">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Default Value</th>
                                                <th>Require</th>
                                                <th colspan="2">Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="input in inputValues">
                                                <td>{{input.name}}</td>
                                                <td>{{input.type}}</td>
                                                <td>{{input.value}}</td>
                                                <td>{{input.require}}</td>
                                                <td>{{input.desc}}</td>
                                                <td>
                                                    <a class="btn btn-xs btn-danger" ng-click="removeInputParam($index)"><i class="fa fa-times fa-fw"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>

                            </fieldset>

                            <fieldset class="m-t-md">
                                <legend class="text-capitalize">Output</legend>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="wsSuccOutput" class="text-md">Success Output</label>
                                        <textarea type="text" 
                                                  class="form-control text-success-dk " 
                                                  rows="9"
                                                  id="wsSuccOutput" 
                                                  name="wsSuccOutput" 
                                                  placeholder="{ STATUS:200, MSG:'Successfully Found Records'}" 
                                                  ng-model="doc.output.success">{{doc.output.success}}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="wsFailOutput" class="text-md">Failure Output</label>
                                        <textarea type="text" 
                                                  class="form-control text-danger-dk"
                                                  rows="9"
                                                  id="wsFailOutput" 
                                                  name="wsFailOutput" 
                                                  placeholder="{ STATUS:101, MSG:'Insuffiant Data'}" 
                                                  ng-model="doc.output.fail">{{doc.output.fail}}</textarea>
                                    </div>
                                </div>

                            </fieldset>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <a class="btn btn-info btn-sm btn-addon" ng-click="addWS()">
                                        <i class="fa fa-save"></i>&nbsp; Save
                                    </a>
                                    &nbsp;
                                    <a class="btn btn-danger btn-sm btn-addon" ng-click="deleteWS(selectedWSID)">
                                        <i class="fa fa-times"></i>&nbsp; Delete
                                    </a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>