<?php
require_once 'config.php';
$nombre = $_GET['nombre'];
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
    <div class="gameContainer">
        <?php
        $productos = Producto::buscaProductoPorNombre($nombre);
        foreach ($productos as $producto) {
          
            echo "<div>";
            echo "<a href='juego.php?id=". $producto->id ."'>";
            echo "<img src='" . $producto->imagen . "' alt='imagen del producto'>";
            echo "<div class=informacion>";
            echo "<p>" . $producto->nombre ."</p>";
            echo "</div>";
            echo "</a>";
            echo "</div>";
            
        }
        ?>

    </div>
    </main>
    
</body>


</html>