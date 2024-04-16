<?php
require_once('config.php')
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
    require('cabecera.php')
        ?>
    
    <?php
    require('gameContainerDisc.php')
        ?>
    <?php
    require('gameContainerDiscLevel.php')
        ?>
    
</body>


</html>