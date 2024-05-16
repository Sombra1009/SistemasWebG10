<div class="carritoContainer">
    <div>
        <h1 class='carritoTittle'>CARRITO</h1>
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
                $form = new FormularioJuegoCarrito($producto);
                $category = $form->gestiona();
                echo $category;
            }
            ?>


        </div>
    </div>
    <div>
        <h2 class='resumenTittle'>RESUMEN</h2>
        <div class="resumen">
            <div class="buyinformacion">
                <?= $resumen ?>
            </div>
            <?php
            $form = new FormularioValidarCompra($total, $n);
            $htmlForm = $form->gestiona();

            echo $htmlForm;
            ?>
        </div>
    </div>
</div>