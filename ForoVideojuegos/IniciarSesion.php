<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link href="css/Inicio.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="logica">
        <?php
        $usuario = $_REQUEST["usuario"];
        $contrasena = $_REQUEST["contrasena"];

        $usuario = strtolower($usuario);

        $conn = mysqli_connect('localhost', 'root', '', 'foroesport', '3306');
        if (!$conn) {
            die('Could not connect to MySQL: ' . mysqli_connect_error());
        }

        $accion = "SELECT idUsuario,user,password FROM usuarios WHERE user = '$usuario'";
        $result = $conn->query($accion);
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            while ($row = $result->fetch_array()) {
                if ($row['user'] == $usuario && $row['password'] == $contrasena) {
                    echo ("<form name='usuarioLanzado' action='index.php' method='POST'>");
                    session_start();
                    $_SESSION['idUsuario'] = $row['idUsuario'];
                    echo ("</form>");
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
    <script>
        document.usuarioLanzado.submit();
    </script>
</html>
