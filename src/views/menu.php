<?php

// Página actual
$page = $_GET["page"] ?? "eventos";

// Rutas correctas desde src/views/menu.php
$pagesBase = __DIR__ . "/pages/";

// Determinar archivos
switch ($page) {

    case "eventos":
        $leftFile  = $pagesBase . "eventos_left.php";
        $rightFile = $pagesBase . "eventos_right.php";
        break;

    case "tareas":
        $leftFile  = $pagesBase . "tareas_left.php";
        $rightFile = $pagesBase . "tareas_right.php";
        break;

    case "configuracion":
        $leftFile  = $pagesBase . "configuracion_left.php";
        $rightFile = $pagesBase . "configuracion_right.php";
        break;

    default:
        $leftFile  = $pagesBase . "inicio_left.php";
        $rightFile = $pagesBase . "inicio_right.php";
        break;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Plan Up | Dashboard</title>
  <link rel="stylesheet" href="/public/css/menu.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#F0F0F0]">

  <!-- Barra sup -->
  <?php /* NO MODIFIQUÉ NADA DE TU DISEÑO */ ?>

  <header class="topbar w-full bg-white shadow-sm px-8 py-4 flex justify-between items-center">

    <div class="flex items-center gap-3">
      <img src="/public/img/logoup.png" class="h-8" />
      <h1 class="text-xl font-semibold text-[#0C2C58]">Plan Up</h1>
      <span class="text-gray-500">Intelligent Task Manager</span>
    </div>

    <div class="flex items-center gap-4">
      <button class="px-6 py-2 rounded-full bg-[#4368FF] text-white font-medium shadow hover:brightness-110 transition">
        ¿Cómo usar Plan Up?
      </button>

      <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-semibold">
        LC
      </div>
    </div>
  </header>


  <!-- Contenedor -->
  <div class="layout-wrapper flex px-6 py-6 gap-6">

    <aside class="sidebar rounded-3xl">

      <nav class="flex flex-col justify-between h-full py-8">

        <div class="flex flex-col items-center gap-8">

          <a class="sidebar-item <?= $page == 'inicio' ? 'active' : '' ?>" href="menu.php?page=inicio">
            <img src="/public/img/menuimg/inicio.png" class="w-7">
            <span>Inicio</span>
          </a>

          <a class="sidebar-item <?= $page == 'tareas' ? 'active' : '' ?>" href="menu.php?page=tareas">
            <img src="/public/img/menuimg/tareas.png" class="w-7">
            <span>Tareas</span>
          </a>

          <a class="sidebar-item <?= $page == 'eventos' ? 'active' : '' ?>" href="menu.php?page=eventos">
            <img src="/public/img/menuimg/eventos.png" class="w-7">
            <span>Eventos</span>
          </a>

          <a class="sidebar-item <?= $page == 'jenny' ? 'active' : '' ?>" href="menu.php?page=jenny">
            <img src="/public/img/menuimg/jenny.png" class="w-7">
            <span>Jenny</span>
          </a>

        </div>

        <div class="flex flex-col items-center gap-6">
          <a class="sidebar-item <?= $page == 'configuracion' ? 'active' : '' ?>" href="menu.php?page=configuracion">
            <img src="/public/img/menuimg/config.png" class="w-7">
            <span>Configuración</span>
          </a>

          <div class="user-avatar w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-semibold">
            LC
          </div>
        </div>

      </nav>
    </aside>


    <!-- Paneles dinámicos -->
    <div class="flex w-full gap-6">

      <!-- PANEL IZQUIERDO -->
      <section class="panel-left rounded-3xl px-4 py-8 bg-white shadow w-[380px]">
          <?php
              if (file_exists($leftFile)) include $leftFile;
              else echo "<p>No se encontró el panel izquierdo.</p>";
          ?>
      </section>

      <!-- PANEL DERECHO -->
      <section class="panel-main rounded-3xl p-8 bg-white shadow w-full">
          <?php
              if (file_exists($rightFile)) include $rightFile;
              else echo "<p>No se encontró el panel derecho.</p>";
          ?>
      </section>

    </div>
  </div>

</body>
</html>
