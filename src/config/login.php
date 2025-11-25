<?php
session_start();
require_once "conexion.php";

$email = $_POST['correo'] ?? null;
$password = $_POST['contraseña'] ?? null;

if(!$email || !$password){
    echo "faltan_datos";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = :correo LIMIT 1");
$stmt->bindParam(":correo", $email);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if($usuario && $usuario['contrasena'] === $password){
    
    // Crear la sesión del usuario
    $_SESSION['usuario'] = [
        'id' => $usuario['id_usuario'],
        'nombre' => $usuario['nombre'],
        'correo' => $usuario['correo'],
        'zona_horaria' => $usuario['zona_horaria']
    ];

    echo "success";

} else {
    echo "error";
}
?>
