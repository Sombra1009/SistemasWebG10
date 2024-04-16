<?php
require_once 'config.php';
$target_dir = dirname('productos/'); // Esto obtendrá la ruta de la carpeta donde se encuentra este script PHP

$target_file = $target_dir . 'hola.png';


if (isset($_POST['nombre'])) {

    $nombre = $_POST['nombre'];

    if (isset($_POST['descripcion'])) {

        $descripcion = $_POST['descripcion'];

        if (isset($_POST['precio'])) {

            $precio = $_POST['precio'];

            if (isset($_POST['stock'])) {

                $stock = $_POST['stock'];

                $producto = Producto::creaProducto($nombre, $descripcion, $precio, $stock, '', $_SESSION['id']);

            }

        }

    }

}

if($producto){

    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], "productos/".$producto->id . ".png")) {

        $producto->cambiaImagen("productos/".$producto->id . ".png");

    }

}
header("Location:principal.php");
