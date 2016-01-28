@extends('layouts.bootstrap')

@section('head')
<title>Inventario de Ip's IFX</title>
<link href="/packages/tree-grid/src/treeGrid.css" rel="stylesheet">
<link href="/packages/bootstrap/css/loading.css" rel="stylesheet">
<script type="text/javascript" src="/packages/tree-grid/src/tree-grid-directive.js"></script>
<script type="text/javascript" src="/js/ipInventarioContoller/treeGrid.js"></script>
<script type="text/javascript" src="/js/ipInventarioContoller/inventoryIpFactory.js"></script>
@stop

@section('content')
<div class="row">
    <div class='form-group col-sm-12'>
        <h4>Inventario de IP's</h4>
    </div>
</div>
<div class="row" ng-app="inventoryips">
    <br/><br/>
    <div ng-controller="inventoryipController" class='col-sm-9'>
        <div class="row">
            <div class="col-lg-12">
                <h5>Filtros</h5>
            </div>
        </div>
        <br>
        <div class="row form-horizontal">
            <div class='form-group'>
                <div class="col-lg-4">
                    <label>Rangos</label>
                </div>
                <div class="col-lg-3">
                    <select 
                        ng-model="RangeId" 
                        ng-options="option.IpAddress for option in ipranges track by option.Id"
                        class="form-control"
                        name='ipranges'>
                    </select>
                </div>
            </div>
            <div class='form-group'>
                <div class="col-lg-4">
                    <label>Ip</label>
                </div>
                <div class="col-lg-3">
                    {{ Form::input('text', 'IpAdressId', Input::old('IpAdressId'), array('class' => 'form-control', 'placeholder' => 'Buscar IP', 
                                'ng-model' => 'IpAdressId' , 'ng-disabled' => '(ServiceId || RangeId)')) }}
                </div>
                <div class="col-lg-2">
                    <select 
                        ng-model="NetMask"
                        ng-disabled = "(ServiceId || RangeId)"
                        ng-init="NetMask = mask[0]" 
                        ng-options="option.value for option in mask track by option.value"
                        class="form-control"
                        name='ipmask'>
                    </select>
                </div>
            </div>
            <div class='form-group'>
                <div class="col-lg-4">
                    <label>Servicio</label>
                </div>
                <div class="col-lg-3">
                    {{ Form::input('text', 'ServiceId', Input::old('ServiceId'), array('class' => 'form-control', 'placeholder' => 'Buscar Service ID', 
                                'ng-model' => 'ServiceId', 'ng-disabled' => '(IpAdressId)' )) }}
                </div>
            </div>
            <div class='form-group'>
                <div class="col-lg-4">
                    <button ng-disabled="(!ServiceId) && (!IpAdressId) && (!RangeId)" ng-click="ServiceId = '';IpAdressId =''; RangeId = '';" class="btn btn-warning" >
                        Limpiar
                    </button>
                </div>
                <div class="col-lg-4">
                    <button ng-click="filtrarArbol();" class="btn btn-info" ng-if="(!ServiceId) && (!IpAdressId) && RangeId" ng-disabled="(!RangeId)">
                        Buscar Rango
                    </button>
                    <button ng-click="filtrarIp();" class="btn btn-info" ng-if="(!ServiceId) && IpAdressId" ng-disabled="(!IpAdressId || !NetMask)">
                        Buscar Ip
                    </button>
                    <button ng-click="filtrarServicio();" class="btn btn-info" ng-if="(!IpAdressId) && ServiceId" ng-disabled="(!ServiceId) && (!IpAdressId || !NetMask) && (!RangeId)">
                        Buscar Servicio
                    </button>
                </div>

            </div>
        </div>

        <button ng-click="my_tree.expand_all()" class="btn btn-default btn-sm">Expand All</button>
        <button ng-click="my_tree.collapse_all()" class="btn btn-default btn-sm">Collapse All</button>
        <tree-grid 
            tree-data="tree_data" 
            tree-control="my_tree" 
            col-defs="col_defs" 
            expand-on="expanding_property" 
            on-select="my_tree_handler(branch)" 
            ip-address="IpAdressId"
            expand-level="2"
            icon-leaf= "glyphicon glyphicon-globe"></tree-grid>
        <!--<tree-grid tree-data="tree_data"></tree-grid>-->
    </div>
</div>

@stop