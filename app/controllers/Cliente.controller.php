<?php
session_start();

header("Content-type: application/json; charset=utf-8");

require_once '../models/Cliente.php';
$cliente = new Cliente();

if (isset($_GET['operation'])) {
  switch ($_GET['operation']) {
    case 'listaClientes':
      echo json_encode($cliente->listaClientes());
      break;
  }
}