<div class="container w-xxl w-auto-xs white-box" ng-controller="SigninFormController" ng-init="app.settings.container = false;">
    <div class="text-center m-t"><img src="<?= UPLD_URL; ?>images/common/logo.png" alt="{{app.name}}" title="{{app.name}}" /></div>
    <a href class="navbar-brand block">{{app.name}}</a>
    <div class="m-b-lg">
        <div class="wrapper text-center">
            <strong>Sign in to get in touch</strong>
        </div>
        <form name="form" class="form-validation">
            <div class="text-danger wrapper text-center" ng-show="authError">
                {{authError}}
            </div>
            <input type="hidden" id="isLoginPage" name="isLoginPage" value="yes" />
            <div class="list-group list-group-sm">
                <div class="list-group-item">
                    <input type="email" 
                           ng-pattern="/^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/" 
                           placeholder="Email" 
                           class="form-control no-border" 
                           ng-model="user.email" required autofocus>
                </div>
                <div class="list-group-item">
                    <input type="password" placeholder="Password" class="form-control no-border" ng-model="user.password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-lg btn-info btn-block" ng-click="login()" ng-disabled='form.$invalid'>Log in</button>
            <!--div class="text-center m-t m-b"><a ui-sref="access.forgotpwd">Forgot password?</a></div-->
            <div class="line line-dashed"></div>
        </form>
    </div>
    <div class="text-center">

    </div>
</div>
