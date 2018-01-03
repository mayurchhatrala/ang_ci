'use strict';

var _URL = window.URL || window.webkitURL;

var images = [];

/* Controllers */
app.controller('WeeklyDataCtrl', ['$scope', '$http', '$state', 'toaster', '$stateParams', '$timeout', '$location', 'Upload', '$filter',
    function ($scope, $http, $state, toaster, $stateParams, $timeout, $location, Upload, $filter) {

        var requestId;
        if (requestedId == '')
            requestId = 0;
        else
            requestId = parseInt(requestedId);

        $scope.adsImageArray = [];
        $scope.categoryList = [];
        $scope.retailerList = [];
        /*
         *  TO SET THE FORM VALUE
         */

        if (requestId !== 0) {

            $http.post(BASEURL + 'weeklyads/formData', {requestId: requestId}).then(function (response) {

                $scope.weekly = {
                    // iCategoryID: response.data.categoryId,
                    // iRetailerID: response.data.retailerId,
                    iAdsID: response.data.adsId,
                    vAdsName: response.data.adsName,
                    vAdsLink: response.data.adsLink,
                    vAdsImages: response.data.adsImage,
                    dtEndDate: response.data.modifiedDate,
                };

                $scope.checkCategoryList();
                $scope.checkRetailerList(response.data.categoryId);

                $scope.selectedCategory(response.data.categoryId);
                $scope.selectedRetailer(response.data.retailerId);

                /* if (requestId !== 0) {
                 setTimeout(function () {
                 angular.element(document.getElementById('iCategoryID')).scope().checkRetailerList($scope.weekly.iCategoryID);    
                 }, 1000);
                 }*/

                if (response.data.catalogImage != 'undefined')
                    $scope.adsImageArray = response.data.adsImage;

            });
        } else {
            $scope.weekly = {};

//            var date = new Date();
//            $scope.weekly.dtEndDate = $filter('date')(new Date(new Date().setDate(new Date().getUTCDate() + 7)));

            $scope.weekly.dtEndDate = (new Date(new Date().setDate(new Date().getUTCDate() + 7)));
            $scope.end = new Date();
            $scope.minStartDate = 0; //fixed date
            $scope.maxStartDate = $scope.end; //init value
            $scope.minEndDate = $scope.weekly.dtEndDate; //init value
            $scope.maxEndDate = $scope.end; //fixed date same as $scope.maxStartDate init value

            $scope.$watch('weekly.dtEndDate', function (val) {
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
                $scope.weekly.iCategoryID = selectedPage;
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

                $scope.weekly.iRetailerID = selectedRet;
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

        /*
         *      REMOVE IMAGE FROM ARRAY
         */
        $scope.removeImage = function (imageID) {

            $http.post(BASEURL + 'weeklyads/operation/D/1/' + imageID).then(function (responses) {
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

            var posturl = BASEURL + 'weeklyads/operation/I/1';
            if (requestId !== 0)
                posturl = BASEURL + 'weeklyads/operation/U/1/' + requestId;

            Upload.upload({
                url: posturl,
                data: {
                    vAdsName: $scope.weekly.vAdsName,
                    vAdsLink: $scope.weekly.vAdsLink,
                    iCategoryID: $scope.weekly.iCategoryID.categoryId,
                    iRetailerID: $scope.weekly.iRetailerID.retailerId,
                    dtEndDate: $scope.weekly.dtEndDate,
                    vAdsImages: $scope.user.image
                }
            }).then(function (response) {
                switch (response.data.STATUS) {
                    case 101 :
                        //toaster.pop('warning', 'Warning', response.data.MSG);
                        swal(response.data.MSG, '', 'error');
                        break;

                    case 200 :
                        $scope.category = {};
                        images = [];
                        $state.go('app.weeklyads.list');
                        var alertMsg = requestId !== 0 ? 'Updated' : 'Inserted';
                        swal(alertMsg, response.MSG, "success");
                        requestedId = 0;
                        break;
                }
            });


            /* $http.post(posturl, $scope.category).then(function (response) {
             switch (response.data.STATUS) {
             case 101 :
             //toaster.pop('warning', 'Warning', response.data.MSG);
             swal(response.data.MSG);
             break;
             
             case 200 :
             $scope.category = {};
             $state.go('app.category.list');
             
             var alertMsg = requestId !== 0 ? 'Updated' : 'Inserted';
             swal(alertMsg, response.data.MSG, "success");
             
             requestedId = 0;
             break;
             }
             }, function (x) {
             toaster.pop('error', 'Error', 'Server Error');
             }); */

        };
    }]);


// new file upload mayur
app.directive('file', function () {
    return {
        scope: {file: '='},
        link: function (scope, el, attrs) {

            el.bind('change', function (event) {

                images = [];

                var file = event.target.files[0];
                scope.file = file ? file : '';

                if (file.type == 'image/jpeg' || file.type == 'image/jpg' || file.type == 'image/bmp' || file.type == 'image/png') {
                    scope.$apply(function () {
                        for (var i = 0; i < event.target.files.length; i++) {
                            images.push(event.target.files[i]);
                        }
                    });
                } else {
                    alert("Please select valid Image file.");
                }

            });
        }
    };
});

/*
 
 app.directive('file', function () {
 return {
 scope: {file: '='},
 require: "ngModel",
 link: function (scope, el, attrs, ngModel) {
 
 el.bind('change', function (event) {
 
 var file = event.target.files[0];
 scope.file = file ? file : undefined;
 
 if (typeof (file) != 'undefined') {
 
 var image;
 image = new Image();
 image.onload = function () {
 
 if (this.width >= 1024 && this.height >= 500) {
 console.log("The image width is " + this.width + " and image height is " + this.height);
 // ngModel.$invalid = true;
 ngModel.$setValidity('server', false);
 } else {
 // ngModel.$invalid = false;
 ngModel.$setValidity('server', true);
 }
 };
 image.src = _URL.createObjectURL(file);
 }
 
 
 if (file.type == 'image/jpeg' || file.type == 'image/jpg' || file.type == 'image/bmp' || file.type == 'image/png') {
 scope.$apply();
 } else {
 alert("Please select valid Image file.");
 }
 });
 }
 };
 });  
 
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