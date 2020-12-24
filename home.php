<?php
//require_once 'controller/CStudents.php';

//$cs = new CStudents();

?>
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
    <nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
        <a class="navbar-brand" href="#">Control</a>
        </div>
        <ul class="nav navbar-nav">
        <li class="active"><a>Estudiantes</a></li>
        </ul>
    </div>
    </nav>

    <hr>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="add.php" class="btn btn-primary">Agregar Estudiante</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <fieldset>
                    <legend>Listado de Estudiantes:</legend>

                    <table id="table-students" class="table table-bordered tabled-striped">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Rut</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Curso</th>
                        <th scope="col">Fecha Nacimiento</th>
                        <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $cs->index();
                    ?>
                    </tbody>
                    </table>
                </fieldset>
            </div>
        </div>
    </div>
    


    <?php require_once('js.php'); ?>
</body>
</html>