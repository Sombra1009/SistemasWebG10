<?php

class HistorialMonedas {
    use MagicProperties;

    public static function introducirHistorialMonedas($idUsuario, $monedas, $estado) {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO historialMonedero(idUsuario, monedas, estado, fecha) VALUES('%d', '%d', '%d', NOW())",
            $conn->real_escape_string($idUsuario),
            $conn->real_escape_string($monedas),
            $conn->real_escape_string($estado));
        $rs = $conn->query($query);
        if ($rs){
            $ret = true;
        }
        else{
            $ret = false;
        }

        $rs->free();
        return $ret;
    }

    public static function getHistorialMonedas($idUsuario) {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM historialMonedero WHERE idUsuario = '%d' ORDER BY id DESC",
            $conn->real_escape_string($idUsuario));
        $rs = $conn->query($query);
        $historial = [];
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $historial[] = new HistorialMonedas($fila['id'], $fila['idUsuario'], $fila['monedas'], $fila['estado'], $fila['fecha']);
            }
        }
        $rs->free();
        return $historial;
    }

    private $id;
    private $idUsuario;
    private $monedas;
    private $estado;
    private $fecha;

    public function __construct($id, $idUsuario, $monedas, $estado, $fecha) {
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->monedas = $monedas;
        $this->estado = $estado;
        $this->fecha = $fecha;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function getMonedas() {
        return $this->monedas;
    }

    public function setMonedas($monedas) {
        $this->monedas = $monedas;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
}