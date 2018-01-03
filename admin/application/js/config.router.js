'use strict';

var requestedId = 0;
var lastStateName = '';
var permissionVal = Array();
var resetemail = '';
/**
 * Config for the router
 */
angular.module('app').run(['$rootScope', '$state', '$stateParams', '$http', '$location', '$templateCache', function ($rootScope, $state, $stateParams, $http, $location, $templateCache) {
        $rootScope.$state = $state;
        $rootScope.$stateParams = $stateParams;
        $rootScope.$http = $http;
        /*
         * DISABLE CACHING
         */

        $rootScope.$on('$stateChangeStart', function (event, toState, toParams, fromState, fromParams) {
            /*
             * TO CHECK USER IS LOGGED IN OR NOT..??
             */
            $http.post(BASEURL + 'login/sessionCheck', {checkSession: 'y'}).then(function (response) {
                lastStateName = fromState.name;
                if (toState.module !== 'public' && response.data.value === -1) {
                    $state.go('access.signin');
                } else if (toState.module !== 'public' && response.data.value !== -1 && response.data.lock) {
                    $state.go('access.lock');
                } else if (toState.module === 'public' && response.data.value !== -1) {
                    $state.go('app.dashboard');
                }
            });
        });
        $rootScope.$on('$stateChangeSuccess', function (event, toState, toParams, fromState, fromParams) {
            if (typeof $stateParams.requestId !== 'undefined')
                requestedId = $stateParams.requestId;

            if (typeof $stateParams.resetemail !== 'undefined')
                resetemail = $stateParams.resetemail;
        });
    }]).config(['$stateProvider', '$urlRouterProvider', 'JQ_CONFIG', function ($stateProvider, $urlRouterProvider, JQ_CONFIG) {
        $urlRouterProvider.otherwise('/app/dashboard');
        $stateProvider.state('access', {
            url: '/access',
            template: '<div ui-view class="fade-in-right-big smooth"></div>'
        }).state('access.signin', {
            /* 
             * HERE WE ARE GOING TO CHECK USER'S CREDENTIALS...
             */
            url: '/signin',
            module: 'public',
            templateUrl: BASEURL + 'login/index/y',
            resolve: {
                deps: ['uiLoad', function (uiLoad) {
                        return uiLoad.load([JS_CNTRL + 'login/signin.js']);
                    }]
            }
        }).state('access.forgotpwd', {
            /* 
             * LOAD FORGOT PASSWORD CONTENT...
             */
            url: '/forgotpwd',
            module: 'public',
            templateUrl: BASEURL + 'login/forgotpwd/y',
            resolve: {
                deps: ['uiLoad', function (uiLoad) {
                        return uiLoad.load([JS_CNTRL + 'login/forgotpwd.js']);
                    }]
            }
        }).state('access.resetpwd', {
            /* 
             * LOAD FORGOT PASSWORD CONTENT...
             */
            url: '/resetpwd/:resetemail',
            module: 'public',
            templateUrl: BASEURL + 'login/resetpwd/y',
            resolve: {
                deps: ['uiLoad', function (uiLoad) {
                        return uiLoad.load([JS_CNTRL + 'login/resetpwd.js']);
                    }]
            }
        }).state('access.lock', {
            /* 
             * HERE WE ARE GOING TO CHECK USER'S CREDENTIALS...
             */
            url: '/lock',
            module: 'lock',
            templateUrl: BASEURL + 'lock/index/y',
            resolve: {
                deps: ['uiLoad', function (uiLoad) {
                        return uiLoad.load([JS_CNTRL + 'lock/lock.js']);
                    }]
            }
        }).state('app', {
            abstract: true,
            url: '/app',
            templateUrl: BASEURL + 'app/index/y'
        }).state('app.dashboard', {
            /* 
             * TO LOAD THE DASHBOARD CONTENT
             */
            url: '/dashboard',
            templateUrl: BASEURL + 'dashboard/index/y'
        }).state('app.trash', {
            /* 
             * TO LOAD THE TRASH CONTENT
             */
            url: '/trash',
            templateUrl: BASEURL + 'trash/index/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'app/trash/list.js']);
                    }]
            }
        }).state('app.profile', {
            url: '/profile',
            template: '<div ui-view class="fade-in-down smooth"></div>'
        }).state('app.profile.update', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE PROFILE INFORMATION 
             */
            url: '/update',
            templateUrl: BASEURL + 'profile/index/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'profile/profile.js']);
                    }]
            }
        }).state('app.profile.password', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE PASSWORD DETAILS 
             */
            url: '/password',
            templateUrl: BASEURL + 'profile/password/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'profile/password.js']);
                    }]
            }
        }).state('app.profile.settings', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/settings',
            templateUrl: BASEURL + 'profile/settings/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'profile/settings.js']);
                    }]
            }
        })
                
