<?php

class Comentario{

    use MagicProperties;

    public static function productoComentado($idProducto, $idUsuario){
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM comentario WHERE idProducto = %d AND idUsuario = %d", $conn->real_escape_string($idProducto), $conn->real_escape_string($idUsuario));
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = true;
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    } 

    public static function getComentarios($idProducto) {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM comentario WHERE idProducto = '%d' ORDER BY id DESC",
            $conn->real_escape_string($idProducto));
        $rs = $conn->query($query);
        $comentarios = [];
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $comentarios[] = new Comentario($fila['id'], $fila['idUsuario'], $fila['idProducto'], $fila['contenido'], $fila['valoracion'], $fila['fecha']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $comentarios;
    }

    public static function getValoracionMedia($idProducto) {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT AVG(valoracion) as media FROM comentario WHERE idProducto = '%d'",
            $conn->real_escape_string($idProducto));
        $rs = $conn->query($query);
        $media = 0;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $media = $fila['media'];
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $media;
    }

    public static function getComentario($id){
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM comentario WHERE id = %d", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Comentario($fila['id'], $fila['idUsuario'], $fila['idProducto'], $fila['contenido'], $fila['valoracion'], $fila['fecha']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    public static function introducirComentario($idUsuario, $idProducto, $contenido, $valoracion) {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO comentario(idUsuario, idProducto, contenido, valoracion, fecha) VALUES('%d', '%d', '%s', '%d', NOW())",
            $conn->real_escape_string($idUsuario),
            $conn->real_escape_string($idProducto),
            $conn->real_escape_string($contenido),
            $conn->real_escape_string($valoracion));
        $rs = $conn->query($query);
        if ($rs){
            $result = self::getComentario($conn->insert_id);
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }

    private $id;
    private $idUsuario;
    private $idProducto;
    private $contenido;
    private $valoracion;
    private $fecha;

    public function __construct($id, $idUsuario, $idProducto, $contenido, $valoracion, $fecha) {
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->idProducto = $idProducto;
        $this->contenido = $contenido;
        $this->valoracion = $valoracion;
        $this->fecha = $fecha;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function getIdProducto() {
        return $this->idProducto;
    }

    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    public function getContenido() {
        return $this->contenido;
    }

    public function setContenido($contenido) {
        $this->contenido = $contenido;
    }

    public function getValoracion() {
        return $this->valoracion;
    }

    public function setValoracion($valoracion) {
        $this->valoracion = $valoracion;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
}