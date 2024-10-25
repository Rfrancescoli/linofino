<?php

require_once 'Conexion.php';

class Cliente extends Conexion
{

  private $pdo;

  public function __CONSTRUCT()
  {
    $this->pdo = parent::getConexion();
  }

  /* Retorna una lista de clientes */
  public function listaClientes(): array
  {
    return parent::getData("spu_clients_listar");
  }
}