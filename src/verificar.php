<?php
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $datos = &$_POST;

    if(isset($datos['id'])){
        Usuario::verificarUsuario($datos['id']);
        header("Location: ../admin.php");
        exit();
    }
}

header("Location: ../");
exit();