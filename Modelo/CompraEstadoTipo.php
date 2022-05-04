<?php

class CompraEstadoTipo {

  private $idcompraesttipo;
  private $cetdescripcion;
  private $cetdetalle;
  private $msjerror;

  public function __construct() {
    $this->idcompraesttipo = null;
    $this->cetdescripcion = '';
    $this->cetdetalle = '';
  }

  public function setear($idcompraesttipo, $cetdescripcion, $cetdetalle) {
    $this->setIdCompraEstTipo($idcompraesttipo);
    $this->setCetDescripcion($cetdescripcion);
    $this->setCetDetalle($cetdetalle);
  }

  public function getIdCompraEstTipo() {
    return  $this->idcompraesttipo;
  }
  public function setIdCompraEstTipo($idcompraesttipo) {
    $this->idcompraesttipo = $idcompraesttipo;
  }

  public function getCetDescripcion() {
    return  $this->cetdescripcion;
  }
  public function setCetDescripcion($cetdescripcion) {
    $this->cetdescripcion = $cetdescripcion;
  }

  public function getCetDetalle() {
    return  $this->cetdetalle;
  }
  public function setCetDetalle($cetdetalle) {
    $this->cetdetalle = $cetdetalle;
  }

  public function getMsjError() {
    return  $this->msjerror;
  }
  public function setMsjError($msjerror) {
    $this->msjerror = $msjerror;
  }

  public function cargar() {
    $resp = false;
    $base = new BaseDatos();
    $sql = "SELECT * FROM compraestadotipo WHERE idcompraestadotipo = {$this->getIdCompraEstTipo()}";
    if ($base->Iniciar()) {
      $res = $base->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $base->Registro();

          $this->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
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
    $sql = "INSERT INTO compraestadotipo ( idcompraestadotipo,cetdescripcion,cetdetalle ) VALUES ({$this->getIdCompraEstTipo()},'{$this->getCetDescripcion()}','{$this->getCetDetalle()}')";

    if ($base->Iniciar()) {
      if ($id = $base->Ejecutar($sql)) {
        $this->setIdCompraEstTipo($id);

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
    $sql = "UPDATE compraestadotipo SET cetdescripcion = '{$this->getCetDescripcion()}', cetdetalle = '{$this->getCetDetalle()}' WHERE idcompraestado = {$this->getIdCompraEstTipo()}";
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

  public function eliminar() {
    $resp = false;
    $base = new BaseDatos();
    $sql = "DELETE FROM compraestadotipo WHERE idcompraestadotipo= {$this->getIdCompraEstTipo()}";
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
    $sql = "SELECT * FROM compraestadotipo ";
    if ($parametro != "") {
      $sql .= " WHERE {$parametro}";
    }
    $res = $base->Ejecutar($sql);
    if ($res > -1) {
      if ($res > 0) {

        while ($row = $base->Registro()) {
          $obj = new CompraEstadoTipo();
          $obj->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);

          array_push($arreglo, $obj);
        }
      }
    }

    return $arreglo;
  }
}
