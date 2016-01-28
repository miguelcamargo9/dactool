@extends('layouts.bootstrap')

@section('head')
<title>Generar Graficas Consumo</title>
<meta name="description" content="Nuevo Sitio Dactool">
<script src="/packages/ui/jquery-ui/jquery-ui.js"></script>
<script>
//    $(function () {
//        $("#serviceid").autocomplete({
//            source: function (request, response) {
//                $.ajax({
//                    type: "POST",
//                    url: "/autoserviceid",
//                    dataType: "json",
//                    success: function (data) {
//                        response(data);
//                    }
//                });
//            }
//        });
//    });

</script>
@stop


@section('content')

<div class="container">
    <h3>Generar Graficas Consumo</h3>
    {{
    Form::open(
        array(
            'action' => 'HomeController@generateGraphsResult',
            'method' => 'post',
            'role'   => 'form',
            'class'  => 'form-inline'
        )

    )
    }}
    <div class="form-group">
        {{ Form::label('# Servicio:') }}
        {{ Form::input('number', 'serviceid', Input::old('serviceid'), array('id' => 'serviceid','class' => 'form-control', 'required' => 'true', 'min' => 1)) }}
    </div>
    {{ Form::input('submit', null, 'Enviar', array('class' => 'btn btn-primary')) }}
    {{ Form::close() }}
</div>

@stop