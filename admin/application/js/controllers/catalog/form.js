'use strict';

var _URL = window.URL || window.webkitURL;

var images = [];

/* Controllers */
app.controller('CatalogDataCtrl', ['$scope', '$http', '$state', 'toaster', '$stateParams', '$timeout', '$location', 'Upload', '$filter',
    function ($scope, $http, $state, toaster, $stateParams, $timeout, $location, Upload, $filter) {

        var requestId;
        if (requestedId == '')
            requestId = 0;
        else
            requestId = parseInt(requestedId);

        $scope.adsImageArray = [];
        $scope.categoryList = [];
        $scope.retailerList = [];

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
         *  TO SET THE FORM VALUE
         */

        if (requestId !== 0) {

            $http.post(BASEURL + 'Catalog/formData', {requestId: requestId}).then(function (response) {

                $scope.catalog = {
                    // iCategoryID: response.data.categoryId,
                    // iRetailerID: response.data.retailerId,
                    iCatalogID: response.data.catalogID,
                    vCatalogName: response.data.catalogName,
                    dtEndDate: response.data.endDate,
                };

                $scope.checkCategoryList();
                $scope.checkRetailerList(response.data.categoryId);

                $scope.selectedCategory(response.data.categoryId);
                $scope.selectedRetailer(response.data.retailerId);


                /* if (requestId !== 0) {
                 setTimeout(function () {
                 angular.element(document.getElementById('iCategoryID')).scope().checkRetailerList($scope.catalog.iCategoryID);
                 }, 1000);
                 } */

                if (response.data.catalogImage != 'undefined')
                    $scope.adsImageArray = response.data.catalogImage;

            });
        } else {
            $scope.catalog = {};

            // var date = new Date();
            // $scope.catalog.dtEndDate = $filter('date')(new Date(new Date().setDate(new Date().getUTCDate() + 7)), 'yyyy-MM-dd H:MM:SS');

            $scope.catalog.dtEndDate = (new Date(new Date().setDate(new Date().getUTCDate() + 7)));
            $scope.end = new Date();
            $scope.minStartDate = 0; //fixed date
            $scope.maxStartDate = $scope.end; //init value
            $scope.minEndDate = $scope.catalog.dtEndDate; //init value
            $scope.maxEndDate = $scope.end; //fixed date same as $scope.maxStartDate init value

            $scope.$watch('catalog.dtEndDate', function (val) {
                $scope.minEndDate = val;
            });
            $scope.$watch('end', function (val) {
                $scope.maxStartDate = val;
            });
            $scope.dateOptions = {
                'year-format': "'yy'",
                'starting-day': 1
            };
        }

        /*
         *      GET SELECTED CATEGORY
         */
        $scope.selectedCategory = function (catID) {
            setTimeout(function () {
                var allPage = $scope.categoryList;
                var selectedPage = Array();
                angular.forEach(allPage, function (value, key) {
                    if (value.categoryId == catID) {
                        selectedPage = (allPage[key]);
                    }
                });
                $scope.catalog.iCategoryID = selectedPage;
                $('.ui-select-search').trigger('click');
                $('div.ui-select').removeClass('open');
            }, 500);
        };

        $scope.selectedRetailer = function (retID) {
            setTimeout(function () {

                var allRet = $scope.retailerList;
                var selectedRet = Array();

                angular.forEach(allRet, function (value, key) {
                    if (value.retailerId == retID) {
                        selectedRet = allRet[key];
                    }
                });

                $scope.catalog.iRetailerID = selectedRet;
                $('.ui-select-search').trigger('click');
                $('div.ui-select').removeClass('open');
            }, 500);
        };

        /*
         *      GET CATEGORY LIST
         */
        $scope.checkCategoryList = function () {

            $http.get(BASEURL + 'category/categoryRecord').then(function (responses) {
                $scope.categoryList = responses.data.aaData;
            });
        };

        /*
         *      GET CATEGORY LIST
         */
        $scope.checkRetailerList = function (rID) {

            $http.post(BASEURL + 'retailer/RetailerList', {'iRetailrID': rID}).then(function (responses) {
                if (typeof (responses.data.STATUS) == 'undefined') {
                    $scope.retailerList = responses.data;
                } else {
                    $scope.retailerList = [];
                }
            });
        };

        // DYNAMIC FILE SELECT
        $scope.items = [];
        $scope.add = function () {
            $scope.items.push({
                id: $scope.items.length
            });
        };

        // DYNAMIC FILE CONTROLL REMOVE
        $scope.RemoveFile = function (id) {
            delete $scope.items[id];
        };

        /*
         *      REMOVE IMAGE FROM ARRAY
         */
        $scope.removeImage = function (imageID) {

            $http.post(BASEURL + 'Catalog/operation/D/1/' + imageID).then(function (responses) {
                delete $scope.adsImageArray[imageID];
                console.log($scope.adsImageArray);
            });
        }

        $scope.imageArray = [];
        $scope.user = [];

        $scope.addNewImage = function () {
            var newItemNo = $scope.imageArray.length + 1;
            $scope.imageArray.push({'id': 'choice' + newItemNo});
        };

        $scope.removeChoice = function (id) {
            angular.element('#image_' + id).remove();
            delete $scope.user.image[id];
        };

        $scope.SubmitDisPlay = false;
        $scope.saveFormClick = function () {

            $scope.SubmitDisPlay = true;

            var posturl = BASEURL + 'Catalog/operation/I/1';
            if (requestId !== 0)
                posturl = BASEURL + 'Catalog/operation/U/1/' + requestId;

            Upload.upload({
                url: posturl,
                data: {
                    vCatalogImages: $scope.user.image,
                    iCategoryID: $scope.catalog.iCategoryID.categoryId,
                    iRetailerID: $scope.catalog.iRetailerID.retailerId,
                    vCatalogName: $scope.catalog.vCatalogName,
                    dtEndDate: $scope.catalog.dtEndDate,
                }
            }).then(function (response) {
                switch (response.data.STATUS) {
                    case 101 :
                        //toaster.pop('warning', 'Warning', response.data.MSG);
                        swal(response.data.MSG, '', 'error');
                        break;

                    case 200 :
                        $scope.catalog = {};
                        $state.go('app.catalog.list');
                        var alertMsg = requestId !== 0 ? 'Updated' : 'Inserted';
                        swal(alertMsg, response.MSG, "success");
                        $scope.SubmitDisPlay = false;
                        requestedId = 0;
                        break;
                }
            });
        };
    }]);

/**
 * AngularJS default filter with the following expression:
 * "person in people | filter: {name: $select.search, age: $select.search}"
 * performs a AND between 'name: $select.search' and 'age: $select.search'.
 * We want to perform a OR.
 */

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
    }
});
 