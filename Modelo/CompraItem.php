<?php

class CompraItem {

  private $idcompraitem;
  private $objproducto;
  private $objcompra;
  private $cicantidad;
  private $cipreciototal;
  private $msjerror;

  public function __construct() {

    $this->idcompraitem = null;
    $this->objproducto = null;
    $this->objcompra = null;
    $this->cicantidad = null;
  }

  public function setear($idcompraitem, $objproducto, $objcompra, $cicantidad, $cipreciototal) {
    $this->setIdCompraItem($idcompraitem);
    $this->setObjProducto($objproducto);
    $this->setObjCompra($objcompra);
    $this->setCiCantidad($cicantidad);
    $this->setCiPrecioTotal($cipreciototal);
  }

  public function getIdCompraItem() {
    return $this->idcompraitem;
  }
  public function setIdCompraItem($idcompraitem) {
    $this->idcompraitem = $idcompraitem;
  }

  /**
   * @return Producto
   */
  public function getObjProducto() {
    return $this->objproducto;
  }
  public function setObjProducto($objproducto) {
    $this->objproducto = $objproducto;
  }

  /**
   * @return Compra
   */
  public function getObjCompra() {
    return $this->objcompra;
  }
  public function setObjCompra($objcompra) {
    $this->objcompra = $objcompra;
  }

  public function getCiCantidad() {
    return $this->cicantidad;
  }
  public function setCiCantidad($cicantidad) {
    $this->cicantidad = $cicantidad;
  }

  public function getCiPrecioTotal() {
    return $this->cipreciototal;
  }
  public function setCiPrecioTotal($cipreciototal) {
    $this->cipreciototal = $cipreciototal;
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
    $sql = "SELECT * FROM compraitem WHERE idcompraitem = {$this->getIdCompraItem()}";
    if ($base->Iniciar()) {
      $res = $base->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $base->Registro();

          $objproducto = new Producto();
          $objproducto->setIdProducto($row['idproducto']);
          $objproducto->cargar();

          $objcompra = new Compra;
          $objcompra->setIdCompra($row['idcompra']);
          $objcompra->cargar();

          $this->setear($row['idcompraitem'], $objproducto, $objcompra, $row['cicantidad'], $row['cipreciototal']);
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
    $sql = "INSERT INTO compraitem (idproducto, idcompra, cicantidad, cipreciototal) VALUES ({$this->getObjProducto()->getIdProducto()}, {$this->getObjCompra()->getIdCompra()}, {$this->getCiCantidad()}, {$this->getCiPrecioTotal()})";

    if ($base->Iniciar()) {
      if ($elId = $base->Ejecutar($sql)) {
        $this->setIdCompraItem($elId);

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
    $sql = "UPDATE compraitem SET idproducto = {$this->getObjProducto()->getIdProducto()}, idcompra = {$this->getObjCompra()->getIdcompra()}, cicantidad = {$this->getCiCantidad()}, cipreciototal = {$this->getCiPrecioTotal()} WHERE idcompraitem = {$this->getIdCompraItem()}";
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
    $sql = "DELETE FROM compraitem WHERE idcompraitem= {$this->getIdCompraItem()}";
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
    $sql = "SELECT * FROM compraitem ";
    if ($parametro != "") {
      $sql .= " WHERE {$parametro}";
    }
    $res = $base->Ejecutar($sql);
    if ($res > -1) {
      if ($res > 0) {

        while ($row = $base->Registro()) {
          $obj = new CompraItem();

          $objcompra = new Compra();
          $objcompra->setIdCompra($row['idcompra']);
          $objcompra->cargar();

          $objproducto = new Producto();
          $objproducto->setIdProducto($row['idproducto']);
          $objproducto->cargar();

          $obj->setear($row['idcompraitem'], $objproducto, $objcompra, $row['cicantidad'], $row['cipreciototal']);

          array_push($arreglo, $obj);
        }
      }
    }

    return $arreglo;
  }
}
