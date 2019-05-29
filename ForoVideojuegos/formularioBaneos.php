<!DOCTYPE html>
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
        <a href="index.php"><img src="imagenes/LogoEsport.jpg" width="150" height="150" alt="logo del foro"/></a>
    </div>
    <h1>¿A QUIEN VAS A BANEAR?</h1>
    <form action="baneos.php" method="POST">
        <div class="form-group row">
            <label for="staticUser" class="col-sm-2 col-form-label">Usuario</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="Nombre de Usuario">
            </div>
        </div>
        <div class="form-group row">
            <div class="form-group">
                <label for="exampleFormControlSelect1" class="col-sm-2 col-form-label">Tipo de Baneo</label>
                <br>
                <select class="custom-select" size="6">
                    <option>1 dia</option>
                    <option>2 dias</option>
                    <option>1 semana</option>
                    <option>1 mes</option>
                    <option>vacaciones de larga duracion</option>
                    <option>variables</option>
                </select>
            </div>
            <input type="submit" value="Banear"/>
        </div>
    </form>
</body>
</html>