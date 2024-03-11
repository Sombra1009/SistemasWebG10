<?php

class Producto{
    
    use MagicProperties;

    public static function buscaPorNombre($nombre){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM productos WHERE nombre LIKE \'%s%\'';
        $query = sprintf($query, $conn->real_escape_string($nombre));

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['cantidad'], $fila['imagen'], $fila['valoracion'], $fila['categoria']);
            }
            $rs->free();
        }

        return $result;
    }

    public static function getAllProducts(){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM productos';

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['cantidad'], $fila['imagen'], $fila['valoracion'], "categoria");
            }
            $rs->free();
        }
        else
            $result = false;

        return $result;
    }

    public static function buscarProductoDeCarrito($mail){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM productos P INNER JOIN order_item OI ON P.id = OI.product_id INNER JOIN orders O ON OI.order_id = O.order_id WHERE O.mail = %s AND O.state = %d';
        $query = sprintf($query, $mail, Orders::CARRITO);

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['cantidad'], $fila['imagen'], $fila['valoracion'], $fila['categoria']);
            }
            $rs->free();
        }

        return $result;
    }

    public static function buscarProductosCompradosDeUsuario($mail){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM productos P INNER JOIN order_item OI ON P.id = OI.product_id INNER JOIN orders O ON OI.order_id = O.order_id WHERE O.mail = %s AND O.state = %d';
        $query = sprintf($query, $mail, Orders::COMPRA);

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['cantidad'], $fila['imagen'], $fila['valoracion'], $fila['categoria']);
            }
            $rs->free();
        }

        return $result;
    }

    public static function insertaProducto($nombre, $descripcion, $precio, $cantidad, $imagen, $valoracion, $categoria){
        $conn = BD::getInstance()->getConexionBd();
        $query = 'INSERT INTO productos (nombre, descripcion, precio, cantidad, imagen, valoracion, categoria) VALUES (\'%s\', \'%s\', %d, %d, \'%s\', %d, %d)';
        $query = sprintf($query, $conn->real_escape_string($nombre), $conn->real_escape_string($descripcion), $precio, $cantidad, $conn->real_escape_string($imagen), $valoracion, $categoria);

        $rs = $conn->query($query);
        if ($rs) {
            $result = $conn->insert_id;
        } else {
            $result = false;
        }

        return $result;
    }

    public static function buscarProductosPorMail($mail){
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM productos P INNER JOIN order_item OI ON P.id = OI.product_id INNER JOIN orders O ON OI.order_id = O.order_id WHERE O.mail = %s AND O.state = %d';
        $query = sprintf($query, $mail, Orders::COMPRA);

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['cantidad'], $fila['imagen'], $fila['valoracion'], $fila['categoria']);
            }
            $rs->free();
        }

        return $result;
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