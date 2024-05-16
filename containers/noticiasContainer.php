<h2 class="containerTittle"><?= $tittle ?>
</h2>

<div class="noticiasContainer">

    <?php
    foreach ($noticias as $noticia) {
        $noticiao = <<<EOS
        <div>
            <a href='noticia.php?id={$noticia->id}'>
                <img src='{$noticia->imagen}' alt='imagen de la noticia'>
                <p class="tituloNoticia">{$noticia->nombre}</p>
            </a>
        </div>
        EOS;

        echo $noticiao;
    }
    ?>
</div>