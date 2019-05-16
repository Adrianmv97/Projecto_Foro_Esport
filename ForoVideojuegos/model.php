<?php

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
        require_once 'config.php';

        $conexion = new model(Config::$host, Config::$user, Config::$pass, Config::$baseDatos);
        $comentario = $conexion->escrituraComentario($idPost, $TituloPost, $comentario, $idUsuario, $nombreUsuario, $apellidoUsuario);
    } else {
        echo "no a entrado";
//header("Location: post.php?accion=ver&idPost=". $idPost ."&TituloPost=". $TituloPost ."");
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
        $consulta->bind_result($id, $tituloTema);
        while ($fila = $consulta->fetch()) {
            $arrayFila = array("id" => $id, "TituloTema" => $tituloTema);
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
        $consulta->bind_result($idComentario, $comentario, $idUsuarioRelacion, $idPostRelacion, $nombreUsuario, $apellidoUsuario);
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
        $consulta->prepare("SELECT * FROM Temas WHERE idTema = " . $idTema);
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

}
