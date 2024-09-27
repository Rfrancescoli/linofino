<?php

require_once 'Conexion.php';

class Persona extends Conexion
{

  private $pdo;

  public function __CONSTRUCT()
  {
    $this->pdo = parent::getConexion();
  }

  // Método para registrar una persona
  public function registrarPersona($params = []):int
  {
    try {
      $cmd = $this->pdo->prepare("CALL spu_personas_registrar(@idpersona,?,?,?,?,?)");
      $cmd->execute(
        array(
          $params['apellidos'],
          $params['nombres'],
          $params['telefono'],
          $params['dni'],
          $params['direccion']
        )
      );

      // Actualización: capturamos el valor de salida OUT
      $response = $this->pdo->query("SELECT @idpersona AS idpersona")->fetch(PDO::FETCH_ASSOC);
      return (int) $response['idpersona'];
    } catch (Exception $e) {
      error_log("Error: " . $e->getMessage());
      return -1;
    }
  }
}

/* $persona = new Persona();

$id = $persona->registrarPersona([
  "apellidos" => "Flroes Atuncar",
  "nombres" => "Cristina",
  "telefono"  => "987524163",
  "dni" => "45454545",
  "direccion" => ""
]);

echo $id;  */