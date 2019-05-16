<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once 'config.php';
require_once 'model.php';
session_start();

if (!isset($_SESSION['idUsuario'])) {
    header('Location: index.php');
}
if (isset($_SESSION['idUsuario'])) {
    if ($_SESSION['levelUser'] != 10) {
        header('Location: index.php');
    }
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">

        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

        <script type="text/javascript">

            $(function () {
                $("#tabs").tabs();
            });

        </script>

    </head>
    <body>
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Usuarios</a></li>
                <li><a href="#tabs-2">Temas</a></li>
                <li><a href="#tabs-3">SubForos</a></li>
                <li><a href="#tabs-4">Post</a></li>
            </ul>
            <div id="tabs-1">
                <?php
                $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
                $usuarios = $conexion->verTodosUsuarios();
                foreach ($usuarios as $valor) {
                    echo $valor['idUsuario'];
                    echo " --- ";
                    echo $valor['Nombre'];
                    echo " ";
                    echo $valor['Apellidos'];
                    echo " <-------> ";
                    echo $valor['Correo'];
                    echo "<br>";
                }
                $conexion->desconectar();
                ?>

            </div>
            <div id="tabs-2">
                <?php
                $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
                $articulos = $conexion->verTemas();

                foreach ($articulos as $valor) {
                    $cantidad = $conexion->verCantidadSubforosAsignadoTema($valor['id']);
                    echo "<div>Tema: " . $valor['TituloTema'] . " -- Subforos -> " . $cantidad . "</div>";
                }
                $conexion->desconectar();

                echo "<form action='model.php' method='POST'>";
                echo "<div class='col-lg-10'>";
                echo "<input type='text' name='TituloTema' placeholder='Titulo del Tema'>";
                echo "</div>";
                echo "<button type='submit' class='btn btn-primary'>Crear Tema</button>";
                echo "</form>";
                ?>

            </div>
            <div id="tabs-3">
                <?php
                $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
                $temas = $conexion->verTemas();

                foreach ($temas as $valor) {
                    $subforos = $conexion->verSubForos($valor['id']);
                    if (!empty($subforos)) {
                        echo "<div>Tema: " . $valor['TituloTema'];
                        foreach ($subforos as $valor) {
                            echo "<br>";
                            echo $valor['TituloSubForo'];
                        }
                        echo "</div>";
                        echo "<br>";
                    }
                }
                $conexion->desconectar();
                
                echo "<form action='model.php' method='POST'>";
                echo "<div class='col-lg-10'>";
                echo "<input type='text' name='TituloNuevoSubForo' placeholder='Titulo del Subforo'>";
                echo "</div>";
                echo "<div class='col-lg-10'>";
                echo "<select name='idRelacionTema'>";
                foreach ($temas as $valor){
                    echo "<option value= ".$valor['id'].">".$valor['TituloTema']."</option>";
                }
                echo "</select>";
                echo "</div>";
                echo "<button type='submit' class='btn btn-primary'>Crear Subforo</button>";
                echo "</form>";
                ?>

            </div>
            <div id="tabs-4">
                <?php
                $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
                $temas = $conexion->verTemas();

                foreach ($temas as $valor) {
                    $subforos = $conexion->verSubForos($valor['id']);
                    if (!empty($subforos)) {
                        echo "<div>Tema: " . $valor['TituloTema'];
                        foreach ($subforos as $valor) {
                            $posts = $conexion->verPosts($valor['idSubforo']);
                            if (!empty($posts)) {
                                echo "<br>";
                                echo "Subforo: " . $valor['TituloSubForo'];
                                foreach ($posts as $valor) {
                                    echo "<br>";
                                    echo $valor['TituloPost'];
                                }
                                echo "</div>";
                                echo "<br>";
                            }
                        }
                    }
                }
                $conexion->desconectar();
                ?>

            </div>
        </div>
        <button class='btn btn-primary'><a href="index.php">Salir</a></button>
    </body>
</html>
