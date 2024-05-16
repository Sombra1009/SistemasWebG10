<?php
require_once 'config.php';

$nombre = $_POST['search'] ?? '';

$cabecera = 'cabeceraBotones.php';

ob_start();
$productos = Producto::buscaProductoPorNombrePorNivel($nombre);
$tittle = "JUEGOS";
require 'containers/gameContainer.php';

$contenidoPrincipal = ob_get_clean();

require 'plantilla.php';