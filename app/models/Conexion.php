<?php

class Conexion{

  //1. Almacenamos los datos de conexión
  private $servidor = "localhost";
  private $puerto = "3306";
  private $baseDatos = "linofino";
  private $usuario = "root";
  private $clave = "";

  public function getConexion(){

    try{
      $pdo = new PDO(
        "mysql:host={$this->servidor};
        port={$this->puerto};
        dbname={$this->baseDatos};
        charset=UTF8", 
        $this->usuario, 
        $this->clave
      );

      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  // Método para evitar la SQLinjection
  // TRIM = Borrar espacios, los espacios son un caracter
  /**
   * Evita intentos de ataque a través de campos INPUT
   */
  public static function limpiarCadena($cadena):string{
    $cadena = trim($cadena);
    $cadena = stripslashes($cadena);
    $cadena = str_ireplace("<script>", "", $cadena);
    $cadena = str_ireplace("</script>", "", $cadena);
    $cadena = str_ireplace("<script src", "", $cadena);
    $cadena = str_ireplace("<script type", "", $cadena);

    $cadena = str_ireplace("SELECT * FROM", "", $cadena);
    $cadena = str_ireplace("DELETE FROM", "", $cadena);
    $cadena = str_ireplace("INSERT INTO", "", $cadena);

    $cadena = str_ireplace("DROP TABLE", "", $cadena);
    $cadena = str_ireplace("DROP DATABASE", "", $cadena);
    $cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
    $cadena = str_ireplace("SHOW TABLES", "", $cadena);
    $cadena = str_ireplace("SHOW DATABASES", "", $cadena);

    $cadena = str_ireplace("<?php", "", $cadena);
    $cadena = str_ireplace("?>", "", $cadena);
    $cadena = str_ireplace("--", "", $cadena);
    $cadena = str_ireplace(">", "", $cadena);
    $cadena = str_ireplace("<", "", $cadena);
    $cadena = str_ireplace("[", "", $cadena);
    $cadena = str_ireplace("]", "", $cadena);

    $cadena = str_ireplace("^", "", $cadena); // ALT + 94
    $cadena = str_ireplace("==", "", $cadena);
    $cadena = str_ireplace("===", "", $cadena);
    $cadena = str_ireplace(";", "", $cadena);
    $cadena = str_ireplace("::", "", $cadena);
    $cadena = str_ireplace("('", "", $cadena);
    $cadena = str_ireplace("')", "", $cadena);

    $cadena = stripslashes($cadena);
    $cadena = trim($cadena);

    return $cadena;
  }

  /**
   * Retorna una colección de datos de la fuente (SPU) especificada
   */
  public function getData($spuName = ""):array{
    try{
      $cmd = $this->getConexion()->prepare("call {$spuName}()");
      $cmd->execute();
      return $cmd->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
      error_log("Error: " . $e->getMessage());
    }
  }

}

/* $entrada = "<script>alert('Hey que pasa')</script><h1>SENATI</h1>";
$datoLimpio = Conexion::limpiarCadena($entrada);
echo $datoLimpio; */


/* $idgenerado = null;
    try {
        $query = $this->pdo->prepare("CALL spu_registrar_persona_usuario(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $query->execute([
            $params['apellidos'],
            $params['nombres'],
            $params['nrodocumento'],
            $params['direccion'],
            $params['tipodoc'],
            $params['numeroHijos'],
            !empty($params['fechaIngreso']) ? $params['fechaIngreso'] : null,
            $params['correo'],
            $params['clave'],  // La contraseña ya debe estar encriptada
            $params['idRol']
        ]);

        $row = $query->fetch(PDO::FETCH_ASSOC);
        $idgenerado = $row['idPersonal'];
    } catch (Exception $e) {
        $idgenerado = -1;
    }
    return $idgenerado; */