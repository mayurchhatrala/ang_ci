'use strict';

/* Controllers */
app.controller('SettingsUpdateCtrl', ['$scope', '$http', '$state', function ($scope, $http, $state) {
        /*
         * TO SET THE FORM VALUE
         */
        var requestId = $('#requestId').val();
        $http.post(BASEURL + 'profile/getSettingsRecord', {requestId: requestId}).then(function (response) {
            //console.log(response);
            switch (response.data.STATUS) {
                case 101 :
                    $scope.settings = {};
                    break;

                case 200 :
                    $scope.settings = {
                        contactEmail: response.data.RECORD.vSettingValue,
                        iRadius: parseFloat(response.data.RECORD.iRadius),
                    };
                    break;
            }
        });

        $scope.updateSettingsClick = function () {

            var submitObj = {
                contactEmail: $scope.settings.contactEmail,
                iRadius: $scope.settings.iRadius,
            };

            $http.post(BASEURL + 'profile/updateSettings', submitObj).then(function (response) {
                switch (response.data.STATUS) {
                    case 101 :
                        swal('Warning', response.data.MSG, 'warning');
                        break;

                    case 200 :
                        swal('Success', response.data.MSG, 'success');
                        break;
                }

            }, function (x) {
                swal('Error', 'Server Error', 'error');
            });
        };
    }])
        ;