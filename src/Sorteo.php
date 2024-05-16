<?php

class Sorteo{

    use MagicProperties;

    private $id;
    private $nombre;
    private $descripcion;
    private $imagen;
    private $estado;
    private $idProd;
    private $fecha;

    public static function buscaTodosActivos(){
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM sorteo WHERE estado = %d", $conn->real_escape_string(Sorteo::ACTIVO));
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Sorteo($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['imagen'], $fila['estado'], $fila['idProd'], $fila['fecha']);
            }
            $rs->free();
        }
        return $result;
    }

    public function escribirTabla(){
        $tabla = <<<EOS
        <td> $this->id </td>
        <td> $this->nombre </td>
        <td> $this->descripcion </td>
        <td> $this->imagen </td>
        <td> $this->estado </td>
        <td> $this->idProd </td>
        EOS;
        if ($this->estado == 1){
            $tabla .= <<<EOS
            <td>
                <form action="src/TerminarSorteo.php" method="post">
                    <input type="hidden" name="id" value="$this->id">
                    <input class="add" type="submit" value="Terminar">
                </form>
            </td>
            EOS;
        }
        else{
            $tabla .= <<<EOS
            <td>
            </td>
            EOS;
        }

        $tabla .= <<<EOS
            <td> <a class="modify" href="ModificarSorteo.php?id={$this->id}"><img src="img/modificar.png" alt="Boton para modificar"></a> </td>
        EOS;
        return $tabla;
    }

    public static function getHeaders(){
        $result = [];
        $result[] = 'ID';
        $result[] = 'Nombre';
        $result[] = 'Descripcion';
        $result[] = 'Imagen';
        $result[] = 'Estado';
        $result[] = 'ID Producto';
        $result[] = 'Terminar Sorteo';
        return $result;
    }

    public static function getAllSorteos(){
        $result = [];
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM sorteo");
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Sorteo($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['imagen'], $fila['estado'], $fila['idProd'], $fila['fecha']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function participaSorteo($idSorteo, $idUsuario){
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM listaSorteo WHERE idSorteo = %d AND idUsuario = %d", $conn->real_escape_string($idSorteo), $conn->real_escape_string($idUsuario));
        $rs = $conn->query($query);
        if ($rs->num_rows > 0) {
            $result = true;
        }
        $rs->free();
        return $result;
    }

    public static function buscaPorId($id){
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM sorteo WHERE id = %d", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Sorteo($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['imagen'], $fila['estado'], $fila['idProd'], $fila['fecha']);
            }
            $rs->free();
        }
        return $result;
    }

    public static function nuevoSorteo($nombre, $descripcion, $imagen, $idProd, $estado){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO sorteo (nombre, descripcion, imagen, estado, idProd, fecha) VALUES ('%s', '%s', '%s', %d, %d, NOW())", $conn->real_escape_string($nombre), $conn->real_escape_string($descripcion), $conn->real_escape_string($imagen), $conn->real_escape_string($estado), $conn->real_escape_string($idProd));
        $rs = $conn->query($query);
        if ($rs) {
            $id = $conn->insert_id;
            $result = new Sorteo($id, $nombre, $descripcion, $imagen, $estado, $idProd, $conn->query("SELECT NOW()"));
        } else {
            $result = false;
        }
        return $result;
        
    }


    public function realizarSorteo(){
        $conn = BD::getInstance()->getConexionBd();

        $conn->begin_transaction();

        $query = sprintf("UPDATE sorteo SET estado = %d WHERE id = %d", $conn->real_escape_string(Sorteo::INACTIVO), $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        $this->estado = Sorteo::INACTIVO;
        $query = sprintf("SELECT * FROM listaSorteo WHERE idSorteo = %d ORDER BY RAND() LIMIT 1", $conn->real_escape_string($this->id));
        $rs = $conn->query($query);


        $query = sprintf("DELETE FROM listaSorteo WHERE idSorteo = %d", $conn->real_escape_string($this->id));
        $conn->query($query);

        if($rs){
            $conn->commit();
            $result = $rs->fetch_assoc()['idUsuario'];
            $rs->free();
        }
        else{
            $conn->rollback();
            $result = false;
        }

        
        return $result;
    }

    public function compruebaUsuario($idUsuario){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM listaSorteo WHERE idSorteo = %d AND idUsuario = %d", $conn->real_escape_string($this->id), $conn->real_escape_string($idUsuario));
        $rs = $conn->query($query);
        if ($rs->num_rows > 0) {
            // El usuario está en la tabla
            $result = true;
        } else {
            // El usuario no está en la tabla
            $result = false;
        }
        
        $rs->free();
        return $result;
    }

    public function annadeUsuario($idUsuario){
        $rs = $this->compruebaUsuario($idUsuario);
        if(!$rs){
            $conn = BD::getInstance()->getConexionBd();
            $query = sprintf("INSERT INTO listaSorteo (idSorteo, idUsuario) VALUES (%d, %d)", $conn->real_escape_string($this->id), $conn->real_escape_string($idUsuario));
            $rs = $conn->query($query);
        }
        return $rs;
    }

    public function eliminaUsuario($idUsuario){
        $rs = $this->compruebaUsuario($idUsuario);
        if($rs){
            $conn = BD::getInstance()->getConexionBd();
            $query = sprintf("DELETE FROM listaSorteo WHERE idSorteo = %d AND idUsuario = %d", $conn->real_escape_string($this->id), $conn->real_escape_string($idUsuario));
            $rs = $conn->query($query);
        }
        return $rs;
    }

    public function cambiaImagen($imagen){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE sorteo SET imagen = '%s' WHERE id = %d", $conn->real_escape_string($imagen), $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        return $rs;
    }

    public function cambiaNombre($nombre){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE sorteo SET nombre = '%s' WHERE id = %d", $conn->real_escape_string($nombre), $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        return $rs;
    }

    public function cambiaDescripcion($descripcion){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE sorteo SET descripcion = '%s' WHERE id = %d", $conn->real_escape_string($descripcion), $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        return $rs;
    }

    public function cambiaIdProducto($idProducto){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE sorteo SET idProd = %d WHERE id = %d", $conn->real_escape_string($idProducto), $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        return $rs;
    }

    public function cambiaEstado($estado){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE sorteo SET estado = %d WHERE id = %d", $conn->real_escape_string($estado), $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        return $rs;
    }

    private const ACTIVO = 1;
    private const INACTIVO = 0;
    
    public function __construct($id, $nombre, $descripcion, $imagen, $estado, $idProd, $fecha){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->imagen = $imagen;
        $this->estado = $estado;
        $this->idProd = $idProd;
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
    public function getImagen(){
        return $this->imagen;
    }
    public function setImagen($imagen){
        $this->imagen = $imagen;
    }
    public function getEstado(){
        return $this->estado;
    }
    public function setEstado($estado){
        $this->estado = $estado;
    }
    public function getIdProd(){
        return $this->idProd;
    }
    public function setIdProd($idProd){
        $this->idProd = $idProd;
    }
    public function getFecha(){
        return $this->fecha;
    }
    public function setFecha($fecha){
        $this->fecha = $fecha;
    }

}