@extends('layouts.bootstrap')

@section('head')
<title>Usuarios</title>
<meta name="description" content="Nuevo Sitio Dactool">
<link href="/packages/bootstrap/css/loading.css" rel="stylesheet">
<link href="/packages/bootstrap/css/popbox.css" media="screen" charset="utf-8" rel="stylesheet">
<script src="/packages/jquery.confirm-master/jquery.confirm.js"></script>
<script src="/js/usuariosController/usuariosController.js"></script>
@stop

<?php
$visibleEditar = (Session::get('visibleEditar')) ? "display:block;" : "display:none;";
?>

@section('content')

@include('UsuariosController.editarperfil')

<div class="row">
    <div class='form-group col-sm-12'>
        <h4>LISTA DE USUARIOS</h4>
    </div>
</div>
<?php 
$visible = (isset($mensaje) && $mensaje != '') ? "display:block;" : "display:none;";
?>
<div class="alert alert-success" role="alert" style="{{$visible}}">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
    <span class="sr-only">Error:</span>
    <strong>{{$mensaje}}</strong>
</div>
<div class="row">
    <div class='form-group col-sm-12'>
        <table id="usuarios" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID USUARIO</th>
                    <th>NICK NAME</th>
                    <th>NOMBRE</th>
                    <th>GRUPO</th>
                    <th>PERFIL</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@stop