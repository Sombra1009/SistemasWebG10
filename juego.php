<?php
require_once 'config.php';
$id = $_GET['id'];

$producto = Producto::getProduct($id);
$htmlFormLogin = '';
$htmlFormResenna = '';

if (!$producto) {
    header("Location: ./");
    exit();
}

if (isset($_SESSION['role'])) {
    $form = new FormularioCompra($id);
    $htmlFormLogin = $form->gestiona();

    if (!Comentario::productoComentado($id, $_SESSION['id'])) {
        $formR = new FormularioResenna($id);
        $htmlFormResenna = $formR->gestiona();
    }
}
$media = number_format(Comentario::getValoracionMedia($id) ?? 0, 2);

$check1 = "";
$check2 = "";
$check3 = "";
$check4 = "";
$check5 = "";
if ($media <= 1 && $media > 0) {
    $check1 = "checked";
} else if ($media <= 2 && $media > 1) {
    $check2 = "checked";
} else if ($media <= 3 && $media > 2) {
    $check3 = "checked";
} else if ($media <= 4 && $media > 3) {
    $check4 = "checked";
} else if ($media <= 5 && $media > 4) {
    $check5 = "checked";
}

$cabecera = 'cabeceraBotones.php';

$descuento = '';
if ($producto->descuento > 0) {
    $descuento = "<span class='descuento'> {$producto->descuento}% </span>";
}
$precio = $producto->precio;

$foro = Foro::getForoPorIdProducto($producto->id);

$contenidoPrincipal = <<<EOS
    <h1 class='containerTittle'>{$producto->nombre}</h1>
    <div class='juego'>
        <img src='{$producto->imagen}' alt='imagen de la noticia'>
        <p class='desc'>{$producto->descripcion}</p>
        <div class='juegoDer'>
            <a class='foroButton' href='foro.php?id={$foro->id}'>FORO</a>
            <div class='valoracion'>
                <p>Valoración media: {$media}</p>
                <div class="rating">
                        <input type='radio' hidden  id='rating_51' value="5" data-idx='0' {$check5} disabled>	
                        <label for='rating_51'></label>
                    
                        <input type='radio' hidden id='rating_41' value="4" data-idx='1' {$check4} disabled>
                        <label for='rating_41'></label>
                    
                        <input type='radio' hidden id='rating_31' value="3" data-idx='2' {$check3} disabled>
                        <label for='rating_31'></label>
                
                        <input type='radio' hidden id='rating_21' value="2" data-idx='3' {$check2} disabled>
                        <label for='rating_21'></label>
                    
                        <input type='radio' hidden id='rating_11' value="1" data-idx='4' {$check1} disabled>
                        <label for='rating_11'></label>
                </div>
            </div>

            <h2>Precio: {$precio}€ <span> {$descuento} </span> </h2>

            {$htmlFormLogin}
        </div>
    </div>

    {$htmlFormResenna}
EOS;

ob_start();
require_once 'containers/comentariosContainer.php';
$contenidoPrincipal .= ob_get_clean();

require_once 'plantilla.php';