<h2 class="containerTittle"><?= $tittle ?></h2>
<div class="categoriaContainer">

    <?php
    foreach ($categorias as $categoria) {
        $category = <<<EOS
        <div>
            <a href='categoria.php?id={$categoria->id }'>
                <p class="tituloNoticia">{$categoria->nombre}</p>
            </a>
        </div>
        EOS;

        echo $category;
    }
    ?>
</div>