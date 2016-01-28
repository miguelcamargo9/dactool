var app = angular.module('inventoryips', [
    'treeGrid'
]);

app.controller('inventoryipController', [
    '$scope',
    '$rootScope',
    'inventoriIpFactory',
    function ($scope, $rootScope, inventoriIpFactory) {
        $('#loading').show();
        inventoriIpFactory.getIpRanges().success(function (data) {
            $scope.ipranges = data;
        });

        $scope.filtrarArbol = function () {
            inventoriIpFactory.getInventoriIpRangos($scope.RangeId.RangeId).success(function (data) {
                $scope.generarArbol(data);
            });
        };

        $scope.filtrarIp = function () {
            inventoriIpFactory.getInventoriIpId($scope.IpAdressId, $scope.NetMask.value).success(function (data) {
                $scope.generarArbol(data);
                setTimeout(function () {
                    $scope.$apply($scope.my_tree.expand_all);
                }, 25);
            });
        };
        
        $scope.filtrarServicio = function () {
            inventoriIpFactory.getInventarioServicio($scope.ServiceId).success(function (data) {
                $scope.generarArbol(data);
                setTimeout(function () {
                    $scope.$apply($scope.my_tree.expand_all);
                }, 25);
            });
        };

        $scope.tree_data = [];
        $scope.my_tree = tree = {};
        $scope.mask = [{value: 24}, {value: 25}, {value: 26}, {value: 27}, {value: 28}, {value: 29}, {value: 30}, {value: 32}];
        $scope.IpAdressId = '';
        $scope.col_defs = [
            {field: "IpAddress", displayName: "Direccion IP",
                cellTemplate:
                        "<div ng-if='row.branch[\"Netmask\"] == 24'><a href='' ng-click='cargarBusqueda(row.branch[col.field]);'>{{row.branch[\"IpAddress\"]}}</a></div>" +
                        "<div ng-if='row.branch[\"Netmask\"] != 24'>{{row.branch[col.field]}}</div>"},
            {field: "state_ip", displayName: "Estado", subField: "Nombre",
                cellTemplate: "<div>{{row.branch[col.field][col.subField]}}</div>"},
            {field: "ServiceId", displayName: "Service ID",
                cellTemplate: "<div><a href='verservicio/{{row.branch[col.field]}}'>{{row.branch[col.field]}}</a></div>"},
            {field: "rango_ip", displayName: "Rango IFX", subField: "IpAddress",
                cellTemplate: "<div>{{row.branch[col.field][col.subField]}}</div>"}
//            {field: "OperationId", displayName: "Operation ID"}
        ];
        inventoriIpFactory.getInventoriIp().success(function (data) {
            $scope.generarArbol(data);
        });

        $scope.generarArbol = function (data) {
            $('#loading').hide();
            var myTreeData = getTree(data, 'Id', 'IdPadre');
            $scope.tree_data = myTreeData;
            $scope.expanding_property = "";

            function getTree(data, primaryIdName, parentIdName) {
                if (!data || data.length == 0 || !primaryIdName || !parentIdName)
                    return [];

                var tree = [],
                        rootIds = [],
                        item = data[0],
                        primaryKey = item[primaryIdName],
                        treeObjs = {},
                        parentId,
                        parent,
                        len = data.length,
                        i = 0;

                while (i < len) {
                    item = data[i++];
                    primaryKey = item[primaryIdName];
                    treeObjs[primaryKey] = item;
                    parentId = item[parentIdName];

                    if (parentId) {
                        parent = treeObjs[parentId];

                        if (parent.children) {
                            parent.children.push(item);
                        }
                        else {
                            parent.children = [item];
                        }
                    }
                    else {
                        rootIds.push(primaryKey);
                    }
                }

                for (var i = 0; i < rootIds.length; i++) {
                    tree.push(treeObjs[rootIds[i]]);
                }
                ;

                return tree;
            }
        };

    }
]);


