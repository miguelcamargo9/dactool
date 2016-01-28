@extends('layouts.bootstrap')

@section('head')
<title>Detalle Servicio</title>

@section('content')
<div class="row form-group col-sm-12">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th colspan="4">
                    INFORMACIÓN DEL SERVICIO {{$servicio}}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="4">
                    <b>Detalle de IP's</b>
                </td>
            </tr>
            <tr>
                <th>Subservicio</th>
                <th>IP Address</th>
                <th>Interfaces</th>
                <th>VLAN</th>
            </tr>
            @foreach ($infoIp as $info)
            <tr>
                <td>{{$info['subservicios']}}</td>
                <td>{{$info['ipaddressname']}}</td>
                <td>{{$info['interfaces']}}</td>
                <td>{{$info['vlans']}}</td>
            </tr>
            @endforeach
            <tr>
                <td style="width: 10%">Customer ID:</td>
                <td colspan="3">{{$confRouter->CUSTOMERID}}</td>
            </tr>
            <tr>
                <td style="width: 10%">Customer:</td>
                <td colspan="3">{{$confRouter->NOMBRE_CLIENTE}}</td>
            </tr>
            <tr>
                <td colspan="4">
                    <b>Información de Equipo <a href="/verinterfaces/{{$device->ID}}">{{$device->name}}</a></b>
                </td>
            </tr>
            <tr>
                <td style="width: 10%">Dirección IP:</td>
                <td>{{$device->ifaddr}}</td>
                <td style="width: 10%">Tipo:</td>
                <td>{{$device->Tipo->name}}</td>
            </tr>
            <tr>
                <td style="width: 10%">Fabricante:</td>
                <td>{{$device->Fabricante->name}}</td>
                <td style="width: 10%">Ubicación:</td>
                <td>{{$device->Ubicacion->completename}}</td>
            </tr>
            @foreach ($infoInterface as $info)
            <tr>
                <td colspan="2">
                    <b>Información de Interface {{$info['INTERFACE']}}</b>
                </td>
                <td colspan="2">
                    Gráfica de Consumo:
                </td>
            </tr>
            <tr>
                <td style="width: 10%">Configuración:</td>
                <td>{{$info['CONF']}}</td>
                <td rowspan="3" class="text-center" colspan="2">
                    {{$info['GRAFICA']}}
                </td>
            </tr>
            <tr>
                <td style="width: 10%">VLAN:</td>
                <td>{{$info['VLAN']}}</td>          
            </tr>
            <tr>
                <td style="width: 10%">Estado:</td> 
                <?php $state = ($info['INTSTATE'] == 'Up') ? "success" : "danger"; ?>
                <td class="{{$state}}">{{$info['INTSTATE']}}</td>
            </tr>
            @endforeach
            <?php if ($deviceTo != "NO DISPONIBLE") { ?>
                <tr>
                    <td colspan="4">
                        <b>Información de Equipo Conectado <a href="/verinterfaces/{{$deviceTo->ID}}">{{$deviceTo->name}}</a></b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%">Dirección IP:</td>
                    <td colspan="3">{{$deviceTo->ifaddr}}</td>
                </tr>
                <tr>
                    <td style="width: 10%">Tipo:</td>
                    <td colspan="3">{{$deviceTo->Tipo->name}}</td>
                </tr>
                <tr>
                    <td style="width: 10%">Fabricante:</td>
                    <td colspan="3">{{$deviceTo->Fabricante->name}}</td>
                </tr>
                <tr>
                    <td style="width: 10%">Ubicación:</td>
                    <td colspan="3">{{$deviceTo->Ubicacion->completename}}</td>
                </tr>
                <?php if ($confSwitche != "NO DISPONIBLE") { ?>
                    <tr>
                        <td colspan="4">
                            <b>Información de Interface Conectada {{$confSwitche->INTERFACE}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%">Configuración:</td>
                        <td colspan="3">{{$confSwitche->CONF}}</td>
                    </tr>
                    <tr>
                        <td style="width: 10%">Estado:</td> 
                        <td colspan="3" class="{{$state}}">{{$confRouter->INTSTATE}}</td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td colspan="4">
                            <b>Información de Interface Conectada no disponible</b>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="4">
                        <b>Información de Equipo Conectado no disponible</b>
                    </td>
                </tr>
<?php } ?>
        </tbody>
    </table>
</div>
@stop