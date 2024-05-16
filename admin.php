<?php
require_once 'config.php';
$form = $_GET['form'] ?? '';

if ($form == 'producto') {
    $formSubida = "SubidaProducto.php";
    $tabla = 'producto';
    $head = Producto::getHeaders();
    $datos = Producto::getAllProducts();
} else if ($form == 'noticia') {
    $formSubida = "SubidaNoticia.php";
    $tabla = 'noticia';
    $head = Noticia::getHeaders();
    $datos = Noticia::getAllNoticias();
} else if ($form == 'sorteo') {
    $formSubida = "SubidaSorteo.php";
    $tabla = 'sorteo';
    $head = Sorteo::getHeaders();
    $datos = Sorteo::getAllSorteos();
} else {
    $formSubida = "SubidaUsuario.php";
    $tabla = 'usuario';
    $head = Usuario::getHeaders();
    $datos = Usuario::getAllUsuarios();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VirtualVenture</title>
    <link rel="stylesheet" href="style.css">
    <script src="sweetalert2.js"></script>
    <script src="scripts.js"></script>
    <link rel="icon" type="image/x-icon" href="img/logologo.png">
</head>

<body>

    <?php
    require 'cabecera.php';
    ?>

    <main class="admin">
        <nav>
            <ul>
                <li><a href="admin.php">Usuarios</a></li>
                <li><a href="admin.php?form=producto">Productos</a></li>
                <li><a href="admin.php?form=noticia">Noticias</a></li>
                <li><a href="admin.php?form=sorteo">Sorteos</a></li>
            </ul>
        </nav>
        <div>
            <div class="tablas">
                <a class="add" href="<?= $formSubida ?>">Añadir</a>
                <table>
                    <thead>
                        <tr>
                            <?php
                            foreach ($head as $dato) { ?>
                                <th> <?= $dato ?> </th>
                            <?php } ?>

                            <th> Modificar </th>
                            <th> Eliminar </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($datos as $dato) { ?>
                            <tr>
                                <?php
                                echo $dato->escribirTabla(); ?>
                                
                                <td>
                                    <div>
                                        <form action="src/borrar.php" method="post" id="deleteForm<?= $dato->id?>">
                                            <input type="hidden" name="id" value="<?= $dato->id ?>" />
                                            <input type="hidden" name="tabla" value="<?= $tabla ?>" />
                                            <button class="delete" type="button" onclick="confirmarDelete(<?= $dato->id?>)">
                                                <span class="button__text">Delete</span>
                                                <span class="button__icon"><svg class="svg" height="512"
                                                        viewBox="0 0 512 512" width="512"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <title></title>
                                                        <path
                                                            d="M112,112l20,320c.95,18.49,14.4,32,32,32H348c17.67,0,30.87-13.51,32-32l20-320"
                                                            style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px">
                                                        </path>
                                                        <line
                                                            style="stroke:#fff;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px"
                                                            x1="80" x2="432" y1="112" y2="112"></line>
                                                        <path
                                                            d="M192,112V72h0a23.93,23.93,0,0,1,24-24h80a23.93,23.93,0,0,1,24,24h0v40"
                                                            style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px">
                                                        </path>
                                                        <line
                                                            style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"
                                                            x1="256" x2="256" y1="176" y2="400"></line>
                                                        <line
                                                            style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"
                                                            x1="184" x2="192" y1="176" y2="400"></line>
                                                        <line
                                                            style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"
                                                            x1="328" x2="320" y1="176" y2="400"></line>
                                                    </svg></span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>