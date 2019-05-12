<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Foro E-Sports By Ramon, Adrian & Victor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css" type="text/css">
    <script src="main.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-light bg-primary">
    <div class="collapse navbar-collapse d-flex flex-row bd-highlight" id="navbarText" id="datos">
        <span class="navbar-text">
            Datos de usuario
        </span>
    </div>
    <div class="collapse navbar-collapse d-flex flex-row-reverse bd-highlight" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <div class="p-2 border bg-success">
                <li class="nav-item active">
                    <a class="nav-link" href="registro.html">Registrarse</a>
                </li>
            </div>
        </ul>
        <ul class="navbar-nav">
            <div class="p-2 border bg-success">
                <li class="nav-item active">
                    <a class="nav-link" href="iniciarSesion.html">Iniciar Sesion</a>
                </li>
            </div>
        </ul>
    </div>
</nav>
<?php 
    include('./templates/nav.php');

    require_once 'config.php';
    require_once 'model.php';
    
    $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);

    $indiceTema = 2;
    $foro = $conexion->verSubForos($indiceTema);
    $tema = $conexion->verTemas();
    echo '<div class="jumbotron jumbotron-fluid mx-auto">';
    echo "<h3>Natación</h3>";
    foreach ($foro as $valor) {
        echo '<div class="card">';
            echo "<a href='subforo.php' class='btn btn-primary btn-lg btn-block' role='button' aria-pressed='true'>" . $valor['TituloSubForo'] . "</a>";
        echo '</div>';
        $indiceTema ++;
    }
    
    echo '</div>';
    $conexion->desconectar();

    include('./templates/footer.php');
?>
</body>
</html>