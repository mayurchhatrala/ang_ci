'use strict';

/* Controllers */
// Profile controller
app.controller('ProfileUpdateCtrl', ['$scope', '$http', '$state', function ($scope, $http, $state) {
        /*
         * TO SET THE FORM VALUE
         */
        var requestId = $('#requestId').val();
        $http.post(BASEURL + 'profile/getProfileRecord', {requestId: requestId}).then(function (response) {
            //console.log(response);
            switch (response.data.STATUS) {
                case 101 :
                    $scope.profile = {};
                    break;

                case 200 :
                    $scope.profile = {
                        firstName: response.data.RECORD.vFirstName,
                        lastName: response.data.RECORD.vLastName,
                        emailId: response.data.RECORD.vEmail
                    };
                    break;
            }
        });

        $scope.updateProfileClick = function () {
            var submitObj = {
                firstName: $scope.profile.firstName,
                lastName: $scope.profile.lastName,
                emailId: $scope.profile.emailId,
            };
            $http.post(BASEURL + 'profile/updateProfile', submitObj).then(function (response) {
                switch (response.data.STATUS) {
                    case 101 :
                        swal('Warning', response.data.MSG, 'warning');
                        break;

                    case 200 :
                        $('.profileFullName').html($scope.profile.firstName + ' ' + $scope.profile.lastName);
                        swal('Success', response.data.MSG, 'success');
                        break;
                }

            }, function (x) {
                swal('Error', 'Server Error', 'error');
            });
        };
    }])
        ;