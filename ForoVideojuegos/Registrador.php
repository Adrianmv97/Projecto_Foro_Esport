<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="css/Inicio.css" rel="stylesheet" type="text/css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>

    </head>
    <body  class="logica">
        <div  class="centro">
            <?php
            $newUser = $_REQUEST["newUser"];
            $newPassword = $_REQUEST["newPass"];

            $newUser = strtolower($newUser);

            $conn = mysqli_connect('localhost', 'root', '', 'testforo', '3306');
            if (!$conn) {
                die('Could not connect to MySQL: ' . mysqli_connect_error());
            }
            $accion = "INSERT INTO `usuarios` (`USER`, `PASSWORD`)"
                    . " VALUES ('$newUser', '$newPassword')";

            $accion2 = "SELECT user FROM usuarios WHERE user = '$newUser'";

            $result = $conn->query($accion2);
            $count = mysqli_num_rows($result);
            if ($count == 1) {
                echo "Usuario ya existente";
                echo "<br>";
                echo "<a href='registro.html'>Volver</a>";
            } else {
                if ($conn->query($accion) === TRUE) {
                    echo "Usuario creado correctamente";
                    echo ("<br>");
                    echo ("<a href='IniciarSesion.html'>Iniciar Sesion</a>");
                } else {
                    echo "Error: " . $accion . "<br>" . $conn->error;
                }
            }


            mysqli_close($conn);
            ?>
        </div>

    </body>
</html>
