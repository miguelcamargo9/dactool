@extends('layouts.bootstrap')

@section('head')
<title>Listada Servicios</title>
<link href="/packages/bootstrap/css/popbox.css" media="screen" charset="utf-8" rel="stylesheet">
<link href="/packages/bootstrap/css/loading.css" rel="stylesheet">
<script src="/js/equiposController/listaServicios.js"></script>
@stop

@section('content')

<table width="60%" class="table">
    <thead>
        <tr>
            <th>
                LISTA DE SERVICIOS
            </th>
        </tr>
    </thead>
</table>
<table id="servicios" class="table table-striped table-hover">
    <thead>
        <tr>
            <th>SUBSIDIARIA</th>
            <th>SID</th>
            <th>PRODUCTO</th>
            <th>CID</th>
            <th>CLIENTE</th>
            <th>EQUIPO-CORE</th>
            <th>TIPO</th>
        </tr>
    </thead>
</table>
@stop