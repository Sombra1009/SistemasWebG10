<h2 class="containerTittle"><?= $tittle ?></h2>
<div class="foroContainer">

    <?php
    foreach ($foros as $foro) {
        $imagen = Producto::getProduct($foro->idProducto)->imagen;
        $div = <<<EOS
        <div>
            <a href='foro.php?id={$foro->id}'>
                <img src='{$imagen}' alt='imagen del foro'>
                <p class="tituloForo">{$foro->titulo}</p>
            </a>
        </div>
        EOS;
        echo $div;
    }
    ?>
</div>