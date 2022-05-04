<?php

class Rol {

  private $idrol;
  private $rodescripcion;
  private $colMenus;
  private $msjError;

  public function __construct() {
    $this->idrol = null;
    $this->rodescripcion = "";
  }

  public function setear($idrol, $rodescripcion) {
    $this->setIdRol($idrol);
    $this->setRoDescripcion($rodescripcion);
  }

  public function getIdRol() {
    return $this->idrol;
  }
  public function setIdRol($idrol) {
    $this->idrol = $idrol;
  }

  public function getRoDescripcion() {
    return $this->rodescripcion;
  }
  public function setRoDescripcion($rodescripcion) {
    $this->rodescripcion = $rodescripcion;
  }
  
  public function getColMenus() {
    // if (empty($this->colMenus)) {
    //   $abmMR = new AbmMenuRol();
    //   $condicionMR['idrol'] = $this->getIdRol();
    //   $colMenusRol = $abmMR->buscar($condicionMR);

    //   $colMenus = [];
    //   foreach ($colMenusRol as $menuRol) {
    //     array_push($colMenus, $menuRol->getObjMenu());
    //   }
    //   $this->setColMenus($colMenus);
    // }

    // return $this->colMenus;
  }
  public function setColMenus($colMenus) {
    $this->colMenus = $colMenus;
  }

  public function getMsjError() {
    return $this->msjError;
  }
  public function setMsjError($msjError) {
    $this->msjError = $msjError;
  }

  public function cargar() {
    $resp = false;
    $base = new BaseDatos();
    $sql = "SELECT * FROM rol WHERE idrol = {$this->getIdRol()}";
    if ($base->Iniciar()) {
      $res = $base->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $base->Registro();
          $this->setear($row['idrol'], $row['rodescripcion']);
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
    $sql = "INSERT INTO rol (rodescripcion) VALUES ('{$this->getRoDescripcion()}')";

    if ($base->Iniciar()) {
      if ($elId = $base->Ejecutar($sql)) {
        $this->setIdRol($elId);

        $resp = true;
      } else {
        $this->setMsjError("Tabla->insertar: {$base->getError()[2]}");
      }
    } else {
      $this->setMsjError("Tabla->insertar: {$base->getError()[2]}");
    }
    return $resp;
  }

  public function modificar() {
    $resp = false;
    $base = new BaseDatos();
    $sql = "UPDATE rol SET rodescripcion = '{$this->getRoDescripcion()}' WHERE idrol = {$this->getIdRol()}";
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
    $sql = "DELETE FROM rol WHERE idrol={$this->getIdRol()}";
    if ($base->Iniciar()) {
      if ($base->Ejecutar($sql)) {
        $resp = true;
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
    $sql = "SELECT * FROM rol ";
    if ($parametro != "") {
      $sql .= " WHERE {$parametro}";
    }
    $res = $base->Ejecutar($sql);
    if ($res > -1) {
      if ($res > 0) {

        while ($row = $base->Registro()) {
          $obj = new Rol();
          $obj->setear($row['idrol'], $row['rodescripcion']);

          array_push($arreglo, $obj);
        }
      }
    }

    return $arreglo;
  }
}
