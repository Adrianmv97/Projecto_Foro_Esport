<?php
require_once 'config.php';
require_once 'model.php';
?>
<html>
    <head>
        <meta charset="utf-8" />
        <link href="css/Inicio.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="logica">
        <?php
        $usuario = $_REQUEST["usuario"];
        $contrasena = $_REQUEST["contrasena"];

        $conn = mysqli_connect('localhost', 'root', '', 'foroesport', '3306');
        if (!$conn) {
            die('Could not connect to MySQL: ' . mysqli_connect_error());
        }

        $accion = "SELECT idUsuario,user,password,nombre,apellidos,levelUser FROM usuarios WHERE user = '$usuario'";
        $result = $conn->query($accion);
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            while ($row = $result->fetch_array()) {
                if ($row['user'] == $usuario) {
                    if (password_verify($contrasena, $row['password'])) {
                        $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
                        $busquedaUsuarioBaneado = $conexion->buscarUsuarioBan($row['idUsuario']);
                        if ($busquedaUsuarioBaneado != false) {
                            $localTime = new DateTime("now");
                            $localTime = $localTime->format('Y-m-d H:i:s');
                            foreach ($busquedaUsuarioBaneado as $valor) {
                                $diaExpiBaneo = $valor['ExpiracionBan'];
                            }
                            if ($localTime > $diaExpiBaneo) {
                                session_start();
                                $_SESSION['idUsuario'] = $row['idUsuario'];
                                $_SESSION['nombre'] = $row['nombre'];
                                $_SESSION['apellido'] = $row['apellidos'];
                                $_SESSION['levelUser'] = $row['levelUser'];
                                header("Location: index.php");
                            } else {
                                echo ("<div>");
                                echo ("Tu usuario se encuentra baneado, dia del desbaneo: ". $diaExpiBaneo);
                                echo ("<br>");
                                echo ("<a href='iniciarSesion.html'>Iniciar Sesion</a>");
                                echo ("<br>");
                                echo ("<a href='index.php'>Inicio</a>");
                                echo ("</div>");
                            }
                        }else {
                            session_start();
                                $_SESSION['idUsuario'] = $row['idUsuario'];
                                $_SESSION['nombre'] = $row['nombre'];
                                $_SESSION['apellido'] = $row['apellidos'];
                                $_SESSION['levelUser'] = $row['levelUser'];
                                header("Location: index.php");
                        }
                    } else if ($row['user'] == $usuario && $row['password'] != $contrasena) {
                        echo ("<div>");
                        echo ("La contrasena en incorrecta, porfavor vuelve a escribirla");
                        echo ("<br>");
                        echo ("<a href='iniciarSesion.html'>Iniciar Sesion</a>");
                        echo ("<br>");
                        echo ("<a href='index.php'>Inicio</a>");
                        echo ("</div>");
                    }
                }
            }
        } else {
            echo ("<div>");
            echo ("Usuario incorrecto o no registrado");
            echo ("<br>");
            echo ("<a href='registro.html'>Registrarse</a>");
            echo ("<br>");
            echo ("<a href='iniciarSesion.html'>Iniciar Sesion</a>");
            echo ("<br>");
            echo ("<a href='index.php'>Inicio</a>");
            echo ("</div>");
        }


        mysqli_free_result($result);
        mysqli_close($conn);
        ?>
    </body>
</html>
