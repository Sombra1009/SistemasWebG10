<?php
require_once 'config.php';
require_once 'src/Usuario.php';

$username = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_SPECIAL_CHARS);
$password = $_POST["password"] ?? null;

if ($username && $password) {
    $usuario = Usuario::login($username, $password);

    if ($usuario) {
        $_SESSION['id'] = $usuario->id;
        $_SESSION['username'] = $usuario->username;
        $_SESSION['role'] = $usuario->role;
        $_SESSION['usuario'] = $usuario;

        header("Location: principal.php");
        exit();
    }
}
header("Location: login.php?error=1");
exit();