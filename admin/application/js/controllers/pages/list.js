'use strict';

app.controller('PagesDatatableCtrl', ['$scope', '$http', '$state', 'toaster', function ($scope, $http, $state, toaster) {
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
            sAjaxSource: BASEURL + 'Pages/PagesRecord',
            aoColumns: [
                {
                    mData: 'pName',
                    sWidth: '10%'
                },
                {
                    mData: 'pContent',
                    sWidth: '10%'
                },
                {
                    mData: 'pDate',
                    sWidth: '10%'
                },
                {
                    mData: 'EndDate',
                    sWidth: '10%'
                },
                {
                    mData: 'pID',
                    sWidth: '10%'
                }
            ],
            aoColumnDefs: [
                {
                    aTargets: [1],
                    mRender: function (data, type, full) {
                        return data.substr(1, 200);
                    }
                },
                {
                    aTargets: [4],
                    mRender: function (data, type, full) {

                        if (full['pStatus'] == 'Active')
                            html[0] = '<a class="btn btn-info btn-xs btn-rounded change-option" data-tooltip="Active"><i class="glyphicon glyphicon-ok" id="i-lock-' + full['pID'] + '"></i></a>';

                        if (full['pStatus'] == 'Deactive')
                            html[0] = '<a class="btn btn-danger btn-xs btn-rounded change-option" data-tooltip="Deactive"><i class="glyphicon glyphicon-remove" id="i-lock-' + full['pID'] + '"></i></a>';

                        html[0] += '&nbsp; <a class="btn btn-success btn-xs btn-rounded" data-tooltip="Edit" href="' + BASEURL + '#/app/content/form/' + full['pID'] + '"><i class="fa fa-pencil fa-fw"></i></a>';

                        html[0] += '&nbsp; <a class="btn btn-danger btn-xs btn-rounded delete-option" data-tooltip="Delete" data-target="12"><i class="glyphicon glyphicon-trash"></i></a>';


                        return html[0];
                    }
                }
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(2)', nRow).attr("id", 'pages/operation');
            }
        };
    }]);