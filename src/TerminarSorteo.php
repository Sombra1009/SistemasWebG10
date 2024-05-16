<?php
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $datos = &$_POST;

    if(isset($datos['id'])){
        $ganador = Sorteo::buscaPorId($datos['id'])->realizarSorteo();
        $usuario = Usuario::getUsuarioPorId($ganador);
        if($usuario){
            header("Location: ../GanadorSorteo.php?nombre='{$usuario->username}'");
            exit();
        }else{
            header("Location: ../GanadorSorteo.php?nombre=nadie");
            exit();
        }
    }else{
        header("Location: ../");
    exit();
    }
}else{
    header("Location: ../");
exit();
}


