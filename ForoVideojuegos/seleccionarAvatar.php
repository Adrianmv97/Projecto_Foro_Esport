<!DOCTYPE html>
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
        <a href="index.php"><img src="imagenes/LogoEsport.jpg" width="150" height="150" alt="logo del foro"/></a>
    </div>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Elige tu foto o imagen de perfil</h1>
            <?php
            for($i = 0; $i <= 53; $i++) {
                echo "<img src='imagenes/default-profile.png' height='50px' width='40px'>";
            }
            ?>
            <button type="button" class="btn btn-success">Guardar Foto de Perfil</button>
        </div>
    </div>    
</body>
</html>