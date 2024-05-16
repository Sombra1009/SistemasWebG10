<?php

class Niveles{

    use MagicProperties;
    
    public static function getMaxLevel()
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT COUNT(*) FROM niveles");
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            $result = $fila['COUNT(*)'];
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    public static function getMaxXp($level)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM niveles WHERE nivel = %d", $conn->real_escape_string($level));
        $rs = $conn->query($query);
        if ($rs) {
            $fila= $rs->fetch_assoc();
            $result = $fila['xpLevel'];
            
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
  


   

    

}