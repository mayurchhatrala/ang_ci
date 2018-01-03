<div style="background:url(<?= IMG_URL; ?>c4.jpg) center center; background-size:cover">
    <div class="wrapper-lg bg-white-opacity">
        <div class="row m-t">
            <div class="col-sm-7">
                <a href class="thumb-lg pull-left m-r">
                    <img src="<?= IMG_URL; ?>profile32.png" class="img-circle">
                </a>
                <div class="clear m-b">
                    <div class="m-b m-t-sm">
                        <span class="h3 text-black profileFullName"><?= $this->session->userdata('ADMINFULLNAME'); ?></span>
                        <small class="m-l">@<?= $this->session->userdata('ADMINTYPENAME'); ?></small>
                    </div>
                    <div class="m-b m-t-sm">
                        <div class="col-lg-6 m-l-n">
                            <strong>Last Login: </strong> <?= date(DATE_OBJ_FORMAT, $this->session->userdata('LAST_LOGIN')); ?>
                        </div>
                        <div class="col-lg-6 m-l-n">
                            <strong>Last Login IP: </strong><?= $this->session->userdata('LAST_IP'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>