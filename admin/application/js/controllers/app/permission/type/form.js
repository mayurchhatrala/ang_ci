'use strict';

app.filter('propsFilter', function () {
    return function (items, props) {
        var out = [];

        if (angular.isArray(items)) {
            items.forEach(function (item) {
                var itemMatches = false;

                var keys = Object.keys(props);
                for (var i = 0; i < keys.length; i++) {
                    var prop = keys[i];
                    var text = props[prop].toLowerCase();
                    if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
                        itemMatches = true;
                        break;
                    }
                }

                if (itemMatches) {
                    out.push(item);
                }
            });
        } else {
            // Let the output be the input untouched
            out = items;
        }

        return out;
    };
})
/* Controllers */
app.controller('AdminTypeDataCtrl', ['$scope', '$http', '$state', '$stateParams', function ($scope, $http, $state, $stateParams) {
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

        $scope.disabled = undefined;
        $scope.searchEnabled = undefined;

        $scope.enable = function () {
            $scope.disabled = false;
        };

        $scope.disable = function () {
            $scope.disabled = true;
        };

        $scope.enableSearch = function () {
            $scope.searchEnabled = true;
        }

        $scope.disableSearch = function () {
            $scope.searchEnabled = false;
        }



        /*
         * TO SET THE FORM VALUE
         */
        $scope.allPages = [];
        $scope.allAdminTypes = [];
        var accessValue = [];
        var accessPages = [];
        $scope.admintype = {};
        //console.log(requestId);
        $scope.operationName = 'Add';
        if (requestId !== 0) {
            $http.post(BASEURL + 'permission/adminTypeFormData', {requestId: requestId}).then(function (response) {
                accessValue = response.data.RECORD.adminAccess;
                accessPages = response.data.RECORD.adminPages;
                $scope.admintype = {
                    vAdminTitle: response.data.RECORD.adminTitle
                };

                $scope.getAllTypes();
                $scope.getAllPages();

                $scope.selectedTypes();
                $scope.selectedPages();
            });
            $scope.operationName = 'Edit';
        } else {
            setTimeout(function () {
                $scope.getAllPages();

            }, 500);
        }

        $scope.selectedPages = function () {
            setTimeout(function () {
                var allPage = $scope.allPages;
                var selectedPage = Array();
                angular.forEach(allPage, function (value, key) {
                    if (accessPages.indexOf(value.id) > -1) {
                        selectedPage.push(allPage[key]);
                    }
                });
                $scope.admintype.accessPage = selectedPage;
                $('.ui-select-search').trigger('click');
                $('div.ui-select-multiple').removeClass('open');
            }, 500);
        };
        $scope.selectedTypes = function () {
            setTimeout(function () {
                var allAdminTypes = $scope.allAdminTypes;
                var selectedType = Array();
                angular.forEach(allAdminTypes, function (value, key) {
                    if (accessValue.indexOf(value.adminTypeId) > -1) {
                        selectedType.push(allAdminTypes[key]);
                    }
                });
                $scope.admintype.accessType = selectedType;
                $('.ui-select-search').trigger('click');
                $('div.ui-select-multiple').removeClass('open');
            }, 500);
        };

        /*
         * TO GET ALL THE PAGES
         */

        $scope.getAllPages = function () {
            $http.post(BASEURL + 'general/getAllPages', {requestId: requestId}).then(function (resp) {
                switch (resp.data.STATUS) {
                    case 101 :
                        $scope.allPages = {};
                        break;

                    case 200 :
                        $scope.allPages = resp.data.DATA;
                        break;
                }
            });
        };

        $scope.getAllTypes = function () {
            $http.post(BASEURL + 'general/getAllAdminTypes', {requestId: requestId}).then(function (resp) {
                switch (resp.data.STATUS) {
                    case 101 :
                        $scope.allAdminTypes = {};
                        break;

                    case 200 :
                        $scope.allAdminTypes = resp.data.DATA;
                        break;
                }
            });
        };

        $scope.saveFormClick = function () {
            var posturl = BASEURL + 'crud/operation/I/1';
            if (requestId !== 0)
                posturl = BASEURL + 'crud/operation/U/1/' + requestId;

            //console.log($scope.admintype);

            $http.post(posturl, $scope.admintype).then(function (response) {
                switch (response.data.STATUS) {
                    case 101 :
                        swal(response.data.MSG);
                        break;

                    case 200 :
                        $scope.admintype = {};
                        $state.go('app.permission.type');

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