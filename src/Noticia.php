<?php

class Noticia{
    
    use MagicProperties;

    public static function buscaPorNombre($nombre){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM noticia WHERE nombre LIKE \'%s%\'';
        $query = sprintf($query, $conn->real_escape_string($nombre));

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Noticia($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['imagen']);
            }
            $rs->free();
        }

        return $result;
    }

    public static function getAllNoticias(){

        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM noticia';
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Noticia($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['imagen']);
            }
            $rs->free();
        }
        else
            $result = false;

        return $result;
    }

    public static function getNoticia($id){

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM noticia N WHERE N.id=%d", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Noticia($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['imagen']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function insertaNoticia($nombre, $descripcion, $imagen){
        $conn = BD::getInstance()->getConexionBd();
        $query = 'INSERT INTO productos (nombre, descripcion, imagen) VALUES (\'%s\', \'%s\', \'%s\')';
        $query = sprintf($query, $conn->real_escape_string($nombre), $conn->real_escape_string($descripcion), $conn->real_escape_string($imagen));

        $rs = $conn->query($query);
        if ($rs) {
            $result = $conn->insert_id;
        } else {
            $result = false;
        }

        return $result;
    }

    
    private $id;
    private $nombre;
    private $descripcion;
    private $imagen;
    
    public function __construct($id, $nombre, $descripcion, $imagen){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->imagen = $imagen;
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
    
    public function getImagen(){
        return $this->imagen;
    }
    
    public function setImagen($imagen){
        $this->imagen = $imagen;
    }

}