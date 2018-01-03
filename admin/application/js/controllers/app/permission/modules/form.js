'use strict';

/* Controllers */
app.controller('AdminModulesDataCtrl', ['$scope', '$http', '$state', '$stateParams', function ($scope, $http, $state, $stateParams) {
        var requestId = parseInt(requestedId);
        $scope.setPermission = function (value) {
            permissionVal = JSON.parse(value);
            angular.element(document.querySelector('#permissions')).remove();

            if (permissionVal[6]) {
                swal('Error', 'You don\'t have a permission to access this page!!', "error");
                $state.go('app.dashboard');
            }

            if (requestId == 0 && !permissionVal[1]) {
                angular.element(document.querySelector('#addRecord')).remove();
            }
            if (requestId != 0 && !permissionVal[2]) {
                angular.element(document.querySelector('#addRecord')).remove();
            }
        };

        /*
         * TO SET THE FORM VALUE
         */
        var accessValue = Array();
        //console.log(requestId);
        $scope.operationName = 'Add';
        if (requestId !== 0) {
            $http.post(BASEURL + 'permission/adminModulesFormData', {requestId: requestId}).then(function (response) {
                accessValue = response.data.adminAccess;
                $scope.permission = {
                    vModuleName: response.data.moduleName,
                    vModuleIcon: response.data.moduleIcon,
                    iOrderVal: response.data.moduleOrder,
                    isDeveloper: (response.data.isDevelopment == "yes" ? true : false)
                };
            });
            $scope.operationName = 'Edit';
        } else {
            $scope.permission = {};
            $scope.permission.isDeveloper = 'no';
        }

        $scope.saveFormClick = function () {
            var posturl = BASEURL + 'crud/operation/I/3';
            if (requestId !== 0)
                posturl = BASEURL + 'crud/operation/U/3/' + requestId;

            $http.post(posturl, $scope.permission).then(function (response) {
                switch (response.data.STATUS) {
                    case 101 :
                        swal(response.data.MSG);
                        break;

                    case 200 :
                        $scope.admintype = {};
                        $state.go('app.modules.list');

                        var alertMsg = requestId !== 0 ? 'Updated' : 'Inserted';
                        swal(alertMsg, response.data.MSG, "success");

                        requestedId = 0;
                        break;
                }
            }, function (x) {
                //toaster.pop('error', 'Error', 'Server Error');
            });
        };
    }]);
//
//app.directive('chosen', function () {
//    var linker = function (scope, element, attrs) {
//        var list = attrs['chosen'];
//
//        scope.$watch(list, function () {
//            element.trigger('chosen:updated');
//        });
//
//        scope.$watch(attrs['ngModel'], function () {
//            element.trigger('chosen:updated');
//        });
//
//        element.chosen({width: '350px'});
//    };
//
//    return {
//        restrict: 'A',
//        link: linker
//    };
//});