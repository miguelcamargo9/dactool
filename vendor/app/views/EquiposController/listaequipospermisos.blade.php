@extends('layouts.bootstrap')

@section('head')
<title>Lista de Equipos</title>
<meta name="description" content="Nuevo Sitio Dactool">
<script type="text/javascript">

    $(document).ready(function () {
        $('#example').DataTable({
            "ajax": {
                "url": "/datosequipos",
                "type": "POST"
            },
            "sAjaxDataProp": "",
            "columns": [
                {"data": "hostname"},
                {"data": "ifaddr"},
                {"data": "fabricante"},
                {"data": "pais"},
                {"data": "tipo"},
                {"data": "firmware"},
                {"data": "showlog"},
                {"data": "save"},
                {"data": "backup"}
            ],
            "dom": 'T<"clear">lfrtip',
            "oTableTools": {
                "sSwfPath": "/packages/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sButtonText": "Excel",
                        "mColumns": [0, 1, 2, 3],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "csv",
                        "sButtonText": "CSV",
                        "mColumns": [0, 1, 2, 3],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "pdf",
                        "sButtonText": "PDF",
                        "mColumns": [0, 1, 2, 3],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "print",
                        "sButtonText": "Imprimir",
                        "mColumns": [0, 1, 2, 3],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "copy",
                        "sButtonText": "Copiar",
                        "mColumns": [0, 1, 2, 3],
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
            <th>
                LISTA DE EQUIPOS
            </th>
        </tr>
    </thead>
</table>
<table id="example" cellspacing="0" width="70%" class="display">
    <thead>
        <tr>
            <th>NOMBRE EQUIPO</th>
            <th>DIRECCIÓN IP</th>
            <th>FABRICANTE</th>
            <th>PAIS INSTALACIÓN</th>
            <th>TIPO</th>
            <th>FIRMWARE</th>
            <th>SYSLOG</th>
            <th>GENERAR COPIA</th>
            <th>ULTIMA COPIA</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
</table>

@stop