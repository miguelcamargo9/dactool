@extends('layouts.bootstrap')

@section('head')
<title>Dactool Site</title>
<meta name="description" content="Nuevo Sitio Dactool">
@stop

@section('content')
<!--@if(count($cron) > 0)
@foreach ($cron as $row): 
    {{$row}}<br>
@endforeach;
@else
{{$cron}}
@endif-->
    <?php $comando = 'cat crontab.txt'; echo "comando ejecutado <b>$comando</b>"; $output = shell_exec($comando);?><pre>{{$output}}
@stop


