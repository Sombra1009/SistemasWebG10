<?php
require_once 'config.php';
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
    <div class="sesion">
        <h1>Sube tu propio juego</h1>
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Usuario o contraseña incorrectos</p>';
        }
        ?>

        <form action="procesarSubida.php" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre">
            <label for="descripcion">Descripcion:</label>
            <textarea rows="6" cols="66" id="descripcion" name="descripcion" style="color: black; border-radius: 20px; padding: 10px"></textarea>
            <label for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" placeholder="Precio">
            <label for="stock">Stock:</label>
            <input type="number" name="stock" id="stock" placeholder="Stock">
            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" id="imagen">
            <input type="submit" value="Login">
        </form>
    </div>
</body>

</html>