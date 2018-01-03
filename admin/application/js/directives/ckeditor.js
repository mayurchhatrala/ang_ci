app.directive('ckEditor', [function () {
        return {
            require: '?ngModel',
            restrict: 'C',
            link: function (scope, elm, attr, ngModel) {
                var ck = CKEDITOR.replace(elm[0], {
                    removeButtons: 'Cut,Copy,Paste,PasteText,PasteFromWord',
                });

                if (!ngModel)
                    return;

                ck.on('pasteState', function () {
                    scope.$apply(function () {
                        ngModel.$setViewValue(ck.getData());

                    });
                });

                ngModel.$render = function (value) {
                    ck.setData(ngModel.$viewValue);
                };
            }
        };
    }]);