<nav class="navBarPrincipal">
    <div class="principal">
        <a href="./">
        <img src="img/logoFinal.png"></a>
        <form action="buscar.php" role="search" method="post" class="buscador">
            <label for="search">Search for stuff</label>
            <input name="search" id="search" type="search" placeholder="Search..." required />
            <button type="submit">Buscar</button>
        </form>
        <div class="derecha">
            <?php if (isset($_SESSION['role'])) {
                if ($_SESSION['role'] == 3) { ?>
                    <a href="admin.php"><img src="img/admin.png" alt="Boton para acceder al panel del administrador"></a>
                <?php }
                if ($_SESSION['role'] > 1) { ?>
                    <a href="SubidaProducto.php"><img src="img/upload.png" alt="Boton para subir un producto"></a>
                <?php } ?>
                
                <a href="carrito.php"><img src="img/LogoCarrito.png" alt="Boton para abrir el carrito"></a>
            <?php } ?>
            <div class="dropdown">
                <a>
                    <img src="img/usuarioLogo.png">
                </a>
                <div class="menu">
                    <?php if (isset($_SESSION['role'])) { ?>
                        <a href="Perfil.php">Perfil</a>
                        <a href="historialMonedas.php">Historial de Monedas</a>
                        <a href="historialCarritos.php">Historial de Compras</a>
                        <a onclick="cerrarSesion()">Cerrar Sesion</a>
                    <?php } else { ?>
                        <a href="IniciarSesion.php">Iniciar Sesion</a>
                        <a href="registro.php">Registrarse</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="botones">
        <a href="noticias.php">NOTICIAS</a>
        <a href="categorias.php">CATEGORIAS</a>
        <a href="ofertas.php">OFERTAS</a>
        <a href="foros.php">FORO</a>
    </div>
</nav>