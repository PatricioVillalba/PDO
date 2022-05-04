<?php

class AbmUsuario {

  /**
   * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
   * @param array $datos
   * @return Usuario
   */
  private function cargarObjeto($datos) {
    $obj = null;

    if (
      array_key_exists('idusuario', $datos) &&
      array_key_exists('usnombre', $datos) &&
      array_key_exists('uspass', $datos) &&
      array_key_exists('usmail', $datos) &&
      array_key_exists('usdeshabilitado', $datos)
    ) {
      $obj = new Usuario();
      $obj->setear($datos['idusuario'], $datos['usnombre'], $datos['uspass'], $datos['usmail'], $datos['usdeshabilitado']);
    }
    return $obj;
  }

  /**
   * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
   * @param array $datos
   * @return Usuario
   */
  private function cargarObjetoConClave($datos) {
    $obj = null;

    if (isset($datos['idusuario'])) {
      $obj = new Usuario();
      //$obj->setear($datos['idusuario'], null, null, null, null);
      $obj->setear($datos['idusuario'], "", "", "", null);
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
    if (isset($datos['idusuario']))
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
    $datos['idusuario'] = null;
    $obj = $this->cargarObjeto($datos);
    if ($obj != null && $obj->insertar()) {
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
      $obj = $this->cargarObjetoConClave($datos);
      $abm = new AbmUsuarioRol();
      $array =["idusuario"=>$obj->getIdUsuario()];
      $objUsuarioRol=$abm->buscar($array);
      foreach ($objUsuarioRol as $objUR) {
        $array=["idrol"=>$objUR->getObjRol()->getIdRol(),"idusuario"=>$objUR->getObjUsuario()->getIdUsuario()];
        $abm->baja($array);
      }
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
    return $obj;
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
      if (isset($datos['usnombre']))
      $where .= " and usnombre = '{$datos['usnombre']}'";
      if (isset($datos['uspass']))
      $where .= " and uspass = '{$datos['uspass']}'";
      if (isset($datos['usmail']))
      $where .= " and usmail = '{$datos['usmail']}'";
      if (isset($datos['usdeshabilitado']))
      $where .= " and usdeshabilitado = '{$datos['usdeshabilitado']}'";
    }

    $arreglo = Usuario::listar($where);
    return $arreglo;
  }
  public function buscarAjax($datos) {
    $where = " true ";
    // verEstructura($datos);exit;

    if ($datos != null) {
      if (isset($datos['busqueda']) && $datos['busqueda']!="null"){
        $where .= " and idusuario  like '%{$datos['busqueda']}%'";
        $where .= " or usnombre like '%{$datos['busqueda']}%'";
        // $where .= " or uspass like '%{$datos['busqueda']}%'";
        $where .= " or usmail like '%{$datos['busqueda']}%'";
        $where .= " or usdeshabilitado like'%{$datos['busqueda']}%'";
      }
      // verEstructura($datos['busqueda']);
      // if ($datos['busqueda']==="null" ){
      //   verEstructura('if');
      // }else{
      //   verEstructura('else');
      // }exit;
    }
    $arreglo = Usuario::listar($where);
    $arreglo =$this->arregloUsuarios($arreglo);
    return $arreglo;
  }

  public function arregloUsuarios($datos) {
    $array=[];
    foreach ($datos as $obj) {
        array_push($array,['id'=>$obj->getIdUsuario(),'nombre'=>$obj->getUsNombre(),'UsPass'=> substr($obj->getUsPass(), 0, 5).'..' , 'UsMail'=>$obj->getUsMail(),'UsDeshabilitado'=>$obj->getUsDeshabilitado()]);
    }
    return $array;
  }
}
