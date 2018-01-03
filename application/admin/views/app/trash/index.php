<div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="app.settings.asideFolded = false;
                app.settings.asideDock = false;">
    <!-- main -->
    <div class="col">
        <!-- main header -->
        <div class="bg-light lter b-b wrapper-md">
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <h1 class="m-n font-thin h3 text-black">Trash</h1>
                    <small class="text-muted">Overview & Statistics</small>
                </div>
            </div>
        </div>
        <!-- / main header -->
        <div class="wrapper-md" ng-controller="TrashListCtrl">
            <script type="text/ng-template" id="detailContent.html">
<?php $this->load->view('app/trash/detail'); ?>
            </script>

            <!-- stats -->
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $allPages = getMenuListWithPermission();
                    foreach ($allPages AS $mKey => $mVal) {
                        $mPages = $mVal['pages'];
                        ?>
                        <div class="col-md-12">
                            <div class="panel wrapper">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="font-thin m-t-none m-b-md text-muted"><?= $mKey; ?></h4>
                                        <?php
                                        for ($i = 0; $i < count($mPages); $i++) {
                                            $permissionsArr = $mPages[$i]['permission'];
                                            $rec_count = $mPages[$i]['rec_count'];
                                            $percent = $rec_count['fresh'] != 0 ? round((($rec_count['trash'] / $rec_count['fresh']) * 100)) : 0;
                                            //echo $rec_count['trash'] . ' ' . $rec_count['fresh'];
                                            if (!empty($permissionsArr)) {
                                                ?>
                                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
                                                    <div ui-jq="easyPieChart" ui-options="{percent: <?= $percent; ?>,lineWidth: 10,trackColor: '#e8eff0',barColor: '#23b7e5',scaleColor: false,size: 100,rotate: 90,lineCap: 'butt'}" class="inline m-t">
                                                        <div>
                                                            <span class="text-primary h4"><?= $percent; ?>%</span>
                                                        </div>
                                                    </div>
                                                    <div class="text-muted font-bold text-xs m-t m-b">
                                                        <a href="javascript:void(0);" ng-click="lookInAround('<?= $mPages[$i]['state']; ?>')"><?= $mPages[$i]['name']; ?></a>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!-- /state -->
        </div>
    </div>
    <!-- / main -->
</div>