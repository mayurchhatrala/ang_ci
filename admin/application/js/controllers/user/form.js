'use strict';

/* Controllers */
app.controller('UserDataCtrl', ['$scope', '$http', '$state', '$stateParams', function ($scope, $http, $state, $stateParams) {
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
        $scope.operationName = 'Add';
        //console.log(requestId);
        if (requestId !== 0) {
            $http.post(BASEURL + 'user/formData', {requestId: requestId}).then(function (response) {
                $scope.user = {
                    vFirstName: response.data.userFirstName,
                    vLastName: response.data.userLastName,
                    vEmail: response.data.userEmail,
                    iAdminTypeID: response.data.userAdminId
                };
            });
            $scope.operationName = 'Edit';
        } else {
            $scope.user = {};
        }

        $scope.saveFormClick = function () {
            var posturl = BASEURL + 'crud/operation/I/2';
            if (requestId !== 0)
                posturl = BASEURL + 'crud/operation/U/2/' + requestId;

            $http.post(posturl, $scope.user).then(function (response) {
                switch (response.data.STATUS) {
                    case 101 :
                        //toaster.pop('warning', 'Warning', response.data.MSG);
                        swal(response.data.MSG);
                        break;

                    case 200 :
                        $scope.user = {};
                        $state.go('app.user.list');

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
