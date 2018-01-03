(function () {
    var permissionFactory = function () {
        factory.setValue = function (value) {
            permissionVal = JSON.parse(value);
        }
    }

    app.factory('setPermission', permissionFactory);
});