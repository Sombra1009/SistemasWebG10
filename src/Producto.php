<?php
class Producto{
    
    use MagicProperties;
    //devuelve todos los productos activos.
    public static function getAllProducts()
    {
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM producto");
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['stock'], $fila['imagen'], $fila['valoracion'], $fila['user_id'], $fila['descuento'], $fila['nivel'], $fila['fecha'], $fila['estado']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public function escribirTabla(){
        $categoria = Categoria::getCategoriaProducto($this->id);
        $nombre = $categoria->nombre ?? '';
        $tabla = <<<EOS
        <td> $this->id </td>
        <td> $this->nombre </td>
        <td> $this->descripcion </td>
        <td> $this->precio </td>
        <td> $this->stock </td>
        <td> $this->imagen </td>
        <td> $this->valoracion </td>
        <td> {$nombre} </td>
        <td> $this->user_id </td>
        <td> $this->descuento </td>
        <td> $this->nivel </td>
        <td> $this->fecha </td>
        <td> $this->estado </td>
        <td> <a class="modify" href="ModificarProducto.php?id={$this->id}"><img src="img/modificar.png" alt="Boton para modificar"></a> </td>
        EOS;
        return $tabla;
    }

    public static function getHeaders(){
        $result = [];
        $result[] = 'ID';
        $result[] = 'Nombre';
        $result[] = 'Descripcion';
        $result[] = 'Precio';
        $result[] = 'Stock';
        $result[] = 'Imagen';
        $result[] = 'Valoracion';
        $result[] = 'Categoria';
        $result[] = 'User_id';
        $result[] = 'Descuento';
        $result[] = 'Nivel';
        $result[] = 'Fecha';
        $result[] = 'Estado';
        return $result;
    }
    //devuelve todos los productos activos con nivel menor igual a level.
    public static function getAllProductsPorLevel($level)
    {
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM producto WHERE nivel <= %s AND estado = %d", $conn->real_escape_string($level), Producto::ACTIVO);
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['stock'], $fila['imagen'], $fila['valoracion'], $fila['user_id'], $fila['descuento'], $fila['nivel'], $fila['fecha'], $fila['estado']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    //devuelve todos los productos activos con nivel menor igual a level y con descuento mayor a 0.
    public static function getAllProductsPorLevelDescontados($level)
    {
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM producto WHERE nivel = %s AND descuento > 0 AND estado = %d", $conn->real_escape_string($level), Producto::ACTIVO);
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['stock'], $fila['imagen'], $fila['valoracion'], $fila['user_id'], $fila['descuento'], $fila['nivel'], $fila['fecha'], $fila['estado']);
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
                $result = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['stock'], $fila['imagen'], $fila['valoracion'], $fila['user_id'], $fila['descuento'], $fila['nivel'], $fila['fecha'], $fila['estado']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function creaProducto($nombre, $descripcion, $precio, $stock, $imagen, $user_id, $descuento, $nivel, $estado = Producto::ACTIVO)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $conn->begin_transaction();

        $query = sprintf("INSERT INTO producto(nombre, descripcion, precio, stock, imagen, valoracion, user_id, descuento, nivel, fecha, estado) VALUES('%s', '%s', %f, %d, '%s', 0, %d, %f, %d, NOW(), %d)"
            , $conn->real_escape_string($nombre)
            , $conn->real_escape_string($descripcion)
            , $precio
            , $stock
            , $conn->real_escape_string($imagen)
            , $user_id
            , $descuento
            , $nivel
            , $estado
        );

        
        if ( $rs = $conn->query($query) ) {
            $result = new Producto($conn->insert_id, $nombre, $descripcion, $precio, $stock, $imagen, 0, $user_id, 0, 0, $conn->query("SELECT NOW()"), Producto::ACTIVO);
            $rs = Foro::creaForo($result->id, "foro de ".$nombre);

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        if($rs){
            $conn->commit();
        }
        else{
            $result = false;
            $conn->rollback();
        }

        return $result;
    }
    //devuelve todos los productos que contengan el nombre pasado por parametro y que esten activos.
    public static function buscaProductoPorNombre($nombre)
    {
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM producto P WHERE P.nombre LIKE '%%%s%%' AND P.estado = %d", $conn->real_escape_string($nombre), Producto::ACTIVO);
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['stock'], $fila['imagen'], $fila['valoracion'], $fila['user_id'], $fila['descuento'], $fila['nivel'], $fila['fecha'], $fila['estado']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaProductoPorNombrePorNivel($nombre)
    {
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM producto P WHERE P.nombre LIKE '%%%s%%' AND P.estado = %d AND nivel <= %d", $conn->real_escape_string($nombre), Producto::ACTIVO, $_SESSION['nivel'] ?? 1);
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['stock'], $fila['imagen'], $fila['valoracion'], $fila['user_id'], $fila['descuento'], $fila['nivel'], $fila['fecha'], $fila['estado']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    //devuelve todos los productos que pertenezcan a la categoria pasada por parametro y que esten activos.
    public static function buscaProductoPorCategoria($categoria)
    {
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM producto P INNER JOIN listaCategoria L ON P.id = L.idProd WHERE L.idCategoria=%d AND P.estado = %d", $conn->real_escape_string($categoria), Producto::ACTIVO);
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['stock'], $fila['imagen'], $fila['valoracion'], $fila['user_id'], $fila['descuento'], $fila['nivel'], $fila['fecha'], $fila['estado']);
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
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['stock'], $fila['imagen'], $fila['valoracion'], $fila['user_id'], $fila['descuento'], $fila['nivel'], $fila['fecha'], $fila['estado']);
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
                $result[] = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['stock'], $fila['imagen'], $fila['valoracion'], $fila['user_id'], $fila['descuento'], $fila['nivel'], $fila['fecha'], $fila['estado']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public function borraProducto(){
        $result = true;
        $conn = BD::getInstance()->getConexionBd();
        
        if(Orders_item::buscaPorProductoComprado($this->id)){
            

            self::cambiaEstado(Producto::INACTIVO);
            $items = Orders_item::buscaPorProductoPendiente($this->id);

            $conn->begin_transaction();
            
            $query = sprintf("UPDATE producto SET estado=%d WHERE id=%d", Producto::INACTIVO, $conn->real_escape_string($this->id));
            $rs = $conn->query($query);

            foreach ($items as $item) {

                $rs = $item->borra() && $rs;
            }

            if($rs){
                $conn->commit();
            }
            else{
                $conn->rollback();
            }
            
        }
        else {
            $query = sprintf("DELETE FROM producto WHERE id=%d", $conn->real_escape_string($this->id));
            $rs = $conn->query($query);
        }

        $result = $rs;
        $rs->free();

        return $result;
    }
    public function cambiaDescuento($descuento){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE producto SET descuento=%f WHERE id=%d", $conn->real_escape_string($descuento), $conn->real_escape_string($this->id));
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
        $query = sprintf("UPDATE producto SET precio=%f WHERE id=%d", $conn->real_escape_string($precio), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public function cambiaStock($stock){

        if($stock < 0){
            return false;
        }

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE producto SET stock=%d WHERE id=%d", $conn->real_escape_string($stock), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        else{
            $this->stock = $stock;
        }
        return $result;
    }

    public function cambiaEstado($estado){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE producto SET estado=%d WHERE id=%d", $conn->real_escape_string($estado), $conn->real_escape_string($this->id));
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

    public function cambiaNombre($nombre){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE producto SET nombre='%s' WHERE id=%d", $conn->real_escape_string($nombre), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }else{
            $this->nombre = $nombre;
        }
        return $result;
    }

    public function cambiaDescripcion($descripcion){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE producto SET descripcion='%s' WHERE id=%d", $conn->real_escape_string($descripcion), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }else{
            $this->descripcion= $descripcion;
        }

        return $result;
    }

    public function cambiaUserId($user_id){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE producto SET user_id=%d WHERE id=%d", $conn->real_escape_string($user_id), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }else{
            $this->user_id = $user_id;
        }

        return $result;
    }


    private const ACTIVO = 1;
    private const INACTIVO = 0;
    
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
    private $estado;
    
    public function __construct($id, $nombre, $descripcion, $precio, $stock, $imagen, $valoracion, $user_id, $descuento, $nivel, $fecha, $estado){
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
        $this->estado = $estado;
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
        $rs = $this->precio;
        if((!isset($_SESSION['nivel']) && $this->nivel == 0) || (isset($_SESSION['nivel']) && $_SESSION['nivel'] >= $this->nivel)){
            $rs = $rs - $rs*($this->descuento/100);
        }

        return number_format($rs, 2);
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
        $rs = 0;
        if((!isset($_SESSION['nivel']) && $this->nivel == 0) || (isset($_SESSION['nivel']) && $_SESSION['nivel'] >= $this->nivel)){
            $rs = $this->descuento;
        }

        return $rs;
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

    public function getEstado(){
        return $this->estado;
    }
    public function setEstado($estado){
        $this->estado = $estado;
    }

    public function getUser_id(){
        return $this->user_id;
    }
    
    public function setUser_id($user_id){
        $this->user_id = $user_id;
    }

}
