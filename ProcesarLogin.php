<?php

require_once 'includes/config.php';
require_once 'includes/vistas/helpers/usuarios.php';
require_once 'includes/vistas/helpers/autorizacion.php';
require_once 'includes/vistas/helpers/login.php';

$tituloPagina = 'Login';

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$password = $_POST["password"] ?? null;

$esValido = $username && $password && ($usuario = Usuario::login($username, $password));
if (!$esValido) {
	header("login.php");
}

$_SESSION['idUsuario'] = $usuario->id;
$_SESSION['roles'] = $usuario->roles;
$_SESSION['nombre'] = $usuario->mail;

header("principal.php");

require 'includes/vistas/comun/layout.php';