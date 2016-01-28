@extends('layouts.bootstrap')

@section('head')
<title>Dactool Site</title>
<meta name="description" content="Nuevo Sitio Dactool">
<link href="/packages/bootstrap/css/loading.css" rel="stylesheet">
<script type="text/javascript">
    $.ajax({
        type: "POST",
        url: "/deletevlan",
        data: {
            vlanid: '<?php echo $vlanid; ?>'
        },
        beforeSend: loadStart,
        complete: loadStop,
        success: function (result) {
            $('#msg').html(result);
        },
        error: function () {
            $('#msg').html("Error Eliminando Vlan");
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
        <a href="/deletevlan"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-share-alt"></span>Volver</button></a>
    </div>
</div>
@stop