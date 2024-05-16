<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>VirtualVenture</title>
    <script src="sweetalert2.js"></script>
    <script src="scripts.js"></script>
    <link rel="icon" type="image/x-icon" href="img/logologo.png">
</head>

<body>
    <?php
    require 'cabeceraBotones.php';
    ?>
    <?php
    $sorteos = Sorteo::buscaTodosActivos();
    require 'Carrousel.php';
    ?>

    <?php
    $productos = Producto::getAllProductsPorLevel($_SESSION['nivel'] ?? 1);
    $tittle = "JUEGOS";
    require 'containers/gameContainer.php';

    if (isset($_SESSION['role']) && !isset($_SESSION['noMostrar'])) {
        if (($_SESSION['xp'] >= Niveles::getMaxXp($_SESSION['nivel'])) && ($_SESSION['nivel'] < Niveles::getMaxLevel())) {
            $form = new FormularioPerfil();
            $form->gestiona();
            $action = htmlspecialchars($_SERVER['REQUEST_URI']);
            $subirNivel = <<<EOS
                <form action="{$action}" method="post" id="levelUpForm">
                    <input type="hidden" name="levelUp" value="levelUp">
                    <input type="hidden" name="formId" value="formularioPerfil">
                </form>
            EOS;
            echo $subirNivel; ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Enhorabuena! Tiene suficiente experiencia para subir de nivel',
                    showCloseButton: true,
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'No volver a mostrar',
                    theme: 'bootstrap-4'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("levelUpForm").submit();
                    } else if(result.dismiss === Swal.DismissReason.cancel){
                        Swal.fire("Puede proceder a subir de nivel en la sección de perfil").then((result) => {
                                window.location.href = "noMostrar.php";
                        });
                    }else{
                        Swal.fire("Puede proceder a subir de nivel en la sección de perfil")
                    }
                });
            </script>
            <?php

        }
    }
    ?>

</body>

</html>