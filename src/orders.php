<?php

class Orders
{
    use MagicProperties;


    public static function buscaPorId($id)
    {
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM Orders O WHERE O.id = %d';
        $query = sprintf($query, $id);

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Orders($fila['order_id'], $fila['mail'], $fila['order_date'], $fila['state']);
            }
            $rs->free();
        }

        return $result;
    }


    public static function buscaPorMail($mail)
    {
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM Orders O WHERE O.mail = %s AND O.state = 1';
        $query = sprintf($query, $mail);

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Orders($fila['order_id'], $fila['mail'], $fila['order_date'], $fila['state']);
            }
            $rs->free();
        }

        return $result;
    }
    public static function buscaCarritoMail($mail)
    {
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM Orders O WHERE O.mail = %s AND O.state = %d';
        $query = sprintf($query, $mail, self::CARRITO);

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Orders($fila['order_id'], $fila['mail'], $fila['order_date'], $fila['state']);
            }
            $rs->free();
        }

        return $result;
    }

    public static function compraCarrito($mail)
    {
        $result = false;

        $conn = BD::getInstance()->getConexionBd();
        $query = 'UPDATE Orders SET state = %d, order_date = NOW() WHERE mail = %s AND state = %d';
        $query = sprintf($query, self::COMPRA, $mail, self::CARRITO);

        $rs = $conn->query($query);
        if ($rs) {

            do{
                $query = 'INSERT INTO Orders (mail, state) VALUES (%s, %d)';
                $query = sprintf($query, $mail, self::CARRITO);
                $rs = $conn->query($query);
            }while(!$rs);

            if ($rs) {
                $result = true;
            }
        }

        return $result;
    }

    public const COMPRA = 1;
    public const CARRITO = 0;
    private $order_id;
    private $mail;
    private $order_date;

    private $state;

    private function __construct($order_id, $mail, $order_date, $state)
    {
        $this->order_id = $order_id;
        $this->mail = $mail;
        $this->order_date = $order_date;
        $this->state = $state;
    }

    public function getId()
    {
        return $this->order_id;
    }
    public function getMail(){
        return $this->mail;
    }
    public function getOrderDate(){
        return $this->order_date;
    }
    public function getState(){
        return $this->state;
    }
    public function setState($state){
        $this->state = $state;
    }

}