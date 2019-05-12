<?php

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

    public function escrituraComentario() {
        
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

    public function desconectar() {
        $this->conexion->close();
    }

}
