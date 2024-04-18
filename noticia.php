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


<body>
    <?php
    require ('cabecera.php')
        ?>
    <main>
        <?php
        $noticia = Noticia::getNoticia($id);
        ?>

        <div class="gameBuyContainer">
            <?php
            echo "<p>".$noticia->nombre."</p>";
            ?>
            <div>
                <div style="display: flex;">
                    <?php
                    echo "<img src='" . $noticia->imagen . "' alt='Portada de la noticia " . $noticia->nombre . "' class='portada'>";
                    ?>
                    <div class="buyinformacion">
                        <?php
                        echo "<p>" . $noticia->descripcion . "</p>";
                        ?>

                    </div>
                </div>
            </div>

        </div>
    </main>
</body>


</html>