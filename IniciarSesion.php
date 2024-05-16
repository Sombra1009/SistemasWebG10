<?php
require_once 'config.php';

$form = new FormularioLogin();
$htmlFormLogin = $form->gestiona();

$contenidoPrincipal = <<<EOS
$htmlFormLogin
EOS;

$cabecera = 'cabecera.php';

require 'plantilla.php';
