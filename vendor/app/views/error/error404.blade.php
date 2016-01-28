<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dactool Site</title>
    
    <link href="/packages/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/packages/bootstrap/css/bootstrap.theme.min.css" rel="stylesheet">
    <script type = "text/javascrip" src="/packages/bootstrap/js/jquery.js"></script>
    <script type = "text/javascrip" src="/packages/bootstrap/js/bootstrap.min.js"></script>
    @yield('head')
  </head>

  <body>
      <div class="container" style="margin-top:5%;">
          <h1><span class="glyphicon glyphicon-fire"></span> Error 404, la página solicitada no existe.</h1>
          <a href="{{URL::route('index')}}" >
              Regresar a la página inicial.
          </a>
    </div><!-- /.container -->
  </body>
</html>
