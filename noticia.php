<?php
require_once 'config.php';
$id = $_GET['id'];

$noticia = Noticia::getNoticia($id);

$fecha = date('d-m-Y H:i:s', strtotime($noticia->fecha));

$cabecera = 'cabeceraBotones.php';

$contenidoPrincipal = <<<EOS
    <h1 class='containerTittle'>{$noticia->nombre}</h1>
    <div class='noticia'>
        <img src='{$noticia->imagen}' alt='imagen de la noticia'>
        <div>
        <h2>{$fecha}</h2>
        <p class='desc'>{$noticia->descripcion}</p>
        </div>
    </div>
EOS;

require_once 'plantilla.php';