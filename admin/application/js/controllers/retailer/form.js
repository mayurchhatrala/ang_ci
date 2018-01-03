'use strict';


/* Controllers */
app.controller('RetailerDataCtrl', ['$scope', '$http', '$state', 'toaster', '$stateParams', '$timeout', '$location',
    function ($scope, $http, $state, toaster, $stateParams, $timeout, $location) {

        var requestId;
        var lnlg = [];
        if (requestedId == '')
            requestId = 0;
        else
            requestId = parseInt(requestedId);

        function updateControls(addressComponents, lnlg) {

            $scope.retailer.vRetailerAddress = addressComponents.formattedAddress;
            $scope.retailer.vLatitude = lnlg.latitude;
            $scope.retailer.vLongtitude = lnlg.longitude;

            $scope.retailer.vRetailerstreetName = addressComponents.streetName;
            $scope.retailer.vRetailerstreetNumber = addressComponents.streetNumber;
            $scope.retailer.vRetailerAddressLine = addressComponents.addressLine1;
            $scope.retailer.vRetailerCity = addressComponents.city;
            $scope.retailer.vRetailerDistrict = addressComponents.district;
            $scope.retailer.vRetailerState = addressComponents.stateOrProvince;
            $scope.retailer.vRetailerCountry = addressComponents.country;

            $('#vRetailerAddress').val(addressComponents.formattedAddress);
            $('#vRetailerstreetName').val(addressComponents.vRetailerstreetName);
            $('#vRetailerstreetNumber').val(addressComponents.vRetailerstreetNumber);
            $('#vRetailerAddressLine').val(addressComponents.vRetailerAddressLine);
            $('#vRetailerCity').val(addressComponents.vRetailerCity);
            $('#vRetailerDistrict').val(addressComponents.vRetailerDistrict);
            $('#vRetailerState').val(addressComponents.vRetailerState);
            $('#vRetailerCountry').val(addressComponents.vRetailerCountry);
            $('#vLatitude').val(lnlg.latitude);
            $('#vLongitude').val(lnlg.longitude);
        }

        //  TO SET MAP
        if (requestId == 0) {


            $('#map').locationpicker({
                // location: {latitude: 23.035033058, longitude: 72.4969186360596},
                location: {latitude: 40.763822537332, longitude: -73.97301},
                radius: 300,
                zoom: 14,
                scrollwheel: true,
                inputBinding: {
                    latitudeInput: $('#vLatitude'),
                    longitudeInput: $('#vLongtitude'),
                    locationNameInput: $('#vRetailerAddress')
                },
                enableAutocomplete: true,
                onchanged: function (currentLocation, radius, isMarkerDropped) {
                    // var addressComponents = $(this).locationpicker('map').location.addressComponents;
                    var addressComponents = {};

                    addressComponents['formattedAddress'] = $(this).locationpicker('map').location.formattedAddress;
                    addressComponents['streetName'] = $(this).locationpicker('map').location.addressComponents.streetName != 'undefined' || $(this).locationpicker('map').location.addressComponents.streetName != '' ? $(this).locationpicker('map').location.addressComponents.streetName : '';
                    addressComponents['streetNumber'] = $(this).locationpicker('map').location.addressComponents.streetNumber != 'undefined' || $(this).locationpicker('map').location.addressComponents.streetNumber != '' ? $(this).locationpicker('map').location.addressComponents.streetNumber : '';
                    addressComponents['addressLine1'] = $(this).locationpicker('map').location.addressComponents.addressLine1 != 'undefined' || $(this).locationpicker('map').location.addressComponents.addressLine1 != '' ? $(this).locationpicker('map').location.addressComponents.addressLine1 : '';
                    addressComponents['city'] = $(this).locationpicker('map').location.addressComponents.city != 'undefined' || $(this).locationpicker('map').location.addressComponents.city != '' ? $(this).locationpicker('map').location.addressComponents.city : '';
                    addressComponents['district'] = $(this).locationpicker('map').location.addressComponents.district != 'undefined' || $(this).locationpicker('map').location.addressComponents.district != '' ? $(this).locationpicker('map').location.addressComponents.district : '';
                    addressComponents['stateOrProvince'] = $(this).locationpicker('map').location.addressComponents.stateOrProvince != 'undefined' || $(this).locationpicker('map').location.addressComponents.stateOrProvince != '' ? $(this).locationpicker('map').location.addressComponents.stateOrProvince : '';
                    addressComponents['country'] = $(this).locationpicker('map').location.addressComponents.country != 'undefined' || $(this).locationpicker('map').location.addressComponents.country != '' ? $(this).locationpicker('map').location.addressComponents.country : '';

                    lnlg.latitude = $(this).locationpicker('map').location.latitude;
                    lnlg.longitude = $(this).locationpicker('map').location.longitude;
                    updateControls(addressComponents, lnlg);
                },
                oninitialized: function (component) {
                    var addressComponents = {};

                    addressComponents['formattedAddress'] = $(component).locationpicker('map').location.formattedAddress;
                    addressComponents['streetName'] = $(component).locationpicker('map').location.addressComponents.streetName != 'undefined' || $(component).locationpicker('map').location.addressComponents.streetName != '' ? $(component).locationpicker('map').location.addressComponents.streetName : '';
                    addressComponents['streetNumber'] = $(component).locationpicker('map').location.addressComponents.streetNumber != 'undefined' || $(component).locationpicker('map').location.addressComponents.streetNumber != '' ? $(component).locationpicker('map').location.addressComponents.streetNumber : '';
                    addressComponents['addressLine1'] = $(component).locationpicker('map').location.addressComponents.addressLine1 != 'undefined' || $(component).locationpicker('map').location.addressComponents.addressLine1 != '' ? $(component).locationpicker('map').location.addressComponents.addressLine1 : '';
                    addressComponents['city'] = $(component).locationpicker('map').location.addressComponents.city != 'undefined' || $(component).locationpicker('map').location.addressComponents.city != '' ? $(component).locationpicker('map').location.addressComponents.city : '';
                    addressComponents['district'] = $(component).locationpicker('map').location.addressComponents.district != 'undefined' || $(component).locationpicker('map').location.addressComponents.district != '' ? $(component).locationpicker('map').location.addressComponents.district : '';
                    addressComponents['stateOrProvince'] = $(component).locationpicker('map').location.addressComponents.stateOrProvince != 'undefined' || $(component).locationpicker('map').location.addressComponents.stateOrProvince != '' ? $(component).locationpicker('map').location.addressComponents.stateOrProvince : '';
                    addressComponents['country'] = $(component).locationpicker('map').location.addressComponents.country != 'undefined' || $(component).locationpicker('map').location.addressComponents.country != '' ? $(component).locationpicker('map').location.addressComponents.country : '';

                    lnlg.latitude = $(component).locationpicker('map').location.latitude;
                    lnlg.longitude = $(component).locationpicker('map').location.longitude;
                    updateControls(addressComponents, lnlg);
                }
            });

        }


        if (requestId !== 0) {
            $http.post(BASEURL + 'retailer/formData', {requestId: requestId}).then(function (response) {

                $scope.retailer = {
                    iCategoryID: response.data.categoryId,
                    iRetailerID: response.data.retailerId,
                    vRetailerName: response.data.retailerName,
                    vRetailerEmail: response.data.retailerEmail,
                    vRetailerPhone: parseInt(response.data.retailerPhone),
                    vRetailerLink: response.data.retailerLink,
                    vRetailerLogo: response.data.retailerImage,
                    vRetailerAddress: response.data.retailerAddress,
                    tRetailerDesc: response.data.retailerDesc,
                    vLatitude: response.data.retailerLati,
                    vLongtitude: response.data.retailerLong,
                };

                // EDIT RECORD
                $('#map').locationpicker({
                    location: {
                        latitude: response.data.retailerLati,
                        longitude: response.data.retailerLong
                    },
                    radius: 300,
                    zoom: 14,
                    scrollwheel: true,
                    inputBinding: {
                        latitudeInput: $('#vLatitude'),
                        longitudeInput: $('#vLongtitude'),
                        locationNameInput: $('#vRetailerAddress')
                    },
                    enableAutocomplete: true,
                    onchanged: function (currentLocation, radius, isMarkerDropped) {
                        var addressComponents = {};

                        addressComponents['formattedAddress'] = $(this).locationpicker('map').location.formattedAddress;
                        addressComponents['streetName'] = $(this).locationpicker('map').location.addressComponents.streetName != 'undefined' || $(this).locationpicker('map').location.streetName != '' ? $(this).locationpicker('map').location.addressComponents.streetName : '';
                        addressComponents['streetNumber'] = $(this).locationpicker('map').location.addressComponents.streetNumber != 'undefined' || $(this).locationpicker('map').location.streetNumber != '' ? $(this).locationpicker('map').location.addressComponents.streetNumber : '';
                        addressComponents['addressLine1'] = $(this).locationpicker('map').location.addressComponents.addressLine1 != 'undefined' || $(this).locationpicker('map').location.addressLine1 != '' ? $(this).locationpicker('map').location.addressComponents.addressLine1 : '';
                        addressComponents['city'] = $(this).locationpicker('map').location.addressComponents.city != 'undefined' || $(this).locationpicker('map').location.city != '' ? $(this).locationpicker('map').location.addressComponents.city : '';
                        addressComponents['district'] = $(this).locationpicker('map').location.addressComponents.district != 'undefined' || $(this).locationpicker('map').location.district != '' ? $(this).locationpicker('map').location.addressComponents.district : '';
                        addressComponents['stateOrProvince'] = $(this).locationpicker('map').location.addressComponents.stateOrProvince != 'undefined' || $(this).locationpicker('map').location.stateOrProvince != '' ? $(this).locationpicker('map').location.addressComponents.stateOrProvince : '';
                        addressComponents['country'] = $(this).locationpicker('map').location.addressComponents.country != 'undefined' || $(this).locationpicker('map').location.addressComponents.country != '' ? $(this).locationpicker('map').location.addressComponents.country : '';

                        lnlg.latitude = $(this).locationpicker('map').location.latitude;
                        lnlg.longitude = $(this).locationpicker('map').location.longitude;
                        updateControls(addressComponents, lnlg);
                    },
                    oninitialized: function (component) {
                        var addressComponents = {};

                        addressComponents['formattedAddress'] = $(component).locationpicker('map').location.formattedAddress != 'undefined' || $(component).locationpicker('map').location.formattedAddress != '' ? $(component).locationpicker('map').location.formattedAddress : '';
                        addressComponents['streetName'] = typeof ($(component).locationpicker('map').location.addressComponents.streetName) != 'undefined' || $(component).locationpicker('map').location.addressComponents.streetName !== '' ? $(component).locationpicker('map').location.addressComponents.streetName : '';
                        addressComponents['streetNumber'] = $(component).locationpicker('map').location.addressComponents.streetNumber != 'undefined' || $(component).locationpicker('map').location.addressComponents.streetNumber != '' ? $(component).locationpicker('map').location.addressComponents.streetNumber : '';
                        addressComponents['addressLine1'] = $(component).locationpicker('map').location.addressComponents.addressLine1 != 'undefined' || $(component).locationpicker('map').location.addressComponents.addressLine1 != '' ? $(component).locationpicker('map').location.addressComponents.addressLine1 : '';
                        addressComponents['city'] = typeof ($(component).locationpicker('map').location.addressComponents.city) !== 'undefined' || $(component).locationpicker('map').location.addressComponents.city != '' ? $(component).locationpicker('map').location.addressComponents.city : '';
                        addressComponents['district'] = $(component).locationpicker('map').location.addressComponents.district != 'undefined' || $(component).locationpicker('map').location.addressComponents.district != '' ? $(component).locationpicker('map').location.addressComponents.district : '';
                        addressComponents['stateOrProvince'] = $(component).locationpicker('map').location.addressComponents.stateOrProvince != 'undefined' || $(component).locationpicker('map').location.addressComponents.stateOrProvince != '' ? $(component).locationpicker('map').location.addressComponents.stateOrProvince : '';
                        addressComponents['country'] = $(component).locationpicker('map').location.addressComponents.country != 'undefined' || $(component).locationpicker('map').location.addressComponents.country != '' ? $(component).locationpicker('map').location.addressComponents.country : '';

                        lnlg.latitude = $(component).locationpicker('map').location.latitude;
                        lnlg.longitude = $(component).locationpicker('map').location.longitude;
                        updateControls(addressComponents, lnlg);
                    }
                });

            });
        } else {
            $scope.retailer = {};
        }

        /*
         *      GET CATEGORY LIST
         */

        $scope.checkCategoryList = function () {

            $http.get(BASEURL + 'category/categoryRecord').then(function (responses) {
                $scope.categoryList = responses.data.aaData;
            });
        };

        var image = '';

        $scope.SubmitDisPlay = false;
        $scope.saveFormClick = function () {

            $scope.SubmitDisPlay = true;

            var posturl = BASEURL + 'retailer/operation/I/1';
            if (requestId !== 0)
                posturl = BASEURL + 'retailer/operation/U/1/' + requestId;

            if (typeof ($scope.retailer.file) == 'undefined' || typeof ($scope.retailer.file.myImage) == 'undefined') {
                $scope.retailer.file = '';
            }

            $http({
                method: 'POST',
                url: posturl,
                headers: {'Content-Type': 'json'},
                data: {
                    vRetailerName: $scope.retailer.vRetailerName,
                    iCategoryID: $scope.retailer.iCategoryID,
                    vRetailerEmail: $scope.retailer.vRetailerEmail,
                    vRetailerPhone: $scope.retailer.vRetailerPhone,
                    vRetailerLink: $scope.retailer.vRetailerLink,
                    tRetailerDesc: $scope.retailer.tRetailerDesc,
                    vRetailerAddress: $scope.retailer.vRetailerAddress,
                    vLatitude: $scope.retailer.vLatitude,
                    vLongtitude: $scope.retailer.vLongtitude,
                    vRetailerLogo: $scope.retailer.file.myImage,
                    vRetailerstreetName: $scope.retailer.vRetailerstreetName,
                    vRetailerstreetNumber: $scope.retailer.vRetailerstreetNumber,
                    vRetailerAddressLine: $scope.retailer.vRetailerAddressLine,
                    vRetailerCity: $scope.retailer.vRetailerCity,
                    vRetailerDistrict: $scope.retailer.vRetailerDistrict,
                    vRetailerCountry: $scope.retailer.vRetailerCountry,
                    vRetailerState: $scope.retailer.vRetailerState,
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
                        $state.go('app.retailer.list');
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

app.directive('file', function () {
    return {
        scope: {file: '='},
        require: "ngModel",
        link: function (scope, el, attrs, ngModel) {

            el.bind('change', function (event) {

                // images = [];

                var file = event.target.files[0];
                scope.file = file ? file : '';

                /* if (typeof (file) != 'undefined') {
                 
                 var image;
                 image = new Image();
                 image.onload = function () {
                 
                 console.log(scope.file);
                 
                 console.log("The image width is " + this.width + " and image height is " + this.height);
                 if (this.width >= 400 && this.height >= 400) {
                 
                 scope.file = '';
                 alert("The image width is " + this.width + " and image height is " + this.height);
                 ngModel.$invalid = true;
                 ngModel.$setValidity('server', false);
                 $("#retailerImage").show();
                 
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