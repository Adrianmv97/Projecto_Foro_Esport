<?php

require_once 'config.php';

if (isset($_REQUEST["idPost"])) {
    $idPost = $_REQUEST["idPost"];
}
if (isset($_REQUEST["TituloPost"])) {
    $TituloPost = $_REQUEST["TituloPost"];
}

if (isset($_REQUEST["comentario"])) {
    $comentario = $_REQUEST["comentario"];
    session_start();
    if (isset($_SESSION["idUsuario"])) {
        $idUsuario = $_SESSION["idUsuario"];
        $nombreUsuario = $_SESSION['nombre'];
        $apellidoUsuario = $_SESSION['apellido'];


        $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
        $comentario = $conexion->escrituraComentario($idPost, $TituloPost, $comentario, $idUsuario, $nombreUsuario, $apellidoUsuario);
    } else {
        header("Location: post.php?accion=ver&idPost=" . $idPost . "&TituloPost=" . $TituloPost . "");
    }
}
if (isset($_REQUEST["contenidoPost"])) {

    $idSubForo = $_REQUEST["idSubForo"];
    $contenidoPost = $_REQUEST["contenidoPost"];
    session_start();

    $idUsuario = $_SESSION["idUsuario"];
    $nombreUsuario = $_SESSION['nombre'];
    $apellidoUsuario = $_SESSION['apellido'];

    $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
    $comentario = $conexion->crearPost($idSubForo, $contenidoPost, $idUsuario, $nombreUsuario, $apellidoUsuario, $TituloPost, $TituloSubForo);
}

if (isset($_REQUEST["TituloTema"])) {
    $TituloTema = $_REQUEST["TituloTema"];
    $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
    $comentario = $conexion->crearTema($TituloTema);
}

if (isset($_REQUEST["TituloNuevoSubForo"])) {
    $TituloNuevoSubForo = $_REQUEST["TituloNuevoSubForo"];
    $idRelacionTema = $_REQUEST["idRelacionTema"];

    $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
    $comentario = $conexion->crearSubForo($TituloNuevoSubForo, $idRelacionTema);
}

if (isset($_REQUEST["accion"])) {
    $accion = $_REQUEST["accion"];

    if ($accion == "drop") {
        $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
        if (isset($_REQUEST['idPost'])) {
            $conexion->dropPost($_REQUEST['idPost']);
        } else if (isset($_REQUEST['idSubforo'])) {
            $conexion->dropSubForo($_REQUEST['idSubforo']);
        } else if (isset($_REQUEST['idTema'])) {
            $conexion->dropTema($_REQUEST['idTema']);
        }
    }

    if ($accion == "ban") {
        $idUsuario = $_REQUEST['idUsuario'];
        $nombreUsuario = $_REQUEST['nombreUsuario'];
        $tipoBaneo = $_REQUEST['tipoBaneo'];
        $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
        $conexion->banUsuario($idUsuario, $nombreUsuario, $tipoBaneo);
    }
    if ($accion == "modDatosUsuario") {
        $idUsuario = $_REQUEST['idUsuario'];
        $nombreUsuario = $_REQUEST['cambiarNombre'];
        $apellidoUsuario = $_REQUEST['cambiarApellidos'];
        $correoUsuario = $_REQUEST['cambiarCorreo'];
        
        $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
        $conexion->modDatosUsuarios($idUsuario,$nombreUsuario,$apellidoUsuario,$correoUsuario);
    }
    
    if ($accion == "cambiarImagen") {
        $idUsuario = $_REQUEST['idUsuario'];
        $idImagen = $_REQUEST['idImagen'];
        
        $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
        $conexion->cambiarImagenUsuario($idImagen,$idUsuario);
    }
    
}

class model {

    private $conexion;

    public function __construct($host, $user, $pass, $baseDatos) {
        $this->conexion = new mysqli($host, $user, $pass, $baseDatos);
    }

    public function verTemas() {
        $resultado = array();
        $consulta = $this->conexion->stmt_init();
        $consulta->prepare("SELECT * FROM Temas");
        $consulta->execute();
        $consulta->bind_result($id, $tituloTema, $idImagen);
        while ($fila = $consulta->fetch()) {
            $arrayFila = array("id" => $id, "TituloTema" => $tituloTema , "idImagen" => $idImagen);
            array_push($resultado, $arrayFila);
        }
        return $resultado;
    }

