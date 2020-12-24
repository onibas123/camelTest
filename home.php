<?php session_start();?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Bienvenido</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="SitePoint">
    <?php require_once('css.php'); ?>
</head>
<body>
    <nav class="navbar navbar-default" role="navigation">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target=".navbar-ex1-collapse">
            <span class="sr-only">Desplegar navegación</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Home</a>
        </div>


        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Último acceso <?php echo $_SESSION['user_data']['last_access'];?><b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                    <li><a><?php echo $_SESSION['user_data']['rol'];?></a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo $_SESSION['BASE_URL'].'/middleware/Users.php?action=logout';?>">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <hr>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <fieldset>
                    <legend>Bienvenido: <?php echo $_SESSION['user_data']['user'].' | '.$_SESSION['user_data']['rol'];?></legend>

                </fieldset>
            </div>
        </div>
    </div>
    
    <?php require_once('js.php'); ?>
    <script>
        $(document).ready(function() {
            inactivity_stat();
        });
         
        function inactivity_stat()
        {
            var time;
            window.onload = resetTimer;
            // DOM events
            document.onmousemove = resetTimer;
            document.onkeypress = resetTimer;

            function resetTimer()
            {
                clearTimeout(time);
                time = setTimeout(logout, 1000 * 60 * <?php echo $_SESSION['expire_mins'];?>);
                // 1000 milliseconds = 1 second
                // * 60 = 1 min
                // * $_SESSION['expire_mins'] quantity of mins to check inactivity
                //if exist inactivity redirect to login by logout with function "logout"
            }
        }

        function logout() 
        {
            window.location.href = '<?php echo $_SESSION['BASE_URL'].'/middleware/Users.php?action=logout';?>';
        }

        
    </script>
</body>
</html>