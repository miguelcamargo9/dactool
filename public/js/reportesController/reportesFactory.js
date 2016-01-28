/* global app, site */

app.factory('reportesFactory', function ($http) {
    return {
        'getEstadosQuoereUp': function (filtro) {
            return $http.post('/reporteestadosup', {filtro: filtro});
        },
        'getEstadosQuoereDown': function (filtro) {
            return $http.post('/reporteestadosdown', {filtro: filtro} );
        },
        'getServiciosGrafica': function (filtro) {
            return $http.post('/reporteserviciosgrafica', {filtro: filtro} );
        },
        'getInconsistecias': function (filtro) {
            return $http.post('/reporteInconsistencias', {filtro: filtro} );
        },
        'getVlans': function (filtro) {
            return $http.post('/reportevlans', {filtro: filtro} );
        },
        'getPaises': function () {
            return $http.post('/reportes/paises');
        }
    };

});
