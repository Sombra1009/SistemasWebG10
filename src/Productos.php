<?php
class Producto{
    
    use MagicProperties;

    public static function getAllProducts()
    {
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = "SELECT * FROM producto";
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['stock'], $fila['imagen'], $fila['valoracion'], $fila['user_id'], $fila['descuento'], $fila['nivel'], $fila['fecha']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function getProduct($id)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM producto P WHERE P.id=%d", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['stock'], $fila['imagen'], $fila['valoracion'], $fila['user_id'], $fila['descuento'], $fila['nivel'], $fila['fecha']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function creaProducto($nombre, $descripcion, $precio, $stock, $imagen, $user_id)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO producto(nombre, descripcion, precio, stock, imagen, valoracion, user_id, descuento, nivel, fecha) VALUES('%s', '%s', %f, %d, '%s', %d, %d, 0, 1, NOW())"
            , $conn->real_escape_string($nombre)
            , $conn->real_escape_string($descripcion)
            , $precio
            , $stock
            , $imagen
            , $user_id
            , $conn
        );
        if ( $conn->query($query) ) {
            $result = new Producto($conn->insert_id, $nombre, $descripcion, $precio, $stock, $imagen, 0, $user_id, 0, 0, $conn->query("SELECT NOW()"));
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaProductoPorNombre($nombre)
    {
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM producto P WHERE P.nombre LIKE '%%%s%%'", $conn->real_escape_string($nombre));
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['stock'], $fila['imagen'], $fila['valoracion'], $fila['user_id'], $fila['descuento'], $fila['nivel'], $fila['fecha']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaProductoPorCategoria($categoria)
    {
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM producto P INNER JOIN listaCategoria L ON P.id = L.idProd WHERE L.idCategoria=%d", $conn->real_escape_string($categoria));
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['stock'], $fila['imagen'], $fila['valoracion'], $fila['user_id'], $fila['descuento'], $fila['nivel'], $fila['fecha']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaProductoPorUsuario($username)
    {
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM producto P INNER JOIN usuario U ON P.user_id = U.id WHERE U.username='%s'", $conn->real_escape_string($username));
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['stock'], $fila['imagen'], $fila['valoracion'], $fila['user_id'], $fila['descuento'], $fila['nivel'], $fila['fecha']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function getAllDiscountedProducts()
    {
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = "SELECT * FROM producto WHERE descuento > 0 ORDER BY nivel ASC";
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['stock'], $fila['imagen'], $fila['valoracion'], $fila['user_id'], $fila['descuento'], $fila['nivel'], $fila['fecha']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public function borraProducto(){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM producto WHERE id=%d", $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public function cambiaDescuento($descuento){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE producto SET descuento=%d WHERE id=%d", $conn->real_escape_string($descuento), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public function cambiaNivel($nivel){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE producto SET nivel=%d WHERE id=%d", $conn->real_escape_string($nivel), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public function cambiaPrecio($precio){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE producto SET precio=%d WHERE id=%d", $conn->real_escape_string($precio), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public function cambiaStock($stock){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE producto SET stock=%d WHERE id=%d", $conn->real_escape_string($stock), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public function decrementaStock($cantidad){
        $this->cambiaStock($this->stock - $cantidad);
    }

    public function cambiaValoracion($valoracion){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE producto SET valoracion=%d WHERE id=%d", $conn->real_escape_string($valoracion), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public function cambiaImagen($imagen){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE producto SET imagen='%s' WHERE id=%d", $conn->real_escape_string($imagen), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $imagen;
    private $valoracion;
    private $user_id;
    private $descuento;
    private $nivel;
    private $fecha;
    
    public function __construct($id, $nombre, $descripcion, $precio, $stock, $imagen, $valoracion, $user_id, $descuento, $nivel, $fecha){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->imagen = $imagen;
        $this->valoracion = $valoracion;
        $this->user_id = $user_id;
        $this->descuento = $descuento;
        $this->nivel = $nivel;
        $this->fecha = $fecha;
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
    
    public function getstock(){
        return $this->stock;
    }
    
    public function setstock($stock){
        $this->stock = $stock;
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
    
    public function getDescuento(){
        return $this->descuento;
    }
    public function setDescuento($descuento){
        $this->descuento = $descuento;
    }
    public function getNivel(){
        return $this->nivel;
    }
    public function setNivel($nivel){
        $this->nivel = $nivel;
    }
    public function getFecha(){
        return $this->fecha;
    }
    public function setFecha($fecha){
        $this->fecha = $fecha;
    }

}
