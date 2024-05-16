<?php
require_once 'config.php';


$cabecera = 'cabeceraBotones.php';
$contenidoPrincipal = '';

$i = 1;

foreach(Orders::buscaComprasUser($_SESSION['id']) as $order){
    $orderItems = $order->orderItemsAsociados();
    ob_start();
    $tittle = "Carrito ".$i;
    require 'containers/historialContainer.php';

    $contenidoPrincipal .= ob_get_clean();
    $i += 1;
}



require 'plantilla.php';
