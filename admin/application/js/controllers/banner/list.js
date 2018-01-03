'use strict';

app.controller('BannerAdsDatatableCtrl', ['$scope', '$http', '$state', 'toaster', function ($scope, $http, $state, toaster) {
        var html = [];
        requestedId = 0;

        $scope.options = {
            sPaginationType: "full_numbers",
            bStateSave: true,
            bProcessing: true,
            bServerSide: false,
            sServerMethod: "POST",
            oLanguage: {
                sSearch: "Search:"
            },
            bSortCellsTop: true,
            sAjaxSource: BASEURL + 'banner/BannerRecord',
            aoColumns: [
                {
                    mData: 'bannerIcon',
                    sWidth: '15%'
                },
                {
                    mData: 'bannerLink',
                    sWidth: '15%'
                },
                {
                    mData: 'createDate',
                    sWidth: '20%',
                },
                {
                    mData: 'modifiedDate',
                    sWidth: '20%',
                },
                {
                    mData: 'bannerId',
                    sWidth: '30%'
                }
            ],
            aoColumnDefs: [
                {
                    aTargets: [0],
                    mRender: function (data, type, full) {

                        if (full['bannerId'] != '' && full['bannerIcon'] != '') {
                            html[0] = '<img src=" ' + IMAGE_URL + 'Banner/' + full['bannerId'] + '/' + full['bannerIcon'] + ' " height="50" width="50" />';
                        } else {
                            html[0] = ' ';
                        }

                        return html[0];
                    }
                },
                {
                    aTargets: [2],
                    mRender: function (data, type, full) {

                        return full['createDate1'];
                    }
                },
                {
                    aTargets: [3],
                    mRender: function (data, type, full) {

                        return full['modifiedDate1'];
                    }
                },
                {
                    aTargets: [4],
                    mRender: function (data, type, full) {

                        if (full['bannerStatus'] == 'Active')
                            html[0] = '<a class="btn btn-info btn-xs btn-rounded change-option" data-tooltip="Active"><i class="glyphicon glyphicon-ok" id="i-lock-' + full['bannerId'] + '"></i></a>';

                        if (full['bannerStatus'] == 'Deactive')
                            html[0] = '<a class="btn btn-danger btn-xs btn-rounded change-option" data-tooltip="Deactive"><i class="glyphicon glyphicon-remove" id="i-lock-' + full['bannerId'] + '"></i></a>';

                        html[0] += '&nbsp; <a class="btn btn-success btn-xs btn-rounded" data-tooltip="Edit" href="' + BASEURL + '#/app/banner/form/' + full['bannerId'] + '"><i class="fa fa-pencil fa-fw"></i></a>';

                        html[0] += '&nbsp; <a class="btn btn-danger btn-xs btn-rounded delete-option" data-tooltip="Delete" data-target="9"><i class="glyphicon glyphicon-trash"></i></a>';

                        // html[0] += '&nbsp; <a class="btn btn-info btn-xs btn-rounded " data-tooltip="View Detail" href="' + BASEURL + '#/app/banner/view/' + full['retailerId'] + '"><i class="glyphicon glyphicon-globe"></i></a>';

                        //html += '&nbsp; <label class="i-switch m-t-xs m-r"><input type="checkbox" checked><i></i></label>';

                        return html[0];
                    }
                }
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(2)', nRow).attr("id", 'banner/operation');
            }
        };
    }]);