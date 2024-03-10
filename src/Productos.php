<?php

class Producto{
    
    use MagicProperties;

    function getAllProducts(){
        $result = false;
    }
    
    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $cantidad;
    private $imagen;
    private $valoracion;
    private $categoria;
    
    public function __construct($id, $nombre, $descripcion, $precio, $cantidad, $imagen, $valoracion, $categoria){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
        $this->imagen = $imagen;
        $this->valoracion = $valoracion;
        $this->categoria = $categoria;
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
    
    public function getPrecio(){
        return $this->precio;
    }
    
    public function setPrecio($precio){
        $this->precio = $precio;
    }
    
    public function getCantidad(){
        return $this->cantidad;
    }
    
    public function setCantidad($cantidad){
        $this->cantidad = $cantidad;
    }
    
    public function getImagen(){
        return $this->imagen;
    }
    
    public function setImagen($imagen){
        $this->imagen = $imagen;
    }
    
    public function getValoracion(){
        return $this->valoracion;
    }
    
    public function setValoracion($valoracion){
        $this->valoracion = $valoracion;
    }
    
    public function getCategoria(){
        return $this->categoria;
    }
    
    public function setCategoria($categoria){
        $this->categoria = $categoria;
    }

}