    public function verSubForos($idTema) {
        $resultado = array();
        $consulta = $this->conexion->stmt_init();
        $consulta->prepare("SELECT * FROM subforo WHERE idTemaRelacion = " . $idTema);
        $consulta->execute();
        $consulta->bind_result($idSubforo, $tituloSubForo, $idTemaRelacion);
        while ($fila = $consulta->fetch()) {
            $arrayFila = array("idSubforo" => $idSubforo, "TituloSubForo" => $tituloSubForo, "idTemaRelacion" => $idTemaRelacion);
            array_push($resultado, $arrayFila);
        }
        return $resultado;
    }

    public function verPost($idPost) {
        $resultado = array();
        $consulta = $this->conexion->stmt_init();
        $consulta->prepare("SELECT * FROM post WHERE idPost = " . $idPost);
        $consulta->execute();
        $consulta->bind_result($idPost, $tituloPost, $contenidoPost, $idSubforoRelacion, $idUsuarioRelacion, $nombreUsuario, $apellidoUsuario);
        while ($fila = $consulta->fetch()) {
            $arrayFila = array("idPost" => $idPost, "TituloPost" => $tituloPost, "ContenidoPost" => $contenidoPost, "idSubforoRelacion" => $idSubforoRelacion,
                "idUsuarioRelacion" => $idUsuarioRelacion, "NombreUsuario" => $nombreUsuario, "ApellidoUsuario" => $apellidoUsuario);
            array_push($resultado, $arrayFila);
        }
        return $resultado;
    }

    public function verComentarios($idPost) {
        $resultado = array();
        $consulta = $this->conexion->stmt_init();
        $consulta->prepare("SELECT * FROM comentario WHERE idPostRelacion = " . $idPost);
        $consulta->execute();
        $consulta->bind_result($idComentario, $comentario, $idPostRelacion, $idUsuarioRelacion, $nombreUsuario, $apellidoUsuario);
        while ($fila = $consulta->fetch()) {
            $arrayFila = array("idComentario" => $idComentario, "Comentario" => $comentario, "idUsuarioRelacion" => $idUsuarioRelacion
                , "idPostRelacion" => $idPostRelacion, "NombreUsuario" => $nombreUsuario, "ApellidoUsuario" => $apellidoUsuario);
            array_push($resultado, $arrayFila);
        }
        return $resultado;
    }

    public function escrituraComentario($idPost, $TituloPost, $comentario, $idUsuario, $nombreUsuario, $apellidoUsuario) {

        $insercion = $this->conexion->stmt_init();

        $insercion->prepare("INSERT INTO `comentario` (`Comentario`, `IdPostRelacion`, `IdUsuarioRelacion` , `nombreUsuario` , `apellidoUsuario`)"
                . " VALUES ('$comentario', '$idPost' , '$idUsuario' , '$nombreUsuario' , '$apellidoUsuario' )");
        $insercion->execute();
        header("Location: post.php?accion=ver&idPost=" . $idPost . "&TituloPost=" . $TituloPost . "");
    }

    public function verPosts($idSubForo) {
        $resultado = array();
        $consulta = $this->conexion->stmt_init();
        $consulta->prepare("SELECT * FROM post WHERE idSubforoRelacion = " . $idSubForo);
        $consulta->execute();
        $consulta->bind_result($idPost, $tituloPost, $contenidoPost, $idSubforoRelacion, $idUsuarioRelacion, $nombreUsuario, $apellidoUsuario);
        while ($fila = $consulta->fetch()) {
            $arrayFila = array("idPost" => $idPost, "TituloPost" => $tituloPost, "ContenidoPost" => $contenidoPost, "idSubforoRelacion" => $idSubforoRelacion,
                "idUsuarioRelacion" => $idUsuarioRelacion, "NombreUsuario" => $nombreUsuario, "ApellidoUsuario" => $apellidoUsuario);
            array_push($resultado, $arrayFila);
        }
        return $resultado;
    }

    public function verTodosUsuarios() {
        $resultado = array();
        $consulta = $this->conexion->stmt_init();
        $consulta->prepare("SELECT idUsuario,Correo,Nombre,Apellidos,LevelUser FROM usuarios WHERE LevelUser > 0");
        $consulta->execute();
        $consulta->bind_result($idUsuario, $correo, $nombre, $apellidos, $levelUser);
        while ($fila = $consulta->fetch()) {
            $arrayFila = array("idUsuario" => $idUsuario, "Nombre" => $nombre, "Apellidos" => $apellidos, "LevelUser" => $levelUser, "Correo" => $correo);
            array_push($resultado, $arrayFila);
        }
        return $resultado;
    }

