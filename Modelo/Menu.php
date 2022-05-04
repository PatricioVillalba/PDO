<?php

class Menu
{

  private $idmenu;
  private $menombre;
  private $medescripcion;
  private $objmepadre;
  private $medeshabilitado;
  private $link;
  private $msjerror;

  public function __construct()
  {
    $this->idmenu = null;
    $this->menombre = '';
    $this->medescripcion = '';
    $this->objmepadre = null;
    $this->link = '';
    $this->medeshabilitado = '';
  }

  public function setear($idmenu, $menombre, $meDescrip, $objmepadre, $medeshabilitado, $link)
  {
    $this->setIdMenu($idmenu);
    $this->setMeNombre($menombre);
    $this->setMeDescripcion($meDescrip);
    $this->setObjMePadre($objmepadre);
    $this->setMeDeshabilitado($medeshabilitado);
    $this->setLink($link);
  }

  public function getIdMenu()
  {
    return $this->idmenu;
  }
  public function setIdMenu($idmenu)
  {
    $this->idmenu = $idmenu;
  }

  public function getMeNombre()
  {
    return $this->menombre;
  }
  public function setMeNombre($menombre)
  {
    $this->menombre = $menombre;
  }

  public function getMeDescripcion()
  {
    return $this->medescripcion;
  }
  public function setMeDescripcion($meDescrip)
  {
    $this->medescripcion = $meDescrip;
  }

  /**
   * @return Menu
   */
  public function getObjMePadre()
  {
    return $this->objmepadre;
  }
  public function setObjMePadre($idPadre)
  {
    $this->objmepadre = $idPadre;
  }

  public function getMeDeshabilitado()
  {
    return $this->medeshabilitado;
  }
  public function setMeDeshabilitado($meDeshabli)
  {
    $this->medeshabilitado = $meDeshabli;
  }
  public function getLink()
  {
    return $this->link;
  }
  public function setLink($link)
  {
    $this->link = $link;
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
    $sql = "SELECT * FROM menu WHERE idmenu = {$this->getIdMenu()}";
    if ($base->Iniciar()) {
      $res = $base->Ejecutar($sql);
      if ($res > -1) {
        if ($res > 0) {
          $row = $base->Registro();

          if ($row['idpadre'] != null) {
            $objMenuPadre = new Menu();
            $objMenuPadre->setIdMenu($row['idpadre']);
            $objMenuPadre->cargar();
          } else {
            $objMenuPadre = null;
          }

          $this->setear($row['idmenu'], $row['menombre'], $row['medescripcion'], $objMenuPadre, $row['medeshabilitado'], $row['link']);
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
    $estado = $this->getMeDeshabilitado() == 1 ? 'null' : date('Y-m-d H:i:s');
    $idPadre = $this->getObjMePadre() != null ? $this->getObjMePadre()->getIdMenu() : 'null';
      
      $sql = "INSERT INTO menu (menombre, medescripcion, idpadre, medeshabilitado,link) VALUES ('{$this->getMeNombre()}','{$this->getMeDescripcion()}',".$idPadre.",".$estado.",'{$this->getLink()}')";
      
      if ($base->Iniciar()) {
      if ($elId = $base->Ejecutar($sql)) {
        $this->setIdMenu($elId);
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
    $estado = $this->getMeDeshabilitado() == 1 ? 'null' : date('Y-m-d H:i:s');
    $idPadre = $this->getObjMePadre() != null ? $this->getObjMePadre()->getIdMenu() : 'null';

    $sql = "UPDATE menu SET menombre='{$this->getMeNombre()}', medescripcion='{$this->getMeDescripcion()}', idpadre={$idPadre},medeshabilitado='{$estado}',link='{$this->getLink()}' WHERE idmenu={$this->getIdMenu()}";  
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
    $sql = "DELETE FROM menu WHERE idmenu={$this->getIdMenu()}";
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
    $sql = "SELECT * FROM menu ";
    if ($parametro != "") {
      $sql .= " WHERE {$parametro}";
    }
    $res = $base->Ejecutar($sql);
    if ($res > -1) {
      if ($res > 0) {
        while ($row = $base->Registro()) {
          $obj = new Menu();

          if ($row['idpadre'] != null) {
            $objMenuPadre = new Menu();
            $objMenuPadre->setIdMenu($row['idpadre']);
            $objMenuPadre->cargar();
          } else {
            $objMenuPadre = null;
          }

          $obj->setear($row['idmenu'], $row['menombre'], $row['medescripcion'], $objMenuPadre, $row['medeshabilitado'], $row['link']);

          array_push($arreglo, $obj);
        }
      }
    }

    return $arreglo;
  }
}