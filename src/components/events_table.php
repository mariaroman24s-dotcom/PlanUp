<?php
require_once "../config/conexion.php";
session_start();

$id_usuario = $_SESSION["id_usuario"] ?? 1;

$stmt = $pdo->prepare("
    SELECT * FROM eventos
    WHERE id_usuario = :id
    ORDER BY fecha_inicio ASC
");
$stmt->execute(["id" => $id_usuario]);

$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="/public/css/events_table.css">
<script src="/public/js/events_table.js" defer></script>

<div class="events-table-box">
    <h3 class="table-title">Próximos eventos</h3>

    <table class="events-table">
        <thead>
            <tr>
                <th>Evento</th>
                <th>Fecha</th>
                <th>Lugar</th>
                <th>Opciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($eventos as $e): ?>
                <tr>
                    <td><?= $e["titulo"] ?></td>

                    <td>
                        <?= date("d-m-Y H:i", strtotime($e["fecha_inicio"])) ?>
                        <br>
                        <strong><?= date("H:i", strtotime($e["fecha_fin"])) ?></strong>
                    </td>

                    <td><?= $e["ubicacion"] ?></td>

                    <td>
                        <button class="edit-btn" onclick="editEvent(<?= $e['id_evento'] ?>)">Editar</button>
                        <button class="delete-btn" onclick="deleteEvent(<?= $e['id_evento'] ?>)">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
