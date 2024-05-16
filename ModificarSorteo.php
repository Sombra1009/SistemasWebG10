<?php
require_once 'config.php';

$usuario = Sorteo::buscaPorId($_GET['id'] ?? 0);

if(!isset($_SESSION['role']) || $_SESSION['role'] < 3 || !$usuario){
    header("Location: ./");
    exit();
}



$form = new FormularioModificarSorteo($usuario);
$htmlFormLogin = $form->gestiona();

$contenidoPrincipal = <<<EOS
$htmlFormLogin
EOS;

$cabecera = 'cabecera.php';

require 'plantilla.php';