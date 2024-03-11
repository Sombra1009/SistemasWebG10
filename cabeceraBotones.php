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
            if (!isset($_SESSION["vendedor"])) {
                ?>
                <a href="upload.php">AdminPanel</a>
                <?php
            }
            ?>
            <a href="carrito.php"><img src="img/LogoCarrito.png" alt="carrito"></a>
            <a href="login.php"><img src="img/usuarioLogo.png" alt="carrito"></a>
        </div>
    </div>

    <div class="botones">
        <a href="noticias.php">NOTICIAS</a>
        <a href="categoria.php">CATEGORIAS</a>
        <a href="ofertas.php">OFERTAS</a>
        <a href="proximosJuegos.php">PROXIMOS JUEGOS</a>
        <a href="foro.php">FORO</a>
    </div>
</header>