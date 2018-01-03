'use strict';

/* Controllers */
// signin controller
app.controller('ResetPWDFormController', ['$scope', '$http', '$state', function ($scope, $http, $state) {
        $scope.user = {};
        $scope.authError = null;
        $scope.resetpwd = function () {
            $scope.authError = null;
            // Try to login
            $http.post(BASEURL + 'login/resetpwdSubmit', {email: resetemail, pwd: $scope.user.password}).then(function (response) {
                switch (response.data.STATUS) {
                    case 101 :
                        swal('Warning', response.data.MSG, "warning");
                        break;

                    case 200 :
                        swal('Success', response.data.MSG, "success");
                        $state.go('access.signin');
                        resetemail = '';
                        break;
                }
            }, function (x) {
            });
        };
    }]);

app.directive('passwordMatch', [function () {
        return {
            restrict: 'A',
            scope: true,
            require: 'ngModel',
            link: function (scope, elem, attrs, control) {
                var checker = function () {

                    //get the value of the first password
                    var e1 = scope.$eval(attrs.ngModel);

                    //get the value of the other password  
                    var e2 = scope.$eval(attrs.passwordMatch);
                    return e1 == e2;
                };
                scope.$watch(checker, function (n) {

                    //set the form control to valid if both 
                    //passwords are the same, else invalid
                    control.$setValidity("unique", n);
                });
            }
        };
    }]);