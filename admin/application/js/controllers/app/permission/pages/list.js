'use strict';

app.controller('AdminPagesTableCtrl', ['$scope', '$http', '$state', function ($scope, $http, $state) {
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
            sAjaxSource: BASEURL + 'permission/getAdminPagesRecord',
            aoColumns: [
                {
                    mData: 'pageTitle',
                    sWidth: '30%'
                },
                {
                    mData: 'pageState',
                    sWidth: '30%'
                },
                {
                    mData: 'moduleName',
                    sWidth: '25%'
                },
                {
                    mData: 'pageId',
                    bSortable: false,
                    sWidth: '15%'
                }
            ],
            aoColumnDefs: [
                {
                    aTargets: [3],
                    mRender: function (data, type, full) {
                        html[0] = '<button class="btn ' + (full['status'] == 'deactive' ? 'btn-default' : 'btn-success') + ' btn-xs status-option" data-target="4"><i class="fa fa-lightbulb-o fa-fw"></i></button>';
                        html[0] += '&nbsp; <a class="btn btn-info btn-xs" href="' + BASEURL + '#/app/pages/form/' + full['pageId'] + '"><i class="fa fa-pencil fa-fw"></i></a>';
                        html[0] += '&nbsp; <a class="btn btn-danger btn-xs delete-option" data-target="4"><i class="fa fa-times fa-fw"></i></a>';

                        return html[0];
                    }
                }
            ]
        };
    }]);