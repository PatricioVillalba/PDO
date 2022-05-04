<?php

class AbmRol {

  /**
   * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
   * @param array $datos
   * @return Rol
   */
  private function cargarObjeto($datos) {
    $obj = null;

    if (
      array_key_exists('idrol', $datos) &&
      array_key_exists('rodescripcion', $datos)
    ) {

      $obj = new Rol();

      $obj->setear($datos['idrol'], $datos['rodescripcion']);
    }
    return $obj;
  }

  /**
   * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
   * @param array $datos
   * @return Rol
   */
  private function cargarObjetoConClave($datos) {
    $obj = null;

    if (isset($datos['idrol'])) {
      $obj = new Rol();
      $obj->setear($datos['idrol'], null);
    }
    return $obj;
  }


  /**
   * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
   * @param array $datos
   * @return boolean
   */

  private function seteadosCamposClaves($datos) {
    $resp = false;
    if (isset($datos['idrol']))
      $resp = true;
    return $resp;
  }

  /**
   * Permite ingresar un registro en la base de datos
   * @param array $datos
   * @return boolean
   */
  public function alta($datos) {
    $resp = false;
    $datos['idrol'] = null;
    $obj = $this->cargarObjeto($datos);

    if ($obj != null && $obj->insertar()) {
      $resp = true;
    }
    return $resp;
  }
  /**
   * permite eliminar un objeto 
   * @param array $datos
   * @return boolean
   */
  public function baja($datos) {
    $resp = false;
    if ($this->seteadosCamposClaves($datos)) {
      $obj = $this->cargarObjetoConClave($datos);
      if ($obj != null && $obj->eliminar()) {
        $resp = true;
      }
    }

    return $resp;
  }

  /**
   * permite modificar un objeto
   * @param array $datos
   * @return boolean
   */
  public function modificacion($datos) {
    $resp = false;
    if ($this->seteadosCamposClaves($datos)) {
      $obj = $this->cargarObjeto($datos);
      if ($obj != null && $obj->modificar()) {
        $resp = true;
      }
    }
    return $resp;
  }

  /**
   * permite buscar un objeto
   * @param array $datos
   * @return array
   */
  public function buscar($datos) {
    $where = " true ";
    if ($datos != null) {
      if (isset($datos['idrol']))
        $where .= " and idrol  = {$datos['idrol']}";
      if (isset($datos['rodescripcion']))
        $where .= " and rodescripcion = '{$datos['rodescripcion']}'";
    }

    $arreglo = Rol::listar($where);
    return $arreglo;
  }

  public function cambiarRol($datos) {
  
    $resp = false;
    $session = new Session();
    $_SESSION['rol'] = $datos['idrol'];
    $session->setRolActual($_SESSION['rol']);
    exit;
  
  }
}
