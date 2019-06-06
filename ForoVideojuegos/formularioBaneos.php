<?php
session_start();

if (!isset($_SESSION['idUsuario'])){
    header("Location: accessDenied.php");
}
if (isset($_REQUEST['accion'])){
    $accion = $_REQUEST['accion'];
    $idUsuario = $_REQUEST['idUsuario'];
    $nombreUsuario = $_REQUEST['nombreUsuario'];
}
?>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
    <style>
        form, h1, #logo {
            text-align: center;
        }

        input, select {
            width: 200px;
        }
    </style>
</head>
<body>
    <div id="logo">
        <a href="index.php"><img src="imagenes/LogoEsport.png" width="150" height="150" alt="logo del foro"/></a>
    </div>
    <h1>¿A QUIEN VAS A BANEAR?</h1>
    <form action="model.php" method="POST">
        <div class="form-group row">
            <label for="staticUser" class="col-sm-2 col-form-label">Usuario</label>
            <div class="col-sm-10">
                <?php
                echo "<input type='text' name='nombreUsuario' readonly class='form-control-plaintext' value='$nombreUsuario'>"
                ?>
    
            </div>
        </div>
        <div class="form-group row">
            <div class="form-group">
                <label for="exampleFormControlSelect1" class="col-sm-2 col-form-label">Tipo de Baneo</label>
                <br>
                <select name="tipoBaneo" class="custom-select" size="5">
                    <option value="1">1 dia</option>
                    <option value="2">2 dias</option>
                    <option value="3">1 semana</option>
                    <option value="4">1 mes</option>
                    <option value="5">vacaciones de larga duracion</option>
                </select>
            </div>
            <input type="submit" value="Banear"/>
        </div>
        <?php
        echo "<input type='hidden' name='idUsuario' value='$idUsuario'>"
        ?>
        <input type="hidden" name="accion" value="ban">
    </form>
</body>
</html>