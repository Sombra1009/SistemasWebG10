<?php
class Orders_item{

    use MagicProperties;

    public static function crea($order_id, $product_id, $cantidad, $precio)
    {
        $m = new Orders_item($order_id, $product_id, $cantidad, $precio);
        return $m;
    }


    public static function buscaPorOrderId($order_id)
    {
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM Orders_item O WHERE O.order_id = %d';
        $query = sprintf($query, $order_id);

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Orders_item($fila['order_id'], $fila['product_id'], $fila['cantidad'], $fila['precio'], $fila['order_item_id']);
            }
            $rs->free();
        }

        return $result;
    }

    public static function buscaPorProductId($product_id)
    {
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM Orders_item O WHERE O.product_id = %d';
        $query = sprintf($query, $product_id);

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Orders_item($fila['order_id'], $fila['product_id'], $fila['cantidad'], $fila['precio'], $fila['order_item_id']);
            }
            $rs->free();
        }

        return $result;
    }

    public static function insertaProductoOrder($order_id, $product_id)
    {
        $rs = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM productos WHERE id = %d';
        $query = sprintf($query, $product_id);
        $result = $conn->query($query);
        if ($result) {
            $fila = $result->fetch_assoc();
            $precio = $fila['precio'];
            $result->free();

            $query = 'INSERT INTO Orders_item (order_id, product_id, cantidad, precio) VALUES (%d, %d, %d, %f)';
            $query = sprintf($query, $order_id, $product_id, 1, $precio);
            $rs = $conn->query($query);
        }

        return $rs;
    }

    private $order_item_id;

    private $order_id;

    private $product_id;

    private $cantidad;

    private $precio;

    private function __construct($order_id, $product_id, $cantidad, $precio, $order_item_id = null)
    {
        $this->order_id = intval($order_id);
        $this->product_id = intval($product_id);
        $this->cantidad = intval($cantidad);
        $this->precio = floatval($precio);
        $this->order_item_id = $order_item_id !== null ? intval($order_item_id) : null;
    }

    public function getOrder_item_id()
    {
        return $this->order_item_id;
    }
    public function getOrder_id()
    {
        return $this->order_id;
    }

    public function getProduct_id()
    {
        return $this->product_id;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }
    public function getprecio() {
        return $this->precio;
    }

}