<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="/packages/bootstrap/css/bootstrap.min_1.css" rel="stylesheet">
        <link href="/packages/DataTables/media/css/dataTables.bootstrap.css" rel="stylesheet">
        <link href="/packages/DataTables/media/css/dataTables.responsive.css" rel="stylesheet">
        <link href="/packages/DataTables/extensions/TableTools/css/dataTables.tableTools.css" rel="stylesheet">
        <link href="/packages/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
        <script src="/packages/DataTables/media/js/jquery.js"></script>
        <script src="/packages/DataTables/media/js/jquery.dataTables.min.js"></script>
        <script src="/packages/DataTables/media/js/dataTables.bootstrap.min.js"></script>
        <script src="/packages/DataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
        <script src="/packages/bootstrap/js/bootstrap.min.js"></script>
        <script src="/packages/angular/angular.min.js"></script>

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
                    <a class="navbar-brand" href="{{URL::route('index')}}">Dactool <span style="font-size: 9px">v 1.0 IFX Networks</span></a>
                </div>
                <div id="navbar" class="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <?php
                        $Interfaces = Session::get('Menus');
                        $vista = Route::currentRouteName();
                        ?>
                        @foreach ($Interfaces as $interfaz)
                        @if (isset($interfaz['Hijos']))
                        <?php
                        $routerHijos = array();
                        foreach ($interfaz['Hijos'] as $hijo) {
                            $routerHijos[] = $hijo['RouteName'];
                        }
                        $activo = (($vista == $interfaz['RouteName']) || in_array($vista, $routerHijos)) ? 'active' : '';
                        ?>
                        <li class="dropdown {{$activo}}">
                            <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon {{$interfaz['Glyphicon']}}"></span>
                                {{$interfaz['DisplayName']}}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($interfaz['Hijos'] as $hijo)
                                <?php
                                $activo = ($vista == $hijo['RouteName']) ? 'active' : '';
                                ?>
                                <li class="{{$activo}}"><a href="{{URL::route($hijo['RouteName'])}}"><span class="glyphicon {{$hijo['Glyphicon']}}"></span> {{$hijo['DisplayName']}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @else
                        <?php
                        $activo = ($vista == $interfaz['RouteName']) ? 'active' : '';
                        ?>
                        <li class="{{$activo}}"><a href="{{URL::route($interfaz['RouteName'])}}"><span class="glyphicon {{$interfaz['Glyphicon']}}"></span> {{$interfaz['DisplayName']}}</a></li>
                        @endif
                        @endforeach
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
