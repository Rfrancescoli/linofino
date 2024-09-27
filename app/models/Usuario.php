<?php

require_once 'Conexion.php';

class Usuario extends Conexion
{

  private $pdo;

  public function __CONSTRUCT()
  {
    $this->pdo = parent::getConexion();
  }

  public function registrarUsuario($params = []):int
  {
    try {
      $cmd = $this->pdo->prepare("CALL spu_usuarios_registrar(@idusuario,?,?,?,?)");
      $cmd->execute(
        array(
          $params['idpersona'],
          $params['nomusuario'],
          $params['claveacceso'],
          $params['perfil']
        )
      );

      $response = $this->pdo->query("SELECT @idusuario AS idusuario")->fetch(PDO::FETCH_ASSOC);
      return (int) $response['idusuario'];
    } catch (Exception $e) {
      error_log("Error: " . $e->getMessage());
      return -1;
    }
  }

  
  public function getAll():array{
    return parent::getData("spu_usuarios_listar");
  }
}

/* $usuario = new Usuario();

$id = $usuario->registrarUsuario([
  "idpersona" => 1,
  "nomusuario"  => "anicama",
  "claveacceso" => "9876154",
  "perfil" => "SUP"
]);

echo $id; 

var_dump($usuario->getAll());*/