/*******************************************************************************************************************************************************
********************************************************************************************************************************************************/
        
        .state('app.permission', {
            url: '/permission',
            template: '<div ui-view class="fade-in-down smooth"></div>'
        }).state('app.permission.type', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/type',
            templateUrl: BASEURL + 'permission/adminType/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'app/permission/type/list.js']);
                    }]
            }
        }).state('app.permission.form', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/form',
            templateUrl: BASEURL + 'permission/adminTypeForm/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load('ui.select').then(function () {
                            return $ocLazyLoad.load(JS_CNTRL + 'app/permission/type/form.js');
                        });
                    }]
            }
        }).state('app.permission.form.edit', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/:requestId',
            templateUrl: BASEURL + 'permission/adminTypeForm/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'app/permission/type/form.js']);
                    }]
            }
        }).state('app.permission.list', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/list',
            templateUrl: BASEURL + 'permission/adminPermission/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'app/permission/list.js']);
                    }]
            }
        }).state('app.permission.manage', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/manage',
            templateUrl: BASEURL + 'permission/adminPermissionForm/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'app/permission/form.js']);
                    }]
            }
        }).state('app.permission.manage.edit', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/:requestId',
            templateUrl: BASEURL + 'permission/adminPermissionForm/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'app/permission/form.js']);
                    }]
            }
        })
                
/*******************************************************************************************************************************************************
********************************************************************************************************************************************************/    
            
        .state('app.modules', {
            url: '/modules',
            template: '<div ui-view class="fade-in-down smooth"></div>'
        }).state('app.modules.list', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/list',
            templateUrl: BASEURL + 'permission/adminModules/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'app/permission/modules/list.js']);
                    }]
            }
        }).state('app.modules.form', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/form',
            templateUrl: BASEURL + 'permission/adminModulesForm/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'app/permission/modules/form.js']);
                    }]
            }
        }).state('app.modules.form.edit', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/:requestId',
            templateUrl: BASEURL + 'permission/adminModulesForm/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'app/permission/modules/form.js']);
                    }]
            }
        })
                
/*******************************************************************************************************************************************************
********************************************************************************************************************************************************/    
            
        .state('app.pages', {
            url: '/pages',
            template: '<div ui-view class="fade-in-down smooth"></div>'
        }).state('app.pages.list', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/list',
            templateUrl: BASEURL + 'permission/adminPages/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'app/permission/pages/list.js']);
                    }]
            }
        }).state('app.pages.form', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/form',
            templateUrl: BASEURL + 'permission/adminPagesForm/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'app/permission/pages/form.js']);
                    }]
            }
        }).state('app.pages.form.edit', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/:requestId',
            templateUrl: BASEURL + 'permission/adminPagesForm/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'app/permission/pages/form.js']);
                    }]
            }
        })
                
/*******************************************************************************************************************************************************
********************************************************************************************************************************************************/    
            
        .state('template', {
            abstract: true,
            url: '/template',
            templateUrl: BASEURL + 'app/index/y'
        }).state('template.email', {
            url: '/email',
            template: '<div ui-view class="fade-in-down smooth"></div>'
        }).state('template.email.list', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/list',
            templateUrl: BASEURL + 'template/emailList/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'template/email/list.js']);
                    }]
            }
        }).state('template.email.form', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/form',
            templateUrl: BASEURL + 'template/emailForm/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        $ocLazyLoad.load(JS_CNTRL + 'template/email/form.js');
                    }]
            }
        }).state('template.email.form.edit', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/:requestId',
            templateUrl: BASEURL + 'template/emailForm/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(JS_CNTRL + 'template/email/form.js');
                    }]
            }
        })
                
/*******************************************************************************************************************************************************
********************************************************************************************************************************************************/    
            
        .state('app.logs', {
            url: '/logs',
            template: '<div ui-view></div>'
        }).state('app.logs.activity', {
            url: '/activity',
            template: '<div ui-view class="fade-in-down smooth"></div>'
        }).state('app.logs.activity.list', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/list',
            templateUrl: BASEURL + 'logs/activityList/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'logs/activity/list.js']);
                    }]
            }
        }).state('app.logs.activity.view', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/view/:requestId',
            templateUrl: BASEURL + 'logs/activityView/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'logs/activity/view.js']);
                    }]
            }
        })
                
