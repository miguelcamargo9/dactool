$(document).ready(function () {
    $('#loading').show();
    $('#usuarios').dataTable({
        "ajax": {
            "url": "/datosusuarios",
            "type": "POST"
        },
        "sAjaxDataProp": "",
        "columns": [
            {"data": "IdUsuario"},
            {"data": "NickNameUsuario"},
            {"data": "NombreUsuario"},
            {"data": "Grupo"},
            {"data": "Perfil"}
        ],
        "lengthMenu":
                [[10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "All"]],
        "language": {
            "zeroRecords": "NO HAY USUARIOS"
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

    var objetoDataTable = $("#usuarios").dataTable();

    $("body").click(function () {
        $("#editarPerfil:visible").hide();
    });

    $(".showPopBox").bind('click', function (e) {
        $("#editarPerfil").show();
        e.stopPropagation();
    });

    $(document).ajaxComplete(function () {
        $("#loading").hide();
        $(".editar", objetoDataTable.fnGetNodes()).bind('click', function (e) {
            var id = $(this).attr('alt');
            $("#editarPerfil").show();
            $.ajax({
                type: "POST",
                url: "/getUser",
                async: false,
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (result) {
                    $('#nickname').val(result.NickNameUsuario);
                    $('#nombre').val(result.NombreUsuario);
                    $('#grupo').val(result.IdGrupo);
                    $('#perfil option[value="' + result.IdPerfil + '"]').prop('selected', true);
                    $('#idusuario').val(result.IdUsuario);
                },
                error: function () {
                    $('#editarPerfil').html("Error Generando el BackUp");
                }
            });
            e.stopPropagation();
        });
        $(".confirmEditar").confirm({
            text: "Está seguro de guardar los cambios realizados",
            title: "Confirmación Requerida",
            confirm: function (button) {
                $("#formEditPerfil").submit();
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

    $("#editarPerfil").bind('click', function (e) {
        e.stopPropagation();
    });
});