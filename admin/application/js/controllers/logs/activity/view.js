'use strict';

/* Controllers */
app.controller('UserActivityViewDataCtrl', ['$scope', '$http', '$state', '$stateParams', function ($scope, $http, $state, $stateParams) {
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

        /*
         * TO GET THE RECORD FROM THE DATABASE...
         */
        var pageId = 0;
        $scope.operationName = 'Add';
        if (requestId !== 0) {
            $http.post(BASEURL + 'logs/activityLogData', {requestId: requestId, pageId: pageId}).then(function (response) {
                $scope.activity = {
                    activities: response.data
                };
            });
            $scope.operationName = 'View';
        } else {
            $scope.activity = {};
        }

        $scope.loadMore = function () {
            pageId = pageId + 1;
            $http.post(BASEURL + 'logs/activityLogData', {requestId: requestId, pageId: pageId}).then(function (response) {
                var resp = response.data;
                for (var i = 0; i < resp.length; i++) {
                    var temp = Array();
                    temp = resp[i];
                    $scope.activity.activities.push(temp);
                }
            });
        }
    }]);
