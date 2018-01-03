'use strict';

app.controller('TrashListCtrl', ['$scope', '$http', '$state', '$modal', function ($scope, $http, $state, $modal) {
        requestedId = 0;
        
        $scope.lookInAround = function (statName) {
            var modalInstance = $modal.open({
                templateUrl: 'detailContent.html',
                controller: 'TrashListCtrl',
                scope: $scope,
                size: 'lg'
            });

        };
    }
]);


