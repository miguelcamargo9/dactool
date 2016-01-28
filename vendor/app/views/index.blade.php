@extends('layouts.bootstrap')

@section('head')
<link href="/packages/sb_admin/dist/css/sb-admin-2.css" rel="stylesheet">
<link href="/packages/sb_admin/bower_components/morrisjs/morris.css" rel="stylesheet">
<script src="/packages/sb_admin/bower_components/metisMenu/dist/metisMenu.min.js"></script>
<script src="/packages/sb_admin/bower_components/flot/jquery.flot.js"></script>
<script src="/packages/sb_admin/bower_components/flot/jquery.flot.pie.js"></script>
<script src="/packages/sb_admin/bower_components/raphael/raphael-min.js"></script>
<script src="/packages/sb_admin/bower_components/morrisjs/morris.min.js"></script>
<script src="/packages/sb_admin/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script>
    //Flot Pie Chart
    $(function () {

        var datos;

        $.ajax({
            type: "GET",
            url: "{{url('getnobackup')}}",
            async: false,
            dataType: 'json'
        }).done(function (data) {
            datos = data;
        }).fail(function () {
            alert("error occured");
        });

        var plotObj = $.plot($("#flot-pie-chart"), datos, {
            series: {
                pie: {
                    show: true
                }
            },
            grid: {
                hoverable: true
            },
            tooltip: true,
            tooltipOpts: {
                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                shifts: {
                    x: 20,
                    y: 0
                },
                defaultTheme: false
            }
        });

        var barChart = Morris.Bar({
            element: 'morris-bar-chart',
            data: [{
                    y: '',
                    a: null,
                    b: null
                }],
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Interfaces Up', 'Interfaces Down'],
            barColors: ['#0b62a4', '#d9534f', '#37619d', '#fefefe', '#A87D8E', '#2D619C', '#2D9C2F'],
            hideHover: 'auto',
            resize: true
        });

        var areaChart = Morris.Area({
            element: 'morris-area-chart',
            data: [{
                    period: '',
                    Cancelaciones: null,
                    Reactivaciones: null,
                    Suspensiones: null
                }],
            xkey: 'period',
            ykeys: ['Cancelaciones', 'Reactivaciones', 'Suspensiones'],
            labels: ['Cancelaciones', 'Reactivaciones', 'Suspensiones'],
            lineColors: ['#d9534f', '#5cb85c', '#37619d', '#fefefe', '#A87D8E', '#2D619C', '#2D9C2F'],
            pointSize: 2,
            hideHover: 'auto',
            resize: true
        });

        requestDataArea(areaChart);
        requestDataBarras(barChart);

        function requestDataArea(chart) {
            $.ajax({
                type: "GET",
                url: "{{url('getrcs')}}",
                async: false,
                dataType: 'json'
            }).done(function (data) {
                chart.setData(data);
            }).fail(function () {
                alert("error occured");
            });
        }

        function requestDataBarras(chart) {
            $.ajax({
                type: "GET",
                url: "{{url('getinteroutersfbr')}}",
                async: false,
                dataType: 'json'
            }).done(function (data) {
                chart.setData(data);
            }).fail(function () {
                alert("error occured");
            });
        }

    });
</script>
@stop


@section('content')
<h1>Pagina de Inicio</h1>
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Back Up Equipos
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="flot-chart">
                    <div class="flot-chart-content" id="flot-pie-chart"></div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Interfaces Por Fabricante
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="flot-chart">
                    <div id="morris-bar-chart"></div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Actividad de Interfaces
            </div>
            <div class="panel-body">
                <div id="morris-area-chart"></div>
            </div>
        </div>
    </div>
</div>
@stop
