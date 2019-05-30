<!DOCTYPE html>
<?php
session_start();

if (isset($_REQUEST["accion"])) {
    $accion = $_REQUEST["accion"];
}
if (isset($_REQUEST["idSubForo"])) {
    $idSubForo = $_REQUEST["idSubForo"];
}
if (isset($_REQUEST["TituloSubForo"])) {
    $TituloSubForo = $_REQUEST["TituloSubForo"];
}
if (!isset( $_SESSION['idUsuario'])){
    header("Location: accessDenied.php");
}
?>
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
            </div>
            <div class="collapse navbar-collapse d-flex flex-row-reverse bd-highlight" id="navbarSupportedContent">
                <?php
                if (isset($_SESSION['idUsuario'])) {
                    echo "<ul class = 'navbar-nav'>";
                    echo "<div class = 'p-2 border bg-success'>";
                    echo "<li class = 'nav-item active'>";
                    echo "<a class = 'nav-link' href = 'desconectar.php'>Cerrar Sesion</a>";
                    echo "</li>";
                    echo "</div>";
                    echo "</ul>";
                    echo "<ul class = 'navbar-nav'>";
                    echo "<div class = 'p-2 border bg-success'>";
                    echo "<li class = 'nav-item active'>";
                    echo "<a class = 'nav-link' href = 'perfil.php'>Datos de Usuario</a>";
                    echo "</li>";
                    echo "</div>";
                    echo "</ul>";
                } else {
                    echo "<ul class = 'navbar-nav'>";
                    echo "<div class = 'p-2 border bg-success'>";
                    echo "<li class = 'nav-item active'>";
                    echo "<a class = 'nav-link' href = 'registro.html'>Registrarse</a>";
                    echo "</li>";
                    echo "</div>";
                    echo "</ul>";
                    echo "<ul class = 'navbar-nav'>";
                    echo "<div class = 'p-2 border bg-success'>";
                    echo "<li class = 'nav-item active'>";
                    echo "<a class = 'nav-link' href = 'iniciarSesion.html'>Iniciar Sesión</a>";
                    echo "</li>";
                    echo "</div>";
                    echo "</ul>";
                }
                ?>
            </div>
        </nav>
        <?php
        include('./templates/nav.php');

        require_once 'config.php';
        require_once 'model.php';

        $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);

        $subforo = $conexion->verPosts($idSubForo);

        echo '<div class="jumbotron jumbotron-fluid mx-auto">';
        echo "<h3>" . $TituloSubForo . "</h3>";
        foreach ($subforo as $valor) {
            echo '<div class="card">';
            echo "<a href='post.php?accion=ver&idPost=" . $valor['idPost'] . "&TituloPost=" . $valor['TituloPost'] . "' class='btn btn-primary btn-lg btn-block' role='button' aria-pressed='true'>" . $valor['TituloPost'] . "</a>";
            echo '</div>';
        }

        echo '</div>';
        $conexion->desconectar();
        ?>

        <?php
        if (isset($_SESSION['idUsuario'])) {
            echo "<form action='model.php' method='POST'>";
            echo "<div class='col-lg-10'>";

            echo "<input type='text' name='TituloPost' placeholder='Titulo de tu post'>";
            echo "<input type='text' class='form-control' id='inputText' name='contenidoPost' placeholder='Contenido de tu post'>";

            echo "<input type='hidden' name='idSubForo' value = " . $idSubForo . ">";

            echo "</div>";
            echo "<button type='submit' class='btn btn-primary'>Crear Post</button>";
            echo "</form>";
        }
        ?>

    </body>
</html>