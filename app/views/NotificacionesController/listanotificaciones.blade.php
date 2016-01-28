@extends('layouts.bootstrap')

@section('head')
<title>Lista Notificaciones</title>
<meta name="description" content="Nuevo Sitio Dactool">
<link href="/packages/bootstrap/css/loading.css" rel="stylesheet">
<link href="/packages/bootstrap/css/childrows.css" media="screen" charset="utf-8" rel="stylesheet">
<script src="/js/notificacionesController/notificacionesController.js"></script>
@stop


@section('content')
<div class="row">
    <div class='form-group col-sm-12'>
        <h4>LISTA DE NOTIFICACIONES</h4>
    </div>
</div>
<div class="row">
    <div class='form-group col-sm-12'>
        <table id="notificaciones" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th>ID NOTIFICACIÓN</th>
                    <th>RUTA</th>
                    <th>ASUNTO</th>
                    <th>DESCRIPCION</th>
                    <th>AUTOR</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@stop