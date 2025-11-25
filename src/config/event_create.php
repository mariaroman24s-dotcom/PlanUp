<?php
require_once "conexion.php";
session_start();

$id_usuario = $_SESSION["id_usuario"] ?? 1; // temporal

$titulo       = $_POST["titulo"];
$descripcion  = $_POST["descripcion"];
$inicio       = $_POST["fecha_inicio"];
$fin          = $_POST["fecha_fin"];
$ubicacion    = $_POST["ubicacion"];

if (!$titulo || !$inicio || !$fin) {
    echo "missing_fields";
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO eventos (id_usuario, titulo, descripcion, fecha_inicio, fecha_fin, ubicacion)
        VALUES (:id, :t, :d, :fi, :ff, :u)
    ");

    $stmt->execute([
        "id" => $id_usuario,
        "t" => $titulo,
        "d" => $descripcion,
        "fi" => $inicio,
        "ff" => $fin,
        "u" => $ubicacion
    ]);

    echo "success";

} catch (Exception $e) {
    echo "error: " . $e->getMessage();
}
