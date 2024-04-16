
<div class="gameContainer">
    <?php
    $categorias = Categoria::getAllCategorias();
    foreach ($categorias as $categoria) {
        echo "<div>";
        echo "<a href='categoria.php?id=". $categoria->id ."'>";
        echo "<div class=informacion>";
        echo "<p>" . $categoria->nombre ."</p>";
        echo "</div>";
        echo "</a>";
        echo "</div>";
    }
    ?>
</div>