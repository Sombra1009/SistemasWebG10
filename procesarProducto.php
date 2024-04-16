<?php
require_once 'config.php';
$producto = $_GET['producto'];

$carrito = Orders::buscaCarritoUser($_SESSION['id']);
$carrito->añadeProducto($producto);
if(isset($_GET['prin'])){
    header("location:principal.php");
}
header("location:juego.php?id=".$producto);