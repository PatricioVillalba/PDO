<?php

class AbmMenu
{

  /**
   * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
   * @param array $datos
   * @return Menu
   */
  private function cargarObjeto($datos)
  {
    $obj = null;
    if (array_key_exists('idmenu', $datos) && array_key_exists('menombre', $datos) &&  array_key_exists('medescripcion', $datos) &&  array_key_exists('link', $datos)) {
      $obj = new Menu();
      $objPadre = null;
      if (isset($datos['idpadre']) && $datos['idpadre'] != null) {
        $objPadre  = new Menu;
        $objPadre->setIdMenu($datos['idpadre']);
        $objPadre->cargar();
      }
      $obj->setear($datos['idmenu'], $datos['menombre'], $datos['medescripcion'], $objPadre, $datos['medeshabilitado'], $datos['link']);
    }
    return $obj;
  }

  /**
   * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
   * @param array $datos
   * @return Menu
   */
  private function cargarObjetoConClave($datos)
  {
    $obj = null;

    if (isset($datos['idmenu'])) {
      $obj = new Menu();
      $obj->setear($datos['idmenu'], null, null, null, null, null);
    }
    return $obj;
  }


  /**
   * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
   * @param array $datos
   * @return boolean
   */

  private function seteadosCamposClaves($datos)
  {
    $resp = false;
    if (isset($datos['idmenu']))
      $resp = true;
    return $resp;
  }

  /**
   * Permite ingresar un registro en la base de datos
   * @param array $datos
   * @return boolean
   */
  public function alta($datos)
  {
    $resp = false;
    $datos['idmenu'] = null;

    $obj = $this->cargarObjeto($datos);
    if ($obj != null && $obj->insertar()) {
      $resp = true;
    }

    if (!empty($datos['roles'])) {
      foreach ($datos['roles'] as $rol) {
        $abmMrol = new AbmMenuRol;
        if ($obj->getObjMePadre() != null) {
          $abmMrol->alta(['idmenu' => $obj->getIdMenu(), 'idrol' => $rol]);
        }
      }
    }
    return $obj;
  }
  /**
   * permite eliminar un objeto 
   * @param array $datos
   * @return boolean
   */
  public function baja($datos)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($datos)) {
      $obj = $this->cargarObjetoConClave($datos);
      $AbmMenuRol = new AbmMenuRol();
      $objsMenuRol = $AbmMenuRol->buscar(['idmenu' => $obj->getIdMenu()]);
      foreach ($objsMenuRol as $objMenuRol) {
      $objMenuRol->eliminar();
      }
      if ($obj != null && $obj->eliminar()) {
        $resp = true;
      }else{
        $resp = false;
      }
    }

    return $resp;
  }

  /**
   * permite modificar un objeto
   * @param array $datos
   * @return boolean
   */
  public function modificacion($datos)
  {
    $resp = false;
    if ($this->seteadosCamposClaves($datos)) {
      $obj = $this->cargarObjeto($datos);

      if ($obj != null && $obj->modificar()) {
        $resp = true;
      }

      $AbmMenuRol = new AbmMenuRol();
      $objsMenuRol = $AbmMenuRol->buscar(['idmenu' => $obj->getIdMenu()]);
      foreach ($objsMenuRol as $objMenuRol) {
        $objMenuRol->eliminar();
      }

      if (!empty($datos['roles'])) {
        foreach ($datos['roles'] as $rol) {
          $abmMrol = new AbmMenuRol;
          if ($obj->getObjMePadre() != null) {
            $abmMrol->alta(['idmenu' => $obj->getIdMenu(), 'idrol' => $rol]);
          }
        }
      }

    }
    return $obj;
  }

  function buscarIdPadre($data)
  {
    $resp = false;
    if (isset($data['idpadre']) && !is_numeric($data['idpadre'])) {
      $abmMenu = new AbmMenu;
      $colMenusPadre = $abmMenu->buscar(null);
      $x = 0;
      while ($x < count($colMenusPadre) && !$resp) {
        $menu = $colMenusPadre[$x];
        if ($menu->getMeNombre() == $data['idpadre']) {
          $data['idpadre'] = $menu->getIdMenu();
          $resp = true;
        }
        $x++;
      }
    }
    return $data;
  }

  /**
   * permite buscar un objeto
   * @param array $datos
   * @return array
   */
  public function buscar($datos)
  {
    $where = " true ";
    if ($datos != null) {
      if (isset($datos['idmenu']))
        $where .= " and idmenu  = {$datos['idmenu']}";
      if (isset($datos['menombre']))
        $where .= " and menombre = '{$datos['menombre']}'";
      if (isset($datos['medescripcion']))
        $where .= " and medescripcion = '{$datos['medescripcion']}'";
      if (isset($datos['idpadre']))
        $where .= " and idpadre = {$datos['idpadre']}";
      if (isset($datos['medeshabilitado']))
        $where .= " and medeshabilitado = '{$datos['medeshabilitado']}'";
      if (isset($datos['link']))
        $where .= " and link = '{$datos['link']}'";
    }

    return Menu::listar($where);
  }

  public function buscarPadres()
  {
    $where = " true and idpadre is null";
    return Menu::listar($where);
  }
}
