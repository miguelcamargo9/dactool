@extends('layouts.bootstrap')

@section('head')
<title>Tareas</title>
<meta name="description" content="Nuevo Sitio Dactool">
<link href="/packages/bootstrap/css/loading.css" rel="stylesheet">
<link href="/packages/bootstrap/css/popbox.css" media="screen" charset="utf-8" rel="stylesheet">
<script src="/packages/jquery.confirm-master/jquery.confirm.js"></script>
<script src="/js/tareasController/tareasController.js"></script>
@stop

@section('content')

<?php
$visibleNuevo = (Session::get('visibleNuevo')) ? "display:block;" : "display:none;";
?>

@include('TareasController.nuevatarea')
<table width="60%" class="table">
    <thead>
        <tr>
            <th>
                TAREAS DEL SISTEMA
            </th>
        </tr>
    </thead>
    @if(Session::get('idPeril') == 3)
    <tbody>
        <tr>
            <td style="text-align: right;">
                <button type="button" class="btn btn-success btn-xs glyphicon glyphicon-plus showPopBox"></button>
            </td>
        </tr>
    </tbody>
    @endif
</table>
<table id="tareassistema" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>RUTA</th>
            <th>NOMBRE</th>
            <th>MINUTOS</th>
            <th>HORAS</th>
            <th>DIA DEL MES</th>
            <th>MES</th>
            <th>PROXEXE</th>
            <th>PARAMETROS</th>
            <th>USUARIO</th>
        </tr>
    </thead>
</table>
@stop


