@extends('layouts.bootstrap')

@section('head')
<title>Inventario de Ip's IFX</title>
@stop

@section('content')
<div class="content" style="height: 1000px">
    <form action="http://phpipam:8081/site/login/loginCheck.php" method="post" target="my_frame" id="ipamform">
        <input type="hidden" name="ipamusername" value="{{Session::get('NickNameUsuario')}}" />
        <input type="hidden" name="ipampassword" value="{{Session::get('password')}}" />
        <input type="hidden" name="redirect" value="true" />
        <!--<input type="submit" />-->
    </form>
    <iframe scrolling="no" src="http://phpipam:8081/?dactool=true&page=subnets&section=1&subnetId=7" 
            name="my_frame" frameborder="0" height="100%" width="100%"></iframe>
    <script>
        $('form#ipamform').submit();
    </script>
</div>
@stop