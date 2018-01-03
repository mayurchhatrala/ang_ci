'use strict';

angular.module('app', ['ngMap']);

/* Controllers */
app.controller('GoogleMAPCtrl', ['$scope', '$http', '$state', '$stateParams', function ($scope, $http, $state, $stateParams) {
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
        $scope.gmap = {
            latitude: 55.327383,
            longitude: 18.06747
        };

        var map;
        var lat = $scope.gmap.latitude;
        var long = $scope.gmap.longitude;

        $scope.$on('mapInitialized', function (evt, evtMap) {
            map = evtMap;
            var latLng = new google.maps.LatLng(lat, long);
            var marker = new google.maps.Marker({
                position: latLng,
                title: 'Select Event Point',
                map: map,
                animation: 'DROP',
                draggable: true
            });
            marker.setPosition(latLng);
            marker.setVisible(true);

            //var marker = new google.maps.Marker({map: map, animation: 'DROP', draggable: true});
            google.maps.event.addListener(marker, 'dragend', function (event) {
                console.log(event.latLng.A + ' ' + event.latLng.F);
                $scope.gmap.latitude = event.latLng.A;
                $scope.gmap.longitude = event.latLng.F;
            });
        });

    }]);
