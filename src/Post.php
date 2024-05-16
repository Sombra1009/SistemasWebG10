<?php
class Post {
    use MagicProperties;
    private $id;
    private $idUsuario;
    private $idForo;
    private $contenido;
    private $fecha;

    public static function creaPost($idUsuario, $idForo, $contenido){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO post (idUsuario, idForo, contenido, fecha) VALUES (%d, %d, '%s', NOW())", $conn->real_escape_string($idUsuario), $conn->real_escape_string($idForo), $conn->real_escape_string($contenido));
        $rs = $conn->query($query);

        return $rs;
    }

    public static function getPostIdForo($idForo){
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM post WHERE idForo = %d ORDER BY id DESC", $conn->real_escape_string($idForo));
        $rs = $conn->query($query);

        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Post($fila['id'], $fila['idUsuario'], $fila['idForo'], $fila['contenido'], $fila['fecha']);
            }
            $rs->free();
        }

        return $result;
    }

    public function cambiaContenido($contenido){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE post SET contenido = '%s' WHERE id = %d", $conn->real_escape_string($contenido), $conn->real_escape_string($this->id));
        $rs = $conn->query($query);

        return $rs;
    }

    public function borra(){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM post WHERE id = %d", $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        return $rs;
    }
    public function __construct($id, $idUsuario, $idForo, $contenido, $fecha) {
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->idForo = $idForo;
        $this->contenido = $contenido;
        $this->fecha = $fecha;
    }

    public function getId() {
        return $this->id;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getIdForo() {
        return $this->idForo;
    }

    public function getContenido() {
        return $this->contenido;
    }

    public function getFecha() {
        return $this->fecha;
    }

    // You can add more methods here for additional functionality

}