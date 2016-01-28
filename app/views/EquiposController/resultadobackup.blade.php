@extends('layouts.bootstrap')

@section('head')
<title>Dactool Site</title>
<meta name="description" content="Nuevo Sitio Dactool">
<link href="/packages/bootstrap/css/loading.css" rel="stylesheet">
<script type="text/javascript">
    $.ajax({
        type: "POST",
        url: "/savedevice",
        data: {
            id: '<?php echo $device; ?>'
        },
        beforeSend: loadStart,
        complete: loadStop,
        success: function (result) {
            $('#msg').html(result);
        },
        error: function () {
            $('#msg').html("Error Generando el BackUp");
        }
    });

    function loadStart() {
        $('#loading').show();
    }
    function loadStop() {
        $("#loading").hide();
    }
</script>
@stop


@section('content')
<div class="container">
    <div id="msg">

    </div>
    <div class="container">
        <br/><br/>
        <a href="/listaequipos"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-share-alt"></span>Volver</button></a>
    </div>
</div>
@stop