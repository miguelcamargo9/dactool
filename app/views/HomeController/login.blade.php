@extends('layouts.bootstraplogin')

@section('head')
<title>Login Dactool</title>
<meta name="description" content="Nuevo Sitio Dactool">
@stop

@section('content')
<div class="container">
    <div class="row" style="margin-top:20px">
        <div class="col-sm-2 col-md-4">
        </div>
        <div class="col-xs-12 col-sm-8 col-md-4">
            {{
                Form::open(
                    array(
                        'action' => 'HomeController@Login',
                        'method' => 'post',
                        'role'   => 'form',
                        'class'  => 'form-horizontal',
                        'id'     => 'form_equipos'
                    )

                )
            }}
            <fieldset>
                <div style="text-align: center;">
                    <img src="/packages/images/dactool_logo.png" >
                </div>            
                <hr class="colorgraph">
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1" >
                    </div>
                    <div class="col-xs-10 col-sm-10 col-md-10" >
                        <div class="input-group" style="margin-bottom:20px;">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
                            <input name="username" type="text" id="username" class="form-control" placeholder="Usuario" required>
                            <div class="input-group-addon">@ifxcorp.com</div>
                        </div>
                    </div>
                    <div class="col-xs-1 col-sm-1 col-md-1" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-1 col-sm-1 col-md-1" >
                    </div>
                    <div class="col-xs-10 col-sm-10 col-md-10" >
                        <div class="input-group">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></div>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Contrase&ntilde;a" required>
                        </div>
                    </div>
                    <div class="col-xs-1 col-sm-1 col-md-1" >
                    </div>
                </div>
                <hr class="colorgraph">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4" >
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4" >
                        <input type="submit" name="Submit" value="Entrar" class="btn btn-success btn-block">
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4" >
                    </div>
                </div>
                <?php if (Session::get('error') && Session::get('error') != "") { ?>
                    <hr class="colorgraph">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 alert alert-danger" style="text-align: center;">
                            {{Session::get('error')}} 
                        </div>
                    </div>
                <?php } ?>
                @if(Session::get('csrf_error'))
                <hr class="colorgraph">
                <div class="row">
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        <strong>{{Session::get('csrf_error')}} </strong>
                    </div>
                </div>
                @endif  
            </fieldset>
            {{ Form::close() }}
        </div>
        <div class="col-sm-2 col-md-4">
        </div>
    </div>
</div>
</body>
</html>
@stop