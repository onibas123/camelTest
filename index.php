<?php session_start();?>
<html>
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta http-equiv="Content-Language" content="es"/>
  <?php include('css.php');?>
  <?php include('js.php');?>  
  <link rel="stylesheet" type="text/css" href="assets/css/custom.css">
</head>
<body>
  <div class="container">
        <div class="row vertical-offset-100">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div style="background-color: #3276B1;" class="panel-heading">                                
                        <div class="row-fluid user-row">

                            <h2 align="center"><font color="white">Autentificación</font></h2>
                            <br>
                            <?php
                            if(!empty($_SESSION['message']))
                              echo '<center><h5><font color="red">'.$_SESSION['message'].'</font></h5></center>';
                            ?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="middleware/Users.php" method="post">
                          <input type="hidden" name="action" id="input-action" value="login">
                          <div class="form-group">
                            <div class="input-group">

                              <label for="input-user" class="input-group-addon"></label>
                              <input type="text" class="form-control" id="input-user" name="input-user" placeholder="Usuario" required>
                              
                            </div>
                          </div> <!-- /.form-group -->

                          <div class="form-group">
                            <div class="input-group">
                              <label for="input-password" class="input-group-addon"></label>
                              <input type="password" class="form-control" name="input-password" id="input-password" placeholder="Contraseña" required>
                              
                            </div> <!-- /.input-group -->
                          </div> <!-- /.form-group -->
                          <input class="btn btn-lg btn-primary btn-block" type="submit" id="login" value="Iniciar">
                                <br>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <br><br><br><br><br>
    <footer style="color: white;" class="main-footer-wrapper dark-black">
      <div id="wrapper-footer">
        <div class="bottom-bar-wrapper">
          <div class="bottom-bar-inner">
            <div class="container">
                <div class="row">
                  <div class="col-md-12 sidebar text-center">
                    <aside id="text-12" class="widget widget_text">     
                      <div class="textwidget"><p><b>Copyright &copy; 2020 <a href="https://camelsecure.com/">CAMEL SECURE</a>.</strong> Todos los derechos reservados.</b></p>
                      </div>
                    </aside>              
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </footer>

</body>
</html>