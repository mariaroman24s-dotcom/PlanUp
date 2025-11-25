<?php
require_once "conexion.php";

$nombre = $_POST['nombre'] ?? null;
$email = $_POST['correo'] ?? null;
$password = $_POST['contraseña'] ?? null;
$confirmar = $_POST['confirmar'] ?? null;  // ← nuevo

if(!$nombre || !$email || !$password || !$confirmar){
    echo "Faltan datos";
    exit;
}

// VALIDACIÓN DE CONTRASEÑA AQUÍ
if($password !== $confirmar){
    echo "no_coinciden";
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, contrasena)
                           VALUES (:nombre, :correo, :contrasena)");

    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":correo", $email);
    $stmt->bindParam(":contrasena", $password);

    $stmt->execute();

    // -----------------------------------------
    // 🚀 REDIRECCIÓN AL MENÚ DESPUÉS DE REGISTRAR
    // -----------------------------------------
    header("Location: ../views/menu.php");
    exit;

} catch (PDOException $e){
    echo "correo_duplicado";
}
?>
