<!DOCTYPE html>
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
        <form class="form-group" action="datosUsuario.php">
            <label for="nombre"><span>Nombre:</span> Cambiar por usuario real</label>
            <input type="text" class="form-control" id="name" placeholder="Cambiar nombre" name="cambiarNombre"/>
            <br/>
            <label for="apellidos"><span>Apellidos:</span> Cambiar por apellidos</label>
            <input type="text" class="form-control" id="pwd" placeholder="Cambiar apellidos" name="cambiarApellidos"/>
            <br/>
            <label for="correo"><span>Correo Electronico:</span> Cambiar por correo</label>
            <input type="email" class="form-control" id="email" placeholder="Cambiar correo" name="cambiarCorreo"/>
            <br/>
            <label for="pwd"><span>Contraseña:</span> ***********</label>
            <input type="password" class="form-control" id="pwd" placeholder="*******" name="cambiarPassword"/>
            <br/>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>