<header>
    <div class="titulo">
        <div class="izquierda">
            <img src="img/logoFinal.png" alt="Logotipo de la empresa como foto">
        </div>

        <div class="centro">
            <form action="index.html" method="get">
                <input class="barraBusqueda" type="text" name="q" placeholder="Buscar">
                <input type="submit" value="Buscar">
            </form>
        </div>

        <div class="derecha">
            <?php
            if (!isset($_SESSION["esAdmin"])) {
                ?>
                <a href="upload.php">AdminPanel</a>
                <?php
            }
            ?>
            <a href="index.html"><img src="img/LogoCarrito.png" alt="carrito"></a>
            <a href="login.php"><img src="img/usuarioLogo.png" alt="carrito"></a>
        </div>
    </div>

    <div class="botones">
        <a href="Practica1/bocetos.html">NOTICIAS</a>
        <a href="Practica1/miembros.html">CATEGORIAS</a>
        <a href="Practica1/detalles.html">OFERTAS</a>
        <a href="Practica1/planificacion.html">PROXIMOS JUEGOS</a>
        <a href="Practica1/planificacion.html">FORO</a>
    </div>
</header>