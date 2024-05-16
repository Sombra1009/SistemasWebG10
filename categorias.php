<?php
require_once 'config.php';

$cabecera = 'cabeceraBotones.php';

ob_start();
    $categorias = Categoria::getAllCategorias();
    $tittle = "CATEGORIAS";
    require 'containers/categoriasContainer.php';

$contenidoPrincipal = ob_get_clean();

require 'plantilla.php';