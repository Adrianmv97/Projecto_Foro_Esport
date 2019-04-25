<?php
require_once 'config.php';
require_once 'model.php';
?>

<div class="d-flex flex-wrap p-2 bd-highlight">
    <?php
    $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
    $articulos = $conexion->verTemas();

    foreach ($articulos as $valor) {
        echo "<div class='card text-center' style='width: 25rem;'>";
        
            echo "<div class='card-header'>";
            echo "Ficha" .$valor['id'];
            echo "</div>";

            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>". $valor['TituloTema']."</h5>";
            echo "<a href='post.php' class='btn btn-primary'>Ir al post</a>";
            echo "</div>";

        echo "</div>";
    }
    $conexion->desconectar();
    ?>
</div>