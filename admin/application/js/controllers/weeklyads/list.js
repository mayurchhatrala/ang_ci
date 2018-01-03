'use strict';

app.controller('WeeklyDatatableCtrl', ['$scope', '$http', '$state', 'toaster', function ($scope, $http, $state, toaster) {

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
            sAjaxSource: BASEURL + 'weeklyads/WeeklyAdsRecord',
            aoColumns: [
                {
                    mData: 'adsLink',
                    sWidth: '15%'

                },
                {
                    mData: 'categoryName',
                    sWidth: '10%'

                },
                {
                    mData: 'retailerName',
                    sWidth: '10%'

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
                    mData: 'adsId',
                    sWidth: '25%'

                }

            ],
            aoColumnDefs: [
                /* {
                 
                 aTargets: [0],
                 
                 mRender: function (data, type, full) {
                 
                 
                 
                 if (full['adsId'] != '' && full['adsImage'] != '') {
                 
                 html[0] = '<img src=" ' + IMAGE_URL + 'Weekly/' + full['adsId'] + '/' + full['adsImage'] + ' " height="50" width="60" />';
                 
                 } else {
                 
                 html[0] = ' ';
                 
                 }
                 
                 
                 
                 return html[0];
                 
                 }
                 
                 }, */

                {
                    aTargets: [3],
                    mRender: function (data, type, full) {



                        return full['createDate1'];

                    }

                },
                {
                    aTargets: [4],
                    mRender: function (data, type, full) {



                        return full['modifiedDate1'];

                    }

                },
                {
                    aTargets: [5],
                    mRender: function (data, type, full) {



                        if (full['adsStatus'] == 'Active')
                            html[0] = '<a class="btn btn-info btn-xs btn-rounded change-option" data-tooltip="Active"><i class="glyphicon glyphicon-ok" id="i-lock-' + full['adsId'] + '"></i></a>';



                        if (full['adsStatus'] == 'Deactive')
                            html[0] = '<a class="btn btn-danger btn-xs btn-rounded change-option" data-tooltip="Deactive"><i class="glyphicon glyphicon-remove" id="i-lock-' + full['adsId'] + '"></i></a>';



                        html[0] += '&nbsp; <a class="btn btn-success btn-xs btn-rounded" data-tooltip="Edit" href="' + BASEURL + '#/app/weeklyads/form/' + full['adsId'] + '"><i class="fa fa-pencil fa-fw"></i></a>';



                        html[0] += '&nbsp; <a class="btn btn-danger btn-xs btn-rounded delete-option" data-tooltip="Delete" data-target="10"><i class="glyphicon glyphicon-trash"></i></a>';



                        // html[0] += '&nbsp; <a class="btn btn-info btn-xs btn-rounded " data-tooltip="View Detail" href="' + BASEURL + '#/app/category/view/' + full['categoryId'] + '"><i class="glyphicon glyphicon-globe"></i></a>';



                        //html += '&nbsp; <label class="i-switch m-t-xs m-r"><input type="checkbox" checked><i></i></label>';



                        return html[0];

                    }

                }

            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

                $('td:eq(2)', nRow).attr("id", 'weeklyads/operation');

                $('td:eq(5)', nRow).attr("id", aData.adsImageId);

            }

        };

    }]);