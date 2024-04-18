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
        <h1>CREAR CUENTA</h1>

        <p>Regístrese para acceder a sus claves, interactuar en el foro y poder comprar sus juegos favoritos</p>

        <form action="ProcesarRegistro.php" method="post">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" placeholder="Usuario" required>
            <label for="mail">Correo electrónico:</label>
            <input type="text" name="mail" id="mail" placeholder="Correo electrónico" required>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" placeholder="Contraseña" required>
            <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
            <input type="submit" value="Registrarse">
        </form>


        <p>Al crear una cuenta, aceptas nuestros <a href="img/servicio.pdf">Términos de servicio</a> y <a href="img/privacidad.pdf">Política de privacidad</a></p>
    </div>
</body>

</html>