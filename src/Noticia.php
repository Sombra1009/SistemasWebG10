<?php
class Noticia
{

    use MagicProperties;

    public static function buscaPorNombre($nombre)
    {
        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM noticia WHERE nombre = \'%s\'';
        $query = sprintf($query, $conn->real_escape_string($nombre));

        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Noticia($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['imagen'], $fila['fecha']);
            }
            $rs->free();
        }

        return $result;
    }

    public function escribirTabla()
    {
        $tabla = <<<EOS
        <td> $this->id</td>
        <td> $this->nombre </td>
        <td> $this->descripcion </td>
        <td> $this->imagen </td>
        <td> $this->fecha </td>
        <td> <a class="modify" href="ModificarNoticia.php?id={$this->id}"><img src="img/modificar.png" alt="Boton para modificar"></a> </td>
        EOS;
        return $tabla;
    }

    public static function getHeaders()
    {
        $result = [];
        $result[] = 'ID';
        $result[] = 'Nombre';
        $result[] = 'Descripcion';
        $result[] = 'Imagen';
        $result[] = 'Fecha';
        return $result;
    }
    public static function getAllNoticias()
    {

        $result = [];

        $conn = BD::getInstance()->getConexionBd();
        $query = 'SELECT * FROM noticia';
        $rs = $conn->query($query);
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Noticia($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['imagen'], $fila['fecha']);
            }
            $rs->free();
        } else
            $result = false;

        return $result;
    }

    public static function getNoticia($id)
    {

        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM noticia N WHERE N.id=%d", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Noticia($fila['id'], $fila['nombre'], $fila['descripcion'], $fila['imagen'], $fila['fecha']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function insertaNoticia($nombre, $descripcion, $imagen)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO noticia (nombre, descripcion, imagen, fecha) VALUES ('%s', '%s', '%s', NOW())", $conn->real_escape_string($nombre), $conn->real_escape_string($descripcion), $conn->real_escape_string($imagen));

        $rs = $conn->query($query);
        if ($rs) {
            $result = self::getNoticia($conn->insert_id);
        } else {
            $result = false;
        }

        return $result;
    }

    public function cambiaImagen($imagen)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE noticia SET imagen='%s' WHERE id=%d", $conn->real_escape_string($imagen), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public function cambiaNombre($nombre){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE noticia SET nombre='%s' WHERE id=%d", $conn->real_escape_string($nombre), $conn->real_escape_string($this->id));
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
        $query = sprintf("UPDATE noticia SET descripcion='%s' WHERE id=%d", $conn->real_escape_string($descripcion), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }else{
            $this->descripcion= $descripcion;
        }

        return $result;
    }


    private $id;
    private $nombre;
    private $descripcion;
    private $imagen;
    private $fecha;

    public function __construct($id, $nombre, $descripcion, $imagen, $fecha = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->imagen = $imagen;
        $this->fecha = $fecha;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

}