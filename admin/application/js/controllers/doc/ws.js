'use strict';
var GwsId = 0;
app.controller('WSmanageCtrl', ['$scope', '$http', '$state', '$modal', function ($scope, $http, $state, $modal) {
        $scope.setPermission = function (value) {
            var permissionVal = JSON.parse(value);
            angular.element(document.querySelector('#permissions')).remove();

            if (permissionVal[6]) {
                swal('Error', 'You don\'t have a permission to access this page!!', "error");
                $state.go('app.dashboard');
            }
            if (!permissionVal[1]) {
                angular.element(document.querySelector('#addRecord')).remove();
            }
        };

        var html = [];
        requestedId = 0;
        $scope.doc = {};
        $scope.descLimit = 30;
        //$scope.doc.wsSuportedFormat = [];
        $scope.allSupportFormat = [];
        $scope.headerAddValid = true;
        $scope.hasHeaderRec = false;
        $scope.headerValues = '';
        $scope.inputValues = '';
        $scope.allWS = [];
        $scope.editFormat = [];
        $scope.enableDownload = false;
        $scope.visibleForm = false;
        $scope.isDelete = false;
        $scope.selectedWSID = 0;

        /*
         * TO GET ALL SUPPORTED FORMAT
         */
        $http.post(BASEURL + 'doc/getSupportType', {requestId: requestedId}).then(function (response) {
            switch (response.data.STATUS) {
                case 101 :
                    $scope.allSupportFormat = [];
                    break;

                case 200 :
                    $scope.allSupportFormat = response.data.RECORD;
                    break;
            }
        });

        /*
         * TO GET ALL SUPPORTED INPUT FORMAT
         */
        $http.post(BASEURL + 'doc/getSupportInputFormat', {requestId: requestedId}).then(function (response) {
            switch (response.data.STATUS) {
                case 101 :
                    $scope.allSupportInputFormat = [];
                    break;

                case 200 :
                    $scope.allSupportInputFormat = response.data.RECORD;
                    break;
            }
        });

        /*
         * TO GET ALL WEB SERVICES LIST
         */
        $scope.selectAllWS = function () {
            $http.post(BASEURL + 'doc/getAllWS', {requestId: requestedId}).then(function (response) {
                switch (response.data.STATUS) {
                    case 101 :
                        $scope.allWS = [];
                        $scope.enableDownload = true;
                        break;

                    case 200 :
                        $scope.allWS = response.data.RECORD;
                        break;
                }
            });
        };
        $scope.selectAllWS();

        /*
         * VALIDATE HEADER FORM
         */
        $scope.validateHeaderForm = function () {
            if (typeof $scope.doc.wsHeadName == 'string') {
                $scope.headerAddValid = false;
            } else if (typeof $scope.doc.wsHeadName != 'undefined') {
                $scope.headerAddValid = true;
            } else {
                $scope.headerAddValid = true;
            }
        };

        /*
         * TO ADD HEADER VALUE
         */

        $scope.addHeader = function () {
            if (typeof $scope.headerValues == 'string')
                $scope.headerValues = [];

            var obj = {};
            obj.title = $scope.doc.head.wsHeadName;
            obj.value = $scope.doc.head.wsHeadValue;
            $scope.doc.head = {};

            $scope.headerValues.push(obj);
        };

        /*
         * TO REMOVE HEADER VALUE
         */

        $scope.removeHeader = function (index) {
            $scope.headerValues.splice(index, 1);
            if ($scope.headerValues.length == 0) {
                $scope.headerValues = '';
            }
        }

        /*
         * TO ADD INPUT PARAMS
         */
        $scope.addInputParam = function () {
            if (typeof $scope.inputValues == 'string')
                $scope.inputValues = [];

            //console.log(typeof $scope.doc.field.value);
            var obj = {};
            obj.name = $scope.doc.field.name;
            obj.type = $scope.doc.field.type;
            obj.typeId = $scope.getSelectedTypeId($scope.doc.field.type);
            obj.value = (typeof $scope.doc.field.value == 'undefined' || $scope.doc.field.value == '' ? '' : $scope.doc.field.value);
            obj.require = $scope.doc.field.require;
            obj.desc = (typeof $scope.doc.field.desc == 'undefined' || $scope.doc.field.desc == '' ? '' : $scope.doc.field.desc);
            $scope.doc.field = {};

            $scope.inputValues.push(obj);
        };

        /*
         * TO GET SELECTED TYPE
         */

        $scope.getSelectedTypeId = function (typeName) {
            if (typeName != '') {
                var obj = $scope.allSupportInputFormat;
                for (var i = 0; i < obj.length; i++) {
                    if (obj[i].formatName == typeName) {
                        return obj[i].formatId;
                    }
                }
            }
            return 0;
        }

        /*
         * TO REMOVE INPUT VALUE
         */

        $scope.removeInputParam = function (index) {
            $scope.inputValues.splice(index, 1);
            if ($scope.inputValues.length == 0) {
                $scope.inputValues = '';
            }
        }

        /*
         * TO RESET ALL THE VALUES
         */

        $scope.resetValues = function () {
            $scope.doc = {};

            //$scope.allSupportFormat = [];
            $scope.headerAddValid = true;
            $scope.hasHeaderRec = false;
            $scope.headerValues = '';
            $scope.inputValues = '';
            $scope.editFormat = [];
            $scope.isDelete = false;
            $scope.selectedWSID = 0;
            //$scope.allWS = [];
            GwsId = 0;
        };

        /*
         * TO CREATE A NEW WEB SERVICE
         */

        $scope.createWS = function () {
            $scope.visibleForm = true;
            $scope.resetValues();
        };

        /*
         * TO CANCEL A WEB SERVICE
         */

        $scope.cancelWS = function () {
            $scope.visibleForm = false;
            $scope.resetValues();
        };

        /*
         * TO DELETE THE WEB SERVICE
         */
        $scope.deleteWS = function (wsId) {
            $scope.visibleForm = false;
            $scope.isDelete = true;

            /*
             * TO DELETE THE WEB SERVICE...
             */
            swal({
                title: "Are you sure?",
                text: "You want to delete this web service?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#f05050",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function (isConfirm) {
                if (isConfirm) {
                    $http.post(BASEURL + 'doc/deleteWS', {wsId: wsId}).then(function (response) {
                        switch (response.data.STATUS) {
                            case 101 :
                                $scope.doc = {};
                                break;

                            case 200 :
                                /*
                                 * SELECT ALL WEB SERVICE
                                 */
                                $scope.selectAllWS();
                                $scope.resetValues();
                                swal("Deleted!", response.data.MSG, "success");
                                break;
                        }
                    });
                } else {
                    $scope.isDelete = false;
                }
            });
        };

        /*
         * SELECT WEB SERVICE
         */
        $scope.selectWS = function (wsId) {
            if (!$scope.isDelete) {
                $scope.visibleForm = true;
                $scope.resetValues();
                GwsId = $scope.selectedWSID = wsId;

                /*
                 * TO GET THE RECORD OF THE 
                 * SELECTED WEB SERVICE...
                 */
                $http.post(BASEURL + 'doc/getWSRecord', {wsId: wsId}).then(function (response) {
                    switch (response.data.STATUS) {
                        case 101 :
                            $scope.doc = {};
                            break;

                        case 200 :
                            /*
                             * SET ALL VALUES
                             */
                            $scope.setWSValues(response.data.RECORD);
                            break;
                    }
                });
            }
        };

        $scope.setWSValues = function (obj) {
            console.log('Selected ');
            console.log(obj);
            /* BASIC INFO */
            $scope.doc.info = {
                wsTitle: obj.info.title,
                wsType: obj.info.type,
                wsURL: obj.info.url,
                wsDesc: obj.info.desc
            };
            $scope.editFormat = obj.info.format;
            $scope.doc.info.wsSuportedFormat = new Array();
            for (var i = 0; i < $scope.editFormat.length; i++) {
                $scope.doc.info.wsSuportedFormat[$scope.editFormat[i].id] = true;
            }

            /* HEADER VALUE */
            if (obj.header.length > 0)
                $scope.headerValues = obj.header;

            /* INPUT VALUE */
            if (obj.input.length > 0)
                $scope.inputValues = obj.input;

            /* OUTPUT VALUE */
            $scope.doc.output = {
                success: obj.output.success,
                fail: obj.output.fail
            };

        };

        /*
         * TO ADD NEW WEB SERVICE
         */
        $scope.addWS = function () {
            var obj = $scope.doc;
            obj.head = $scope.headerValues;
            obj.input = $scope.inputValues;
            delete obj.field;
            
            var wsId = $scope.selectedWSID

            $http.post(BASEURL + 'doc/addWS', {object: obj, wsId: wsId}).then(function (response) {
                switch (response.data.STATUS) {
                    case 101 :
                        $scope.doc = {};
                        break;

                    case 200 :
                        /*
                         * SET ALL VALUES
                         */
                        $scope.visibleForm = false;
                        $scope.selectAllWS();
                        $scope.resetValues();
                        break;
                }
            });
        };

        /*
         * PREVIEW THE WEB SERVICE
         */
        $scope.open = function () {
            var modalInstance = $modal.open({
                templateUrl: 'previewWebService.html',
                controller: 'WSmanageCtrl',
                size: 'lg'
            });

            modalInstance.result.then(function (selectedItem) {
                $scope.selected = selectedItem;
            }, function () {
                //$log.info('Modal dismissed at: ' + new Date());
            });
        };

    }]);

app.controller('WSPreviewCtrl', ['$scope', '$http', '$state', '$modal', function ($scope, $http, $state, $modal) {
        $scope.doc = {};
        $scope.descLimit = 30;
        //$scope.doc.wsSuportedFormat = [];
        $scope.allSupportFormat = [];
        $scope.headerAddValid = true;
        $scope.hasHeaderRec = false;
        $scope.headerValues = '';
        $scope.inputValues = '';
        $scope.allWS = [];
        $scope.editFormat = [];
        $scope.enableDownload = false;
        $scope.visibleForm = false;
        $scope.isDelete = false;
        $scope.selectedWSID = 0;

        /*
         * TO GET ALL SUPPORTED FORMAT
         */
        $http.post(BASEURL + 'doc/getSupportType', {}).then(function (response) {
            switch (response.data.STATUS) {
                case 101 :
                    $scope.allSupportFormat = [];
                    break;

                case 200 :
                    $scope.allSupportFormat = response.data.RECORD;
                    $scope.getSelectedWS();
                    break;
            }
        });

        $scope.getSelectedWS = function () {
            $http.post(BASEURL + 'doc/getWSRecord', {wsId: GwsId}).then(function (response) {
                switch (response.data.STATUS) {
                    case 101 :
                        $scope.doc = {};
                        break;

                    case 200 :
                        /*
                         * SET ALL VALUES
                         */
                        $scope.setWSValues(response.data.RECORD);
                        break;
                }
            });
        }

        $scope.setWSValues = function (obj) {
            console.log('Set ');
            console.log(obj);
            /* BASIC INFO */
            $scope.doc.info = {
                wsTitle: obj.info.title,
                wsType: obj.info.type,
                wsURL: obj.info.url,
                wsDesc: obj.info.desc
            };
            $scope.editFormat = obj.info.format;
            $scope.doc.info.wsSuportedFormat = new Array();
            for (var i = 0; i < $scope.editFormat.length; i++) {
                $scope.doc.info.wsSuportedFormat[$scope.editFormat[i].id] = true;
            }

            /* HEADER VALUE */
            if (obj.header.length > 0)
                $scope.headerValues = obj.header;

            /* INPUT VALUE */
            if (obj.input.length > 0)
                $scope.inputValues = obj.input;

            /* OUTPUT VALUE */
            $scope.doc.output = {
                success: obj.output.success,
                fail: obj.output.fail
            };

        };
    }]);

