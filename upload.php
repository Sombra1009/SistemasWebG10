<?php
session_start();
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
        <h1>Subir foto</h1>

        <form action="subida.php" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Subir archivo" name="submit">
        </form>
    </div>
</body>

</html>