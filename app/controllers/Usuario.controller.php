<?php
session_start();

// IO JSON
header("Content-type: application/json; charset=utf-8");

// Determina las vitas las cuales podrá utilizar
// Producción, pagos, tareas, usuarios, reporte-produccion, reporte-fechas
/* $accesos = [
  "ADM" => ["home", "produccion", "pagos", "tareas", "usuarios", "reporte-produccion", "reporte-fechas"],
  "COL" => ["home", "produccion", "tareas", "reporte-produccion"],
  "SUP" => ["home", "tareas"]
];

$accesosV2 = [
  "ADM" => [
    ["modulo" => "", "ruta" => "home", "visible" => true, "texto" => "Inicio", "icono" => "fa-solid fa-wallet"],

    ["modulo" => "jornadas", "ruta" => "listar-jornada", "visible" => true, "texto" => "Jornadas", "icono" => "fa-solid fa-wallet"],

    ["modulo" => "pagos", "ruta" => "listar-pago", "visible" => true, "texto" => "Pagos", "icono" => "fa-solid fa-wallet"],

    ["modulo" => "produccion", "ruta" => "listar-produccion", "visible" => true, "texto" => "Producción", "icono" => "fa-solid fa-wallet"],

    ["modulo" => "reportes", "ruta" => "reporte-diario", "visible" => true, "texto" => "Reportes", "icono" => "fa-solid fa-wallet"],

    ["modulo" => "usuarios", "ruta" => "listar-usuario", "visible" => true, "texto" => "Usuarios", "icono" => "fa-solid fa-wallet"],
    ["modulo" => "usuarios", "ruta" => "registrar-usuario", "visible" => false],
    ["modulo" => "usuarios", "ruta" => "actualizar-usuario", "visible" => false],

    ["modulo" => "tareas", "ruta" => "listar-tarea", "visible" => true, "texto" => "Tareas", "icono" => "fa-solid fa-wallet"],
    ["modulo" => "tareas", "ruta" => "registrar-tarea", "visible" => false]
  ],
  "SUP" => [
    ["modulo" => "", "ruta" => "home", "visible" => true, "texto" => "Inicio", "icono" => "fa-solid fa-wallet"],
    ["modulo" => "produccion", "ruta" => "listar-produccion", "visible" => true, "texto" => "Producción", "icono" => "fa-solid fa-wallet"],
    ["modulo" => "reportes", "ruta" => "reporte-diario", "visible" => true, "texto" => "Reportes", "icono" => "fa-solid fa-wallet"],
    ["modulo" => "tareas", "ruta" => "listar-tarea", "visible" => true, "texto" => "Tareas", "icono" => "fa-solid fa-wallet"],
  ],
  "COL" => [
    ["modulo" => "", "ruta" => "home", "visible" => true, "texto" => "Inicio", "icono" => "fa-solid fa-wallet"],
    ["modulo" => "tareas", "ruta" => "listar-tarea", "visible" => true, "texto" => "Tareas", "icono" => "fa-solid fa-wallet"],
  ]
]; */

// Guardar la configuración de inicio de sesión
if (!isset($_SESSION['login']) || $_SESSION['login']['estado'] == false) {
  $sesion = [
    "estado"      => false,
    "inicio"      => "",
    "idusuario"   => -1,
    "apellidos"   => "",
    "nombres"     => "",
    "nomusuario"  => "",
    "claveacceso" => "",
    "perfil"      => "",
    "accesos"     => []
  ];
}

require_once '../models/Usuario.php';
$usuario = new Usuario();

if (isset($_GET['operation'])) {
  switch ($_GET['operation']) {
    case 'getAll':
      echo json_encode($usuario->getAll());
      break;

    case 'destroy':
      session_destroy();
      session_unset();
      header('location:http://localhost/linofino/');
      break;
  }
}

if (isset($_POST['operation'])) {
  switch ($_POST['operation']) {
    case 'registrarUsuario':
      $claveAcceso = password_hash($usuario->limpiarCadena($_POST['claveacceso']), PASSWORD_BCRYPT);
      $datosRecibidos = [
        "idpersona"     => $usuario->limpiarCadena($_POST['idpersona']),
        "nomusuario"    => $usuario->limpiarCadena($_POST['nomusuario']),
        "claveacceso"   => $claveAcceso,
        "perfil"        => $usuario->limpiarCadena($_POST['perfil'])
      ];
      $idusuario = $usuario->registrarUsuario($datosRecibidos);
      echo json_encode(['idusuario' => $idusuario]);
      break;

    case 'login':
      $nomUsuario = $usuario->limpiarCadena($_POST['nomusuario']);
      /* echo json_encode($usuario->login(['nomusuario' => $nomUsuario])); */
      $registro = $usuario->login(['nomusuario' => $nomUsuario]);

      // Arreglo para la comunicación para el usuario con la vista
      $resultados = [
        "login"     => false,
        "mensaje"   => ""
      ];

      if ($registro) {
        $claveEncriptada = $registro[0]['claveacceso']; // Base de datos
        $claveIngresada = $usuario->limpiarCadena($_POST['claveacceso']); // Formulario
        if (password_verify($claveIngresada, $claveEncriptada)) {
          $resultados["login"] = true;
          $resultados["mensaje"] = "Bienvenido";

          // Ya se validó (nomusuario+claveacceso)
          $sesion["estado"] = true;
          $sesion["inicio"] = date('h:i:s d-m-Y');
          $sesion["idusuario"] = $registro[0]['idusuario'];
          $sesion["apellidos"] = $registro[0]['apellidos'];
          $sesion["nombres"] = $registro[0]['nombres'];
          $sesion["nomusuario"] = $registro[0]['nomusuario'];
          $sesion["claveacceso"] = $registro[0]['claveacceso'];
          $sesion["perfil"] = $registro[0]['perfil'];

          //$sesion["accesos"] = $accesosV2[$registro[0]['perfil']]; // Actualización
          
          // Los accesos se obtienen desde una consulta
          $accesos = $usuario->obtenerPermisos(["idperfil" => $registro[0]['idperfil']]);
          $sesion["accesos"] = $accesos;

        } else {
          $resultados["mensaje"] = "Error en la contraseña";
          $sesion["estado"] = false;
          $sesion["apellidos"] = "";
          $sesion["nombres"] = "";
        }
      } else {
        $resultados["mensaje"] = "No existe el usuario";
        $sesion["estado"] = false;
        $sesion["apellidos"] = "";
        $sesion["nombres"] = "";
      }

      $_SESSION['login'] = $sesion;
      echo json_encode($resultados);
      //echo json_encode($_SESSION['login']);
      break;
  }
}