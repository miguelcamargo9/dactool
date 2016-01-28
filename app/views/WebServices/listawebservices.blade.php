@extends('layouts.bootstrap')

@section('head')
<title>Web Services</title>
<meta name="description" content="Nuevo Sitio Dactool">
<script type="text/javascript">

    var dataset = <?php echo $datos; ?>;
    $(document).ready(function () {
        $('#example').dataTable({
            "data": dataset,
            "columns": [
                {"data": "IdWS"},
                {"data": "NombreWS"},
                {"data": "RutaWS"},
                {"data": "DescripcionWS"},
                {"data": "AutorWS"}
            ],
            "dom": 'T<"clear">lfrtip',
            "oTableTools": {
                "sSwfPath": "/packages/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sButtonText": "Excel",
                        "mColumns": [1, 2, 3, 4],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "csv",
                        "sButtonText": "CSV",
                        "mColumns": [1, 2, 3, 4],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "pdf",
                        "sButtonText": "PDF",
                        "mColumns": [1, 2, 3, 4],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "print",
                        "sButtonText": "Imprimir",
                        "mColumns": [1, 2, 3, 4],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "copy",
                        "sButtonText": "Copiar",
                        "mColumns": [1, 2, 3, 4],
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
<table class="table">
    <thead>
        <tr>
            <th>
                LISTA DE WEB SERVICES
            </th>
        </tr>
    </thead>
</table>
<table id="example" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>ID WEB SERVICE</th>
            <th>ARCHIVO</th>
            <th>RUTA</th>
            <th>DESCRIPCION</th>
            <th>AUTOR</th>
        </tr>
    </thead>
</table>
@stop