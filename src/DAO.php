<?php

class DAO{
    private $BD;
    
    public function __construct(){
        $this->BD = BD::getInstance();
    }
    
    public function getAllProducts(){
        $conn = $this->BD->getConexionBd();
        $query = sprintf("SELECT * FROM `productos`");
        $rs = $conn->query($query);
        $result = [];
        if($rs){
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['cantidad'], $fila['imagen'], $fila['valoracion'],"comida");
            }
            $rs->free();
        }
        else{
            $result = false;
        }

        return $result;
    }

}