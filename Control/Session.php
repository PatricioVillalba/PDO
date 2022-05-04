<?php
class Session
{
  private $objUsuario;
  private $colRoles;
  private $rolActual;
  private $carrito;

  public function __construct()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
      $this->objUsuario = null;
      $this->colRoles = null;
      $this->rolActual = null;
    }
  }

  public function iniciar($nombreUsuario, $psw)
  {
    $inicio = false;
    $datos['usnombre'] = $nombreUsuario;
    $datos['uspass'] = $psw;
    $abmUsuario = new AbmUsuario();
    $abmUsuarioRol = new AbmUsuarioRol();
    $colUsuarios = $abmUsuario->buscar($datos);
    if (count($colUsuarios) > 0) {
      $usuario = $colUsuarios[0];
      $this->setObjUsuario($usuario);
      $_SESSION['idusuario'] = $usuario->getIdUsuario();
      $_SESSION['carrito'] = [];
      $datos['idusuario'] =  $usuario->getIdUsuario();
      $colUsuariosRol = $abmUsuarioRol->buscar($datos);
      if (count($colUsuariosRol) > 0) {
        $usuarioRol = $colUsuariosRol[0];
        $this->setRolActual($usuarioRol->getObjRol()->getIdRol());
        $_SESSION['rol'] = $usuarioRol->getObjRol()->getIdRol();
        $inicio = true;
      }
      if (count($colUsuarios) > 0 && $colUsuarios[0]->getUsDeshabilitado() == null) {
        $usuario = $colUsuarios[0];
        $this->setObjUsuario($usuario);
      }
    }
    return $inicio;
  }

  /**
   * @return Usuario
   */
  //si no hay usuario cargado 
  public function getObjUsuario()
  {
    if ($this->objUsuario == null && isset($_SESSION['idusuario'])) {
      $abmUsuario = new AbmUsuario();
      $datos['idusuario'] = $_SESSION['idusuario'];
      $usuario = $abmUsuario->buscar($datos);

      if (count($usuario) > 0) {
        $this->setObjUsuario($usuario[0]);
      }
    }

    return $this->objUsuario;
  }
  public function setObjUsuario($objUsuario)
  {
    $this->objUsuario = $objUsuario;
  }

  public function getCarrito()
  {
    if (isset($_SESSION['carrito'])) {
      $this->setCarrito($_SESSION['carrito']);
    }
    return $this->carrito;
  }

  public function setCarrito($carrito)
  {
    $this->carrito = $carrito;
  }

  public function getColRoles()
  {
    if (!$this->colRoles) {
      $this->setColRoles($this->getObjUsuario()->getColRoles());
    }

    return $this->colRoles;
  }
  public function setColRoles($colRoles)
  {
    $this->colRoles = $colRoles;
  }

  public function getRolActual()
  {
    if (isset($_SESSION['rol'])) {
      $this->setRolActual($_SESSION['rol']);
    }
    return $this->rolActual;
  }
  public function setRolActual($rolActual)
  {
    $this->rolActual = $rolActual;
  }

  public function validar()
  {
    return ($this->getObjUsuario() != null) ? true : false;
  }

  static public function activa()
  {
    return (isset($_SESSION['idusuario'])) ? true : false;
  }

  public function cerrar()
  {
    // if ($this->getObjUsuario()) {
    session_unset();
    session_destroy();
    $this->objUsuario = null;
    $this->colRoles = null;
    // }
  }

  public function vaciar()
  {
    $_SESSION['carrito'] = [];
  }

  public function agregar($datos)
  {

    if (!isset($_SESSION['carrito'])) {
      $carrito = [];
    }

    array_push($_SESSION['carrito'], $datos);
  }

  public function incrementar($datos)
  {
    $encontreProducto = false;
    $arrNuevo = [];
    $carrito = $_SESSION["carrito"];
    $i = 0;
    do {
      if ($carrito[$i]["idproducto"] == $datos["id"]) {
        $encontreProducto = true;
        $carrito[$i]["cantProd"] = ($carrito[$i]["cantProd"] + 1);
        $carrito[$i]["productoprecio"] = ($carrito[$i]["cantProd"] * $datos['valor']);
      }
      $i++;
    } while ($i < count($carrito) && $encontreProducto == false);
    $arrNuevo = array_merge($carrito, $arrNuevo);
    $_SESSION["carrito"] = $arrNuevo;
  }

  public function disminuir($datos)
  {
    $encontreProducto = false;
    $arrNuevo = [];
    $carrito = $_SESSION["carrito"];
    $i = 0;
    do {
      if ($carrito[$i]["idproducto"] == $datos["id"]) {
        $encontreProducto = true;
        $carrito[$i]["cantProd"] = ($carrito[$i]["cantProd"] - 1);
        $carrito[$i]["productoprecio"] = ($carrito[$i]["cantProd"] * $datos['valor']);
      }
      $i++;
    } while ($i < count($carrito) && $encontreProducto == false);
    $arrNuevo = array_merge($carrito, $arrNuevo);
    $_SESSION["carrito"] = $arrNuevo;
  }

  public function borrar($datos)
  {
    $arrNuevo = [];
    $carrito = $_SESSION["carrito"];
    $i = 0;
    do {
      if ($carrito[$i]["idproducto"] == $datos["id"]) {
        $encontreProducto = true;
        unset($carrito[$i]);
      }
      $i++;
    } while ($i < count($carrito));
    $arrNuevo = array_merge($carrito, $arrNuevo);
    unset($_SESSION["carrito"]);
    $_SESSION["carrito"] = $arrNuevo;
  }

  public function cambioRol($datos){
    if (isset($datos['idrol'])) {
      $_SESSION['rol']=($datos['idrol']);
    };
  }
}
