'use strict';

/* Controllers */
app.controller('AdminPagesDataCtrl', ['$scope', '$http', '$state', '$stateParams', function ($scope, $http, $state, $stateParams) {
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
            $http.post(BASEURL + 'permission/adminPagesFormData', {requestId: requestId}).then(function (response) {
                accessValue = response.data.adminAccess;
                $scope.permission = {
                    vPageTitle: response.data.pageTitle,
                    vPageState: response.data.pageState,
                    iOrderVal: response.data.pageOrder,
                    iPageModuleID: response.data.moduleId
                };
            });
            $scope.operationName = 'Edit';
        } else {
            $scope.permission = {};
        }

        $scope.saveFormClick = function () {
            var posturl = BASEURL + 'crud/operation/I/4';
            if (requestId !== 0)
                posturl = BASEURL + 'crud/operation/U/4/' + requestId;

            $http.post(posturl, $scope.permission).then(function (response) {
                switch (response.data.STATUS) {
                    case 101 :
                        swal(response.data.MSG);
                        break;

                    case 200 :
                        $scope.admintype = {};
                        $state.go('app.pages.list');

                        var alertMsg = requestId !== 0 ? 'Updated' : 'Inserted';
                        swal(alertMsg, response.data.MSG, "success");

                        requestedId = 0;
                        break;
                }
            }, function (x) {
            });
        };
    }]);
