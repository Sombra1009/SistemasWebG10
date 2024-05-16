<?php
require_once 'config.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$foro = Foro::getForoPorId($id);

if(!$id || !$foro){
    header('Location: index.php');
    exit();
}   

$cabecera = 'cabeceraBotones.php';
$form = new FormularioSubidaPost($id);
$htmlForm = $form->gestiona(); 

$contenidoPrincipal = <<<EOS
    <h2 class="foroTittle">{$foro->titulo}</h2>
    <div class="foro">
        <div class="mensajes">
EOS;

foreach(Post::getPostIdForo($id) as $post){
    $usuario = Usuario::getUsuarioPorId($post->idUsuario);
    $contenidoPrincipal .= <<<EOS
        <div class="mensaje">
            <div class="cabeceraPost">
                <p>{$usuario->username}<span>{$post->fecha}</span></p>
            </div>
            <div class="contenidoPost">
                <p>{$post->contenido}</p>
            </div>
        </div>
EOS;
}


$contenidoPrincipal .= <<<EOS
        </div>
        {$htmlForm}
    </div>
    <script>
    function actualizarPagina() {
        location.reload();
    }
    
    setInterval(actualizarPagina, 60000);
    </script>
EOS;


require 'plantilla.php';
