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

        <style>
            #contenedorUsuario {
                border: 1px solid black;
            }

            #contenedorTema {
                border: 1px solid black;
                margin: 10px;
                padding: 10px;
            }

            #botonEliminar {
                margin: 10px;
            }

            #formularioAnadirTema {
                border: 1px solid black;
                text-align: center;
            }

            #formularioAnadirTema > form > div {
                margin: 15px;
            }

            #formularioAnadirTema > form > button {
                margin: 10px;
            }

            #contenedorSubForo {
                border: 1px solid black;
                padding: 10px;
            }

            #contenedorPost {
                border: 1px solid black;
                margin: 10px;
            }

            #formularioAnadirSubForo {
                border: 1px solid black;
                text-align: center;
            }

            #formularioAnadirSubForo > form > div {
                margin: 10px;
            }

            #formularioAnadirSubForo > form > button {
                margin: 10px;
            }

        </style>

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
                    echo "<div id='contenedorUsuario'>";
                    echo "<ul>";
                    echo "Id Usuario: " . $valor['idUsuario'];
                    echo "<br/>";
                    echo "Nombre de Usuario: " . $valor['Nombre'];
                    echo "<br/>";
                    echo "Apellidos del Usuario: " . $valor['Apellidos'];
                    echo "<br/>";
                    echo "Correo Electronico: " . $valor['Correo'];
                    echo "</div>";
                    echo "<a href='formularioBaneos.php'><button type='button'>Banear a " . $valor['Nombre'] . "</button></a>";
                    echo "</ul>";
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
                    echo "<div id='contenedorTema'>";
                    echo "Tema: " . $valor['TituloTema'];
                    echo "<br/>";
                    echo "Subforos asociados: " . $cantidad . " ";
                    echo "</div>";
                    echo "<div id='botonEliminar'>";
                    echo "<a href='eliminarTema.php'><button>Eliminar Tema</button></a>";
                    echo "</div>";
                    echo "<br/>";
                }
                $conexion->desconectar();
                echo "<div id='formularioAnadirTema'>";
                echo "<h2>Crear un Tema</h2>";
                echo "<form action='model.php' method='POST'>";
                echo "<div class='col-lg-10'>";
                echo "<input type='text' name='TituloTema' placeholder='Titulo del Tema'>";
                echo "</div>";
                echo "<button type='submit' class='btn btn-primary'>Crear Tema</button>";
                echo "</form>";
                echo "</div>";
                ?>

            </div>
            <div id="tabs-3">
                <?php
                $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
                $temas = $conexion->verTemas();

                foreach ($temas as $valor) {
                    $subforos = $conexion->verSubForos($valor['id']);
                    if (!empty($subforos)) {
                        echo "<div id='contenedorSubForo'>Tema: " . $valor['TituloTema'];
                        foreach ($subforos as $valor) {
                            echo "<br>";
                            echo $valor['TituloSubForo'];
                            echo " <a href='eliminarSubForo.php'><button>Eliminar Subforo</button></a>";
                        }
                        echo "</div>";
                        echo "<br>";
                    }
                }
                $conexion->desconectar();
                echo "<div id='formularioAnadirSubForo'>";
                echo "<h2>Crear un Subforo</h2>";
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
                echo "</div>";
                ?>

            </div>
            <div id="tabs-4">
                <?php
                $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
                $temas = $conexion->verTemas();

                foreach ($temas as $valor) {
                    $subforos = $conexion->verSubForos($valor['id']);
                    if (!empty($subforos)) {
                        echo "<div id='contenedorPost'>Tema: " . $valor['TituloTema'];
                        foreach ($subforos as $valor) {
                            $posts = $conexion->verPosts($valor['idSubforo']);
                            if (!empty($posts)) {
                                echo "<br>";
                                echo "Subforo: " . $valor['TituloSubForo'];
                                foreach ($posts as $valor) {
                                    echo "<br>";
                                    echo $valor['TituloPost'];
                                    echo " <a href='eliminarPost.php'><button>Eliminar Post</button></a>";
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
