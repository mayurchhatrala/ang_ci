<div class="bg-light lter b-b wrapper-md" ng-controller="GoogleMAPCtrl">
    <h1 class="m-n font-thin h3">Google MAP</h1>
    <div class="m-t-sm">
        <h5 class="m-n font-bold h5 text-uppercase text-dark text-xs">
            <a href="<?= BASE_URL ?>#/app/dashboard">
                <i class="fa fa-home fa-fw"></i>Dashboard</a> /
            <span>Google MAP</span>
        </h5>
    </div>
</div>
<div class="wrapper-md" ng-controller="GoogleMAPCtrl" >
    <div id="permissions" ng-init='setPermission("<?= $pagePermission; ?>")'></div>
    <div class="panel panel-default">     
        <div class="panel-heading font-bold">Google MAP</div>
        <div class="panel-body">
            <form class="form-horizontal" name="form"
                  enctype="multipart/form-data" 
                  data-file-upload="options" >

                <div class="form-group">
                    <label class="col-sm-2 control-label">Manage MAP</label>
                    <div class="col-sm-10">
                        <div class="col-lg-12 m-t-sm">
                            <input type="hidden" ng-model="gmap.latitude" />
                            <input type="hidden" ng-model="gmap.logitude" />
                        </div>
                    </div>
                    <map zoom="3"></map>

                </div>

            </form>
        </div>
    </div>
</div>