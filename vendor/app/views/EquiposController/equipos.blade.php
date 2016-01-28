@extends('layouts.bootstrap')

@section('head')
<title>Nuevo Equipo</title>
@stop

@section('content')
{{$mensaje}}
<h1>Crear Equipo</h1>
{{
    Form::open(
        array(
            'action' => 'EquiposController@NuevoEquipo',
            'method' => 'post',
            'role'   => 'form',
            'class'  => 'form-horizontal',
            'id'     => 'form_equipos'
        )
    )
}}
<div class='form-group'>
    <div class="col-sm-1">{{ Form::label('Nombre:') }}</div>
    <div class="col-sm-11">
        {{ Form::input('text', 'name', Input::old('name'), array('class' => 'form-control', 'placeholder' => 'Enter Device' )) }}
    </div>
    <div class="bg-danger" id="error_name">{{$errors->first('name')}}</div>
</div>
<div class="form-group">
    <div class="col-sm-1">{{ Form::label('Ip:') }}</div>
    <div class="col-sm-11">
        {{ Form::input('text', 'ip', Input::old('ip'), array('class' => 'form-control', 'placeholder' => 'Enter Ip Address')) }}
    </div>
    <div class="bg-danger" id="error_ip">{{$errors->first('ip')}}</div>
</div>
<div class='form-group'>
    <div class="col-sm-1">{{ Form::label('Numero Inventario:') }}</div>
    <div class="col-sm-11">
        {{ Form::input('text', 'numinvent', 'uscisco', array('class' => 'form-control', 'placeholder' => 'Enter Number Inventory')) }}
    </div>
</div>
<div class='form-group'>
    <div class="col-sm-1">{{ Form::label('Ubicación:') }}</div>
    <div class="col-sm-11">
        {{ Form::Select('pais', $paises,'COL',array('class' => 'form-control')) }}
    </div>
</div>
<div class='form-group'>
    <div class="col-sm-1">{{ Form::label('Fabricante:') }}</div>
    <div class="col-sm-11">
        {{ Form::Select('fabricante', $fabricantes,'Juniper',array('class' => 'form-control')) }}
    </div>
</div>
<div class='form-group'>
    <div class="col-sm-1">{{ Form::label('Tipo:') }}</div>
    <div class="col-sm-11">
        {{ Form::Select('tipo', $tipos,'Router',array('class' => 'form-control')) }}
    </div>
</div>

{{ Form::input('hidden', 'enviado') }}
{{ Form::input('submit', null, 'Enviar', array('class' => 'btn btn-primary')) }}


{{ Form::close() }}

@stop


