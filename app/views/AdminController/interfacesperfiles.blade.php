@extends('layouts.bootstrap')

@section('head')
<title>Interfaces vs Perfiles</title>
<link href="/packages/bootstrap/css/loading.css" rel="stylesheet">
<link href="/packages/bootstrap/css/popbox.css" media="screen" charset="utf-8" rel="stylesheet">
<script src="/packages/jquery.confirm-master/jquery.confirm.js"></script>
<script src="/js/adminController/adminController.js"></script>
@stop

@section('content')
<div class="row">
    <div class='form-group col-sm-12'>
        <h4>Interfaces y Perfiles</h4>
    </div>
</div>
<?php 
$visible = (isset($mensaje) && $mensaje != '') ? "display:block;" : "display:none;";
$class = ($error) ? "alert-danger" : "alert-success";
?>
<div class="alert {{$class}}" role="alert" style="{{$visible}}">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
    <span class="sr-only">Error:</span>
    <strong>{{$mensaje}}</strong>
</div>
<div class="row">
    {{
        Form::open(
            array(
                'action' => 'AdminController@newInterfazPerfil',
                'method' => 'post',
                'role'   => 'form',
                'class'  => 'form-horizontal',
                'id'     => 'form_interperfi'
            )
        )
    }}
    <div class='form-group col-sm-6'>
        <div class="col-sm-2">{{ Form::label('Perfil:') }}</div>
        <div class="col-sm-10">
            {{ Form::Select('IdPerfil', $Perfiles, 1, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class='form-group col-sm-6'>
        <div class="col-sm-2">{{ Form::label('Menu:') }}</div>
        <div class="col-sm-10">
            {{ Form::Select('IdInterfaz', $Interfaces, 1, array('class' => 'form-control')) }}
        </div>
    </div>
</div>
<div class="row">
    <div class='form-group col-sm-12'>
        {{ Form::input('hidden', 'enviado') }}
        {{ Form::input('submit', null, 'Asignar', array('class' => 'btn btn-primary')) }}
        {{ Form::close() }}
    </div>
</div>
<hr>
<div class="row">
    <div class='form-group col-sm-12'>
        <h4>Interfaces Asignadas a Perfiles</h4>
    </div>
</div>
<div class="row">
    <div class='form-group col-sm-12'>
        <table id="inetrfacesperfiles" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>PERFIL</th>
                    <th>MENU</th>
                    <th>ELIMINAR</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@stop