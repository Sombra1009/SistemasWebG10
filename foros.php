<?php
require_once 'config.php';

$cabecera = 'cabeceraBotones.php';

ob_start();
    $foros = Foro::getForos();
    $tittle = "FOROS";
    require 'containers/foroContainer.php';

$contenidoPrincipal = ob_get_clean();

require 'plantilla.php';