<?php
require_once('config.php');
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
    require('cabeceraBotones.php')
        ?>
    <article class="evento">
        <a><img src="./img/flechaIzq.png" class="izquierda" alt="anterior evento"></a>
        <a><img src="./img/logoFoto.jpg" class="centro" alt="evento"></a>
        <a><img src="./img/flechaDer.png" class="derecha" alt="siguiente evento"></a>
    </article>

    <?php
    require('gameContainer.php');
    ?>
</body>

</html>