<div class="container w-xxl w-auto-xs white-box" ng-controller="ResetPWDFormController" ng-init="app.settings.container = false;">
    <div class="text-center m-t"><img src="<?= UPLD_URL; ?>images/common/logo.png" alt="{{app.name}}" title="{{app.name}}" /></div>
    <a href class="navbar-brand block">{{app.name}}</a>
    <div class="m-b-lg">
        <div class="wrapper text-center">
            <strong>Reset Password</strong>
        </div>
        <form name="form" class="form-validation">
            <input type="hidden" id="isLoginPage" name="isLoginPage" value="yes" />
            <div class="list-group list-group-sm">
                <div class="list-group-item">
                    <input type="password" placeholder="New Password" class="form-control no-border" ng-model="user.password" required>
                </div>
                <div class="list-group-item">
                    <input type="password" placeholder="Confirm Password" class="form-control no-border" ng-model="user.confirmpassword" password-match="user.password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-lg btn-info btn-block" ng-click="resetpwd()" ng-disabled='form.$invalid'>Reset Password</button>
            <div class="text-center m-t m-b"><a ui-sref="access.signin">Sign In</a></div>
            <div class="line line-dashed"></div>
        </form>
    </div>
    <div class="text-center">

    </div>
</div>
