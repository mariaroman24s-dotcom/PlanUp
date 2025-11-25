<?php
require_once "conexion.php";

$id = $_POST["id_evento"];
$titulo = $_POST["titulo"];
$descripcion = $_POST["descripcion"];
$inicio = $_POST["fecha_inicio"];
$fin = $_POST["fecha_fin"];
$ubicacion = $_POST["ubicacion"];

if (!$id) {
    echo "no_id";
    exit;
}

$stmt = $pdo->prepare("
    UPDATE eventos
    SET titulo = :t, descripcion = :d, fecha_inicio = :fi, fecha_fin = :ff, ubicacion = :u
    WHERE id_evento = :id
");

$stmt->execute([
    "id" => $id,
    "t"  => $titulo,
    "d"  => $descripcion,
    "fi" => $inicio,
    "ff" => $fin,
    "u"  => $ubicacion
]);

echo "updated";
