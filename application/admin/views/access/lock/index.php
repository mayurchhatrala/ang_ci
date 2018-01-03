<div class="modal-over bg-black" ng-controller="LockScreenController">
    <div class="modal-center animated fadeInUp text-center" style="width:200px;margin:-100px 0 0 -100px;">
        <div class="thumb-lg">
            <img src="<?= IMG_URL; ?>profile32.png" class="img-circle">
        </div>
        <p class="h4 m-t m-b"><?= $this->session->userdata('ADMINFULLNAME'); ?></p>
        <form name="form" class="form-validation">
            <div class="input-group">
                <input type="password" 
                       class="form-control text-sm btn-rounded no-border" 
                       placeholder="Enter password" 
                       ng-model="user.password" 
                       autofocus
                       required>
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-success btn-rounded no-border" ng-click="crackLock()" ng-disabled='form.$invalid'>
                        <i class="fa fa-arrow-right" style="font-size: 1.435em;"></i>
                    </button>
                </span>
            </div>
            <div class="text-center wrapper">
                <a href="<?= BASE_URL; ?>logout" title="Log out"><i class="fa fa-power-off text-danger fa-2x"></i></a>
            </div>
            <div class="text-danger wrapper text-center" ng-show="authError">
                {{authError}}
            </div>
        </form>
    </div>
</div>