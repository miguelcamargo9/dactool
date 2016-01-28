@extends('layouts.bootstrap')

@section('head')
<title>Topologia de Red IFX</title>
<script type="text/javascript" src="/packages/topologia/js/vis.js"></script>
<script src="/packages/topologia/js/TopologyNetwork.js"></script>
<link href="/packages/topologia/css/vis.css" rel="stylesheet" type="text/css" />

@stop


@section('content')
<table class="table">
    <thead>
        <tr>
            <th>
                TOPOLOGIA DE RED IFX
            </th>
        </tr>
    </thead>
</table>
<div id="mynetwork">
    <div class="network-frame" style="position: relative; overflow: hidden; width: 100%; height: 100%;">
        <canvas style="position: relative; width: 100%; height: 100%;"></canvas>
    </div>
</div>
@stop