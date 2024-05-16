<h2 class="containerTittle"><?= $tittle ?></h2>
<div class="gameContainer">

    <?php
    foreach ($productos as $product) {
        $htmlFormLogin = '';
        
        if (isset($_SESSION['role'])) {
            $form = new FormularioCompra($product->id);
            $htmlFormLogin = $form->gestiona();
        }

        $procesar = '';
        if (isset($_SESSION['role'])) {
            $procesar =  "href='procesarProducto.php?producto={$product->id}'";
        }
        $descuento = '';
        if($product->descuento > 0){
            $descuento = "<span class='descuento'> {$product->descuento}%</span>";
        }
        $precio = $product->precio;
        $producto = <<<EOS
        <div>
            <a href='juego.php?id={$product->id}'>
                <img src='{$product->imagen}' alt='imagen del producto'>
                <div class="informacion">
                    <p>{$product->nombre}</p>
                    <p class='precio'> {$precio}€  {$descuento} </p>
                    {$htmlFormLogin}
                </div>
            </a>
        </div>
        EOS;

        echo $producto;
    }
    ?>
</div>