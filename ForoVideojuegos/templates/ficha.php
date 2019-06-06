<?php
require_once 'config.php';
require_once 'model.php';
?>

<div class="d-flex flex-wrap p-2 bd-highlight">
    <?php
    $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
    $temas = $conexion->verTemas();

    $indiceTema = 1;
    foreach ($temas as $valor) {
        echo "<div class='card text-center' style='width: 25rem;'>";
        
            echo "<div class='card-header'>";
            echo "Tema " .$indiceTema;
            echo "</div>";

            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>". $valor['TituloTema']."</h5>";
            echo "<img src='https://e00-marca.uecdn.es/assets/multimedia/imagenes/2019/05/13/15577743771579.jpg' class='card-img-top' alt='tema' height='250' width='120'>";
            echo "<br/>";
            echo "<br/>";
            echo "<a href='Foro.php?accion=ver&idTemaUnico=". $valor['id'] ."' class='btn btn-primary'>Ver Tema</a>";
            echo "</div>";

        echo "</div>";
        $indiceTema ++;
    }
    $conexion->desconectar();
    ?>
</div>