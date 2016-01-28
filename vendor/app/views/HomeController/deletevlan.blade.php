@extends('layouts.bootstrap')

@section('head')
<title>Eliminar Vlan</title>
<meta name="description" content="Nuevo Sitio Dactool">
@stop


@section('content')

<div class="container">
    <h3>Eliminar Vlan Red Metro Anillo 10G</h3>
    {{
    Form::open(
        array(
            'action' => 'HomeController@deleteVlanResult',
            'method' => 'post',
            'role'   => 'form',
            'class'  => 'form-inline'
        )

    )
    }}
    <div class="form-group">
        {{ Form::label('# Vlan:') }}
        {{ Form::input('number', 'vlanid', Input::old('vlanid'), array('class' => 'form-control', 'required' => 'true', 'min' => 2, 'max' => 4094)) }}
    </div>
    {{ Form::input('submit', null, 'Enviar', array('class' => 'btn btn-primary')) }}
    {{ Form::close() }}
</div>

@stop