<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $mail = $_POST['mail'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $conn = BD::getInstance()->getConexionBd();
    $stmt = $conn->prepare("INSERT INTO users (mail, username, hashed_password, nivel, xp, role, created_at) VALUES (?, ?, ?, 1, 0, 0, NOW())");
    $stmt->bind_param("sss", $mail, $usuario, $hashed_password);

    if ($stmt->execute()) {
        echo "Usuario registrado correctamente. Ahora puedes <a href='login.php'>iniciar sesión</a>.";
    } else {
        echo "Error al registrar usuario. Por favor, inténtalo de nuevo.";
    }

    $stmt->close();
    $conn->close();
}
?>
