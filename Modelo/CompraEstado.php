<?php

class CompraEstado {

  private $idcompraestado;
  private $objcompra;
  private $objcompraesttipo;
  private $cefechaini;
  private $cefechafin;
  private $msjerror;

  public function __construct() {
    $this->idcompraestado = null;
    $this->objcompra = null;
    $this->objcompraesttipo = null;
    $this->cefechaini = '';
    $this->cefechafin = '';
  }

  public function setear($idcompraestado, $objcompra, $objcompraesttipo, $cefechaini, $cefechafin) {
    $this->setIdCompraEstado($idcompraestado);
    $this->setObjCompra($objcompra);
    $this->setObjCompraEstTipo($objcompraesttipo);
    $this->setCeFechaini($cefechaini);
    $this->setCeFechaFin($cefechafin);
  }

  public function getIdCompraEstado() {
    return  $this->idcompraestado;
  }
  public function setIdCompraEstado($idcompraestado) {
    $this->idcompraestado = $idcompraestado;
  }

  /**
   * @return Compra
   */
  public function getObjCompra() {
    return  $this->objcompra;
  }
  public function setObjCompra($objcompra) {
    $this->objcompra = $objcompra;
  }

  /**
   * @return CompraEstadoTipo
   */
  public function getObjCompraEstTipo() {
    return  $this->objcompraesttipo;
  }
  public function setObjCompraEstTipo($objcompraesttipo) {
    $this->objcompraesttipo = $objcompraesttipo;
  }

  public function getCeFechaIni() {
    return  $this->cefechaini;
  }
  public function setCeFechaIni($cefechaini) {
    $this->cefechaini = $cefechaini;
  }

  public function getCeFechaFin() {
    return  $this->cefechafin;
  }
  public function setCeFechaFin($cefechafin) {
    $this->cefechafin = $cefechafin;
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
    $sql = "SELECT * FROM compraEstado WHERE idcompraestado = {$this->getIdCompraEstado()}";
    if ($base->Iniciar()) {
      $res = $base->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $base->Registro();

          $objcompra = new Compra();
          $objcompra->setIdCompra($row['idcompra']);
          $objcompra->cargar();

          $objCompraEstadoTipo = new CompraEstadoTipo();
          $objCompraEstadoTipo->setIdCompraEstTipo($row['compraestadotipo']);
          $objCompraEstadoTipo->cargar();

          $this->setear($row['idcompraestado'], $objcompra, $objCompraEstadoTipo, $row['cefechaini'], $row['cefechafin']);
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
    $sql = "INSERT INTO compraestado (idcompra, idcompraestadotipo, cefechaini, cefechafin) VALUES ({$this->getObjCompra()->getIdCompra()}, {$this->getObjCompraEstTipo()->getIdCompraEstTipo()}, '{$this->getCeFechaIni()}', '{$this->getCeFechaFin()}')";

    if ($base->Iniciar()) {
      if ($id = $base->Ejecutar($sql)) {
        $this->setIdCompraEstado($id);
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
    $sql = "UPDATE compraestado SET 
      idcompra = {$this->getObjCompra()->getIdCompra()},
      idcompraestadotipo = {$this->getIdCompraEstado()},
      cefechaini = '{$this->getCeFechaIni()}',
      cefechafin=" . (($this->getCeFechaFin() == '') ? "NULL" : "'{$this->getCeFechaFin()}'") . "
      WHERE idcompraestado = {$this->getObjCompraEstTipo()->getIdCompraEstTipo()}";
    print_r($sql);
    // echo $sql;
    if ($base->Iniciar()) {
      // echo "ASD";
      if ($base->Ejecutar($sql)) {
        $resp = true;
        // echo "ad";
      } else {
      // echo "ASD2222";

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
    $sql = "DELETE FROM compraestado WHERE idcompraestado = {$this->getIdCompraEstado()}";
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
    $sql = "SELECT * FROM compraestado ";
    if ($parametro != "") {
      $sql .= " WHERE {$parametro}";
    }
    // echo $sql;
    $res = $base->Ejecutar($sql);
    if ($res > -1) {
      if ($res > 0) {
        while ($row = $base->Registro()) {
          $obj = new CompraEstado();

          $objcompra = new Compra();
          $objcompra->setIdCompra($row['idcompra']);
          $objcompra->cargar();

          $objcompraesttipo = new CompraEstadoTipo();
          $objcompraesttipo->setIdCompraEstTipo($row['idcompraestadotipo']);
          $objcompraesttipo->cargar();

          $obj->setear($row['idcompraestado'], $objcompra, $objcompraesttipo, $row['cefechaini'], $row['cefechafin']);

          array_push($arreglo, $obj);
        }
      }
    }
    return $arreglo;
  }
}
