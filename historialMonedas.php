<?php
require_once 'config.php';
$datos = HistorialMonedas::getHistorialMonedas($_SESSION['id']);
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

    <main class="monedas">
        <div>
            <div class="tablas">
                <h1>Historial de monedas TOTAL: <?= $_SESSION['monedas'] ?></h1>
                <h2><span class="red">GASTADO </span><span class="green"> OBTENIDO</span></h2> 
                <table>
                    <thead>
                        <tr>
                            <th> cantidad </th>
                            <th> fecha </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($datos as $dato) { ?>
                            <tr>
                            <?php
                            $fecha = date('d-m-Y H:i:s', strtotime($dato->fecha));
                            if ($dato->estado == 0) { ?>
                                <td class="red">
                            <?php } else { ?>
                                <td class="green">
                            <?php } ?>
                                 <?= $dato->monedas ?> </td>
                                <td> <?= $fecha ?> </td>
                            
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>