<?php
require_once "../config/conexion.php";
session_start();

// ID del usuario (asumiendo que lo guardas en sesión)
$id_usuario = $_SESSION["id_usuario"] ?? 1;

// Consulta: próximos 5 eventos
$stmt = $pdo->prepare("
    SELECT titulo, fecha_inicio
    FROM eventos
    WHERE id_usuario = :id
    ORDER BY fecha_inicio ASC
    LIMIT 5
");
$stmt->execute(["id" => $id_usuario]);
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="/public/css/events_small_list.css">

<div class="small-events-box">
    <h3 class="small-events-title">Mis eventos</h3>

    <?php if (count($eventos) === 0): ?>
        <p class="no-events">No tienes eventos próximos.</p>

    <?php else: ?>
        <ul class="small-events-list">
            <?php foreach ($eventos as $e):
                $fecha = date("d-M-Y", strtotime($e["fecha_inicio"]));
            ?>
                <li>
                    <span class="event-icon">🔔</span>
                    <span class="event-title"><?= $e["titulo"] ?></span>
                    <span class="event-date">— <?= $fecha ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
