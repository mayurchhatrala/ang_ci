'use strict';

/* Controllers */
// signin controller
app.controller('SigninFormController', ['$scope', '$http', '$state', function ($scope, $http, $state) {
        $scope.user = {};
        $scope.authError = null;
        $scope.login = function () {
            $scope.authError = null;
            // Try to login
            $http.post(BASEURL + 'login/submit', {email: $scope.user.email, password: $scope.user.password}).then(function (response) {
                //console.log(response);
                switch (response.data.STATUS) {
                    case 101 :
                        $scope.authError = response.data.MSG;
                        break;

                    case 200 :
                        //alert(response.data.MSG);
                        //location.href = BASEURL + '#/app/dashboard';
                        window.location.reload();
                        //$state.go('app.dashboard');
                        break;
                }

            }, function (x) {
                $scope.authError = 'Server Error';
            });
        };
    }]);