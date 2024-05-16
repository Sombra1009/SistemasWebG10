<?php
require_once 'config.php';
$id = $_GET['id'];

$cabecera = 'cabeceraBotones.php';

ob_start();
    $productos = Producto::buscaProductoPorCategoria($id);
    $tittle = Categoria::getCategorias($id)->nombre;
    require 'containers/gameContainer.php';

$contenidoPrincipal = ob_get_clean();

require 'plantilla.php';