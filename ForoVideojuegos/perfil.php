<?php
require_once 'config.php';
require_once 'model.php';
session_start();
?>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Foro E-Sports By Ramon, Adrian & Victor</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <style>
            body {
            }
            #logo {
                text-align: center;
            }
            span {
                font-weight: bold;
            }
            .container {
                border: 1px solid black;
                border-radius: 8px;
                padding: 10px;
                background: #111111;
                color: #999999;
            }
        </style>
    </head>
    <body>
        <div id="logo">
            <a href="index.php"><img src="imagenes/LogoEsport.jpg" width="150" height="150" alt="logo del foro"/></a>
        </div>
        <div class="container">
            <h2>Perfil de Usuario</h2>
            <form class="form-group" action="model.php">
                <?php
                $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
                $infoUsuario = $conexion->verDatosUsuario($_SESSION['idUsuario']);
                foreach ($infoUsuario as $valor){
                    echo "<label for='nombre'><span>Nombre: </span></label>";
                    echo "<input type='text' class='form-control' id='name' name='cambiarNombre' value='". $valor['Nombre'] ."'/>";
                    echo "<br/>";
                    echo "<label for='apellidos'><span>Apellidos:</span></label>";
                    echo "<input type='text' class='form-control' id='pwd' name='cambiarApellidos' value='". $valor['Apellidos'] ."'/>";
                    echo "<br/>";
                    echo "<label for='correo'><span>Correo Electronico:</span></label>";
                    echo "<input type='email' class='form-control' id='email' name='cambiarCorreo' value='". $valor['Correo'] ."'/>";
                    echo "<br/>";
                    echo "<button type='submit' class='btn btn-primary'>Guardar Cambios</button>";
                    echo "<input type='hidden' name='idUsuario' value='". $_SESSION['idUsuario'] ."'>";
                }
                ?>
                <input type='hidden' name='accion' value='modDatosUsuario'>
            </form>
        </div>
    </body>
</html>