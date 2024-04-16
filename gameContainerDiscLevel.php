
<div class="gameContainer">
    <?php
    $productos = Producto::getAllDiscountedProducts();
    foreach ($productos as $product) {
        if($product->descuento > 0){
            if(isset($_SESSION['id']) && $product->nivel <= $_SESSION['usuario']->nivel) {
                echo "<div>";
                echo "<a href='juego.php?id=". $product->id ."'>";
                echo "<img src='" . $product->imagen . "' alt='imagen del producto'>";
                echo "<div class=informacion>";
                echo "<p>" . $product->nombre ."</p>";
                echo "<p class='precio'>" . $product->precio . "€</p>";
                echo '<form action="carrito.php" method="post">
                <input type="hidden" name="url_destino" value="pagina_destino.php">
                <button type="submit">Comprar</button>
                </form>';
                echo "</div>";
                echo "</a>";
                echo "</div>";
            }
        }
    }
    ?>
</div>
