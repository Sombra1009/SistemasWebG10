<?php
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $datos = &$_POST;

    if (isset($datos['tabla'])) {
        if (isset($datos['id'])) {
            $conn = BD::getInstance()->getConexionBd();
            $query = sprintf("DELETE FROM %s WHERE id=%d", $conn->real_escape_string($datos['tabla']), $conn->real_escape_string($datos['id']));
            $rs = $conn->query($query);
            if($datos['tabla'] == 'noticia'){
                unlink('../noticias/' . $datos['id'] . '.png');
            }else if($datos['tabla'] == 'sorteo'){
                unlink('../sorteo/' . $datos['id'] . '.png');
            }
            header("Location: ../admin.php?form=" . $datos['tabla']);
            exit();
        }
    }
}