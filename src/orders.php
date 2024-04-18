<?php

class Orders
{
    use MagicProperties;

    public static function buscaPorId($id){
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM orders WHERE id = %d", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Orders($fila['id'], $fila['idUsuario'], $fila['estado'], $fila['fecha']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaCarritoUser($idUsuario){
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM orders WHERE idUsuario = %d AND estado = %d", $conn->real_escape_string($idUsuario), Orders::CARRITO);
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Orders($fila['id'], $fila['idUsuario'], $fila['estado'], $fila['fecha']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function buscaComprasUser($idUsuario){
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM orders WHERE idUsuario = %d AND estado = %d", $conn->real_escape_string($idUsuario), Orders::COMPRADO);
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Orders($fila['id'], $fila['idUsuario'], $fila['estado'], $fila['fecha']);
            }
            $rs->free();
        }
        return $result;
    }

    public function añadeProducto($idProducto){

        if ($this->estado == Orders::COMPRADO) {
            return false;
        }

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO orderItem (idOrder, idProd) VALUES (%d, %d)", $conn->real_escape_string($this->id), $conn->real_escape_string($idProducto));
        $rs = $conn->query($query);
        return $rs;
    }

    public function eliminaProducto($idProducto){

        if ($this->estado == Orders::COMPRADO) {
            return false;
        }

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM orderItem WHERE idOrder = %d AND idProd = %d", $conn->real_escape_string($this->id), $conn->real_escape_string($idProducto));
        $rs = $conn->query($query);
        return $rs;
    }

    public function compraCarro(){
        if ($this->estado == Orders::COMPRADO) {
            return false;
        }
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE orders SET estado = %d, fecha = NOW() WHERE id = %d", Orders::COMPRADO, $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        if($rs){
            $rs = self::crearCarro($this->idUsuario);
        }
        return $rs;
    }

    public function productosAsociados(){
        $items = Orders_Item::buscaPorIdOrder($this->id);
        $productos = [];
        foreach ($items as $item) {
            $productos[] = $item->productoAsociado();
        }
        return $productos;
    }
    public static function crearCarro($idUsuario){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO orders (idUsuario, estado, fecha) VALUES (%d, %d, NOW())", $conn->real_escape_string($idUsuario), Orders::CARRITO);
        $rs = $conn->query($query);
        return $rs;
    }

    public function __construct($id, $idUsuario, $estado, $fecha)
    {
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->estado = $estado;
        $this->fecha = $fecha;
    }

    private const COMPRADO = 1;
    private const CARRITO = 0;

    private $id;
    private $idUsuario;
    private $estado;
    private $fecha;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }
    public function getEstado()
    {
        return $this->estado;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
}