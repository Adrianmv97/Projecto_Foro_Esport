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

    public function verPost($idSubforo) {
        $resultado = array();
        $consulta = $this->conexion->stmt_init();
        $consulta->prepare("SELECT * FROM post WHERE idSubforoRelacion = " . $idSubforo);
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
    
    public function escrituraComentario(){
        
    }

    public function desconectar() {
        $this->conexion->close();
    }

}
