<!-- list -->

<ul class="nav">

    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">

        <span translate="aside.nav.HEADER">Navigation</span>

    </li> 

    <li>

        <a ui-sref="app.dashboard">

            <i class="fa fa-home fa-fw text-lg"></i>

            <span class="font-bold" translate="aside.nav.DASHBOARD">Dashboard</span>

        </a>

    </li>

    <li class="line dk"></li>



    <?php

    $allPages = getMenuListWithPermission();

    //_print_r($allPages, TRUE);

    foreach ($allPages AS $mKey => $mVal) {

        $mPages = $mVal['pages'];

        ?>

        <li>

            <a href class="auto">

                <span class="pull-right text-muted">

                    <i class="fa fa-fw fa-angle-right text"></i>

                    <i class="fa fa-fw fa-angle-down text-active"></i>

                </span>

                

                <i class="fa fa-<?= $mVal['moduleIcon']; ?> fa-fw text-lg"></i>

                <span class="font-bold"><?= $mKey; ?></span>

            </a>



            <ul class="nav nav-sub dk">

                <?php

                for ($i = 0; $i < count($mPages); $i++) {

                    $permissionsArr = $mPages[$i]['permission'];

                    

                    if ($this->session->userdata('ADMINTYPE') == 1 || !empty($permissionsArr)) {

                        ?>

                        <li>

                            <a ui-sref="<?= $mPages[$i]['state']; ?>" class="page-click" data-page="<?= $mPages[$i]['id']; ?>">

                                <span><?= $mPages[$i]['name']; ?></span>

                            </a>

                        </li>

                        <?php

                    }

                }

                ?>

            </ul>

        </li>

        <li class="line dk"></li>



    <?php } ?>

</ul>

<!-- / list -->

