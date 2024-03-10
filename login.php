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
        <h1>Inicio de sesión</h1>

        <form action="login.php" method="post">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" placeholder="Usuario">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" placeholder="Password">
            <p>¿No tienes cuenta? <a href="registro.php">Crear cuenta</a></p>
            <input type="submit" value="Login">
        </form>
    </div>
</body>

</html>