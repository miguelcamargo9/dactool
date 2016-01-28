
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="/packages/DataTables/media/css/jquery.dataTables.css" rel="stylesheet">
        <link href="/packages/DataTables/extensions/TableTools/css/dataTables.tableTools.css" rel="stylesheet">
        <link href="/packages/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/packages/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
        <script src="/packages/DataTables/media/js/jquery.js"></script>
        <script src="/packages/DataTables/media/js/jquery.dataTables.min.js"></script>
        <script src="/packages/DataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
        <script src="/packages/bootstrap/js/bootstrap.min.js"></script>

        @yield('head')
    </head>

    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{URL::route('index')}}">Dactool</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <?php
                        $vista = Route::currentRouteName();
                        $current = array(
                            'index' => '',
                            'equipos' => '',
                            'listaequipos' => '',
                            'listatareas' => '',
                            'listausuarios' => '',
                            'listascripts' => '',
                            'listareportes' => '',
                            'listanotifiaciones' => '',
                            'listainterfaces' => '',
                            'listawebservicios' => '',
                            'generategraphs' => '',
                            'deletevlan' => '');
                        if ($vista == '' || $vista == 'index') {
                            $current['index'] = 'active';
                        } else if ($vista == 'equipos') {
                            $current['equipos'] = 'active';
                        } else if ($vista == 'listaequipos') {
                            $current['listaequipos'] = 'active';
                        } else if ($vista == 'listatareas') {
                            $current['listatareas'] = 'active';
                        } else if ($vista == 'listausuarios') {
                            $current['listausuarios'] = 'active';
                        } else if ($vista == 'listascripts') {
                            $current['listascripts'] = 'active';
                        } else if ($vista == 'listareportes') {
                            $current['listareportes'] = 'active';
                        } else if ($vista == 'listanotifiaciones') {
                            $current['listanotifiaciones'] = 'active';
                        } else if ($vista == 'listainterfaces') {
                            $current['listainterfaces'] = 'active';
                        } else if ($vista == 'listawebservicios') {
                            $current['listawebservicios'] = 'active';
                        } else if ($vista == 'generategraphs') {
                            $current['generategraphs'] = 'active';
                        } else if ($vista == 'deletevlan') {
                            $current['deletevlan'] = 'active';
                        }
                        ?>
                        <!--<li class="{{$current['index']}}"><a href="{{URL::route('index')}}">Inicio</a></li>-->
                        <li class="{{$current['listaequipos']}} dropdown">
                            <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Equipos</a>
                            <ul class="dropdown-menu">
                                <li class="{{$current['listaequipos']}}"><a href="{{URL::route('listaequipos')}}">Lista Equipos</a></li>
                                <li class="{{$current['listainterfaces']}}"><a href="{{URL::route('listainterfaces')}}">Lista Interfaces</a></li>
                            </ul>
                        </li>
                        <li class="{{$current['listatareas']}}"><a href="{{URL::route('listatareas')}}">Tareas</a></li>
                        <li class="{{$current['listausuarios']}}"><a href="{{URL::route('listausuarios')}}">Usuarios</a></li>
                        <li class="{{$current['listascripts']}} dropdown">
                            <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Opciones</a>
                            <ul class="dropdown-menu">
                                <li class="{{$current['listascripts']}}"><a href="{{URL::route('listascripts')}}">Scripts</a></li>
                                <li class="{{$current['listareportes']}}"><a href="{{URL::route('listareportes')}}">Reportes</a></li>
                                <li class="{{$current['listanotifiaciones']}}"><a href="{{URL::route('listanotifiaciones')}}">Notificaciones</a></li>
                            </ul>
                        </li>
                        <li class="{{$current['listawebservicios']}}"><a href="{{URL::route('listawebservicios')}}">Web Services</a></li>
                        <li class="{{$current['generategraphs']}} dropdown">
                            <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Herramientas</a>
                            <ul class="dropdown-menu">
                                <li class="{{$current['generategraphs']}}"><a href="{{URL::route('generategraphs')}}">Generar Graficas</a></li>
                                <li class="{{$current['deletevlan']}}"><a href="{{URL::route('deletevlan')}}">Desanillar Vlan</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="nav navbar-right navbar-link">
                        <span class='glyphicon glyphicon-user' style="color: gray;">
                        </span>{{Session::get('username')}}
                        <span class='glyphicon glyphicon-log-out' style="color: gray;">
                        </span>
                        <a href="{{URL::route('logout')}}">
                            Cerrar Sesión
                        </a>
                    </div>

                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <div class="container">
            <div id="loading">
                <font size="2" face="Arial, Helvetica, sans-serif">
                Procesando el requerimiento, por favor espere, esta tarea puede tomar más de 1 minuto.
                </font>
            </div> 
        </div>
        <div class="container" style="margin-top:8%;">
            @yield('content')
        </div><!-- /.container -->
    </body>
</html>
