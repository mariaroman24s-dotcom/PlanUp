<?php
require_once "../config/conexion.php";
date_default_timezone_set("America/Mexico_City");

$selectedDate = $_GET["dia"] ?? date("Y-m-d");

$monthLabel = date("F Y", strtotime($selectedDate));

/* ===========================
   1. Generar lista de días
   =========================== */
$days = [];
for ($i = -7; $i <= 7; $i++) {
    $date = date("Y-m-d", strtotime("$selectedDate $i days"));
    $days[] = $date;
}

/* ===========================
   2. Generar letras de días para cada fecha
   =========================== */
$weekdayLetters = [];
foreach ($days as $d) {
    // %u → 1=Lunes ... 7=Domingo
    $weekdayIndex = date("N", strtotime($d));

    // Letras manuales ordenadas L M M J V S D
    $letters = ["L", "M", "M", "J", "V", "S", "D"];

    $weekdayLetters[] = $letters[$weekdayIndex - 1];
}
?>

<link rel="stylesheet" href="../../public/css/calendar.css">

<div class="hcal-container">

    <!-- Mes y año -->
    <div class="hcal-month-label">
        <?= $monthLabel ?>
    </div>

    <!-- Letras de días -->
    <div class="hcal-weekdays-long">
        <?php foreach ($weekdayLetters as $w): ?>
            <div><?= $w ?></div>
        <?php endforeach; ?>
    </div>

    <!-- Calendario horizontal + flechas -->
    <div class="hcal-wrapper">

        <button class="hcal-btn" onclick="moveHorizontalDays(-1)">&#x2039;</button>

        <div class="calendar-horizontal" id="hcal">
            <?php foreach ($days as $d):
                $num = date("j", strtotime($d));
                $class = "circle-day";

                if ($d == date("Y-m-d")) $class .= " today";
                if ($d == $selectedDate) $class .= " selected";
            ?>
                <div class="<?= $class ?>" data-date="<?= $d ?>">
                    <?= $num ?>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="hcal-btn" onclick="moveHorizontalDays(1)">&#x203A;</button>

    </div>

</div>
