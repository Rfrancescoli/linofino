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
    $idgenerado = null;
    try {
      $cmd = $this->pdo->prepare("CALL spu_personas_registrar(@idpersona,?,?,?,?,?)");
      $cmd->execute([
        $array['apellidos'],
        $array['nombres'],
        $array['telefono'],
        $array['dni'],
        $array['direccion'] ?? NULL,
      ]);

      $row = $cmd->fetch(PDO::FETCH_ASSOC);
      $idgenerado = $row['idpersona'];
    } catch (Exception $e) {
      error_log("Error: " . $e->getMessage());
      return = -1;
    }
    return $idgenerado;
  }
}
