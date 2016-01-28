@extends('layouts.bootstrap')

@section('head')
<title>Lista de Equipos</title>
<meta name="description" content="Nuevo Sitio Dactool">
<link href="/packages/bootstrap/css/popbox.css" media="screen" charset="utf-8" rel="stylesheet">
<script src="/packages/jquery.confirm-master/jquery.confirm.js"></script>
<script src="/js/equiposController/equiposController.js"></script>
@stop

@section('content')
<?php
$visible = ($visible) ? "display:block;" : "display:none;";
$visibleEditar = (Session::get('visibleEditar')) ? "display:block;" : "display:none;";
$visibleEliminar = (Session::get('visibleEliminar')) ? "display:block;" : "display:none;";
$visible2 = (Session::get('mensaje')) ? "display:block;" : "display:none;";
$query = (Session::get('query')) ? Session::get('query') : "";

?>
{{ Form::input('hidden', 'query', $query, array('id' => 'query')) }}
<div id="mensaje" style="{{$visible2}}" class="boxmensaje">
    <table style="text-align: center;">
        <tr>
            <td>
                {{Session::get('mensaje')}}<br>
            </td>
        </tr>
        <tr>
            <td>
                <button type="button" class="btn btn-primary" id="aceptar">OK</button>
            </td>
        </tr>            
    </table><br>       
</div>

@include('EquiposController.activarequipo')

@include('EquiposController.nuevoequipo')

@include('EquiposController.eliminarequipo')

@include('EquiposController.editarequipo')

<table width="60%" class="table">
    <thead>
        <tr>
            <th>
                LISTA DE EQUIPOS
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: right;">
                <button type="button" class="btn btn-success btn-xs glyphicon glyphicon-plus showPopBox"></button>
            </td>
        </tr>
    </tbody>
</table>
<table id="example" cellspacing="0" width="70%" class="display">
    <thead>
        <tr>
            <th>NOMBRE EQUIPO</th>
            <th>DIRECCIÓN IP</th>
            <th>FABRICANTE</th>
            <th>PAIS INSTALACIÓN</th>
            <th>TIPO</th>
            <th>FIRMWARE</th>
            <th>ESTADO</th>
            <th>SYSLOG</th>
            <th>GENERAR COPIA</th>
            <th>ULTIMA COPIA</th>
            <th>OPCIONES</th>
        </tr>
    </thead>
</table>

@stop
