// lazyload config
var COMP_URL = BASEURL + 'components/';
angular.module('app')
        /**
         * jQuery plugin config use ui-jq directive , config the js and css files that required
         * key: function name of the jQuery plugin
         * value: array of the css js file located
         */

        .constant('JQ_CONFIG', {
            easyPieChart: [
                COMP_URL + 'jquery.easy-pie-chart/dist/jquery.easypiechart.fill.js'
            ],
            sparkline: [
                COMP_URL + 'jquery.sparkline/dist/jquery.sparkline.retina.js'
            ],
            plot: [
                COMP_URL + 'flot/jquery.flot.js',
                COMP_URL + 'flot/jquery.flot.pie.js',
                COMP_URL + 'flot/jquery.flot.resize.js',
                COMP_URL + 'flot.tooltip/js/jquery.flot.tooltip.js',
                COMP_URL + 'flot.orderbars/js/jquery.flot.orderBars.js',
                COMP_URL + 'flot-spline/js/jquery.flot.spline.js'
            ],
            moment: [
                COMP_URL + 'moment/moment.js'
            ],
            screenfull: [
                COMP_URL + 'screenfull/dist/screenfull.min.js'
            ],
            slimScroll: [
                COMP_URL + 'slimscroll/jquery.slimscroll.min.js'
            ],
            sortable: [
                COMP_URL + 'html5sortable/jquery.sortable.js'
            ],
            nestable: [
                COMP_URL + 'nestable/jquery.nestable.js',
                COMP_URL + 'nestable/jquery.nestable.css'
            ],
            filestyle: [
                COMP_URL + 'bootstrap-filestyle/src/bootstrap-filestyle.js'
            ],
            slider: [
                COMP_URL + 'bootstrap-slider/bootstrap-slider.js',
                COMP_URL + 'bootstrap-slider/bootstrap-slider.css'
            ],
            chosen: [
                COMP_URL + 'chosen/chosen.jquery.min.js',
                COMP_URL + 'bootstrap-chosen/bootstrap-chosen.css'
            ],
            TouchSpin: [
                COMP_URL + 'bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js',
                COMP_URL + 'bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css'
            ],
            wysiwyg: [
                COMP_URL + 'bootstrap-wysiwyg/bootstrap-wysiwyg.js',
                COMP_URL + 'bootstrap-wysiwyg/external/jquery.hotkeys.js'
            ],
            dataTable: [
                COMP_URL + 'datatables/media/js/jquery.dataTables.min.js',
                COMP_URL + 'plugins/integration/bootstrap/3/dataTables.bootstrap.js',
                COMP_URL + 'plugins/integration/bootstrap/3/dataTables.bootstrap.css'
            ],
            ngDataTable: [
                COMP_URL + 'angular-datatables/src/angular-datatables.js',
                COMP_URL + 'angular-datatables/styles/main.css'
            ],
            vectorMap: [
                COMP_URL + 'bower-jvectormap/jquery-jvectormap-1.2.2.min.js',
                COMP_URL + 'bower-jvectormap/jquery-jvectormap-world-mill-en.js',
                COMP_URL + 'bower-jvectormap/jquery-jvectormap-us-aea-en.js',
                COMP_URL + 'bower-jvectormap/jquery-jvectormap-1.2.2.css'
            ],
            footable: [
                COMP_URL + 'footable/dist/footable.all.min.js',
                COMP_URL + 'footable/css/footable.core.css'
            ],
            fullcalendar: [
                COMP_URL + 'moment/moment.js',
                COMP_URL + 'fullcalendar/dist/fullcalendar.min.js',
                COMP_URL + 'fullcalendar/dist/fullcalendar.css',
                COMP_URL + 'fullcalendar/dist/fullcalendar.theme.css'
            ],
            daterangepicker: [
                COMP_URL + 'moment/moment.js',
                COMP_URL + 'bootstrap-daterangepicker/daterangepicker.js',
                COMP_URL + 'bootstrap-daterangepicker/daterangepicker-bs3.css'],
            tagsinput: [COMP_URL + 'bootstrap-tagsinput/dist/bootstrap-tagsinput.js',
                COMP_URL + 'bootstrap-tagsinput/dist/bootstrap-tagsinput.css'
            ]}
        )
        // oclazyload config
        .config(['$ocLazyLoadProvider', function ($ocLazyLoadProvider) {
                // We configure ocLazyLoad to use the lib script.js as the async loader
                $ocLazyLoadProvider.config({
                    debug: true,
                    events: true,
                    modules: [
                        {
                            name: 'ngGrid',
                            files: [
                                COMP_URL + 'ng-grid/build/ng-grid.min.js',
                                COMP_URL + 'ng-grid/ng-grid.min.css',
                                COMP_URL + 'ng-grid/ng-grid.bootstrap.css'
                            ]
                        },
                        {
                            name: 'ui.grid',
                            files: [
                                COMP_URL + 'angular-ui-grid/ui-grid.min.js',
                                COMP_URL + 'angular-ui-grid/ui-grid.min.css',
                                COMP_URL + 'angular-ui-grid/ui-grid.bootstrap.css'
                            ]
                        },
                        {
                            name: 'ui.select',
                            files: [
                                COMP_URL + 'angular-ui-select/dist/select.min.js',
                                COMP_URL + 'angular-ui-select/dist/select.min.css'
                            ]
                        },
                        {
                            name: 'angularFileUpload',
                            files: [
                                COMP_URL + 'angular-file-upload/angular-file-upload.min.js'
                            ]
                        },
                        {
                            name: 'ui.calendar',
                            files: [COMP_URL + 'angular-ui-calendar/src/calendar.js']
                        },
                        {
                            name: 'ngImgCrop',
                            files: [
                                COMP_URL + 'ngImgCrop/compile/minified/ng-img-crop.js',
                                COMP_URL + 'ngImgCrop/compile/minified/ng-img-crop.css'
                            ]
                        },
                        {
                            name: 'angularBootstrapNavTree',
                            files: [
                                COMP_URL + 'angular-bootstrap-nav-tree/dist/abn_tree_directive.js',
                                COMP_URL + 'angular-bootstrap-nav-tree/dist/abn_tree.css'
                            ]
                        },
                        {
                            name: 'toaster',
                            files: [
                                COMP_URL + 'angularjs-toaster/toaster.js',
                                COMP_URL + 'angularjs-toaster/toaster.css'
                            ]
                        },
                        {
                            name: 'textAngular',
                            files: [
                                COMP_URL + 'textAngular/dist/textAngular-sanitize.min.js',
                                COMP_URL + 'textAngular/dist/textAngular.min.js'
                            ]
                        },
                        {
                            name: 'vr.directives.slider',
                            files: [
                                COMP_URL + 'venturocket-angular-slider/build/angular-slider.min.js',
                                COMP_URL + 'venturocket-angular-slider/build/angular-slider.css'
                            ]
                        },
                        {
                            name: 'com.2fdevs.videogular',
                            files: [
                                COMP_URL + 'videogular/videogular.min.js'
                            ]
                        },
                        {
                            name: 'com.2fdevs.videogular.plugins.controls',
                            files: [
                                COMP_URL + 'videogular-controls/controls.min.js'
                            ]
                        },
                        {
                            name: 'com.2fdevs.videogular.plugins.buffering',
                            files: [
                                COMP_URL + 'videogular-buffering/buffering.min.js'
                            ]
                        },
                        {
                            name: 'com.2fdevs.videogular.plugins.overlayplay',
                            files: [
                                COMP_URL + 'videogular-overlay-play/overlay-play.min.js'
                            ]
                        },
                        {
                            name: 'com.2fdevs.videogular.plugins.poster',
                            files: [
                                COMP_URL + 'videogular-poster/poster.min.js'
                            ]
                        },
                        {
                            name: 'com.2fdevs.videogular.plugins.imaads',
                            files: [
                                COMP_URL + 'videogular-ima-ads/ima-ads.min.js'
                            ]
                        },
                        {
                            name: 'xeditable',
                            files: [
                                COMP_URL + 'angular-xeditable/dist/js/xeditable.min.js',
                                COMP_URL + 'angular-xeditable/dist/css/xeditable.css'
                            ]
                        },
                        {
                            name: 'smart-table',
                            files: [
                                COMP_URL + 'angular-smart-table/dist/smart-table.min.js'
                            ]
                        },
                        {
                            name: 'googleMap',
                            files: [
                                'http://maps.google.com/maps/api/js'
                            ]
                        },
                        {
                            name: 'bootstrapLightbox',
                            files: [
                                COMP_URL + 'angular-bootstrap-lightbox/angular-bootstrap-lightbox.min.js',
                                COMP_URL + 'angular-bootstrap-lightbox/angular-bootstrap-lightbox.min.css'
                            ]
                        },
                        {
                            name: 'ngImageInputWithPreview',
                            files: [
                                COMP_URL + 'ng-image-input-with-preview/dist/ng-image-input-with-preview.js',
                            ]
                        },
                        {
                            name: "ngFileUpload",
                            files: [COMP_URL + "ng-file-upload/ng-file-upload-all.js"]
                        }
                    ]
                });
            }])
        ;
