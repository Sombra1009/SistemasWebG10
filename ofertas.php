<?php
require_once 'config.php';

$cabecera = 'cabeceraBotones.php';
$nivel = $_SESSION['nivel'] ?? 0;

ob_start();
for($i = 0; $i <= $nivel; $i++) {
    $productos = Producto::getAllProductsPorLevelDescontados($i);
    $tittle = "OFERTAS NIVEL " . $i;
    if($productos){
        require 'containers/gameContainer.php';
    }
}

$contenidoPrincipal = ob_get_clean();

require 'plantilla.php';