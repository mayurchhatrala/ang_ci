'use strict';

app.controller('UserViewDataCtrl', ['$scope', '$http', '$state', 'toaster', function ($scope, $http, $state, toaster) {

        var requestId = parseInt(requestedId);

        $http.post(BASEURL + 'user/formData', {requestId: requestId}).then(function (response) {

            // console.log(response);

            $scope.user = {
                vUserName: response.data.userName,
                vEmailID: response.data.userEmail,
                iMobileNo: response.data.userMobile,
                vPassword: response.data.userPassword,
                eGender: response.data.userGender,
                eUserType: response.data.userType,
                uCreateDate: response.data.uCreateDate,
                uModifiedDate: response.data.uModifiedDate,
                vDeviceID: response.data.userDeviceID,
                vProfilePic: response.data.pImage
            };
        });

    }]);