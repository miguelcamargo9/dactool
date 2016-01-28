@extends('layouts.bootstrap')

@section('head')
<title>Listada Servicios</title>
<link href="/packages/bootstrap/css/popbox.css" media="screen" charset="utf-8" rel="stylesheet">
<link href="/packages/bootstrap/css/loading.css" rel="stylesheet">
<script src="/packages/js/listaServicios.js"></script>
@stop

@section('content')

<table width="60%" class="table">
    <thead>
        <tr>
            <th>
                LISTA DE SERIVICIOS
            </th>
        </tr>
    </thead>
</table>
<table id="servicios" class="table table-striped table-hover">
    <thead>
        <tr>
            <th>SERVICE ID</th>
            <th>PRODUCT</th>
            <th>CUSTOMER</th>
            <th>DEVICE</th>
            <th>TIPO</th>
            <th>INTERFACE</th>
            <th>VLAN</th>
            <th>BW</th>
        </tr>
    </thead>
</table>
@stop