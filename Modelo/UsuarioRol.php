<?php

class UsuarioRol
{

  private $objusuario;
  private $objrol;
  private $msjerror;

  public function __construct()
  {
    $this->objusuario = null;
    $this->objrol = null;
  }

  public function setear($objusuario, $objrol)
  {
    $this->setObjUsuario($objusuario);
    $this->setObjRol($objrol);
  }

  /**
   * @return Usuario
   */
  public function getObjUsuario()
  {
    return $this->objusuario;
  }
  public function setObjUsuario($objusuario)
  {
    $this->objusuario = $objusuario;
  }

  /**
   * @return Rol
   */
  public function getObjRol()
  {
    return $this->objrol;
  }
  public function setObjRol($objrol)
  {
    $this->objrol = $objrol;
  }

  public function getMsjError()
  {
    return $this->msjerror;
  }
  public function setMsjError($msjerror)
  {
    $this->msjerror = $msjerror;
  }


  public function cargar()
  {
    $resp = false;
    $base = new BaseDatos();
    $sql = "SELECT * FROM usuariorol WHERE idusuario = {$this->getObjUsuario()->getIdUsuario()}";
    if ($base->Iniciar()) {
      $res = $base->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $base->Registro();

          $objUsuario = new Usuario();
          $objUsuario->setIdUsuario($row['idusuario']);
          $objUsuario->cargar();

          $objRol = new Rol();
          $objRol->setIdRol($row['idrol']);
          $objRol->cargar();

          $this->setear($objUsuario, $objRol);
        }
      }
    } else {
      $this->setMsjError("Tabla->listar: {$base->getError()}");
    }
    return $resp;
  }

  public function insertar()
  {
    $resp = false;
    $base = new BaseDatos();
    $sql = "INSERT INTO usuariorol (idusuario, idrol) VALUES ({$this->getObjUsuario()->getIdusuario()}, {$this->getObjRol()->getIdRol()})";

    if ($base->Iniciar()) {
      if ($base->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setMsjError("Tabla->insertar: {$base->getError()[2]}");
      }
    } else {
      $this->setMsjError("Tabla->insertar: {$base->getError()[2]}");
    }
    return $resp;
  }

  public function modificar()
  {
    $resp = false;
    $base = new BaseDatos();
    $sql = "UPDATE usuariorol SET idrol ={$this->getObjRol()->getIdRol()} WHERE idusuario = {$this->getObjUsuario()->getIdUsuario()}";
    if ($base->Iniciar()) {

      if ($base->Ejecutar($sql)) {

        $resp = true;
      } else {
        $this->setMsjError("Tabla->modificar: { $base->getError()}");
      }
    } else {
      $this->setMsjError("Tabla->modificar: {$base->getError()}");
    }
    return $resp;
  }

  public function eliminar()
  {
    $resp = false;
    $base = new BaseDatos();
    //$sql = "DELETE FROM usuariorol WHERE idusuario = {$this->getObjUsuario()->getIdUsuario()}";
    $sql = "DELETE FROM usuariorol WHERE idusuario =" . $this->getObjUsuario()->getIdUsuario() . " and idrol= " . $this->getObjRol()->getIdRol();
    if ($base->Iniciar()) {
      if ($base->Ejecutar($sql)) {
        return true;
      } else {
        $this->setMsjError("Tabla->eliminar: {$base->getError()}");
      }
    } else {
      $this->setMsjError("Tabla->eliminar: {$base->getError()}");
    }
    return $resp;
  }

  public static function listar($parametro = "")
  {
    $arreglo = array();
    $base = new BaseDatos();
    $sql = "SELECT * FROM usuariorol ";
    if ($parametro != "") {
      $sql .= " WHERE {$parametro}";
    }
    $res = $base->Ejecutar($sql);
    if ($res > -1) {

      if ($res > 0) {

        while ($row = $base->Registro()) {
          $obj = new UsuarioRol();

          $objUsuario = new Usuario();
          $objUsuario->setIdUsuario($row['idusuario']);
          $objUsuario->cargar();

          $objRol = new Rol();
          $objRol->setIdRol($row['idrol']);
          $objRol->cargar();

          $obj->setear($objUsuario, $objRol);

          array_push($arreglo, $obj);
        }
      }
    }
    return $arreglo;
  }
}
