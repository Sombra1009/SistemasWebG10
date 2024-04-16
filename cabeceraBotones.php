<header>
    <div class="titulo">
        <div class="izquierda">
            <img src="img/logoFinal.png" alt="Logotipo de la empresa como foto">
        </div>

        <div class="centro">
            <form action="busca.php" method="get">
                <input class="barraBusqueda" type="text" name="nombre" placeholder="Buscar">
                <input type="submit" value="Buscar">
            </form>
        </div>

        <div class="derecha">
            <?php
            if (isset($_SESSION["role"]) && $_SESSION["role"] == 3) {
                ?>
                <a href="upload.php"><img src="img/admin.png" alt="boton del admin"></img></a>
                <?php
            } else if (isset($_SESSION["role"]) && $_SESSION["role"] == 2) {
                ?>
                    <a href="upload.php"><img src="img/upload.png" alt="boton de subida de videojuegos"></img></a>
                <?php
            }
            ?>
            <a <?php
           
           
            if (isset($_SESSION["role"]) && $_SESSION["role"] > 0) {
                $carrito = Orders::buscaCarritoUser($_SESSION['id']);
                echo "href='carrito.php?id=". $carrito->id ."'";
                ?><?php
            }
            ?>><img src="img/LogoCarrito.png" alt="carrito">
            </a>
            
            <a <?php
            if (!isset($_SESSION["role"])) {
                ?>href="login.php" <?php
            } else {
                ?>href="perfil.php" <?php
            }
            ?>><img src="img/usuarioLogo.png" alt="carrito"></a>
        </div>
    </div>

    <div class="botones">
        <a href="noticias.php">NOTICIAS</a>
        <a href="categorias.php">CATEGORIAS</a>
        <a href="ofertas.php">OFERTAS</a>
        <a>PROXIMOS JUEGOS</a>
        <a href="foro.php">FORO</a>
    </div>
</header>
