<?php
require_once 'config.php';
$id = $_GET['id'];

$sorteo = Sorteo::buscaPorId($id);

$htmlFormLogin = '';

if (isset($_SESSION['role']) && !Sorteo::participaSorteo($id, $_SESSION['id'])) {
    $form = new FormularioParticiparSorteo($id);
    $htmlFormLogin = $form->gestiona();
}

$cabecera = 'cabeceraBotones.php';


$contenidoPrincipal = <<<EOS
<h1 class='containerTittle'>{$sorteo->nombre}</h1>
<div class='juego'>
    <img src='{$sorteo->imagen}' alt='imagen de la noticia'>
    <p class='desc'>{$sorteo->descripcion}</p>
    <div class='juegoDer'>
        <p>¡¡¡PARTICIPA ANTES DE QUE SE CIERRE!!!</p>
        {$htmlFormLogin}
    </div>
</div>
EOS;

$productos = Producto::getAllProductsPorLevel($_SESSION['nivel'] ?? 1);
$tittle = "JUEGOS";
ob_start();
require 'containers/gameContainer.php';
$contenidoPrincipal .= ob_get_clean();

require_once 'plantilla.php';
