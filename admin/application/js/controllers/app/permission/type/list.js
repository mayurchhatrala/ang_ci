'use strict';

app.controller('AdminTypeTableCtrl', ['$scope', '$http', '$state', function ($scope, $http, $state) {
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
            sAjaxSource: BASEURL + 'permission/getAdminTypeRecord',
            aoColumns: [
                {
                    mData: 'adminTitle',
                    sWidth: '85%'
                },
                {
                    mData: 'adminTypeId',
                    bSortable: false,
                    sWidth: '15%'
                }
            ],
            aoColumnDefs: [
                {
                    aTargets: [1],
                    mRender: function (data, type, full) {
                        html[0] = '<button class="btn ' + (full['status'] == 'deactive' ? 'btn-default' : 'btn-success') + ' btn-xs status-option" data-target="1"><i class="fa fa-lightbulb-o fa-fw"></i></button>';
                        html[0] += '&nbsp; <a class="btn btn-info btn-xs" href="' + BASEURL + '#/app/permission/form/' + full['adminTypeId'] + '"><i class="fa fa-pencil fa-fw"></i></a>';
                        html[0] += '&nbsp; <a class="btn btn-danger btn-xs delete-option" data-target="1"><i class="fa fa-times fa-fw"></i></a>';

                        return html[0];
                    }
                }
            ]
        };
    }]);