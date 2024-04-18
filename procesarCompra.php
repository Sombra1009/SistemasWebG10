<?php
require_once 'config.php';

$carrito = Orders::buscaCarritoUser($_SESSION['id']);
$carrito->compraCarro();
Orders::crearCarro($_SESSION['id']);

header("location:principal.php");