/*******************************************************************************************************************************************************
********************************************************************************************************************************************************/    
            
        .state('app.gallery', {
            url: '/gallery',
            template: '<div ui-view class="fade-in-down smooth"></div>'
        }).state('app.gallery.list', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/list',
            templateUrl: BASEURL + 'gallery/galleryList/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'app/gallery/list.js']);
                    }]
            }
        }).state('app.gallery.form', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/form',
            templateUrl: BASEURL + 'gallery/galleryForm/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load('angularFileUpload').then(function () {
                            return $ocLazyLoad.load('bootstrapLightbox', function () {
                                return $ocLazyLoad.load(JS_CNTRL + 'app/gallery/form.js');
                            })
                        });
                    }]
            }
        }).state('app.gallery.form.edit', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/:requestId',
            templateUrl: BASEURL + 'gallery/galleryForm/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load('angularFileUpload').then(function () {
                            return $ocLazyLoad.load('bootstrapLightbox').then(function () {
                                return $ocLazyLoad.load(JS_CNTRL + 'app/gallery/form.js');
                            });
                        });
                    }]
            }
        })
                
/*******************************************************************************************************************************************************
********************************************************************************************************************************************************/    
            
        .state('app.google', {
            url: '/google',
            template: '<div ui-view class="fade-in-down smooth"></div>'
        }).state('app.google.map', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/map',
            templateUrl: BASEURL + 'user/googleMap/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'app/user/view.js']);
                    }]
            }
        }).state('app.ws', {
            url: '/ws',
            template: '<div ui-view class="fade-in-down smooth"></div>'
        }).state('app.ws.doc', {
            /* 
             * MAINTAIN WEB SERVICE DOCUMENTATION
             */
            url: '/doc',
            templateUrl: BASEURL + 'doc/ws/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'doc/ws.js']);
                    }]
            }
        })
        
/*******************************************************************************************************************************************************
********************************************************************************************************************************************************/
                
            
        .state('app.user', {
            url: '/user',
            template: '<div ui-view class="fade-in-down smooth"></div>'
        }).state('app.user.list', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/list',
            templateUrl: BASEURL + 'user/index/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'user/list.js']);
                    }]
            }
        }).state('app.user.form', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/form',
            templateUrl: BASEURL + 'user/form/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'user/form.js']);
                    }]
            }
        }).state('app.user.form.edit', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/:requestId',
            templateUrl: BASEURL + 'user/form/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load([JS_CNTRL + 'user/form.js']);
                    }]
            }
        })
        
/*******************************************************************************************************************************************************
********************************************************************************************************************************************************/

        .state('app.category', {
                            url: '/category',
                            template: '<div ui-view class="fade-in-down smooth"></div>'
                }).state('app.category.list', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/list',
            templateUrl: BASEURL + 'category/index/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'category/list.js']);
                                }
                        );
                    }]
            }
        }).state('app.category.form', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/form',
            templateUrl: BASEURL + 'category/form/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'category/form.js']);
                                }
                        );
                    }]
            }
        }).state('app.category.form.edit', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/:requestId',
            templateUrl: BASEURL + 'category/form/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'category/form.js']);
                                }
                        );
                    }]
            }
        }).state('app.category.view', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/view/:requestId',
            templateUrl: BASEURL + 'category/view/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'category/view.js']);
                                }
                        );
                    }]
            }
        })

/*******************************************************************************************************************************************************
********************************************************************************************************************************************************/

            .state('app.retailer', {
                    url: '/retailer',
                    template: '<div ui-view class="fade-in-down smooth"></div>'
        }).state('app.retailer.list', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/list',
            templateUrl: BASEURL + 'retailer/index/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'retailer/list.js']);
                                }
                        );
                    }]
            }
        }).state('app.retailer.form', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/form',
            templateUrl: BASEURL + 'retailer/form/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster', 'ngImageInputWithPreview']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'retailer/form.js']);
                                }
                        );
                    }]
            }
        }).state('app.retailer.form.edit', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/:requestId',
            templateUrl: BASEURL + 'retailer/form/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster', 'ngImageInputWithPreview']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'retailer/form.js']);
                                }
                        );
                    }]
            }
        }).state('app.retailer.view', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/view/:requestId',
            templateUrl: BASEURL + 'retailer/view/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'retailer/view.js']);
                                }
                        );
                    }]
            }
        })
        
