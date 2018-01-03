'use strict';

var _URL = window.URL || window.webkitURL;

/* Controllers */
app.controller('CategoryDataCtrl', ['$scope', '$http', '$state', 'toaster', '$stateParams', '$timeout', '$location',
    function ($scope, $http, $state, toaster, $stateParams, $timeout, $location) {

        var requestId;
        if (requestedId == '')
            requestId = 0;
        else
            requestId = parseInt(requestedId);

        /*
         *  TO SET THE FORM VALUE
         */

        if (requestId !== 0) {

            $http.post(BASEURL + 'category/formData', {requestId: requestId}).then(function (response) {

                $scope.category = {
                    iCategoryID: response.data.categoryId,
                    vCategoryName: response.data.categoryName,
                    vCategoryIcon: response.data.categoryIcon,
                };
            });
        } else {
            $scope.category = {};
        }

        // check category name is already in database or not
        $scope.checkCategoryName = function (evt) {
            var CategoryName = evt.target.value;
            $http.post(BASEURL + 'category/CategoryName', {CategoryName: CategoryName}).then(function (responses) {
                if (responses.data >= 1) {
                    $('#UserNameError').show();
                    $('#UserNameError').css('color', '#F00');
                    $scope.form.prUserName.$setValidity('server', false);
                } else {
                    $('#UserNameError').hide();
                    $scope.form.prUserName.$setValidity('server', true);
                }
            });
        };

        $scope.SubmitDisPlay = false;
        
        $scope.saveFormClick = function () {
            
            $scope.SubmitDisPlay = true;

            var posturl = BASEURL + 'category/operation/I/1';
            if (requestId !== 0)
                posturl = BASEURL + 'category/operation/U/1/' + requestId;

            $http({
                method: 'POST',
                url: posturl,
                headers: {'Content-Type': 'json'},
                data: {
                    vCategoryName: $scope.category.vCategoryName,
                    vCategoryIcon: $scope.file
                },
                transformRequest: function (data, headersGetter) {

                    var formData = new FormData();
                    angular.forEach(data, function (value, key) {
                        formData.append(key, value);
                    });
                    var headers = headersGetter();
                    delete headers['Content-Type'];
                    return formData;
                }
            }).success(function (response) {
                
                switch (response.STATUS) {
                    case 101 :
                        //toaster.pop('warning', 'Warning', response.data.MSG);
                        swal(response.MSG);
                        break;
                    case 200 :
                        $scope.category = {};
                        $state.go('app.category.list');
                        var alertMsg = requestId !== 0 ? 'Updated' : 'Inserted';
                        swal(alertMsg, response.MSG, "success");
                        requestedId = 0;
                        break;
                }
            }).error(function (data, status) {
                toaster.pop('error', 'Error', 'Server Error');
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
                var file = event.target.files[0];
                scope.file = file ? file : '';

                if (file.type == 'image/jpeg' || file.type == 'image/jpg' || file.type == 'image/bmp' || file.type == 'image/png') {
                    scope.$apply();
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