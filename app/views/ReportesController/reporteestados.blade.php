@extends('layouts.bootstrap')

@section('head')
<title>Reporte de Estados</title>
<meta name="description" content="Nuevo Sitio Dactool">
<link rel="stylesheet" href="/packages/angular-chart.js-master/dist/angular-chart.css">
<script src="/js/reportesController/app.js"></script>
<script src="/js/reportesController/reportesFactory.js"></script>
<script src="/packages/Chart.js-master/Chart.js"></script>
<script src="/packages/angular-chart.js-master/dist/angular-chart.min.js"></script>
<script src="/packages/angular-chart.js-master/dist/angular-chart.min.js"></script>
@stop


@section('content')
<div class="container" ng-app="graficasApp">

    <div class="col-lg-12 col-sm-12" id="bar-chart" ng-controller="BarCtrlUp">

        <div class='form-group'>
            <label>Filtro Pais</label>
            <div class="row">
                <div class="col-lg-4">
                    <select 
                        ng-model="nFiltro.Pais" 
                        ng-options="option.pais as option.pais for option in paises"
                        class="form-control"
                        name='fuerza'>
                    </select>
                </div>
                <div class="col-lg-4">
                    <button ng-click="aplicarFiltro();" class="btn btn-success" ng-disabled="!nFiltro.Pais">
                        Enviar
                    </button>
                </div>
            </div>
        </div>
        <div class="row panel panel-default">
            <div class="panel-heading">Interfaces UP</div>
            <div class="panel-body">
                <canvas id="bar" class="chart chart-bar" chart-data="data" chart-labels="labels"
                        chart-series="series" chart-legend="true" chart-options="options"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-sm-12" id="bar-chart" ng-controller="BarCtrlDown">
        <div class='form-group'>
            <label>Filtro Pais</label>
            <div class="row">
                <div class="col-lg-4">
                    <select 
                        ng-model="nFiltro.Pais" 
                        ng-options="option.pais as option.pais for option in paises"
                        class="form-control"
                        name='fuerza'>
                    </select>
                </div>
                <div class="col-lg-4">
                    <button ng-click="aplicarFiltro();" class="btn btn-success" ng-disabled="!nFiltro.Pais">
                        Enviar
                    </button>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Interfaces Down</div>
            <div class="panel-body">
                <canvas id="bar" class="chart chart-bar" chart-data="data" chart-labels="labels"
                        chart-series="series" chart-legend="true" chart-options="options"></canvas>
            </div>
        </div>
    </div>
</div>
@stop