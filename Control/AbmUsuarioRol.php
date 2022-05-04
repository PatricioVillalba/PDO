<?php

class AbmUsuarioRol {

  /**
   * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
   * @param array $datos
   * @return UsuarioRol
   */
  private function cargarObjeto($datos) {
    $obj = null;

    if (
      array_key_exists('idusuario', $datos) &&
      array_key_exists('idrol', $datos)
    ) {
      $obj = new UsuarioRol();

      $objRol = new Rol();
      $objRol->setIdRol($datos['idrol']);
      $objRol->cargar();

      $objUsuario = new Usuario();
      $objUsuario->setIdUsuario($datos['idusuario']);
      $objUsuario->cargar();



      $obj->setear($objUsuario, $objRol);
    }
    return $obj;
  }

  /**
   * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
   * @param array $datos
   * @return UsuarioRol
   */
  private function cargarObjetoConClave($datos) {
    $obj = null;

    if (
      isset($datos['idusuario']) &&
      isset($datos['idrol'])
    ) {
      $obj = new UsuarioRol();

      $objRol = new Rol();
      $objRol->setIdRol($datos['idrol']);
      $objRol->cargar();

      $objUsuario = new Usuario();
      $objUsuario->setIdUsuario($datos['idusuario']);
      $objUsuario->cargar();

      $obj->setear($objUsuario, $objRol);
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
    if (
      isset($datos['idusuario']) &&
      isset($datos['idrol'])
    )
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
    $obj = $this->cargarObjeto($datos);
    if ($obj != null and $obj->insertar()) {
    }
    return $obj;
  }

  /**
   * permite eliminar un objeto 
   * @param array $datos
   * @return boolean
   */
  public function baja($datos) {
    $resp = false;
    if ($this->seteadosCamposClaves($datos)) {
      $obj = $this->cargarObjeto($datos);
      if ($obj != null and $obj->eliminar()) {
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
      if ($obj != null and $obj->modificar()) {
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
      if (isset($datos['idusuario']))
        $where .= " and idusuario  = {$datos['idusuario']}";
      if (isset($datos['idrol']))
        $where .= " and idrol  = {$datos['idrol']}";
    }
    $arreglo = UsuarioRol::listar($where);
    return $arreglo;
  }
}
