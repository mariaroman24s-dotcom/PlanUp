<?php
require_once "../config/conexion.php";
date_default_timezone_set("America/Mexico_City");

/* ===========================
   VALIDAR FECHA SELECCIONADA
   =========================== */

$selectedDate = $_GET["dia"] ?? null;

// Si no viene o es inválida, usar hoy
if (!$selectedDate || !strtotime($selectedDate)) {
    $selectedDate = date("Y-m-d");
}

// A partir de aquí calculamos año y mes
$year  = (int)date("Y", strtotime($selectedDate));
$month = date("m", strtotime($selectedDate));

/* Seguridad extra:
   Si por alguna razón nos mandan un año loco (tipo 1970, 1800, etc)
   volvemos a HOY para evitar calendarios rotos.
*/
if ($year < 2000 || $year > 2100) {
    $selectedDate = date("Y-m-d");
    $year  = (int)date("Y");
    $month = date("m");
}

$firstDayMonth = "$year-$month-01";
$daysInMonth   = date("t", strtotime($firstDayMonth));


/* ===========================
   OBTENER EVENTOS DEL MES
   =========================== */

$stmt = $pdo->prepare("
    SELECT fecha_inicio, fecha_fin
    FROM eventos
    WHERE fecha_inicio <= :fin AND fecha_fin >= :inicio
");

$stmt->execute([
    "inicio" => $firstDayMonth,
    "fin"    => date("Y-m-t", strtotime($firstDayMonth))
]);

$eventDays = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $start = strtotime($row["fecha_inicio"]);
    $end   = strtotime($row["fecha_fin"]);

    for ($d = $start; $d <= $end; $d += 86400) {
        $eventDays[] = date("Y-m-d", $d);
    }
}

$eventDays = array_unique($eventDays);
?>

<link rel="stylesheet" href="../../public/css/calendar.css">
<script src="../../public/js/calendar.js" defer></script>

<div class="calendar-container">

    <!-- HEADER DEL MES -->
    <div class="calendar-month-box">

        <div class="calendar-header">
            <button class="month-btn modern" onclick="changeMonth(-1)">&#10094;</button>
            <h2 class="month-year-label">
                <?= date("F", strtotime($selectedDate)) ?>

                <div class="year-selector">
                    <span class="year-text"><?= date("Y", strtotime($selectedDate)) ?></span>
                    <button class="year-dropdown-btn" onclick="toggleYearDropdown(event)">&#9662;</button>

                    <div class="year-dropdown hidden" id="yearDropdown">
                        <?php
                        $currentYear = date("Y");
                        for ($y = $currentYear - 5; $y <= $currentYear + 5; $y++) {
                            echo "<div class='year-option' data-year='$y'>$y</div>";
                        }
                        ?>
                    </div>
                </div>
            </h2>

            <button class="month-btn modern" onclick="changeMonth(1)">&#10095;</button>
        </div>

        <div class="calendar-grid">

            <!-- ENCABEZADO DEL CALENDARIO -->
            <div class="weekday">L</div>
            <div class="weekday">M</div>
            <div class="weekday">M</div>
            <div class="weekday">J</div>
            <div class="weekday">V</div>
            <div class="weekday">S</div>
            <div class="weekday">D</div>

            <?php
            /* ===========================
               DÍAS DEL MES ANTERIOR
               =========================== */

            // Día de la semana en que inicia el mes (1=Lun, 7=Dom)
            $startWeekday = date("N", strtotime($firstDayMonth));
            $prevMonthLastDay = date("t", strtotime("$firstDayMonth -1 month"));
            $prevDaysToShow = $startWeekday - 1;

            for ($i = $prevDaysToShow; $i > 0; $i--) {
                $dayNum = $prevMonthLastDay - $i + 1;
                echo "<div class='day inactive'>$dayNum</div>";
            }

            /* ===========================
               DÍAS DEL MES ACTUAL
               =========================== */

            for ($day = 1; $day <= $daysInMonth; $day++) {

                $currentDate = "$year-$month-" . str_pad($day, 2, "0", STR_PAD_LEFT);
                $class = "day";

                if ($currentDate == date("Y-m-d")) {
                    $class .= " today";
                }

                if ($currentDate == $selectedDate) {
                    $class .= " selected";
                }

                echo "<div class='$class' data-date='$currentDate'>$day";

                if (in_array($currentDate, $eventDays)) {
                    echo "<span class='dot'></span>";
                }

                echo "</div>";
            }

            /* ===========================
               DÍAS DEL SIGUIENTE MES
               =========================== */

            $totalUsedCells = $prevDaysToShow + $daysInMonth;
            $remainingCells = (7 - ($totalUsedCells % 7)) % 7;

            for ($i = 1; $i <= $remainingCells; $i++) {
                echo "<div class='day inactive'>$i</div>";
            }
            ?>

        </div>
    </div>

</div>
