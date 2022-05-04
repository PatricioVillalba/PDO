<?php

class MenuRol {

  private $objmenu;
  private $objrol;
  private $msjerror;

  public function __construct() {
    $this->objmenu = null;
    $this->objrol = null;
  }

  public function setear($objmenu, $objrol) {
    $this->setObjMenu($objmenu);
    $this->setObjRol($objrol);
  }

  /**
   * @return Menu
   */
  public function getObjMenu() {
    return $this->objmenu;
  }
  public function setObjMenu($objmenu) {
    $this->objmenu = $objmenu;
  }

  /**
   * @return Rol
   */
  public function getObjRol() {
    return $this->objrol;
  }
  public function setObjRol($objrol) {
    $this->objrol = $objrol;
  }

  public function getMsjError() {
    return $this->msjerror;
  }
  public function setMsjError($msjerror) {
    $this->msjerror = $msjerror;
  }

  public function cargar() {
    $resp = false;
    $base = new BaseDatos();
    $sql = "SELECT * FROM menurol WHERE objmenu = {$this->getObjMenu()}";
    if ($base->Iniciar()) {
      $res = $base->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $base->Registro();
          $this->setear($row['idmenu'], $row['idrol']);
        }
      }
    } else {
      $this->setMsjError("Tabla->listar: {$base->getError()}");
    }
    return $resp;
  }

  public function insertar() {
    $resp = false;
    $base = new BaseDatos();
    $sql = "INSERT INTO menurol (idmenu, idrol) VALUES ({$this->getObjMenu()->getIdMenu()}, {$this->getObjRol()->getIdRol()})";

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

  /**
   * Este metodo sirve para modificar el rol que puede usar esta opcion de menu
   * @return void
   */
  public function modificar() {
    $resp = false;
    $base = new BaseDatos();
    $sql = "UPDATE menurol SET idrol = {$this->getObjRol()->getIdRol()} WHERE idmenu = {$this->getObjMenu()->getIdMenu()}";
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

  public function eliminar() {
    $resp = false;
    $base = new BaseDatos();
    $sql = "DELETE FROM menurol WHERE idmenu={$this->getObjMenu()->getIdMenu()} AND idrol={$this->getObjRol()->getIdRol()}";
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

  public static function listar($parametro = "") {
    $arreglo = array();
    $base = new BaseDatos();
    $sql = "SELECT * FROM menurol ";
    if ($parametro != "") {
      $sql .= " WHERE {$parametro}";
    }
    $res = $base->Ejecutar($sql);
    if ($res > -1) {
      if ($res > 0) {

        while ($row = $base->Registro()) {
          $obj = new MenuRol();

          $objMenu = new Menu();
          $objMenu->setIdMenu($row['idmenu']);
          $objMenu->cargar();

          $objRol = new Rol();
          $objRol->setIdRol($row['idrol']);
          $objRol->cargar();

          $obj->setear($objMenu, $objRol);

          array_push($arreglo, $obj);
        }
      }
    }

    return $arreglo;
  }
}
