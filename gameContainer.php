
<div class="gameContainer">
    <?php
    $productos = Producto::getAllProducts();
    foreach ($productos as $product) {
        echo "<div>";
        echo "<a href='juego.php?id=". $product->id ."'>";
        echo "<img src='" . $product->imagen . "' alt='imagen del producto'>";
        echo "<div class=informacion>";
        echo "<p>" . $product->nombre ."</p>";
        echo "<p class='precio'>" . $product->precio . "€</p>";
        echo "<a href ='procesarProducto.php?producto=". $product->id  ."'><button>Compra</button></a>";
        echo "</div>";
        echo "</a>";
        echo "</div>";
    }
    ?>
</div>