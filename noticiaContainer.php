
<div class="gameContainer">
    <?php
    $noticias = Noticia::getAllNoticias();
    foreach ($noticias as $noticia) {
        echo "<div>";
        echo "<a href='noticia.php?id=". $noticia->id ."'>";
        echo "<img src='" . $noticia->imagen . "' alt='imagen del producto'>";
        echo "<div class=informacion>";
        echo "<p>" . $noticia->nombre ."</p>";
        echo "</div>";
        echo "</a>";
        echo "</div>";
    }
    ?>
</div>