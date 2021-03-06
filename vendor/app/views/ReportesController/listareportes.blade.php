@extends('layouts.bootstrap')

@section('head')
<title>Lista de Reportes</title>
<meta name="description" content="Nuevo Sitio Dactool">
<script type="text/javascript">

    var dataset = <?php echo $datos; ?>;
    $(document).ready(function () {
        $('#example').dataTable({
            "data": dataset,
            "columns": [
                {"data": "IdReporte"},
                {"data": "NombreReporte"},
                {"data": "DescripcionReporte"},
                {"data": "AutorReporte"}
            ],
            "dom": 'T<"clear">lfrtip',
            "oTableTools": {
                "sSwfPath": "/packages/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sButtonText": "Excel",
                        "mColumns": [1, 2, 3],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "csv",
                        "sButtonText": "CSV",
                        "mColumns": [1, 2, 3],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "pdf",
                        "sButtonText": "PDF",
                        "mColumns": [1, 2, 3],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "print",
                        "sButtonText": "Imprimir",
                        "mColumns": [1, 2, 3],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "copy",
                        "sButtonText": "Copiar",
                        "mColumns": [1, 2, 3],
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
                LISTA DE REPORTES
            </th>
        </tr>
    </thead>
</table>
<table id="example" cellspacing="0" width="70%" class="display">
    <thead>
        <tr>
            <th>ID REPORTE</th>
            <th>ARCHIVO</th>
            <th>DESCRIPCION</th>
            <th>AUTOR</th>
        </tr>
    </thead>
</table>
@stop