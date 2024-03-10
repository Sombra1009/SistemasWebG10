<?php
$target_dir = dirname('productos/'); // Esto obtendrá la ruta de la carpeta donde se encuentra este script PHP
$target_file = 'productos/' . '1.png';

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "El archivo ". basename( $_FILES["fileToUpload"]["name"]). " ha sido subido.";
} else {
    echo "Hubo un error al subir tu archivo.";
}
?>