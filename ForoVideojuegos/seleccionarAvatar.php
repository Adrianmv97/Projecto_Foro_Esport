<?php
require_once 'config.php';
require_once 'model.php';
session_start();


if (!isset($_SESSION['idUsuario'])) {
    header("Location: index.php");
}
?>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        img {
            margin: 10px;
        }
        #logo {
            text-align: center;
        }
    </style>
</head>
<body>
    <div id="logo">
        <a href="index.php"><img src="imagenes/LogoEsport.png" width="150" height="150" alt="logo del foro"/></a>
    </div>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Elige tu foto o imagen de perfil</h1>
            <?php
            $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
            $imagenes = $conexion->verImagenes();
            foreach ($imagenes as $imagen){
                echo "  <a href='model.php?accion=cambiarImagen&idImagen=" . $imagen['id'] . "&idUsuario=". $_SESSION['idUsuario'] ."' class='btn btn-primary'>"
                        . "<img src='". $imagen['ubicacion'] ."' height='80px' width='70px'></a>  ";
            }
                
            
            ?>
        </div>
    </div>    
</body>
</html>