<?php

require_once '../models/Usuario.php';
$usuario = new Usuario();

header("Content-type: application/json; charset=utf-8");

if(isset($_GET['operation'])){
  switch ($_GET['operation']){
    case 'getAll':
      echo json_encode($usuario->getAll());
      break;
  }
}

if(isset($_POST['operation'])){
  switch ($_POST['operation']){
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
  }
}