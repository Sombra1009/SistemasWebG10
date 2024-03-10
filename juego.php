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
    <main>
        
    <div class="gameBuyContainer">
        <p>Nombre</p>
            <div>
            <div style="display: flex;">
                <img src="img/logoFoto.jpg" alt="Logotipo de la empresa como foto" class="portada">
                <div class="buyinformacion">
                   <p>descripcion</p>
                    <p class="precio">10<span>,57</span>€</p>
                    
                </div>
            </div>
            <div class="buyInteracion">
                
                    <p>principal secundarios platino</p>
                    <p>datos</p>
                    <div >
                        <button>Guia</button> 
                        <button>Trucos</button>
                        <button>Reseñas</button>
                    </div>
                    <div class="estrellas" >
                        <p>Ranking</p>
                        <img src="img/estrellaLlena.png" alt="Estrella llena" >
                        <img src="img/estrellaLlena.png" alt="Estrella llena" >
                        <img src="img/estrellaLlena.png" alt="Estrella llena" >
                        <img src="img/estrellaLlena.png" alt="Estrella llena" >
                        <img src="img/estrellaLlena.png" alt="Estrella llena" >
                       
                    </div>
                    <div >
                        <button>Comprar</button>
                    </div>
                
            </div>
       </div>

    </div>

    <div class="gameBuyContainer">
        <p>Juegos similares</p>
        <div class="gameContainer">
            <div>
                <img src="img/logoFoto.jpg" alt="Logotipo de la empresa como foto">
                <div class=informacion>
                    <p>Producto 1</p>
                    <p class="precio">10<span>,57</span>€</p>
                    <button>Comprar</button>
                </div>
            </div>
            <div>
                <img src="img/logoFoto.jpg" alt="Logotipo de la empresa como foto">
                <div class=informacion>
                    <p>Producto 1</p>
                    <p class="precio">10<span>,57</span>€</p>
                    <button>Comprar</button>
                </div>
            </div>
            <div>
                <img src="img/logoFoto.jpg" alt="Logotipo de la empresa como foto">
                <div class=informacion>
                    <p>Producto 1</p>
                    <p class="precio">10<span>,57</span>€</p>
                    <button>Comprar</button>
                </div>
            </div>
            <div>
                <img src="img/logoFoto.jpg" alt="Logotipo de la empresa como foto">
                <div class=informacion>
                    <p>Producto 1</p>
                    <p class="precio">10<span>,57</span>€</p>
                    <button>Comprar</button>
                </div>
            </div>
            <div>
                <img src="img/logoFoto.jpg" alt="Logotipo de la empresa como foto">
                <div class=informacion>
                    <p>Producto 1</p>
                    <p class="precio">10<span>,57</span>€</p>
                    <button>Comprar</button>
                </div>
            </div>
        </div>
    </div>

       
        
        <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
        <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
        <p>Prueba</p>
    </main>
</body>


</html>