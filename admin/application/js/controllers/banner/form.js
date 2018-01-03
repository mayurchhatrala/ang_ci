'use strict';



// TO GET SELECTED FILE HEIGHT AND WIDTH

var _URL = window.URL || window.webkitURL;



/* Controllers */

app.controller('BannerDataCtrl', ['$scope', '$http', '$state', 'toaster', '$stateParams', '$timeout', '$location',

    function ($scope, $http, $state, toaster, $stateParams, $timeout, $location) {



        var requestId;

        

        if (requestedId == '')

            requestId = 0;

        else

            requestId = parseInt(requestedId);        



        if (requestId !== 0) {

            $http.post(BASEURL + 'banner/formData', {requestId: requestId}).then(function (response) {

                $scope.banner = {

                    iBannerID: response.data.bannerId,

                    vBannerLink: response.data.bannerLink,

                    vBannerIcon: response.data.bannerIcon,

                };

            });

        } else {

            $scope.banner = {};

        }



        /*

         *      check Image type

         */



        /* $scope.$watch('file', function (file) {

         

         if (file != undefined)

         {

         var FileUploadPath, FileSize;

         FileUploadPath = file.type;

         FileSize = file.size;

         // alert('File size:' + this.files[0].size);

         

         var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('/') + 1).toLowerCase();

         

         if (FileSize > 300077) {

         alert("File Size is More than limit");

         } else if (Extension == "gif" || Extension == "png" || Extension == "bmp" || Extension == "jpeg"

         || Extension == "jpg") {

         // code 

         

         } else {

         alert("Erroor");

         }

         }

         }); */

$scope.SubmitDisPlay = false;

        $scope.saveFormClick = function () {

$scope.SubmitDisPlay = true;

            var posturl = BASEURL + 'banner/operation/I/1';

            if (requestId !== 0)

                posturl = BASEURL + 'banner/operation/U/1/' + requestId;



            $http({

                method: 'POST',

                url: posturl,

                headers: {'Content-Type': 'json'},

                data: {

                    vBannerLink: $scope.banner.vBannerLink,

                    vBannerIcon: $scope.file

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

                        $scope.retailer = {};

                        $state.go('app.banner.list');

                        var alertMsg = requestId !== 0 ? 'Updated' : 'Inserted';

                        swal(alertMsg, response.MSG, "success");

                        requestedId = 0;

                        break;

                }

            }).error(function (data, status) {

                toaster.pop('error', 'Error', 'Server Error');

            });



        };

    }]);





// new file upload mayur

/* app.directive('file', function () {

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

 }); */



app.directive('file', function () {

    return {

        scope: {file: '='},

        require: "ngModel",

        link: function (scope, el, attrs, ngModel) {



            el.bind('change', function (event) {



                var file = event.target.files[0];

                scope.file = file ? file : '';



                /* if (typeof (file) != 'undefined') {



                    var image;

                    image = new Image();

                    image.onload = function () {



                        

                        if (this.width >= 2000 || this.height >= 2000) {    

                            scope.file = '';                            

                            $("#retailerImage").show();

                            ngModel.$invalid = true;

                            alert("The image width is " + this.width + " and image height is " + this.height);

                            ngModel.$setValidity('server', false);

                        } else {

                            $("#retailerImage").hide();

                            ngModel.$invalid = false;

                            ngModel.$setValidity('server', true);

                        }

                    };

                    image.src = _URL.createObjectURL(file);

                } */



                if (file.type == 'image/jpeg' || file.type == 'image/jpg' || file.type == 'image/bmp' || file.type == 'image/png') {

                    scope.$apply();

                } else {

                    alert("Please select valid Image file.");

                }

            });

        }

    };

});





/* $("#res_image").change(function (e) {

 var $file = $(this);

 var fileExt = ($file.val()).split('.').pop().toUpperCase();

 

 var image, file;

 if (file = this.files[0]) {

 image = new Image();

 image.onload = function () {

 //alert(this.width + ' ' + this.height);

 if (fileExt == 'JPG' || fileExt == 'JPEG' || fileExt == 'PNG') {

 

 } else {

 alert('Please upload valid image type.');

 //$file.replaceWith($file.val('').clone(true));

 $('#removebtn').trigger('click');

 }

 // alert("The image width is " + this.width + " and image height is " + this.height);

 };

 image.src = _URL.createObjectURL(file);

 }

 }); */