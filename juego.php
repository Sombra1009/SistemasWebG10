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

<?php
   
    $product = Producto::getProduct($id);
    $carrito = Orders::buscaCarritoUser($_SESSION['id']);

?>

<body>
    <?php
    require ('cabecera.php')
        ?>
    <main>

        

        <div class="gameBuyContainer">
            <?php
            echo "<p>".$product->nombre."</p>";
            ?>
            <div>
                <div style="display: flex;">
                    <?php
                    echo "<img src='" . $product->imagen . "' alt='Portada del juego " . $product->nombre . "' class='portada'>";
                    ?>
                    <div class="buyinformacion">
                        <?php
                        echo "<p>" . $product->descripcion . "</p>";
                        echo "<p class='precio'>" . $product->precio . "€</p>";
                        ?>

                    </div>
                </div>
                <div class="buyInteracion">

                    <p>principal secundarios platino</p>
                    <p>datos</p>
                    <div>
                        <button>Guia</button>
                        <button>Trucos</button>
                        <button>Reseñas</button>
                    </div>
                    <div class="estrellas">
                        <p>Ranking</p>
                        <img src="img/estrellaLlena.png" alt="Estrella llena">
                        <img src="img/estrellaLlena.png" alt="Estrella llena">
                        <img src="img/estrellaLlena.png" alt="Estrella llena">
                        <img src="img/estrellaLlena.png" alt="Estrella llena">
                        <img src="img/estrellaLlena.png" alt="Estrella llena">

                    </div>
                    <div>
                    <?php 
                    echo "<a href ='procesarProducto.php?producto=". $product->id  ."'><button>Compra</button></a>"
                    ?>
                    
                    </div>

                </div>
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