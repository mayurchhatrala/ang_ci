<div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="app.settings.asideFolded = false;
        app.settings.asideDock = false;">
    <!-- main -->
    <div class="col">
        <!-- main header -->
        <div class="bg-light lter b-b wrapper-md">
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <h1 class="m-n font-thin h3 text-black">Dashboard</h1>
                    <small class="text-muted">Overview, Statistics and more</small>
                </div>
            </div>
        </div>
        <!-- / main header -->
        <div class="wrapper-md">
            <!-- stats -->
            <div class="row">
                <div class="col-md-12">
                    <div class="row row-sm text-center">
                        <div class="col-sm-4 col-xs-6">
                            <a ui-sref="app.category.list" class="block panel padder-v bg-info item">
                                <span class="text-white font-thin h1 block"><?= $data['category']; ?></span>
                                <span class="text-muted text-sm">Category</span>
                                <span class="bottom text-right w-full">
                                    <i class="fa fa-users text-muted m-r-sm"></i>
                                </span>
                            </a>
                        </div>
                        <div class="col-sm-4 col-xs-6">
                            <a ui-sref="app.retailer.list" class="block panel padder-v bg-info item">
                                <span class="text-white font-thin h1 block"><?= $data['retailer']; ?></span>
                                <span class="text-muted text-sm">Retailer</span>
                                <span class="bottom text-right w-full">
                                    <i class="fa fa-users text-muted m-r-sm"></i>
                                </span>
                            </a>
                        </div>
                        <div class="col-sm-4 col-xs-6">
                            <a ui-sref="app.banner.list" class="block panel padder-v bg-info item">
                                <span class="text-white font-thin h1 block"><?= $data['banner']; ?></span>
                                <span class="text-muted text-sm">Banner</span>
                                <span class="bottom text-right w-full">
                                    <i class="fa fa-users text-muted m-r-sm"></i>
                                </span>
                            </a>
                        </div>
                        <div class="col-sm-4 col-xs-6">
                            <a ui-sref="app.weeklyads.list" class="block panel padder-v  bg-success item">
                                <span class="text-white font-thin h1 block"><?= $data['weeklyads']; ?></span>
                                <span class="text-muted text-sm">Weekly Ads</span>
                                <span class="bottom text-right w-full">
                                    <i class="fa fa-users text-muted m-r-sm"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / stats -->
        </div>
    </div>
    <!-- / main -->

    <div class="col w-md bg-white-only b-l bg-auto no-border-xs">
        <div class="padder-md">      
            <!-- streamline -->
            <div class="m-b text-md m-t-lg">Recent Activity</div>

            <?php $allActivity = getRecentActivity($this->session->userdata('ADMINID'), TRUE); ?>

            <div class="streamline b-l m-b">

                <?php
                if (!empty($allActivity)) {
                    for ($i = 0; $i < 9; $i++) {
                        if (isset($allActivity[$i])) {
                            $log = $allActivity[$i];
                            $actClassName = '';
                            $actId = (int) $log['activityId'];

                            switch ($actId) {
                                case 1:
                                    $actClassName = 'b-success';
                                    break;

                                case 2:
                                    $actClassName = 'b-info';
                                    break;

                                case 3:
                                    $actClassName = 'b-danger';
                                    break;
                            }
                            ?>
                            <div class="sl-item b-l <?= $actClassName; ?>">
                                <div class="m-l">
                                    <div class="text-muted"><?= $log['acitvityDate']; ?></div>
                                    <p><?= $log['userName'] . ' ' . $log['activityBeforeString'] . ' ' . $log['activityString'] . ($actId != 9 ? ' in ' . $log['pageName'] : ''); ?>.</p>
                                </div>
                            </div>
                            <?php
                        }
                    }
                } else {
                    ?>
                    <div class="sl-item b-l b-danger">
                        <div class="m-l">
                            <div class="text-muted">&nbsp;</div>
                            <p>No Recent activity found!!</p>
                        </div>
                    </div>
                    <?php
                }
                ?>

            </div>
            <!-- / streamline -->
        </div>
    </div>
    <!-- / right col -->
</div>