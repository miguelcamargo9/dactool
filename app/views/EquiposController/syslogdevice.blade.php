@extends('layouts.bootstrap')

@section('head')
<title>SYS LOG</title>
<link href="/packages/bootstrap/css/loading.css" rel="stylesheet">
<script type="text/javascript">

    $(document).ready(function () {
        $('#loading').show();
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
                {"data": "date"},
                {"data": "uid"},
                {"data": "terminal"},
                {"data": "client_ip"},
                {"data": "type"},
                {"data": "service"},
                {"data": "cmd"}
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

        $(document).ajaxComplete(function () {
            $("#loading").hide();
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
<table id="syslogs" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>FECHA Y HORA</th>
            <th>USUARIO</th>
            <th>TERMINAL</th>
            <th>IP CLIENTE</th>
            <th>TIPO</th>
            <th>SERVICIO</th>
            <th>COMANDO</th>
        </tr>
    </thead>
</table>
@stop