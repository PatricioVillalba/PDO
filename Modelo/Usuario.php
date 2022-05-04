<?php

class Usuario
{

  private $idusuario;
  private $usnombre;
  private $uspass;
  private $usmail;
  private $usdeshabilitado;
  private $colRoles;
  private $colCompras;
  private $msjerror;

  public function __construct()
  {
    $this->idusuario = null;
    $this->usnombre = '';
    $this->uspass = '';
    $this->usmail = '';
    $this->usdeshabilitado = '';
    $this->colRoles = [];
    $this->colCompras = [];
  }

  public function setear($idusuario, $usnombre, $uspass, $usmail, $usdeshabilitado)
  {
    $this->setIdUsuario($idusuario);
    $this->setUsNombre($usnombre);
    $this->setUsPass(md5($uspass));
    $this->setUsMail($usmail);
    $this->setUsDeshabilitado($usdeshabilitado);
  }

  public function getIdUsuario()
  {
    return $this->idusuario;
  }
  public function setIdUsuario($idusuario)
  {
    $this->idusuario = $idusuario;
  }

  public function getUsNombre()
  {
    return $this->usnombre;
  }
  public function setUsNombre($usnombre)
  {
    $this->usnombre = $usnombre;
  }

  public function getUsPass()
  {
    return $this->uspass;
  }
  public function setUsPass($uspass)
  {
    $this->uspass = $uspass;
  }

  public function getUsMail()
  {
    return $this->usmail;
  }
  public function setUsMail($usmail)
  {
    $this->usmail = $usmail;
  }

  public function getUsDeshabilitado()
  {
    return $this->usdeshabilitado;
  }
  public function setUsDeshabilitado($usDeshabli)
  {
    $this->usdeshabilitado = $usDeshabli;
  }

  public function getColRoles()
  {
    if ($this->colRoles == []) {
      $ambUsuarioRol = new AbmUsuarioRol();
      $condicionRol['idusuario'] = $this->getIdUsuario();
      $colRolesUsuario = $ambUsuarioRol->buscar($condicionRol);
      $colRoles = [];
      foreach ($colRolesUsuario as $rolUsuario) {
        array_push($colRoles, $rolUsuario->getObjRol());
      }

      $this->setColRoles($colRoles);
    }

    return $this->colRoles;
  }
  public function setColRoles($colRoles)
  {
    $this->colRoles = $colRoles;
  }

  public function getColCompras()
  {
    // if ($this->colCompras == []) {
    //   $ambCompra = new AbmCompra();
    //   $condicionCompra['idusuario'] = $this->getIdUsuario();
    //   $colCompras = $ambCompra->buscar($condicionCompra);

    //   $this->setColCompras($colCompras);
    // }

    // return $this->colCompras;
  }
  public function setColCompras($colCompras)
  {
    $this->colCompras = $colCompras;
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
    $sql = "SELECT * FROM usuario WHERE idusuario = {$this->getIdUsuario()}";
    if ($base->Iniciar()) {
      $res = $base->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $base->Registro();
          $this->setear($row['idusuario'], $row['usnombre'], $row['uspass'], $row['usmail'], $row['usdeshabilitado']);
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

    if ($this->getUsDeshabilitado() == 2) {
      $fecha=date("Y-m-d h:i:sa") ;
      $sql = "INSERT INTO usuario (usnombre, uspass, usmail, usdeshabilitado) VALUES ('{$this->getUsNombre()}','{$this->getUsPass()}','{$this->getUsMail()}','{$fecha}')";
    } else {
      
      $sql = "INSERT INTO usuario (usnombre, uspass, usmail, usdeshabilitado) VALUES ('" . $this->getUsNombre() . "','" . md5($this->getUsPass()) . "', '" . $this->getUsMail() . "', NULL )";
    }

    if ($base->Iniciar()) {
      if ($elId = $base->Ejecutar($sql)) {
        $this->setIdUsuario($elId);

        $resp = true;
      } else {
        $this->setMsjError("Tabla->insertar: {$base->getError()[2]}");
        $resp = false;
      }
    } else {
      $this->setMsjError("Tabla->insertar: {$base->getError()[2]}");
      $resp = false;
    }
    return $resp;
  }

  public function modificar()
  {
    $resp = false;
    $base = new BaseDatos();
    if ($this->getUsDeshabilitado() == 2) {

      $sql = "UPDATE usuario SET usnombre='" . $this->getUsNombre() . "', uspass='" . $this->getUsPass() . "', usmail= '" . $this->getUsMail() . "' , usdeshabilitado = '" .date("Y-m-d h:i:sa") . "'  WHERE idusuario = " . $this->getIdUsuario();
    } else {

      $sql = "UPDATE usuario SET usnombre = '" . $this->getUsNombre() . "', uspass = '" . $this->getUsPass() . "', usmail = '" . $this->getUsMail() . "', usdeshabilitado = NULL WHERE idusuario = " . $this->getIdUsuario();
    }

    // $sql = "UPDATE usuario SET 
    //   usnombre='{$this->getUsNombre()}', 
    //   uspass='{$this->getUsPass()}', 
    //   usmail='{$this->getUsMail()}', 
    //   usdeshabilitado=" . (($this->getUsDeshabilitado() == '') ? "NULL" : ("'{$this->getUsDeshabilitado()}'")) . "
    //   WHERE idusuario={$this->getIdUsuario()}";

    if ($base->Iniciar()) {
      if ($base->Ejecutar($sql)) {
        $resp = true;
      } else {
        $this->setMsjError("Tabla->modificar: {$base->getError()}");
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
    $sql = "DELETE FROM usuario WHERE idusuario={$this->getIdUsuario()}";
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
    $sql = "SELECT * FROM usuario ";
    if ($parametro != "") {
      $sql .= " WHERE {$parametro}";
    }
    $res = $base->Ejecutar($sql);
    if ($res > -1) {
      if ($res > 0) {

        while ($row = $base->Registro()) {
          $obj = new Usuario();

          $obj->setear($row['idusuario'], $row['usnombre'], $row['uspass'], $row['usmail'], $row['usdeshabilitado']);

          array_push($arreglo, $obj);
        }
      }
    }
    return $arreglo;
  }
}
