<?php

class Compra {

  private $idcompra;
  private $cofecha;
  private $objusuario;
  private $colCompraEstados;
  private $colCompraItems;
  private $msjerror;

  public function __construct() {
    $this->idcompra = null;
    $this->cofecha = '';
    $this->objusuario = null;
    $this->colCompraEstado = [];
    $this->colCompraItems = [];
  }

  public function setear($idcompra, $cofecha, $objusuario) {
    $this->setIdCompra($idcompra);
    $this->setCoFecha($cofecha);
    $this->setObjUsuario($objusuario);
  }

  public function getIdCompra() {
    return  $this->idcompra;
  }
  public function setIdCompra($idcompra) {
    $this->idcompra = $idcompra;
  }

  public function getCoFecha() {
    return  $this->cofecha;
  }
  public function setCoFecha($cofecha) {
    $this->cofecha = $cofecha;
  }

  /**
   * @return Usuario
   */
  public function getObjUsuario() {
    return  $this->objusuario;
  }
  public function setObjUsuario($objusuario) {
    $this->objusuario = $objusuario;
  }

  public function getColCompraEstados() {
    if (empty($this->colCompraEstados)) {
      $ambCE = new AbmCompraEstado();
      $condicionCE['idcompra'] = $this->getIdCompra();
      $colCE = $ambCE->buscar($condicionCE);      
      $this->setColCompraEstados($colCE);
    }
    return $this->colCompraEstados;
  }
  public function getCompraEstadoActual() {
      $ColCompraEstados=$this->getColCompraEstados();
      $ambCE= new AbmCompraEstado();
      $CompraEstadosActual=null;
      foreach ($ColCompraEstados as $CompraEstados) {
        $IdCompraEstTipo=$CompraEstados->getObjCompraEstTipo()->getIdCompraEstTipo();
        $FechaFin=$CompraEstados->getCeFechaFin();
        // verEstructura();
        if(is_null($FechaFin) or  $IdCompraEstTipo==4){
          $condicionCE['idcompra']= $CompraEstados->getIdCompraEstado();
          $colCompraEstadosActual = $ambCE->buscar($condicionCE)[0];      
        }
      }
    return $CompraEstadosActual;
  }

  public function setColCompraEstados($colCompraEstados) {
    $this->colCompraEstados = $colCompraEstados;
  }

  public function getColCompraItems() {
    if (empty($this->colCompraItems)) {
      $ambCI = new AbmCompraItem();
      $condicionCI['idcompra'] = $this->getIdCompra();
      $colCI = $ambCI->buscar($condicionCI);

      $this->setColCompraItems($colCI);
    }

    return $this->colCompraItems;
  }
  public function setColCompraItems($colCompraItems) {
    $this->colCompraItems = $colCompraItems;
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
    $sql = "SELECT * FROM compra WHERE idcompra = {$this->getIdCompra()}";
    if ($base->Iniciar()) {
      $res = $base->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $base->Registro();

          $objUsuario = new Usuario();
          $objUsuario->setIdUsuario($row['idusuario']);
          $objUsuario->cargar();

          $this->setear($row['idcompra'], $row['cofecha'], $objUsuario);
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
    $sql = "INSERT INTO compra (cofecha, idusuario) VALUES ('{$this->getCoFecha()}', {$this->getObjUsuario()->getIdUsuario()})";

    if ($base->Iniciar()) {
      if ($elId = $base->Ejecutar($sql)) {
        $this->setIdCompra($elId);
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
    $sql = "UPDATE compra SET cofecha = '{$this->getCoFecha()}', idusuario = {$this->getObjUsuario()->getIdUsuario()} WHERE idcompra = {$this->getIdCompra()}";
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
    $sql = "DELETE FROM compra WHERE idcompra = {$this->getIdCompra()}";
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
    $sql = "SELECT * FROM compra ";
    if ($parametro != "") {
      $sql .= " WHERE {$parametro}";
    }

    $res = $base->Ejecutar($sql);
    if ($res > -1) {
      if ($res > 0) {
        while ($row = $base->Registro()) {
          $obj = new Compra();

          $objusuario = new Usuario();
          $objusuario->setIdUsuario($row['idusuario']);
          $objusuario->cargar();

          $obj->setear($row['idcompra'], $row['cofecha'], $objusuario);

          array_push($arreglo, $obj);
        }
      }
    }

    return $arreglo;
  }

  public function getestadoActual(){
    return $this->getColCompraEstados()[0]->getObjCompraEstTipo()->getCetDescripcion();
  }
}
