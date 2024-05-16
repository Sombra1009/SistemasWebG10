<?php
require_once 'config.php';

$cabecera = 'cabeceraBotones.php';
$nivel = $_SESSION['nivel'] ?? 0;

ob_start();
    $noticias = Noticia::getAllNoticias();
    $tittle = "NOTICIAS";
    if($noticias){
        $tittle = "NOTICIAS";
        
    } else {
        $tittle = "NO HAY NOTICIAS";
    }

    require 'containers/noticiasContainer.php';

$contenidoPrincipal = ob_get_clean();

require 'plantilla.php';