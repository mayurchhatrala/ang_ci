<div class="bg-light lter b-b wrapper-md" ng-controller="UserActivityViewDataCtrl">
    <h1 class="m-n font-thin h3">User Activity List</h1>
    <div class="m-t-sm">
        <h5 class="m-n font-bold h5 text-uppercase text-dark text-xs">
            <a href="<?= BASE_URL ?>#/app/dashboard">
                <i class="fa fa-home fa-fw"></i>Dashboard</a> /
            <a href="<?= BASE_URL ?>#/app/logs/activity/list">User Activity List</a> /
            <span>{{operationName}}</span>
        </h5>
    </div>
</div>
<div class="wrapper-md" ng-controller="UserActivityViewDataCtrl" >
    <div id="permissions" ng-init='setPermission("<?= $pagePermission; ?>")'></div>
    <div class="panel panel-default">     
        <div class="panel-heading font-bold">User Activity</div>
        <div class="panel-body">
            <div class="col">
                <div class="wrapper">
                    <ul class="timeline">

                        <li class="tl-item" ng-repeat="values in activity.activities">
                            <div class="tl-wrap {{ (values.activityId == '1' ? 'b-success' : (values.activityId == '2' ? 'b-info' : (values.activityId == '3' ? 'b-danger' : '')))}}">
                                <span class="tl-date">{{values.acitvityDate}}</span>
                                <div class="tl-content panel padder b-a">
                                    <span class="arrow left pull-up"></span>
                                    <div>{{values.userName}} {{values.activityBeforeString}} {{values.activityString}}  {{ (values.activityId != '9' ? ' in ' + values.pageName : '')}}   from {{values.acitvityIP}}</div>
                                </div>
                            </div>
                        </li>

                        <li class="tl-header">
                            <button class="btn btn-sm btn-default btn-rounded" ng-click="loadMore()">more</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>