@extends('layouts.bootstrap')

@section('head')
<title>Dactool Site</title>
<meta name="description" content="Nuevo Sitio Dactool">
@stop


@section('content')

<div class="container">
    <h3>Buscar BackUp</h3>
    {{
    Form::open(
        array(
            'action' => 'EquiposController@VerBackEquipo',
            'method' => 'post',
            'role'   => 'form',
            'class'  => 'form-inline'
        )

    )
    }}
    <div class="form-group">
        {{ Form::label('Fecha:') }}
        {{ Form::input('date', 'date', Input::old('date'), array('class' => 'form-control', 'required' => 'true', 'max' => date('Y-m-d'))) }}
    </div>
    {{ Form::input('hidden', 'device', $device) }}
    {{ Form::input('submit', null, 'Enviar', array('class' => 'btn btn-primary')) }}
    {{ Form::close() }}
</div>

@if(count($resultado) == 0)
<div class="container">
    <div class="alert alert-warning"> el device <strong>{{$device}}</strong> no tiene BackUp del día <strong>{{$date}}</strong></div>
</div>
@else
<div class="container">
    <table class="table table-striped table-responsive">
        <thead>
        <th>
            Equipo
        </th>
        <th>
            Fecha BackUp
        </th>
        <th>
            Archivo
        </th>
        </thead>
        <tbody>
            <?php foreach ($resultado as $row): ?>
                <tr>
                    <td>
                        {{$row->equipo}}
                    </td>
                    <td>
                        {{$row->dt}}
                    </td>
                    @if (strstr(strtolower(trim($row->file)), 'vlan')) 
                    <td> <a href = "/logs/{{$row->file}}" target="_blank"> <b>Descargar vlan.dat</b> </td>
                    @elseif (strstr(strtolower(trim($row->file)), 'gz'))
                    <td> <a href = "/logs/{{$row->file}}" target="_blank"> <b>Descargar Configuracion</b> </td>
                    @else
                    <td> <a href = "/logs/{{$row->file}}" target="_blank"> <b>Ver Configuracion</b> </td>
                    @endif
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
@endif

@stop