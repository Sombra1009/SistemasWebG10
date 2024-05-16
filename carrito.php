<?php
require_once 'config.php';


$cabecera = 'cabeceraBotones.php';

ob_start();
    $orderItems = Orders::buscaCarritoUser($_SESSION['id'])->orderItemsAsociados();
    $tittle = "CATEGORIA";
    require 'containers/carritoContainer.php';

$contenidoPrincipal = ob_get_clean();

require 'plantilla.php';