/*******************************************************************************************************************************************************
********************************************************************************************************************************************************/
        
        .state('app.banner', {
                    url: '/banner',
                    template: '<div ui-view class="fade-in-down smooth"></div>'
        }).state('app.banner.list', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/list',
            templateUrl: BASEURL + 'banner/index/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'banner/list.js']);
                                }
                        );
                    }]
            }
        }).state('app.banner.form', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/form',
            templateUrl: BASEURL + 'banner/form/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'banner/form.js']);
                                }
                        );
                    }]
            }
        }).state('app.banner.form.edit', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/:requestId',
            templateUrl: BASEURL + 'banner/form/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'banner/form.js', JS_CNTRL + 'file-upload/upload.js']);
                                }
                        );
                    }]
            }
        }).state('app.banner.view', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/view/:requestId',
            templateUrl: BASEURL + 'banner/view/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'banner/view.js']);
                                }
                        );
                    }]
            }
        })

/*******************************************************************************************************************************************************
********************************************************************************************************************************************************/
        
        .state('app.catalog', {
                    url: '/catalog',
                    template: '<div ui-view class="fade-in-down smooth"></div>'
        }).state('app.catalog.list', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/list',
            templateUrl: BASEURL + 'catalog/index/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'catalog/list.js']);
                                }
                        );
                    }]
            }
        }).state('app.catalog.form', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/form',
            templateUrl: BASEURL + 'catalog/form/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // ngImageInputWithPreview
                        return $ocLazyLoad.load(['toaster', 'ngFileUpload', 'ui.select']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'catalog/form.js']);
                                }
                        );
                    }]
            }
        }).state('app.catalog.form.edit', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/:requestId',
            templateUrl: BASEURL + 'catalog/form/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster', 'ngFileUpload', 'ui.select']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'catalog/form.js']);
                                }
                        );
                    }]
            }
        }).state('app.catalog.view', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/view/:requestId',
            templateUrl: BASEURL + 'catalog/view/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'catalog/view.js']);
                                }
                        );
                    }]
            }
        })

/*******************************************************************************************************************************************************
********************************************************************************************************************************************************/
        
        .state('app.weeklyads', {
                    url: '/weeklyads',
                    template: '<div ui-view class="fade-in-down smooth"></div>'
        }).state('app.weeklyads.list', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/list',
            templateUrl: BASEURL + 'weeklyads/index/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'weeklyads/list.js']);
                                }
                        );
                    }]
            }
        }).state('app.weeklyads.form', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/form',
            templateUrl: BASEURL + 'weeklyads/form/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster', 'ngFileUpload', 'ui.select']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'weeklyads/form.js']);
                                }
                        );
                    }]
            }
        }).state('app.weeklyads.form.edit', {
            /* 
             * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
             */
            url: '/:requestId',
            templateUrl: BASEURL + 'weeklyads/form/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster', 'ngFileUpload', 'ui.select']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'weeklyads/form.js']);
                                }
                        );
                    }]
            }
        }).state('app.weeklyads.view', {
            /* 
             * HERE WE ARE GOING TO LIST OUT THE USERS
             */
            url: '/view/:requestId',
            templateUrl: BASEURL + 'weeklyads/view/y',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                        return $ocLazyLoad.load(['toaster']).then(
                                function () {
                                    return $ocLazyLoad.load([JS_CNTRL + 'weeklyads/view.js']);
                                }
                        );
                    }]
            }
        })
        
/*******************************************************************************************************************************************************
********************************************************************************************************************************************************/


        // Content list
        .state('app.content', {
                url: '/content',
                template: '<div ui-view class="fade-in-down smooth"></div>'
        }).state('app.content.list', {
                url: '/list',
                templateUrl: BASEURL + 'pages/index/y',
                resolve: {
                    deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load(['toaster']).then(
                                    function () {
                                        return $ocLazyLoad.load([JS_CNTRL + 'pages/list.js']);
                                    }
                            );
                        }]
                }
        }).state('app.content.form', {
                /* 
                 * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
                 */
                url: '/form',
                templateUrl: BASEURL + 'pages/form/y',
                resolve: {
                    deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load(['toaster', 'textAngular']).then(
                                    function () {
                                        return $ocLazyLoad.load([JS_CNTRL + 'pages/form.js']);
                                    }
                            );
                        }]
                }
        }).state('app.content.form.edit', {
                /* 
                 * HERE WE ARE GOING TO UPDATE THE SETTINGS DETAILS 
                 */
                url: '/:requestId',
                templateUrl: BASEURL + 'pages/form/y',
                resolve: {
                    deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                            return $ocLazyLoad.load(['toaster', 'textAngular']).then(
                                    function () {
                                        return $ocLazyLoad.load([JS_CNTRL + 'pages/form.js']);
                                    }
                            );
                        }]
                }
        })

/*******************************************************************************************************************************************************
********************************************************************************************************************************************************/
        
    }
])