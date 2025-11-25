<?php
require_once "conexion.php";

$id = $_GET["id"] ?? null;

if (!$id) {
    echo "no_id";
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM eventos WHERE id_evento = :id");
    $stmt->execute(["id" => $id]);

    echo "deleted";

} catch (PDOException $e) {
    echo "error";
}
