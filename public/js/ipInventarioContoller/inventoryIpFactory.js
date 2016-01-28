app.factory('inventoriIpFactory', function ($http) {
    return {
        'getInventoriIp': function (filtro) {
            return $http.post('/getInventoryIp', {filtro: filtro});
        },
        'getInventoriIpRangos': function (filtro) {
            return $http.post('/getInventoriIpRangos', {filtro: filtro});
        },
        'getInventoriIpId': function (ipaddress, netmask) {
            return $http.post('/getInventoriIpId', {ipaddress: ipaddress, netmask: netmask });
        },
        'getInventarioServicio': function (serviceid) {
            return $http.post('/getInventarioServicio', {serviceid: serviceid});
        },
        'getIpRanges': function () {
            return $http.post('/getIpRanges');
        }
    };
});

