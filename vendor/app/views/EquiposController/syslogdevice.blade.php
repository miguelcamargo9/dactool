@extends('layouts.bootstrap')

@section('head')
<title>SYS LOG</title>
<script type="text/javascript">

    $(document).ready(function () {
        var table = $('#syslogs').DataTable({
            "ajax": {
                "url": "/syslogequipo",
                "type": "POST",
                "data": {
                    "id": <?php echo $device->ID; ?> 
                }
            },
            "sAjaxDataProp": "",
            "columns": [
                {"data": "fo"},
                {"data": "facility"},
                {"data": "priority"},
                {"data": "level"},
                {"data": "program"},
                {"data": "msg"}
            ],
            "dom": 'T<"clear">lfrtip',
            "oTableTools": {
                "sSwfPath": "/packages/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sButtonText": "Excel",
                        "mColumns": [0, 1, 2, 3, 4],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "csv",
                        "sButtonText": "CSV",
                        "mColumns": [0, 1, 2, 3, 4],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "pdf",
                        "sButtonText": "PDF",
                        "mColumns": [0, 1, 2, 3, 4],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "print",
                        "sButtonText": "Imprimir",
                        "mColumns": [0, 1, 2, 3, 4],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "copy",
                        "sButtonText": "Copiar",
                        "mColumns": [0, 1, 2, 3, 4],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    }
                ]
            },
            "lengthMenu":
                    [[10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "All"]]
        });
    });

</script>
@stop

@section('content')
<table width="60%" class="table">
    <thead>
        <tr>
            <th colspan="2">
                INFORMACION DE INTERFACES {{$device->name}}
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="width: 10%">Dirección IP:</td>
            <td>{{$device->ifaddr}}</td>
        </tr>
        <tr>
            <td style="width: 10%">Tipo:</td>
            <td>{{$device->Tipo->name}}</td>
        </tr>
        <tr>
            <td style="width: 10%">Fabricante:</td>
            <td>{{$device->Fabricante->name}}</td>
        </tr>
        <tr>
            <td style="width: 10%">Location:</td>
            <td>{{$device->Ubicacion->completename}}</td>
        </tr>
    </tbody>
</table>
<table id="syslogs" class="display" cellspacing="0" width="70%">
    <thead>
        <tr>
            <th>FECHA Y HORA</th>
            <th>HOST</th>
            <th>PRIOR</th>
            <th>NIVEL</th>
            <th>PROGR</th>
            <th>MENSAJE</th>
        </tr>
    </thead>
</table>
@stop