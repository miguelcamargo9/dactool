@extends('layouts.bootstrap')

@section('head')
<title>Lista Notificaciones</title>
<meta name="description" content="Nuevo Sitio Dactool">
<link href="/packages/bootstrap/css/childrows.css" media="screen" charset="utf-8" rel="stylesheet">
<script type="text/javascript">

    function format(d) {
        // `d` is the original data object for the row        
        var html = '<table cellpadding="5" cellspacing="0" border="0">' +
                '<tr>' +
                '<th>Destinatarios Correo</th>' +
                '</tr>';

        for (i = 0; i < d.Destinatarios.length; i++) {
            html += '<tr>' +
                    '<td>' + d.Destinatarios[i].Correo + '</td>' +
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
                {"data": "IdNotificacion"},
                {"data": "NombreNotificacion"},
                {"data": "RutaNotificacion"},
                {"data": "DescripcionNotificacion"},
                {"data": "AutorNotificacion"}
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
                LISTA DE NOTIFICACIONES
            </th>
        </tr>
    </thead>
</table>
<table id="example" cellspacing="0" width="70%" class="display">
    <thead>
        <tr>
            <th></th>
            <th>ID NOTIFICACIÓN</th>
            <th>ARCHIVO</th>
            <th>RUTA</th>
            <th>DESCRIPCION</th>
            <th>AUTOR</th>
        </tr>
    </thead>
</table>
@stop