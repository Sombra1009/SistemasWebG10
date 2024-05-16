<?php
class Foro {

    use MagicProperties;
    private $id;
    private $idProducto;
    private $titulo;

    public static function creaForo($idProducto, $titulo){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO foro (idProducto, titulo) VALUES (%d, '%s')", $conn->real_escape_string($idProducto), $conn->real_escape_string($titulo));
        $rs = $conn->query($query);

        return $rs;
    }

    public static function getForos(){
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = "SELECT * FROM foro";
        $rs = $conn->query($query);

        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Foro($fila['id'], $fila['idProducto'], $fila['titulo']);
            }
            $rs->free();
        }

        return $result;
    }

    public static function getForoPorId($id){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM foro WHERE id = %d", $conn->real_escape_string($id));
        $rs = $conn->query($query);

        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Foro($fila['id'], $fila['idProducto'], $fila['titulo']);
            }
            $rs->free();
        }

        return $result;
    }

    public static function getForoPorIdProducto($idProducto){
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM foro WHERE idProducto = %d", $conn->real_escape_string($idProducto));
        $rs = $conn->query($query);

        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result = new Foro($fila['id'], $fila['idProducto'], $fila['titulo']);
            }
            $rs->free();
        }

        return $result;
    }

    public function changeTitulo($titulo){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE foro SET titulo = '%s' WHERE id = %d", $conn->real_escape_string($titulo), $conn->real_escape_string($this->id));
        $rs = $conn->query($query);

        return $rs;
    }

    public function borra(){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM foro WHERE id = %d", $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        return $rs;
    }

    public function __construct($id, $idProducto, $titulo) {
        $this->id = $id;
        $this->idProducto = $idProducto;
        $this->titulo = $titulo;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getIdProducto() {
        return $this->idProducto;
    }

    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }


}