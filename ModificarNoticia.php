<?php
require_once 'config.php';

$noticia = Noticia::getNoticia($_GET['id'] ?? 0);

if(!isset($_SESSION['role']) || $_SESSION['role'] < 3 || !$noticia){
    header("Location: ./");
    exit();
}



$form = new FormularioModificarNoticia($noticia);
$htmlFormLogin = $form->gestiona();

$contenidoPrincipal = <<<EOS
$htmlFormLogin
EOS;

$cabecera = 'cabecera.php';

require 'plantilla.php';