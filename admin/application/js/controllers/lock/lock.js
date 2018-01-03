'use strict';
/* Controllers */
// lock controller
app.controller('LockScreenController', ['$scope', '$http', '$state', function ($scope, $http, $state) {
        $scope.user = {};
        $scope.authError = null;
        $http.post(BASEURL + 'lock/sessionLock', {screenLock: true}).then(function (response) {
        });
        $scope.crackLock = function () {
            $scope.authError = null;
            // Try to login
            $http.post(BASEURL + 'lock/submit', {password: $scope.user.password}).then(function (response) {
                //console.log(response);
                switch (response.data.STATUS) {
                    case 101 :
                        $scope.authError = response.data.MSG;
                        break;

                    case 200 :
                        if (lastStateName == '' || lastStateName == 'access.lock')
                            $state.go('app.dashboard');
                        else
                            $state.go(lastStateName);
                        break;
                }

            }, function (x) {
                $scope.authError = 'Server Error';
            });
        };
    }]);