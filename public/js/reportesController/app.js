var app = angular.module('graficasApp', ['chart.js']);

(function () {

    app.config(function (ChartJsProvider) {
        // Configure all charts
        ChartJsProvider.setOptions({
            colours: ['#00db37', '#ffbb38', '#ff3345', '#b638ff', '#373DDD', '#9a6d38'],
            responsive: true
        });
        // Configure all doughnut charts
        ChartJsProvider.setOptions('Doughnut', {
            animateScale: true
        });
    });

    app.controller('LineCtrl', ['$scope', 'reportesFactory', function ($scope, reportesFactory) {

            $scope.verGrafica = function () {
                reportesFactory.getServiciosGrafica().success(function (data) {
                    $scope.generarGrafica(data);
                });
            };

            $scope.verGrafica();

            reportesFactory.getPaises().success(function (data) {
                $scope.paises = data;
            });

            $scope.aplicarFiltro = function () {
                reportesFactory.getServiciosGrafica($scope.nFiltro).success(function (data) {
                    $scope.generarGrafica(data);
                });
            };

            $scope.generarGrafica = function (data) {
                $scope.labels = data.labels;
                $scope.series = data.series;
                $scope.data = data.data;
            };
        }
    ]);

    app.controller('BarCtrlUp', ['$scope', 'reportesFactory', function ($scope, reportesFactory) {
            $scope.options = {scaleShowVerticalLines: false};
            $scope.nFiltro = {};

            $scope.verGrafica = function () {
                reportesFactory.getEstadosQuoereUp().success(function (data) {
                    $scope.generarGrafica(data);
                });
            };

            $scope.verGrafica();

            reportesFactory.getPaises().success(function (data) {
                $scope.paises = data;
            });

            $scope.aplicarFiltro = function () {
                reportesFactory.getEstadosQuoereUp($scope.nFiltro).success(function (data) {
                    $scope.generarGrafica(data);
                });
            };

            $scope.generarGrafica = function (data) {
                $scope.labels = data.labels;
                $scope.series = data.series;
                $scope.data = data.data;
            };
        }]);


    app.controller('BarCtrlDown', ['$scope', 'reportesFactory', function ($scope, reportesFactory) {
            $scope.options = {scaleShowVerticalLines: true};
            $scope.nFiltro = {};

            $scope.verGrafica = function () {
                reportesFactory.getEstadosQuoereDown().success(function (data) {
                    $scope.generarGrafica(data);
                });
            };
            
            $scope.verGrafica();

            reportesFactory.getPaises().success(function (data) {
                $scope.paises = data;
            });

            $scope.aplicarFiltro = function () {
                reportesFactory.getEstadosQuoereDown($scope.nFiltro).success(function (data) {
                    $scope.generarGrafica(data);
                });
            };

            $scope.generarGrafica = function (data) {
                $scope.labels = data.labels;
                $scope.series = data.series;
                $scope.data = data.data;
            };

        }]);

    app.controller('BarCtrlIn', ['$scope', 'reportesFactory', function ($scope, reportesFactory) {
            $scope.options = {scaleShowVerticalLines: false};
            $scope.nFiltro = {};

            reportesFactory.getInconsistecias().success(function (data) {
                $scope.labels = data.labels;
                $scope.series = data.series;
                $scope.data = data.data;
            });

            reportesFactory.getPaises().success(function (data) {
                $scope.paises = data;
            });

            $scope.aplicarFiltro = function () {
                reportesFactory.getEstadosQuoereUp($scope.nFiltro).success(function (data) {
                    $scope.labels = data.labels;
                    $scope.series = data.series;
                    $scope.data = data.data;
                });
            };
        }]);

    app.controller('vlanCtrl', ['$scope', 'reportesFactory', function ($scope, reportesFactory) {
            $scope.options = {scaleShowVerticalLines: false};
            $scope.nFiltro = {};

            $scope.verGrafica = function () {
                reportesFactory.getVlans().success(function (data) {
                    $scope.generarGrafica(data);
                });
            };

            $scope.verGrafica();

            reportesFactory.getPaises().success(function (data) {
                $scope.paises = data;
            });

            $scope.aplicarFiltro = function () {
                reportesFactory.getVlans($scope.nFiltro).success(function (data) {
                    $scope.generarGrafica(data);
                });
            };

            $scope.generarGrafica = function (data) {
                $scope.labels = data.labels;
                $scope.series = data.series;
                $scope.data = data.data;
            };
        }]);

    app.controller('DoughnutCtrl', ['$scope', '$timeout', function ($scope, $timeout) {
            $scope.labels = ['Download Sales', 'In-Store Sales', 'Mail-Order Sales'];
            $scope.data = [0, 0, 0];

            $timeout(function () {
                $scope.data = [350, 450, 100];
            }, 500);
        }]);

    app.controller('PieCtrl', function ($scope) {
        $scope.labels = ['Download Sales', 'In-Store Sales', 'Mail Sales'];
        $scope.data = [300, 500, 100];
    });

    app.controller('PolarAreaCtrl', function ($scope) {
        $scope.labels = ['Download Sales', 'In-Store Sales', 'Mail Sales', 'Telesales', 'Corporate Sales'];
        $scope.data = [300, 500, 100, 40, 120];
    });

    app.controller('BaseCtrl', function ($scope) {
        $scope.labels = ['Download Sales', 'Store Sales', 'Mail Sales', 'Telesales', 'Corporate Sales'];
        $scope.data = [300, 500, 100, 40, 120];
        $scope.type = 'PolarArea';

        $scope.toggle = function () {
            $scope.type = $scope.type === 'PolarArea' ? 'Pie' : 'PolarArea';
        };
    });

    app.controller('RadarCtrl', function ($scope) {
        $scope.labels = ['Eating', 'Drinking', 'Sleeping', 'Designing', 'Coding', 'Cycling', 'Running'];

        $scope.data = [
            [65, 59, 90, 81, 56, 55, 40],
            [28, 48, 40, 19, 96, 27, 100]
        ];

        $scope.onClick = function (points, evt) {
            console.log(points, evt);
        };
    });

    app.controller('StackedBarCtrl', function ($scope) {
        $scope.labels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $scope.type = 'StackedBar';

        $scope.data = [
            [65, 59, 90, 81, 56, 55, 40],
            [28, 48, 40, 19, 96, 27, 100]
        ];
    });

    app.controller('TabsCtrl', function ($scope) {
        $scope.labels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $scope.active = true;
        $scope.data = [
            [65, 59, 90, 81, 56, 55, 40],
            [28, 48, 40, 19, 96, 27, 100]
        ];
    });

    app.controller('DataTablesCtrl', function ($scope) {
        $scope.labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
        $scope.data = [
            [65, 59, 80, 81, 56, 55, 40],
            [28, 48, 40, 19, 86, 27, 90]
        ];
        $scope.colours = [
            {// grey
                fillColor: 'rgba(148,159,177,0.2)',
                strokeColor: 'rgba(148,159,177,1)',
                pointColor: 'rgba(148,159,177,1)',
                pointStrokeColor: '#fff',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(148,159,177,0.8)'
            },
            {// dark grey
                fillColor: 'rgba(77,83,96,0.2)',
                strokeColor: 'rgba(77,83,96,1)',
                pointColor: 'rgba(77,83,96,1)',
                pointStrokeColor: '#fff',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(77,83,96,1)'
            }
        ];
        $scope.randomize = function () {
            $scope.data = $scope.data.map(function (data) {
                return data.map(function (y) {
                    y = y + Math.random() * 10 - 5;
                    return parseInt(y < 0 ? 0 : y > 100 ? 100 : y);
                });
            });
        };
    });

    app.controller('TicksCtrl', ['$scope', '$interval', function ($scope, $interval) {
            var maximum = document.getElementById('container').clientWidth / 2 || 300;
            $scope.data = [[]];
            $scope.labels = [];
            $scope.options = {
                animation: false,
                showScale: false,
                showTooltips: false,
                pointDot: false,
                datasetStrokeWidth: 0.5
            };

            // Update the dataset at 25FPS for a smoothly-animating chart
            $interval(function () {
                getLiveChartData();
            }, 40);

            function getLiveChartData() {
                if ($scope.data[0].length) {
                    $scope.labels = $scope.labels.slice(1);
                    $scope.data[0] = $scope.data[0].slice(1);
                }

                while ($scope.data[0].length < maximum) {
                    $scope.labels.push('');
                    $scope.data[0].push(getRandomValue($scope.data[0]));
                }
            }
        }]);

    function getRandomValue(data) {
        var l = data.length, previous = l ? data[l - 1] : 50;
        var y = previous + Math.random() * 10 - 5;
        return y < 0 ? 0 : y > 100 ? 100 : y;
    }
})();

