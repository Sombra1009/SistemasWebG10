<?php
class Orders_item{

    use MagicProperties;



    public static function buscaPorId($id){
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM orderItem WHERE id = %d", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Orders_item($fila['id'], $fila['idOrder'], $fila['idProd'], $fila['cantidad'], $fila['estado'], $fila['precio']);
            }
            $rs->free();
        }
        return $result;
    }



    public static function buscaPorIdOrder($idOrder){
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM orderItem WHERE idOrder = %d", $conn->real_escape_string($idOrder));
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Orders_item($fila['id'], $fila['idOrder'], $fila['idProd'], $fila['cantidad'], $fila['estado'], $fila['precio']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorIdOrderProducto($idOrder, $idProd){
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM orderItem WHERE idOrder = %d AND idProd = %d", $conn->real_escape_string($idOrder), $conn->real_escape_string($idProd));
        $rs = $conn->query($query);
        if ($rs) {
            if ($fila = $rs->fetch_assoc()) {
                $result = new Orders_item($fila['id'], $fila['idOrder'], $fila['idProd'], $fila['cantidad'], $fila['estado'], $fila['precio']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorProducto($idProd){
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM orderItem WHERE idProd = %d", $conn->real_escape_string($idProd));
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Orders_item($fila['id'], $fila['idOrder'], $fila['idProd'], $fila['cantidad'], $fila['estado'], $fila['precio']);
            }
            $rs->free();
        }
        return $result;
    }
    public static function buscaPorProductoPendiente($idProd){
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM orderItem WHERE idProd = %d AND estado = %d", $conn->real_escape_string($idProd), Orders_item::PENDIENTE);
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Orders_item($fila['id'], $fila['idOrder'], $fila['idProd'], $fila['cantidad'], $fila['estado'], $fila['precio']);
            }
            $rs->free();
        }
        return $result;
    }

    public function decrementaCantidad(){
        if($this->cantidad == 1){
            return $this->borra();
        }

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE orderItem SET cantidad = cantidad - 1 WHERE id = %d", $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        if($rs){
            $this->cantidad = $this->cantidad - 1;
        }
        return $rs;
    }

    public function incrementaCantidad(){        
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE orderItem SET cantidad = cantidad + 1 WHERE id = %d", $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        if($rs){
            $this->cantidad = $this->cantidad + 1;
        }
        return $rs;
    }

    public function productoAsociado(){
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM producto WHERE id = %d", $conn->real_escape_string($this->idProd));
        $rs = $conn->query($query);
        if ($rs) {
            if ($fila = $rs->fetch_assoc()) {
                $result = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['stock'], $fila['imagen'], $fila['valoracion'], $fila['user_id'],$fila['descuento'], $fila['nivel'], $fila['fecha'], $fila['estado']);
            }
            $rs->free();
        }
        return $result;
    }

    public function actualizaPrecio(){
        $result = false;
        $pr = Producto::getProduct($this->idProd);
        if($pr){
            $precio = $pr->precio;
            $result = true;
        }
        return $result;
    }

    public function borra(){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM orderItem WHERE id = %d", $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        return $rs;
    }

    public static function buscaPorProductoComprado($idProd){
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM orderItem WHERE idProd = %d AND estado = 'comprado'", $conn->real_escape_string($idProd));
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Orders_item($fila['id'], $fila['idOrder'], $fila['idProd'], $fila['cantidad'], $fila['estado'], $fila['precio']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaPorProductoYOrderPendiente($idProd, $idOrder){
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM orderItem WHERE idProd = %d AND idOrder = %d AND estado = %d", $conn->real_escape_string($idProd), $conn->real_escape_string($idOrder), Orders_item::PENDIENTE);
        $rs = $conn->query($query);
        if ($rs) {
            if ($fila = $rs->fetch_assoc()) {
                $result = new Orders_item($fila['id'], $fila['idOrder'], $fila['idProd'], $fila['cantidad'], $fila['estado'], $fila['precio']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function annadeProducto($idOrder, $idProd){
        $conn = BD::getInstance()->getConexionBd();
        $query = "";
        $pr = Producto::getProduct($idProd);
        $precio = $pr->precio;
        if ($oi = Orders_item::buscaPorProductoYOrderPendiente($idProd, $idOrder)) {
            $rs = $oi->incrementaCantidad();
        }
        else{
            $query = sprintf("INSERT INTO orderItem (idOrder, idProd, cantidad, estado, precio) VALUES (%d, %d, %d, %d, %f)", $conn->real_escape_string($idOrder), $conn->real_escape_string($idProd), 1, Orders_item::PENDIENTE, $precio);
            $rs = $conn->query($query);
        }  
        

        return $rs;
    }
    
    public static function compraCarro($idOrder){
        $conn = BD::getInstance()->getConexionBd();
        $conn->begin_transaction();
        $query = sprintf("UPDATE orderItem SET estado = %d WHERE idOrder = %d", Orders_item::COMPRADO, $conn->real_escape_string($idOrder));
        $rs = $conn->query($query);

        $items = Orders_item::buscaPorIdOrder($idOrder);
        foreach ($items as $item) {
            $pr = Producto::getProduct($item->getIdProd());
            $rs = $rs && $pr->cambiaStock($pr->getStock() - $item->getCantidad());
        }

        if($rs){
            $conn->commit();
        }
        else{
            $conn->rollback();
        }
        
        return $rs;
    }


    private $id;
    private $idOrder;
    private $idProd;
    private $cantidad;
    private $estado;
    private $precio;

    private const PENDIENTE = 0;
    private const COMPRADO = 1;

    public function __construct($id, $idOrder, $idProd, $cantidad, $estado, $precio)
    {
        $this->id = $id;
        $this->idOrder = $idOrder;
        $this->idProd = $idProd;
        $this->cantidad = $cantidad;
        $this->estado = $estado;
        $this->precio = $precio;
    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getIdOrder(){
        return $this->idOrder;
    }
    public function setIdOrder($idOrder){
        $this->idOrder = $idOrder;
    }
    public function getIdProd(){
        return $this->idProd;
    }
    public function setIdProd($idProd){
        $this->idProd = $idProd;
    }
    public function getCantidad(){
        return $this->cantidad;
    }
    public function setCantidad($cantidad){
        $this->cantidad = $cantidad;
    }
    public function getEstado(){
        return $this->estado;
    }
    public function setEstado($estado){
        $this->estado = $estado;
    }
    public function getPrecio(){
        return $this->precio;
    }
    public function setPrecio($precio){
        $this->precio = $precio;
    }

}