<?php
session_start();

require_once 'includes/config.php';
require_once 'includes/vistas/helpers/usuarios.php';
require_once 'includes/vistas/helpers/autorizacion.php';
require_once 'includes/vistas/helpers/login.php';

$tituloPagina = 'Login';

$username = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_SPECIAL_CHARS);
$password = $_POST["password"] ?? null;

if ($username && $password) {
    $usuario = Usuario::login($username, $password);

    if ($usuario) {
        $_SESSION['idUsuario'] = $usuario->id;
        $_SESSION['roles'] = $usuario->roles;
        $_SESSION['nombre'] = $usuario->mail;
        
        header("Location: principal.php");
        exit();
    } else {
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
