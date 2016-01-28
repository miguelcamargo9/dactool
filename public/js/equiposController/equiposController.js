$(document).ready(function () {
    $('#loading').show();
    $('#equipos').DataTable({
        "ajax": {
            "url": "/datosequipos",
            "type": "POST"
        },
        responsive: true,
        "sAjaxDataProp": "",
        "columns": [
            {"data": "hostname"},
            {"data": "ifaddr"},
            {"data": "fabricante"},
            {"data": "pais"},
            {"data": "tipo"},
            {"data": "firmware"},
            {"data": "estado"},
            {"data": "showlog"},
            {"data": "save"},
            {"data": "backup"},
            {"data": "options"}
        ],
//            "order": [[ 6, "asc" ]],
        "dom": 'T<"clear">lfrtip',
        "oTableTools": {
            "sSwfPath": "/packages/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
            "aButtons": [
                {
                    "sExtends": "xls",
                    "sButtonText": "Excel",
                    "mColumns": [0, 1, 2, 3, 4, 5, 6],
                    "oSelectorOpts": {
                        filter: 'applied', order: 'current', page: 'all'
                    }
                },
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV",
                    "mColumns": [0, 1, 2, 3, 4, 5, 6],
                    "oSelectorOpts": {
                        filter: 'applied', order: 'current', page: 'all'
                    }
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "mColumns": [0, 1, 2, 3, 4, 5, 6],
                    "oSelectorOpts": {
                        filter: 'applied', order: 'current', page: 'all'
                    }
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Imprimir",
                    "mColumns": [0, 1, 2, 3, 4, 5, 6],
                    "oSelectorOpts": {
                        filter: 'applied', order: 'current', page: 'all'
                    }
                },
                {
                    "sExtends": "copy",
                    "sButtonText": "Copiar",
                    "mColumns": [0, 1, 2, 3, 4, 5, 6],
                    "oSelectorOpts": {
                        filter: 'applied', order: 'current', page: 'all'
                    }
                }
            ]
        },
        "lengthMenu":
                [[10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "All"]]
    });

    var objetoDataTable = $("#equipos").dataTable();

    objetoDataTable.fnFilter($("#query").val());

    $("body").click(function () {
        $("#nuevoEquipo:visible").hide();
        $("#mensaje:visible").hide();
        $("#activarEquipo:visible").hide();
        $("#eliminarEquipo:visible").hide();
        $("#editarEquipo:visible").hide();
    });

    $(".showPopBox").bind('click', function (e) {
        $("#nuevoEquipo").show();
        $('#query').val($('input[type=search]').val());
        e.stopPropagation();
    });

    $(document).ajaxComplete(function () {
        $("#loading").hide();
        $(".activar", objetoDataTable.fnGetNodes()).bind('click', function (e) {
            var id = $(this).attr('alt');
            $("#activarEquipo").show();
            $.ajax({
                type: "POST",
                url: "/getequipo",
                async: false,
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (result) {
                    $('#query').val($('input[type=search]').val());
                    $('#nameAc').val(result.name);
                    $('#ipAc').val(result.ifaddr);
                    $('#numinventAc').val(result.otherserial);
                    $('#ubicacionAc').val(result.ubicacion.completename);
                    $('#fabricanteAc').val(result.fabricante.name);
                    $('#tipoAc').val(result.tipo.name);
                    $('#idAc').val(result.ID);
                },
                error: function () {
                    $('#activarEquipo').html("Error Generando el BackUp");
                }
            });
            e.stopPropagation();
        });
        $(".confirm").confirm({
            text: "Realmente Quiere Activar Este Equipo?",
            title: "Confirmación Requerida",
            confirm: function (button) {
                $("#formActivarEquipo").submit();
            },
            cancel: function (button) {
                // nothing to do
            },
            confirmButton: "Confirmar",
            cancelButton: "Cancelar",
            post: true,
            confirmButtonClass: "btn-success",
            cancelButtonClass: "btn-default",
            dialogClass: "modal-dialog modal-lg"
        });
        $(".eliminar", objetoDataTable.fnGetNodes()).bind('click', function (e) {
            var id = $(this).attr('alt');
            $("#eliminarEquipo").show();
            $.ajax({
                type: "POST",
                url: "/getequipo",
                async: false,
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (result) {
                    $('#query').val($('input[type=search]').val());
                    $('#nameEl').val(result.name);
                    $('#ipEl').val(result.ifaddr);
                    $('#numinventEl').val(result.otherserial);
                    $('#ubicacionEl').val(result.ubicacion.completename);
                    $('#fabricanteEl').val(result.fabricante.name);
                    $('#tipoEl').val(result.tipo.name);
                    $('#idEl').val(result.ID);
                },
                error: function () {
                    $('#eliminarEquipo').html("Error Generando el BackUp");
                }
            });
            e.stopPropagation();
        });
        $(".confirmEliminar").confirm({
            text: "Realmente Quiere Eliminar Este Equipo?",
            title: "Confirmación Requerida",
            confirm: function (button) {
                $("#formEliminarEquipo").submit();
            },
            cancel: function (button) {
                // nothing to do
            },
            confirmButton: "Confirmar",
            cancelButton: "Cancelar",
            post: true,
            confirmButtonClass: "btn-danger",
            cancelButtonClass: "btn-default",
            dialogClass: "modal-dialog modal-lg"
        });
        $(".editar", objetoDataTable.fnGetNodes()).bind('click', function (e) {
            var id = $(this).attr('alt');
            $("#editarEquipo").show();
            $.ajax({
                type: "POST",
                url: "/getequipo",
                async: false,
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (result) {
                    $('#query').val($('input[type=search]').val());
                    $('#nameEd').val(result.name);
                    $('#name_old').val(result.name);
                    $('#ipEd').val(result.ifaddr);
                    $('#ip_old').val(result.ifaddr);
                    $('#numinventEd').val(result.otherserial);
                    $('#ubicacionEd option[value="' + result.ubicacion.ID + '"]').prop('selected', true);
                    $('#fabricanteEd option[value="' + result.fabricante.ID + '"]').prop('selected', true);
                    $('#tipoEd option[value="' + result.tipo.ID + '"]').prop('selected', true);
                    $('#idEd').val(result.ID);
                },
                error: function () {
                    $('#EditarEquipo').html("Error Generando el BackUp");
                }
            });
            e.stopPropagation();
        });
        $(".confirmEditar").confirm({
            text: "Está seguro de guardar los cambios realizados",
            title: "Confirmación Requerida",
            confirm: function (button) {
                $("#formEditarEquipo").submit();
            },
            cancel: function (button) {
                // nothing to do
            },
            confirmButton: "Confirmar",
            cancelButton: "Cancelar",
            post: true,
            confirmButtonClass: "btn-warning",
            cancelButtonClass: "btn-default",
            dialogClass: "modal-dialog modal-lg"
        });
    });

    $("#aceptar").bind('click', function (e) {
        $("#mensaje").hide();
    });

    $("#nuevoEquipo").bind('click', function (e) {
        e.stopPropagation();
    });

    $("#activarEquipo").bind('click', function (e) {
        e.stopPropagation();
    });

    $("#eliminarEquipo").bind('click', function (e) {
        e.stopPropagation();
    });

    $("#editarEquipo").bind('click', function (e) {
        e.stopPropagation();
    });

//        // Setup - add a text input to each footer cell
//        $('#example tfoot th').each(function () {
//            var title = $('#example thead th').eq($(this).index()).text();
//            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
//        });
//        // Apply the search
//        var tables = $("#example").DataTable();
//        tables.columns().every(function () {
//            var that = this;
//            $('input', this.footer()).on('keyup change', function () {
//                if (that.search() !== this.value) {
//                    that
//                            .search(this.value)
//                            .draw();
//                }
//            });
//        });

});

