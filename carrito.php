<?php
require_once 'config.php';
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="es">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">

    <title>VirtualVenture</title>
</head>


<body>
    <?php
    require ('cabecera.php')
        ?>
    <main>

        <div class="carritoContainer">
            <div class="carrito">
                <p>Carrito</p>
                <?php
                $total = 0;
                $n = 0;
                $productos = Orders::buscaCarritoUser($_SESSION['id'])->productosAsociados();
                foreach ($productos as $producto) {
                    $total = $total + $producto->precio;
                    $n = $n + 1;

                    echo " <div class=juegoCarrito>";
                    echo "<img src='" . $producto->imagen . "' alt='imagen del producto' class=portada>";

                    echo "<div class=buyinformacion>";

                    echo "<p>" . $producto->nombre . "<a style='color:red' href ='procesarEliminar.php?producto=" . $producto->id . "'> Eliminar</a></p>";
                    echo "<p class=precio>" . $producto->precio . "€</p>";
                    echo "</div>";
                    echo "</div>";

                }
                ?>


            </div>
            <div class="resumen">
                <p>Resumen</p>
                <div class="buyinformacion">
                    <p><?php echo $n; ?></p>
                    <p>productos</p>
                    <p class="precio"><?php echo $total; ?>€</p>
                </div>
                <div style="display: flex;">
                    <input type="checkbox">
                    <p>Usar puntos disponibles:</p>
                    <p class="precio"><?php echo Usuario::getUsuario($_SESSION['username'])->monedas; ?></p>
                </div>
                <div style="margin-top: 40px;">
                    <div class="buyinformacion">
                        <p>Total </p>

                        <p class="precio"><?php echo $total; ?>€</p>
                    </div>
                </div>

                <button onclick="window.location.href = 'procesarCompra.php'">Comprar</button>
            </div>

        </div>




        <div class="gameBuyContainer">
            <p>Juegos similares</p>
            <?php
            require ('gameContainer.php');
            ?>
        </div>

    </main>
</body>


</html>