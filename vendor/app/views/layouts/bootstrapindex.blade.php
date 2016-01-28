
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dactool Site</title>
        <meta name="description" content="Nuevo Sitio Dactool">
        <link href="/packages/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/packages/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
        <!-- Bootstrap Core CSS -->
<!--        <link href="/packages/sb_admin/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">-->

        <!-- MetisMenu CSS -->
<!--        <link href="/packages/sb_admin/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">-->

        <!-- Timeline CSS -->
<!--        <link href="/packages/sb_admin/css/timeline.css" rel="stylesheet">-->

        <!-- Custom CSS -->
        <link href="/packages/sb_admin/dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
<!--        <link href="/packages/sb_admin/bower_components/morrisjs/morris.css" rel="stylesheet">-->

        <!-- Custom Fonts -->
<!--        <link href="/packages/sb_admin/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">-->
        @yield('head')
    </head>

    <body>
        <div class="container" style="margin-top:8%;">
            @yield('content')
        </div><!-- /.container -->
        <!-- jQuery -->
        <script src="/packages/sb_admin/bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="/packages/sb_admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="/packages/sb_admin/bower_components/metisMenu/dist/metisMenu.min.js"></script>

        <!-- Flot Charts JavaScript -->
        <script src="/packages/sb_admin/bower_components/flot/excanvas.min.js"></script>
        <script src="/packages/sb_admin/bower_components/flot/jquery.flot.js"></script>
        <script src="/packages/sb_admin/bower_components/flot/jquery.flot.pie.js"></script>
        <script src="/packages/sb_admin/bower_components/flot/jquery.flot.resize.js"></script>
        <script src="/packages/sb_admin/bower_components/flot/jquery.flot.time.js"></script>
<!--        <script src="/packages/sb_admin/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>-->
        <script src="/packages/sb_admin/js/flot-data.js"></script>

        <!-- Custom Theme JavaScript -->
<!--        <script src="/packages/sb_admin/dist/js/sb-admin-2.js"></script>
        <script src="/packages/bootstrap/js/bootstrap.min.js"></script>-->
    </body>
</html>
