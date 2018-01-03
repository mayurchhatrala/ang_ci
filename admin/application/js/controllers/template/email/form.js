'use strict';

/* Controllers */
app.controller('TemplateEmailFormDataCtrl', ['$scope', '$http', '$state', '$stateParams', function ($scope, $http, $state, $stateParams) {
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
        if (requestId !== 0) {
            $http.post(BASEURL + 'template/emailFormData', {requestId: requestId}).then(function (response) {
                $scope.template = {
                    vTemplateName: response.data.templateName,
                    vTemplateAlias: response.data.templateAlias,
                    tTemplateContent: response.data.templateContent
                };
            });
            $scope.operationName = 'Edit';
        } else {
            $scope.template = {};
        }


        $scope.saveFormClick = function () {
            $scope.template.tTemplateContent = CKEDITOR.instances.tTemplateContent.getData();

            var posturl = BASEURL + 'crud/operation/I/5';
            if (requestId !== 0)
                posturl = BASEURL + 'crud/operation/U/5/' + requestId;

            $http.post(posturl, $scope.template).then(function (response) {
                switch (response.data.STATUS) {
                    case 101 :
                        swal(response.data.MSG);
                        break;

                    case 200 :
                        $scope.admintype = {};
                        $state.go('template.email.list');

                        var alertMsg = requestId !== 0 ? 'Updated' : 'Inserted';
                        swal(alertMsg, response.data.MSG, "success");

                        requestedId = 0;
                        break;
                }
            }, function (x) {
            });
        };
    }]);



