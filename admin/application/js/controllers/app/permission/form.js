'use strict';

/* Controllers */
app.controller('AdminPermissionDataCtrl', ['$scope', '$http', '$state', '$stateParams', function ($scope, $http, $state, $stateParams) {
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
        $scope.permission = {};

        //console.log(requestId);
        $scope.operationName = 'Add';
        if (requestId !== 0) {
            $http.post(BASEURL + 'permission/adminPermissionFormData', {requestId: requestId}).then(function (response) {
                $scope.permission.adminTypeName = response.data.adminTitle;
                $scope.permission.adminTypeId = response.data.adminTypeId;
                $scope.pages = response.data.pages;
            });
            $scope.operationName = 'Edit';
        } else {
            $scope.permission.adminTypeName = '';
            $scope.permission.adminTypeId = '';
        }

        $scope.checkUncheck = function (pageId, actionId) {
            var actions = $scope.permission.action[pageId];
            if (actionId == 6 || actionId == 7) {
                $.each(actions, function (key, value) {
                    key != actionId ? $scope.permission.action[pageId][key] = (actionId == 6 ? false : (key == 6 ? false : true)) : '';
                });
            }
        }

        /*
         * Perfect Die Industries
         * 8B N/H Kothariya Ring Road Chowk,
         * Ranija Nagar, Rajkot - 360002
         */

        $scope.saveFormClick = function () {

            var posturl = BASEURL + 'permission/savePermission/' + requestId;

            $http.post(posturl, $scope.permission).then(function (response) {
                switch (response.data.STATUS) {
                    case 101 :
                        swal(response.data.MSG);
                        break;

                    case 200 :
                        $scope.permission = {};
                        $state.go('app.permission.list');

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
