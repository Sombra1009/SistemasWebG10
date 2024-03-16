<?php
$dao = new DAO();
?>
<div class="gameContainer">
    <?php
    $productos = $dao->getAllProducts();
    foreach ($productos as $product) {
        echo "<div>";
        echo "<img src='" . $product->imagen . "' alt='imagen del producto'>";
        echo "<div class=informacion>";
        echo "<p>" . $product->nombre . "</p>";
        echo "<p class='precio'>" . $product->precio . "€</p>";
        echo "<a>Comprar</a>";
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>