    public function verCantidadSubforosAsignadoTema($idTema) {
        $resultado;
        $consulta = $this->conexion->stmt_init();
        $consulta->prepare("SELECT * FROM subforo WHERE idTemaRelacion = " . $idTema);
        $consulta->execute();
        $consulta->store_result();
        $resultado = $consulta->num_rows();
        return $resultado;
    }

    public function verTema($idTema) {
        $resultado = array();
        $consulta = $this->conexion->stmt_init();
        $consulta->prepare("SELECT idTema,nombreTema FROM Temas WHERE idTema = " . $idTema);
        $consulta->execute();
        $consulta->bind_result($id, $tituloTema);
        while ($fila = $consulta->fetch()) {
            $arrayFila = array("id" => $id, "TituloTema" => $tituloTema);
            array_push($resultado, $arrayFila);
        }
        return $resultado;
    }

    public function desconectar() {
        $this->conexion->close();
    }

    public function crearPost($idSubForo, $contenidoPost, $idUsuario, $nombreUsuario, $apellidoUsuario, $TituloPost) {

        $insercion = $this->conexion->stmt_init();

        $insercion->prepare("INSERT INTO `post` (`nombrePost`, `contenidoPost`, `IdSubforoRelacion` , `IdUsuarioRelacion` , `nombreUsuario` , `apellidoUsuario`)"
                . " VALUES ('$TituloPost', '$contenidoPost' , '$idSubForo' , '$idUsuario' , '$nombreUsuario' , '$apellidoUsuario' )");
        $insercion->execute();
        header("Location: foro.php");
    }

    public function crearTema($TituloTema) {

        $insercion = $this->conexion->stmt_init();

        $insercion->prepare("INSERT INTO `temas` (`nombreTema` , `idImagen`)"
                . " VALUES ('$TituloTema', 1)");
        $insercion->execute();
        header("Location: herramientaAdministrativa.php");
    }

    public function crearSubForo($TituloNuevoSubForo, $idRelacionTema) {

        $insercion = $this->conexion->stmt_init();

        $insercion->prepare("INSERT INTO `subforo` (`nombreSubforo`, `idTemaRelacion`)"
                . " VALUES ('$TituloNuevoSubForo' , $idRelacionTema)");
        $insercion->execute();
        header("Location: herramientaAdministrativa.php");
    }

    public function dropTema($idTema) {
        $drop = $this->conexion->stmt_init();
        $drop->prepare("DELETE FROM `temas` WHERE `temas`.`idTema` = $idTema");
        $drop->execute();
        header("Location: herramientaAdministrativa.php");
    }

    public function dropSubForo($idSubforo) {
        $drop = $this->conexion->stmt_init();
        $drop->prepare("DELETE FROM `subforo` WHERE `subforo`.`idSubforo` = $idSubforo");
        $drop->execute();
        header("Location: herramientaAdministrativa.php");
    }

    public function dropPost($idPost) {
        $drop = $this->conexion->stmt_init();
        $drop->prepare("DELETE FROM `post` WHERE `post`.`idPost` = $idPost");
        $drop->execute();
        header("Location: herramientaAdministrativa.php");
    }

    public function banUsuario($idUsuario, $nombreUsuario, $tipoBaneo) {

        $localTime = new DateTime("now");
        if ($tipoBaneo == 1) {
            $infobaneo = "1 dia";
            $tiempoBaneo = "+1 day";
        } else if ($tipoBaneo == 2) {
            $infobaneo = "2 dias";
            $tiempoBaneo = "+2 day";
        } else if ($tipoBaneo == 3) {
            $infobaneo = "1 semana";
            $tiempoBaneo = "+7 day";
        } else if ($tipoBaneo == 4) {
            $infobaneo = "1 mes";
            $tiempoBaneo = "+1 month";
        } else if ($tipoBaneo == 5) {
            $infobaneo = "Vacaciones de larga estancia";
            $tiempoBaneo = "9999-12-31 23:59:59";
        }
        $emitido = $localTime->format('Y-m-d H:i:s');
        $localTime->modify($tiempoBaneo);
        $tiempoBaneado = $localTime->format('Y-m-d H:i:s');

        $baneo = $this->conexion->stmt_init();
        $baneo->prepare("INSERT INTO `baneos` (`id`, `idUsuario`, `TipoBan`, `ExpiracionBan`, `Emitido`)"
                . "VALUES (NULL, $idUsuario, '$infobaneo', '$tiempoBaneado', '$emitido')");
        $baneo->execute();
        header("Location: herramientaAdministrativa.php");
    }

