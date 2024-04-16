<?php
class Categoria{
    use MagicProperties;


    public static function getAllCategorias()
    {
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = "SELECT * FROM categoria";
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                
                $result[] = new Categoria($fila['id'], $fila['nombre'], $fila['descripcion']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function getFromCategorias($id)
    {
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM categoriaLista WHERE idCategoria=\'%s\'';
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                
                $result[] = new Categoria($fila['id'], $fila['nombre'], $fila['descripcion']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function getCategorias($id){
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM categoria WHERE id=\'%s\'';
        $query = sprintf($query, $conn->real_escape_string($id));

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result = new Categoria($fila['id'], $fila['nombre'], $fila['descripcion']);
            }
            $rs->free();
        }

        return $result;
    }

    private $id;
    private $nombre;
    private $descripcion;

    public function __construct($id, $nombre, $descripcion){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }
}