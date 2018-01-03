'use strict';

/* Controllers */
app.controller('PasswordUpdateCtrl', ['$scope', '$http', '$state', '$stateParams', function ($scope, $http, $state, $stateParams) {

        $scope.updatePasswordClick = function () {
            $scope.popUp = {
                type: 'warning',
                title: 'Warning'
            };
            var submitObj = {
                oldPassword: $scope.password.oldPassword,
                newPassword: $scope.password.newPassword,
                confirmPassword: $scope.password.confirmPassword
            };

            $http.post(BASEURL + 'profile/updatePassword', submitObj).then(function (response) {
                switch (response.data.STATUS) {
                    case 101 :
                        $scope.popUp.description = response.data.MSG;
                        break;

                    case 200 :
                        $scope.popUp = {
                            type: 'success',
                            title: 'Success',
                            description: response.data.MSG
                        };

                        $scope.oldData = angular.copy($scope.password);
                        $scope.password = {};
                        $('#oldPassword').focus();
                        break;
                }
                swal($scope.popUp.title, $scope.popUp.description, $scope.popUp.type);

            }, function (x) {
                swal('Error', 'Server Error', 'error');
            });
        };

    }]);