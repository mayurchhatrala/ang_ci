'use strict';

app.controller('UserDatatableCtrl', ['$scope', '$http', '$state', function ($scope, $http, $state) {
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
            sAjaxSource: BASEURL + 'user/userRecord',
            aoColumns: [
                {
                    mData: 'userId',
                    bSortable: false,
                    sWidth: '5%'
                },
                {
                    mData: 'userName',
                    sWidth: '25%'
                },
                {
                    mData: 'userEmail',
                    sWidth: '30%'
                },
                {
                    mData: 'adminTypeName',
                    sWidth: '25%'
                },
                {
                    mData: 'userId',
                    bSortable: false,
                    sWidth: '15%'
                }
            ],
            aoColumnDefs: [
                {
                    aTargets: [0],
                    mRender: function (data, type, full) {
                        html[0] = permissionVal[3] ? '<label class="i-checks"> <input type="checkbox" ng-model="user.action[' + full['userId'] + ']" ng-value="' + full['userId'] + '" ng-init="user.action[' + full['userId'] + '] = false" ng-click="checkUncheck(' + full['userId'] + ')"/><i></i></label>' : '';

                        return html[0];
                    }
                },
                {
                    aTargets: [4],
                    mRender: function (data, type, full) {

                        html[1] = permissionVal[4] ? '<button class="btn ' + (full['status'] == 'deactive' ? 'btn-default' : 'btn-success') + ' btn-xs status-option" data-target="2"><i class="fa fa-lightbulb-o fa-fw"></i></button>' : '';
                        html[1] += permissionVal[2] ? '&nbsp; <a class="btn btn-info btn-xs" href="' + BASEURL + '#/app/user/form/' + full['userId'] + '"><i class="fa fa-pencil fa-fw"></i></a>' : '';
                        html[1] += permissionVal[3] ? '&nbsp; <a class="btn btn-danger btn-xs delete-option" data-target="2"><i class="fa fa-times fa-fw"></i></a>' : '';

                        return html[1];
                    }
                }
            ]
        };

        
        $scope.checkUncheck = function (id) {
            id = parseInt(id);
            console.log(id);
            var actions = $scope.user.action;

            console.log($scope.user.action);
            if (id == 0) {
                if (typeof $scope.user.action[0] == 'undefined')
                    $scope.user.action[0] = true;
                else if ($scope.user.action[0] == true)
                    $scope.user.action[0] = false;
                else if ($scope.user.action[0] == false)
                    $scope.user.action[0] = true;
            }

            $.each(actions, function (key, value) {
                if (id == 0 && key != 0) {
                    if ($scope.user.action[0] == true)
                        $scope.user.action[key] = true;
                    else {
                        $scope.user.action[key] = false;
                    }
                }
            });
        };


    }]);


