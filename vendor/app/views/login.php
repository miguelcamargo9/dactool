<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login Dactool</title>
    <script src="../../DataTables/media/js/jquery.js"></script>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body class="Login">
    <?php
    session_start();
//    echo phpinfo();
    //echo "SESSION <pre>".print_r($_SESSION); 
    ?> 
    <div class="container">
      <div class="row" style="margin-top:20px">
        <div class="col-sm-2 col-md-4">
        </div>
        <div class="col-xs-12 col-sm-8 col-md-4">
          <form name="form_login" method="post" action="ldap_login.php" role="form">
            <fieldset>
              <div style="text-align: center;">
                <!--              <h2>Please Sign In</h2>-->
                <img src="../../dactool_logo.png" >
              </div>            
              <hr class="colorgraph">
              <div class="row">
                <div class="col-xs-1 col-sm-1 col-md-1" >
                </div>
                <div class="col-xs-10 col-sm-10 col-md-10" >
                  <div class="input-group" style="margin-bottom:20px;">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
                    <input name="username" type="text" id="username" class="form-control" placeholder="Usuario" required>
                    <div class="input-group-addon">@ifxcorp.com</div>
                  </div>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1" >
                </div>
              </div>
              <div class="row">
                <div class="col-xs-1 col-sm-1 col-md-1" >
                </div>
                <div class="col-xs-10 col-sm-10 col-md-10" >
                  <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></div>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Contrase&ntilde;a" required>
                  </div>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1" >
                </div>
              </div>
              <hr class="colorgraph">
              <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4" >
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4" >
                  <input type="submit" name="Submit" value="Entrar" class="btn btn-success btn-block">
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4" >
                </div>
              </div>
              <?php if (isset($_SESSION["error"])) { ?>
                <hr class="colorgraph">
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 alert alert-danger" style="text-align: center;">
                    <?php echo $_SESSION["error"]; ?> 
                  </div>
                </div>
              <?php } ?>             
            </fieldset>
          </form>
        </div>
        <div class="col-sm-2 col-md-4">
        </div>
      </div>
    </div>
  </body>
</html>