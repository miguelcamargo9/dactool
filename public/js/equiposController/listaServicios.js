$(document).ready(function () {
    $('#loading').show();
    $('#servicios').dataTable({
        "ajax": {
            "url": "/datosservicios",
            "type": "POST"
        },
        "sAjaxDataProp": "",
        "columns": [
            {"data": "Company"},
            {"data": "Servicio"},
            {"data": "Servicename"},
//            {"data": "Nombre"},
            {"data": "CustomerID"},
            {"data": "Customer"},
            {"data": "Device"},
            {"data": "Tipo"}
        ],
        "language": {
            "zeroRecords": "NO HAY SERVICIOS"
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