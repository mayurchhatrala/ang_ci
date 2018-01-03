<div class="aside-wrap">
    <!-- if you want to use a custom scroll when aside fixed, use the slimScroll
      <div class="navi-wrap" ui-jq="slimScroll" ui-options="{height:'100%', size:'8px'}">
    -->
    <div class="navi-wrap">
        <!-- user -->
        <div class="clearfix hidden-xs text-center hide" id="aside-user">
            <div class="dropdown wrapper" dropdown>
                <a ui-sref="app.page.profile">
                    <span class="thumb-lg w-auto-folded avatar m-t-sm">
                        <img src="<?= IMG_URL; ?>profile32.png" class="img-full" alt="<?= $this->session->userdata('ADMINFULLNAME'); ?>">
                    </span>
                </a>
                <a href class="dropdown-toggle hidden-folded" dropdown-toggle>
                    <span class="clear">
                        <span class="block m-t-sm">
                            <strong class="font-bold text-lt"><?= $this->session->userdata('ADMINFULLNAME'); ?></strong> 
                            <b class="caret"></b>
                        </span>
                        <span class="text-muted text-xs block">@<?= $this->session->userdata('ADMINTYPENAME'); ?></span>
                    </span>
                </a>
                <!-- dropdown -->
                <ul class="dropdown-menu animated fadeInRight w hidden-folded">
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
            </div>
            <div class="line dk hidden-folded"></div>
        </div>
        <!-- / user -->

        <!-- nav -->
        <nav ui-nav class="navi clearfix" >
            <?php $this->load->view('include/nav'); ?>
        </nav>
        <!-- nav -->

    </div>
</div>