<?php
require_once 'config.php';
require_once 'src/Usuario.php';
$mail = $_POST['mail'];
$usuario = $_POST['usuario'];
$password = $_POST['password'];

if($user = Usuario::crearUsuario($usuario, $mail, $password)){
    header("Location:principal.php");
}
