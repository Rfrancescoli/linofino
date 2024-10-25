<?php

require_once 'Conexion.php';

class Usuario extends Conexion
{

  private $pdo;

  public function __CONSTRUCT()
  {
    $this->pdo = parent::getConexion();
  }

  public function registrarUsuario($params = []): int
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

  /* Retorna una lista de usuarios */
  public function getAll(): array
  {
    return parent::getData("spu_usuarios_listar");
  }

  /* Retorna el registro del usuario indicado */
  public function login($params = []): array
  {
    try {
      $cmd = $this->pdo->prepare("call spu_usuarios_login(?)");
      $cmd->execute(
        array($params['nomusuario'])
      );
      return $cmd->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      error_log("Error: " . $e->getMessage());
    }
  }

  /**
   * Obtiene una lista de vistas a las que el usuario puede acceder
   * @param array $params El idperfil se debe enviar coo arreglo asociativo
   * @return array retorna una coleccion de datos
   */
  public function obtenerPermisos($params = []): array
  {
    try {
      $cmd = $this->pdo->prepare("CALL spu_obtener_acceso_usuario(?)");
      $cmd->execute(
        array($params['idperfil'])
      );
      return $cmd->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      error_log("Error: " . $e->getMessage());
      return [];
    }
  }
}

// $usuario = new Usuario();
/* var_dump($usuario->login(['nomusuario' => 'rmarcos@gmail.com']));
 *//*
$id = $usuario->registrarUsuario([
  "idpersona" => 1,
  "nomusuario"  => "anicama",
  "claveacceso" => "9876154",
  "perfil" => "SUP"
]);

echo $id; 

var_dump($usuario->getAll());*/