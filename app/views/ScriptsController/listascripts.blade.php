@extends('layouts.bootstrap')

@section('head')
<title>Lista de Scripts</title>
<link href="/packages/bootstrap/css/childrows.css" media="screen" charset="utf-8" rel="stylesheet">
<meta name="description" content="Nuevo Sitio Dactool">
<script type="text/javascript">

    function format(d) {
        // `d` is the original data object for the row        
        var html = '<table cellpadding="5" cellspacing="0" border="0" class="table table-striped table-bordered table-hover">' +
                '<tr>' +
                '<th>Id</th><th>Nombre del Script</th><th>Ruta del Script<th>Autor Script</th>' +
                '</tr>';

        for (i = 0; i < d.ScriptsFather.length; i++) {
            html += '<tr>' +
                    '<td>' + d.ScriptsFather[i].IdScript + '</td>' +
                    '<td>' + d.ScriptsFather[i].NombreScript + '</td>' +
                    '<td>' + d.ScriptsFather[i].RutaScript + '</td>' +
                    '<td>' + d.ScriptsFather[i].AutorScript + '</td>' +
                    '</tr>';
        }

        html += '</table>';
        return html;
    }

    var dataset = <?php echo $datos; ?>;
    $(document).ready(function () {
        var table = $('#example').DataTable({
            "data": dataset,
            "columns": [
                {
                    "className": 'details-control',
                    "data": null,
                    "defaultContent": ''
                },
                {"data": "IdScript"},
                {"data": "NombreScript"},
                {"data": "RutaScript"},
                {"data": "DescripcionScript"},
                {"data": "AutorScript"},
                {"data": "log"}
            ],
            "dom": 'T<"clear">lfrtip',
            "oTableTools": {
                "sSwfPath": "/packages/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sButtonText": "Excel",
                        "mColumns": [2, 3, 4, 5],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "csv",
                        "sButtonText": "CSV",
                        "mColumns": [2, 3, 4, 5],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "pdf",
                        "sButtonText": "PDF",
                        "mColumns": [2, 3, 4, 5],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "print",
                        "sButtonText": "Imprimir",
                        "mColumns": [2, 3, 4, 5],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "copy",
                        "sButtonText": "Copiar",
                        "mColumns": [2, 3, 4, 5],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    }
                ]
            },
            "lengthMenu":
                    [[10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "All"]]
        });

        // Add event listener for opening and closing details
        $('#example tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });
    });

</script>
@stop


@section('content')
<table width="60%" class="table">
    <thead>
        <tr>
            <th>
                LISTA DE SCRIPTS
            </th>
        </tr>
    </thead>
</table>
<table id="example" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th></th>
            <th>ID SCRIPTS</th>
            <th>ARCHIVO</th>
            <th>RUTA</th>
            <th>DESCRIPCION</th>
            <th>AUTOR</th>
            <th>LOG</th>
        </tr>
    </thead>
</table>
@stop