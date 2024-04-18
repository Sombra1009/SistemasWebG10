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
                $result = new Orders_item($fila['id'], $fila['idOrder'], $fila['idProd']);
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
                $result[] = new Orders_item($fila['id'], $fila['idOrder'], $fila['idProd']);
            }
            $rs->free();
        }
        return $result;
    }

    public function productoAsociado(){
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM producto WHERE id = %d", $conn->real_escape_string($this->idProd));
        $rs = $conn->query($query);
        if ($rs) {
            if ($fila = $rs->fetch_assoc()) {
                $result = new Producto($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['precio'], $fila['stock'], $fila['imagen'], $fila['valoracion'], $fila['user_id'],$fila['descuento'], $fila['nivel'], $fila['fecha']);
            }
            $rs->free();
        }
        return $result;
    }
    


    private $id;
    private $idOrder;
    private $idProd;

    public function __construct($id, $idOrder, $idProd)
    {
        $this->id = $id;
        $this->idOrder = $idOrder;
        $this->idProd = $idProd;
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

}