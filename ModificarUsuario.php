<?php
require_once 'config.php';

$usuario = Usuario::getUsuarioPorId($_GET['id'] ?? 0);

if(!isset($_SESSION['role']) || $_SESSION['role'] < 3 || !$usuario){
    header("Location: ./");
    exit();
}



$form = new FormularioModificarUsuario($usuario);
$htmlFormLogin = $form->gestiona();

$contenidoPrincipal = <<<EOS
$htmlFormLogin
EOS;

$cabecera = 'cabecera.php';

require 'plantilla.php';