<?php
session_start();

// Si el usuario NO ha iniciado sesión, entonces se va a LOGIN
if (!isset($_SESSION['login']) || $_SESSION['login']['estado'] == false) {
  header('location:http://localhost/linofino');
} else {
  // El usuario a ingresado al sistema, solo se le permitirá acceso a las vistas indicadores por su PERFIL
  $url = $_SERVER['REQUEST_URI'];         // Obtener URL
  $rutaCompleta = explode("/", $url);     // URL > array()
  $rutaCompleta = array_filter($rutaCompleta);
  $totalElementos = count($rutaCompleta);
  // Buscaremos la vistaActual n la listaAcceso
  $vistaActual = $rutaCompleta[$totalElementos];
  $listaAcceso = $_SESSION['login']['accesos'];

  // Verificando permiso
  /* $encontrado = false;
  
  foreach($listaAcceso as $acceso){
    if ($vistaActual == $acceso){
      $encontrado = true;
    }
  } */

  $encontrado = false;
  $i = 0;
  while(($i < count ($listaAcceso)) && !$encontrado){
    if($listaAcceso[$i]['ruta'] == $vistaActual){
      $encontrado = true;
    }
    $i++;
  }

  // Validamos si se encontró...
  if (!$encontrado){
    header("Location: http://localhost/linofino/views/home/");
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Lino Fino</title>
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <link href="http://localhost/linofino/css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="index.html">Start Bootstrap</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
      <div class="input-group">
        <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
        <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
      </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#!">Settings</a></li>
          <li><a class="dropdown-item" href="#!">Activity Log</a></li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li><a class="dropdown-item" href="http://localhost/linofino/app/controllers/Usuario.controller.php?operation=destroy">Logout</a></li>
        </ul>
      </li>
    </ul>
  </nav>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link" href="http://localhost/linofino/views">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Inicio
            </a>
            <div class="sb-sidenav-menu-heading">Módulos</div>
            <?php
            foreach ($listaAcceso as $acceso) {
              echo "
              <a class='nav-link' href='http://localhost/linofino/views/{$acceso['ruta']}'>
              <div class='sb-nav-link-icon'><i class='fa-solid fa-plug-circle-check'></i></div>
              {$acceso['texto']}
            </a>
              ";
            }
            ?>

            <!-- Menú de procesos -->
            <!-- <div class="sb-sidenav-menu-heading">Procesos</div> -->

            <!-- Fin menú de procesos -->

            <!-- Menú módulos de sistema -->

            <!-- <div class="sb-sidenav-menu-heading">Addons</div> -->

            <!-- Fin menú módulos de sistema -->

            <!-- Menú reportes -->
            <!-- <div class="sb-sidenav-menu-heading">Reportes</div> -->
            <!-- Fin menú reportes -->

          </div>
        </div>
        <div class="sb-sidenav-footer">
          <div class="small">Logged in as:</div>
          Start Bootstrap
        </div>
      </nav>
    </div>
    <div id="layoutSidenav_content">