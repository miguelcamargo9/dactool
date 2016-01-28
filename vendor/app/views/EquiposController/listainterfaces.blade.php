@extends('layouts.bootstrap')

@section('head')
<title>Listado Interfaces</title>
<link href="/packages/bootstrap/css/childrows.css" media="screen" charset="utf-8" rel="stylesheet">
<link href="/packages/bootstrap/css/popbox.css" media="screen" charset="utf-8" rel="stylesheet">
<script type="text/javascript">
    function format(d) {
        // `d` is the original data object for the row        
        var html = '<table cellpadding="5" cellspacing="0" border="0">' +
                '<tr>' +
                '<th>VLANS</th>' +
                '</tr>' +
                '<tr>';

        for (i = 0; i < d.Vlans.length; i++) {
            html += '<td>' + d.Vlans[i].name + '</td>';
        }

        html += '</tr>';
        html += '</table>';
        return html;
    }
    var dataset = <?php echo $datos; ?>;
    $(document).ready(function () {
        var table = $('#interfaces').DataTable({
            "data": dataset,
            "columns": [
                {
                    "className": 'details-control',
                    "data": null,
                    "defaultContent": ''
                },
                {"data": "interface"}
            ],
            "language": {
                "zeroRecords": "NO HAY INTERFACES"
            },
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
        // Add event listener for opening and closing details
        $('#interfaces tbody').on('click', 'td.details-control', function () {
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
        $("body").click(function () {
            $(".popupTemporal:visible").hide();
        });
        var objetoDataTable = $("#interfaces").dataTable();
        $(".showPopBox", objetoDataTable.fnGetNodes()).bind('click', function (e) {
            $(".popupTemporal").hide();
            $("#" + $(this).attr('alt')).show();
            e.stopPropagation();
        });
        $(".popupTemporal", objetoDataTable.fnGetNodes()).bind('click', function (e) {
            e.stopPropagation();
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
            <td style="width: 10%">Ubicación:</td>
            <td>{{$device->Ubicacion->completename}}</td>
        </tr>
    </tbody>
</table>
<table id="interfaces" class="display" cellspacing="0" width="40%">
    <thead>
        <tr>
            <th></th>
            <th>INTERFACE</th>
        </tr>
    </thead>
</table>
@stop