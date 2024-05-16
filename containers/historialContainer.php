<div class="carritoContainer">
    <div>
        <h1 class='carritoTittle'><?= $tittle ?></h1>
        <div class="carrito">
            <?php
            $total = 0;
            $n = 0;
            $resumen = "";
            foreach ($orderItems as $producto) {
                $precio = $producto->precio * $producto->cantidad;
                $total = $total + $precio;
                $n = $n + $producto->cantidad;
                $resumen .= "<p>" . Producto::getProduct($producto->idProd)->nombre . "---" . $producto->cantidad . "x" . $producto->precio . "€</p>";
                ?>
                <div class="juegoCarrito">
                    <img src='<?= $producto->productoAsociado()->imagen?>' alt='imagen del producto' class=portada>

                    <div class="item">
                        <p class="tituloItem"><?= $producto->productoAsociado()->nombre ?></p>
                        <div class="cantidad">
                            <p class="c"><?= $producto->cantidad ?></p>
                            <p class="precio"><?= $precio ?>€</p>
                        </div>

                    </div>

                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>