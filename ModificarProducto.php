<?php
require_once 'config.php';

$noticia = Producto::getProduct($_GET['id'] ?? 0);

if(!isset($_SESSION['role']) || $_SESSION['role'] < 3 || !$noticia){
    header("Location: ./");
    exit();
}



$form = new FormularioModificarProducto($noticia);
$htmlFormLogin = $form->gestiona();

$contenidoPrincipal = <<<EOS
$htmlFormLogin
EOS;

$cabecera = 'cabecera.php';

require 'plantilla.php';