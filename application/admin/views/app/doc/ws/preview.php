<div class="modal-body wrapper-lg" ng-controller="WSPreviewCtrl">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="m-t-none m-b font-thin">Preview</h1>
            <div class="col-sm-12 margin-0 padding-0">
                <section>
                    <div class="padding-10 margin-5">
                        <h3 id="key">{{doc.info.wsTitle}}</h3>
                        <h4>{{doc.info.wsURL}}</h4>
                    </div>
                    <div class="bg-light b-l-black b-l-2x padding-10 margin-5">
                        <h4>Type</h4>
                        <div class="bs-callout bs-callout-info">
                            <h5>Type : <code class="label bg-info text-uppercase">{{doc.info.wsType}}</code></h5>
                        </div>
                    </div>
                    <div class="bg-light b-l-black b-l-2x padding-10 margin-5">
                        <h4>Header Parameters</h4>
                        <b class="label bg-info m-r-xs" ng-repeat="header in headerValues">{{header.title}}</b>
                        <br><br>
                        <p class="text-danger">{{doc.info.wsDesc}}</p>
                    </div>
                    <div class="bg-light b-l-black b-l-2x padding-10 margin-5">
                        <h4>Supported Formats</h4>  
                        <b class="label bg-info m-r-xs" ng-repeat="format in allSupportFormat" ng-show="doc.info.wsSuportedFormat[format.formatId] == true">{{format.formatName}}</b>
                    </div>

                    <div class="bg-light b-l-black b-l-2x padding-10 margin-5" ng-show="inputValues">
                        <h4>Input</h4>
                        <div class="bg-white padding-10">
                            <table class="table table-striped table-bordered b-t b-b table-responsive" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Default Value</th>
                                        <th>Require</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="input in inputValues">
                                        <td>{{input.name}}</td>
                                        <td><b class="label bg-danger">{{input.type}}</b></td>
                                        <td>{{input.value}}</td>
                                        <td>{{input.require}}</td>
                                        <td>{{input.desc}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-light b-l-black b-l-2x padding-10 margin-5">
                        <h4>Output</h4>
                        <div class="row margin-0 padding-0">
                            <h5>Success</h5>
                            <pre class="bg-white"><code>{{doc.output.success}}</code></pre>
                        </div>
                        <div class="row margin-0 padding-0">
                            <h5>Fail</h5>
                            <pre class="bg-white"><code>{{doc.output.fail}}</code></pre>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>