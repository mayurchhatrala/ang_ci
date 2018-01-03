'use strict';

angular.module('app', ['bootstrapLightbox']);

var uploadImages = [];

/* Controllers */
app.controller('GalleryDataCtrl', ['$scope', '$http', '$state', '$stateParams', '$rootScope', 'FileUploader', 'Lightbox', function ($scope, $http, $state, $stateParams, $rootScope, FileUploader, Lightbox) {
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
        $scope.gallery = {};
        $scope.uploadedItem = [];
        $scope.saveGalleryId = 0;
        if (requestId != 0)
            $scope.saveGalleryId = requestId;

        /*
         * GET ALL UPLOADED IMAGES
         */
        if (requestId != 0) {
            $http.post(BASEURL + 'gallery/getFormData', {requestId: requestId}).then(function (response) {
                if (response.data.STATUS == 200) {
                    $scope.saveGalleryId = response.data.RECORD.info.galleryId;
                    $scope.gallery.vGalleryName = response.data.RECORD.info.galleryName;
                    $scope.uploadedItem = response.data.RECORD.files;
                }
            });
        }

        /*
         * FILE UPLOAD FUNCTIONS
         */
        var posturl = BASEURL + 'gallery/saveData';
        var uploader = $scope.uploader = new FileUploader({
            url: posturl,
            method: 'POST'
        });

        // FILTERS
        uploader.filters.push({
            name: 'customFilter',
            fn: function (item /*{File|FileLikeObject}*/, options) {
                return this.queue.length < 10;
            }
        });
        
        $scope.openLightboxModal = function (index) {
            console.log($scope.uploadedItem);
            Lightbox.openModal($scope.uploadedItem, index);
        };

        // CALLBACKS
        uploader.onWhenAddingFileFailed = function (item /*{File|FileLikeObject}*/, filter, options) {
            //console.info('onWhenAddingFileFailed', item, filter, options);
        };
        uploader.onAfterAddingFile = function (fileItem) {
            //console.info('onAfterAddingFile', fileItem);
        };
        uploader.onAfterAddingAll = function (addedFileItems) {
            //console.info('onAfterAddingAll', addedFileItems);
        };
        uploader.onBeforeUploadItem = function (item) {
            //console.info('onBeforeUploadItem', item);
            item.formData.push({
                saveId: $scope.saveGalleryId,
                galleryName: $scope.gallery.vGalleryName
            });
        };
        uploader.onProgressItem = function (fileItem, progress) {
            //console.info('onProgressItem', fileItem, progress);
        };
        uploader.onProgressAll = function (progress) {
            //console.info('onProgressAll', progress);
        };
        uploader.onSuccessItem = function (fileItem, response, status, headers) {
            //console.info('onSuccessItem', fileItem, response, status, headers);
        };
        uploader.onErrorItem = function (fileItem, response, status, headers) {
            //console.info('onErrorItem', fileItem, response, status, headers);
        };
        uploader.onCancelItem = function (fileItem, response, status, headers) {
            //console.info('onCancelItem', fileItem, response, status, headers);
        };
        uploader.onCompleteItem = function (fileItem, response, status, headers) {
            //console.info('onCompleteItem', fileItem, response, status, headers);
            $scope.saveGalleryId = response.galleryId;
            $scope.uploadedItem.push(response.images);
        };
        uploader.onCompleteAll = function () {
            //console.info('onCompleteAll');
        };

        /* DELETE IMAGE */
        $scope.removeImage = function (index, imageId) {
            if (imageId != '') {
                $http.post(BASEURL + 'gallery/deleteImage', {requestId: imageId}).then(function (response) {
                    if (response.data.STATUS == 200) {
                        $scope.uploadedItem.splice(index, 1);
                    }
                });
            }
        };
    }]);