function format(d) {
    // `d` is the original data object for the row        
    var html = '<table cellpadding="5" cellspacing="0" border="0" class="table table-striped table-bordered table-hover">' +
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

$(document).ready(function () {
    $('#loading').show();
    var table = $('#notificaciones').DataTable({
        "ajax": {
            "url": "/notificacionesdatos",
            "type": "POST"
        },
        "sAjaxDataProp": "",
        "columns": [
            {
                "className": 'details-control',
                "data": null,
                "defaultContent": ''
            },
            {"data": "IdNotificacion"},
            {"data": "RutaNotificacion"},
            {"data": "AsuntoNotificacion"},
            {"data": "DescripcionNotificacion"},
            {"data": "NombreAutor"}
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
    $('#notificaciones tbody').on('click', 'td.details-control', function () {
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

$(document).ajaxComplete(function () {
    $("#loading").hide();
});
