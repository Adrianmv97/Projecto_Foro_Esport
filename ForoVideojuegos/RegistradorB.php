<!DOCTYPE html>
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
    echo "<a href='registro.html'>volver</a>";
} else {
    if ($conn->query($accion) === TRUE) {
        echo "Usuario creado correctamente";
        echo ("<br>");
        echo ("<a href='IniciarSesion.html'>Inicio</a>");
    } else {
        echo "Error: " . $accion . "<br>" . $conn->error;
    }
}


mysqli_close($conn);
?>
