$(document).ready(function () {
    $('#loading').show();
    $('#tareassistema').dataTable({
        "ajax": {
            "url": "/tareasdatos",
            "type": "POST"
        },
        "sAjaxDataProp": "",
        "columns": [
            {"data": "RutaScript"},
            {"data": "Nombre"},
            {"data": "Minutos"},
            {"data": "Horas"},
            {"data": "DiaMes"},
            {"data": "Mes"},
            {"data": "ProximaEjecucion"},
            {"data": "Parametros"},
            {"data": "Usuario"}
        ],
        "language": {
            "zeroRecords": "NO HAY TAREAS"
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
        $("#nuevaTarea:visible").hide();
//        $("#mensaje:visible").hide();
    });
    
    $(".showPopBox").bind('click', function (e) {
        $("#nuevaTarea").show();
        e.stopPropagation();
    });
    
    $(document).ajaxComplete(function () {
        $("#loading").hide();
    });
    
    $("#nuevaTarea").bind('click', function (e) {
        e.stopPropagation();
    });
});