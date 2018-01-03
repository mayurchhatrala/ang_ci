<div class="wrapper-md" ng-controller="UserViewDataCtrl">
    <!-- toaster directive -->
    <toaster-container toaster-options="{'position-class': 'toast-top-right', 'close-button':true}"></toaster-container>
    <!-- / toaster directive -->
    <div class="panel panel-default">     
        <div class="panel-heading font-bold">User Information

            <div class="pull-right"></div>
        </div>
        <div class="panel-body">
            
            
            <div class="col-sm-6">
                <label class="col-sm-4" for="vUserName">User Name:</label>
                <div class="col-sm-8">
                    <label class=""> {{user.vUserName}} </label>                              
                </div>
            </div>
            
            <div class="col-sm-6">
                <label class="col-sm-4" for="vEmailID">Email:</label>
                <div class="col-sm-8">
                    <label class=""> {{user.vEmailID}} </label>                              
                </div>
            </div>

            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="col-sm-6">
                <label class="col-sm-4 control-label" for="iMobileNo">Mobile:</label>
                <div class="col-sm-8">
                    <label class=""> {{user.iMobileNo}} </label> 
                </div>
            </div>

            <div class="col-sm-6">
                <label class="col-sm-4 control-label">Gender:</label>
                <div class="col-sm-8">
                    <label class=""> {{user.eGender}} </label>
                </div>
            </div>

            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="col-sm-6">
                <label class="col-sm-4" for="eUserType">User Type: </label>
                <div class="col-sm-8">
                    <label class=""> {{user.eUserType}} </label>
                </div>
            </div>
            
            <div class="col-sm-6">
                <label class="col-sm-4" for="uCreateDate">Join Date: </label>
                <div class="col-sm-8">
                    <label class=""> {{user.uCreateDate}} </label>
                </div>
            </div>
            
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="col-sm-6">
                <label class="col-sm-4" for="uModifiedDate">Last Modified Date: </label>
                <div class="col-sm-8">
                    <label class=""> {{user.uModifiedDate}} </label>
                </div>
            </div>
            <div class="col-sm-6">
                <label class="col-sm-4" for="vProfilePic">Profile Picture: </label>
                <div class="col-sm-8">
                    <label class="">  </label>
                </div>
            </div>
            
            <div class="line line-dashed b-b line-lg pull-in"></div>
            <div class="col-sm-6">
                <label class="col-sm-4" for="vDeviceID">Device ID: </label>
                <div class="col-sm-8">
                    <label class=""> {{user.vDeviceID}} </label>
                </div>
            </div>
            
        </div>
    </div>

    </div>
</div>