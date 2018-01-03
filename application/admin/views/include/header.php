<!-- navbar header -->
<div class="navbar-header bg-info dker">
    <button class="pull-right visible-xs dk" ui-toggle-class="show" data-target=".navbar-collapse">
        <i class="glyphicon glyphicon-cog"></i>
    </button>
    <button class="pull-right visible-xs" ui-toggle-class="off-screen" data-target=".app-aside" ui-scroll-to="app">
        <i class="glyphicon glyphicon-align-justify"></i>
    </button>
    <!-- brand -->
    <a href="#/" class="navbar-brand text-lt">
        <i class="fa fa-check fa-fw"></i>
        <img src="<?= IMG_URL; ?>logo.png" alt="." class="hide">
        <span class="hidden-folded m-l-xs">{{app.name}}</span>
    </a>
    <!-- / brand -->
</div>
<!-- / navbar header -->

<!-- navbar collapse -->
<div class="collapse pos-rlt navbar-collapse box-shadow bg-info">
    <!-- buttons -->
    <div class="nav navbar-nav hidden-xs">
        <a href class="btn no-shadow navbar-btn" ng-click="app.settings.asideFolded = !app.settings.asideFolded">
            <i class="fa {{app.settings.asideFolded ? 'fa-indent' : 'fa-dedent'}} fa-fw text-white"></i>
        </a>
        <a href class="btn no-shadow navbar-btn" ui-toggle-class="show" target="#aside-user">
            <i class="icon-user fa-fw text-white"></i>
        </a>
    </div>
    <!-- / buttons -->

    <!-- link and dropdown -->
    <ul class="nav navbar-nav hidden-sm">

    </ul>
    <!-- / link and dropdown -->

    <!-- search form -->
    <!--form class="navbar-form navbar-form-sm navbar-left shift" ui-shift="prependTo" target=".navbar-collapse" role="search" ng-controller="TypeaheadDemoCtrl">
        <div class="form-group">
            <div class="input-group">
                <input type="text" ng-model="selected" typeahead="state for state in states | filter:$viewValue | limitTo:8" class="form-control input-sm bg-light no-border rounded padder" placeholder="Search here...">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-sm bg-light rounded"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </div>
    </form-->
    <!-- / search form -->

    <!-- nabar right -->
    <ul class="nav navbar-nav navbar-right">
        <li class="hidden-xs">
            <a ui-fullscreen></a>
        </li>
        <li class="dropdown" dropdown>
            <a href class="dropdown-toggle clear" dropdown-toggle>
                <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
                    <img src="<?= IMG_URL; ?>profile32.png" alt="...">
                    <i class="on md b-white bottom"></i>
                </span>
                <span class="hidden-sm hidden-md profileFullName"><?= $this->session->userdata('ADMINFULLNAME'); ?></span> <b class="caret"></b>
            </a>
            <!-- dropdown -->
            <ul class="dropdown-menu animated fadeInRight w">
                <li>
                    <a ui-sref="app.profile.update"><i class="fa fa-user fa-fw"></i> Update Profile</a>
                </li>
                <li>
                    <a ui-sref="app.profile.password"><i class="fa fa-key fa-fw"></i> Change Password</a>
                </li>
                <li>
                    <a ui-sref="app.profile.settings"><i class="fa fa-cogs fa-fw"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a ui-sref="access.lock"><i class="fa fa-lock fa-fw"></i> Lock (Ctrl + Shft + x)</a>
                </li>
                <li>
                    <a href="<?= BASE_URL; ?>logout"><i class="fa fa-power-off fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- / dropdown -->
        </li>
    </ul>
    <!-- / navbar right -->

</div>
<!-- / navbar collapse -->
