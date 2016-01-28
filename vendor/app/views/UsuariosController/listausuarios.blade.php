@extends('layouts.bootstrap')

@section('head')
<title>Dactool Site</title>
<meta name="description" content="Nuevo Sitio Dactool">
<script type="text/javascript">

    var dataset = <?php echo $datos; ?>;
    $(document).ready(function () {
        $('#example').dataTable({
            "data": dataset,
            "columns": [
                {"data": "IdUsuario"},
                {"data": "NickNameUsuario"},
                {"data": "NombreUsuario"},
                {"data": "IdGrupo"}
            ],
            "lengthMenu":
                    [[10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "All"]]
        });
    });


</script>
@stop


@section('content')
<table width="60%" class="table">
    <thead>
        <tr>
            <th>
                LISTA DE USUARIOS
            </th>
        </tr>
    </thead>
</table>
<table id="example" cellspacing="0" width="70%" class="display">
    <thead>
        <tr>
            <th>ID USUARIO</th>
            <th>NICK NAME</th>
            <th>NOMBRE</th>
            <th>GRUPO</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>ID USUARIO</th>
            <th>NICK NAME</th>
            <th>NOMBRE</th>
            <th>GRUPO</th>
        </tr>
    </tfoot>
</table>
@stop