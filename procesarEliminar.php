<?php
require_once 'config.php';
$producto = $_GET['producto'];

$carrito = Orders::buscaCarritoUser($_SESSION['id']);
$carrito->eliminaProducto($producto);

header("location:carrito.php?id=".$carrito->id);