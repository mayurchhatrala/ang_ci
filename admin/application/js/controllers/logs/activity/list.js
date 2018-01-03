'use strict';

app.controller('UserActivityTableCtrl', ['$scope', '$http', '$state', function ($scope, $http, $state) {
        $scope.setPermission = function (value) {
            permissionVal = JSON.parse(value);
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
        $scope.options = {
            sPaginationType: "full_numbers",
            bStateSave: true,
            bProcessing: true,
            bServerSide: true,
            sServerMethod: "POST",
            oLanguage: {
                sSearch: "Search:"
            },
            bSortCellsTop: true,
            sAjaxSource: BASEURL + 'logs/activityRecord',
            aoColumns: [
                {
                    mData: 'userName',
                    sWidth: '30%'
                },
                {
                    mData: 'logCount',
                    sWidth: '30%'
                },
                {
                    mData: 'userId',
                    bSortable: false,
                    sWidth: '15%'
                }
            ],
            aoColumnDefs: [
                {
                    aTargets: [2],
                    mRender: function (data, type, full) {

                        html[0] = permissionVal[5] ? '<a href="' + BASEURL + '#/app/logs/activity/view/' + full['userId'] + '" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>' : '';

                        return html[0];
                    }
                }
            ]
        };
    }]);
