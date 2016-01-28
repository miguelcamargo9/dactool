@extends('layouts.bootstrap')

@section('head')
<title>Listado Interfaces</title>
<link href="/packages/bootstrap/css/popbox.css" media="screen" charset="utf-8" rel="stylesheet">
<link href="/packages/bootstrap/css/loading.css" rel="stylesheet">
<script type="text/javascript">
    $(document).ready(function () {
        $('#loading').show();
        $('#contenido').hide();
        $('#interfaces').dataTable({
            "ajax": {
                "url": "/datosinterfaces",
                "type": "POST"
            },
            "sAjaxDataProp": "",
            "columns": [
                {"data": "interface"},
                {"data": "state"},
                {"data": "device"},
                {"data": "serviceid"},
                {"data": "customerid"},
                {"data": "cliente"}
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
                        "mColumns": [0, 1, 2, 3, 4, 5],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "csv",
                        "sButtonText": "CSV",
                        "mColumns": [0, 1, 2, 3, 4, 5],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "pdf",
                        "sButtonText": "PDF",
                        "mColumns": [0, 1, 2, 3, 4, 5],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "print",
                        "sButtonText": "Imprimir",
                        "mColumns": [0, 1, 2, 3, 4, 5],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    },
                    {
                        "sExtends": "copy",
                        "sButtonText": "Copiar",
                        "mColumns": [0, 1, 2, 3, 4, 5],
                        "oSelectorOpts": {
                            filter: 'applied', order: 'current', page: 'all'
                        }
                    }
                ]
            },
            "lengthMenu":
                    [[10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "All"]]
        });
        $("body").click(function () {
            $(".popupTemporal:visible").hide();
        });
        $(document).ajaxComplete(function () {
            $("#loading").hide();
            $("#contenido").show();
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
    });

</script>
@stop

@section('content')
<div class="row" id="contenido">
    <table width="60%" class="table">
        <thead>
            <tr>
                <th>
                    INFORMACION DE INTERFACES
                </th>
            </tr>
        </thead>
    </table>
    <table id="interfaces" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>INTERFACE</th>
                <th>STATE</th>
                <th>DEVICE-CORE</th>
                <th>SERVICE ID</th>
                <th>CUSTOMER ID</th>
                <th>CLIENTE</th>
            </tr>
        </thead>
    </table>
</div>
@stop