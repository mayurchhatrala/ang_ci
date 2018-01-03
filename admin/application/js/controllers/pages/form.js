'use strict';

/* Controllers */
app.controller('PagesDataCtrl', ['$scope', '$http', '$state', 'toaster', '$stateParams',
    function ($scope, $http, $state, toaster, $stateParams) {
        /*
         * TO SET THE FORM VALUE
         */

        var requestId = parseInt(requestedId);
        // console.log(requestId);
        if (requestId !== 0) {

            $http.post(BASEURL + 'Pages/formData', {requestId: requestId}).then(function (response) {

                $scope.pages = {
                    iPagesID: response.data.pID,
                    vPageName: response.data.pName,
                    tContent: response.data.pContent,
                    dtDate: response.data.pDate
                };

            });
        } else {
            $scope.pages = {};
        }

        // check email is already in database or not
        $scope.checkPageName = function (evt) {

            var AttributeName = evt.target.value;
            $http.post(BASEURL + 'Pages/checkPageName', {prPageName: AttributeName}).then(function (responses) {
                if (responses.data > 0) {
                    $('#emailError').show();
                    $('#emailError').css('color', '#F00');
                    $scope.form.prPageName.$setValidity('server', false);

                } else {
                    $('#emailError').hide();
                    $scope.form.prPageName.$setValidity('server', true);
                }
            });
        };

        $scope.SubmitDisPlay = false;

        $scope.saveSubCategory = function () {
            
            $scope.SubmitDisPlay = true;

            var posturl = BASEURL + 'Pages/operation/I/1';
            if (requestId !== 0)
                posturl = BASEURL + 'Pages/operation/U/1/' + requestId;

            $http.post(posturl, $scope.pages).success(function (response) {

                switch (response.STATUS) {
                    case 101 :
                        //toaster.pop('warning', 'Warning', response.data.MSG);
                        swal(response.STATUS);
                        break;

                    case 200 :
                        $scope.pages = {};
                        $state.go('app.content.list');

                        var alertMsg = requestId !== 0 ? 'Updated' : 'Inserted';
                        swal(alertMsg, response.MSG, "success");

                        requestedId = 0;
                        break;
                }

            })
                    .error(function (data, status) {
                        toaster.pop('error', 'Error', 'Server Error');
                    });

        }

    }]);