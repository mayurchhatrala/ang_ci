'use strict';

/* Controllers */
// signin controller
app.controller('ForgotPWDFormController', ['$scope', '$http', '$state', function ($scope, $http, $state) {
        $scope.user = {};
        $scope.authError = null;
        $scope.getLink = function () {
            $scope.authError = null;
            // Try to login
            $http.post(BASEURL + 'login/forgotpwdSubmit', {email: $scope.user.email}).then(function (response) {
                //console.log(response);
                switch (response.data.STATUS) {
                    case 101 :
                        swal('Warning', response.data.MSG, "warning");
                        break;

                    case 200 :
                        swal('Success', response.data.MSG, "success");
                        $state.go('access.signin');
                        break;
                }

            }, function (x) {
                $scope.authError = 'Server Error';
            });
        };
    }]);