    public function buscarUsuarioBan($idUsuario) {
        $resultado = array();
        $buscar = $this->conexion->stmt_init();
        $buscar->prepare("SELECT idUsuario,TipoBan,Emitido,ExpiracionBan FROM baneos WHERE idUsuario = $idUsuario");
        $buscar->execute();

        $buscar->store_result();
        $localizado = $buscar->num_rows();
        $buscar->bind_result($idUsuario, $TipoBan, $Emitido, $ExpiracionBan);
        if ($localizado == 0) {
            return false;
        } else if ($localizado > 0) {        
            while ($fila = $buscar->fetch()) {
                $arrayFila = array("idUsuario" => $idUsuario, "TipoBan" => $TipoBan, "Emitido" => $Emitido, "ExpiracionBan" => $ExpiracionBan);
                array_push($resultado, $arrayFila);
            }
            return $resultado;
        }
    }
    
    public function verDatosUsuario($idUsuario) {
        $resultado = array();
        $consulta = $this->conexion->stmt_init();
        $consulta->prepare("SELECT idUsuario,Correo,Nombre,Apellidos,LevelUser,idfotoPerfil FROM usuarios WHERE idUsuario = $idUsuario");
        $consulta->execute();
        $consulta->bind_result($idUsuario, $correo, $nombre, $apellidos, $levelUser, $idfotoPerfil);
        while ($fila = $consulta->fetch()) {
            $arrayFila = array("idUsuario" => $idUsuario, "Nombre" => $nombre, "Apellidos" => $apellidos,
                "LevelUser" => $levelUser, "Correo" => $correo , "idfotoPerfil" => $idfotoPerfil);
            array_push($resultado, $arrayFila);
        }
        return $resultado;
    }
    
    public function modDatosUsuarios($idUsuario,$nombreUsuario,$apellidoUsuario,$correoUsuario) {
        $modificacion = $this->conexion->stmt_init();
        $modificacion->prepare("UPDATE `usuarios` SET `Correo` = '$correoUsuario', `Nombre` = '$nombreUsuario', `Apellidos` = '$apellidoUsuario'"
                . " WHERE `usuarios`.`idUsuario` = $idUsuario");
        $modificacion->execute();
        header("Location: perfil.php");
    }
    
    public function sacarImagenTema ($idImagen){
        $resultado = array();
        $consulta = $this->conexion->stmt_init();
        $consulta->prepare("SELECT ubicacion FROM imagenestemas WHERE id = $idImagen");
        $consulta->execute();
        $consulta->bind_result($ubicacion);
        while ($fila = $consulta->fetch()) {
            $arrayFila = array("ubicacion" => $ubicacion);
            array_push($resultado, $arrayFila);
        }
        return $resultado;
    }
    public function sacarImagenUsuario ($idFotoPerfil){
        $resultado = array();
        $consulta = $this->conexion->stmt_init();
        $consulta->prepare("SELECT Ubicacion FROM fotoperfil WHERE id = $idFotoPerfil");
        $consulta->execute();
        $consulta->bind_result($ubicacion);
        while ($fila = $consulta->fetch()) {
            $arrayFila = array("ubicacion" => $ubicacion);
            array_push($resultado, $arrayFila);
        }
        return $resultado;
    }
    public function cambiarImagenUsuario ($idFotoPerfil, $idUsuario){
        $modificacion = $this->conexion->stmt_init();
        $modificacion->prepare("UPDATE `usuarios` SET `idfotoPerfil` = '$idFotoPerfil' WHERE `usuarios`.`idUsuario` = $idUsuario");
        $modificacion->execute();
        header("Location: index.php");
    }
    public function verImagenes (){
        $resultado = array();
        $consulta = $this->conexion->stmt_init();
        $consulta->prepare("SELECT * FROM fotoperfil");
        $consulta->execute();
        $consulta->bind_result($id,$ubicacion);
        while ($fila = $consulta->fetch()) {
            $arrayFila = array("id" => $id ,"ubicacion" => $ubicacion);
            array_push($resultado, $arrayFila);
        }
        return $resultado;
    }
}
