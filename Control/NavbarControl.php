<?php

class NavbarControl
{
  //   function urlActual() {
  //     // $urlActual = $_SERVER['PHP_SELF'];
  //     // $urlActual = explode('/', $urlActual);
  //     // $urlActual = $urlActual[count($urlActual) - 1];
  //   }
  //     return $urlActual;
  //   }

  function rolesUsuario($sesion)
  {
    return  $sesion->getObjUsuario()->getColRoles();
  }
  function NombreUsuario($sesion)
  {
    return  $sesion->getObjUsuario()->getUsNombre();
  }

  function rolActual($sesion)
  {
    $abmRol = new AbmRol();
    return $abmRol->buscar(['idrol' => $sesion->getRolActual()])[0];
  }


  function menuRol($sesion)
  {
    $abmMenuRol = new AbmMenuRol;
    return $abmMenuRol->buscar(['idrol' => $sesion->getRolActual()]);
  }

  function menues($sesion)
  {
    $abmMenu = new AbmMenu;
    return $abmMenu->buscar(['idmenu' => $sesion->getRolActual()]);
  }

  // function menuesPadres()
  // {
  //   $abmMenuRol = new MenuRol;
  //   $menues= $this->menuRol($sesion);
  // }

  function subMenues($menues)
  {
    $abmMenu = new AbmMenu;
    return $abmMenu->buscar(['idpadre' => $menues->getIdMenu()]);
    // verEstructura($abmMenu->buscar(['idpadre' => $menues->getIdMenu()]));exit;
  }

  // function crear_menu($id_padre, $session)
  // {
  //   $abmMenu = new AbmMenu;
  //   $menues = $abmMenu->buscar(['idpadre' => $id_padre]);
  //   $sale = ""; // Vaciamos la variable menú 

  //   foreach ($menues as $menu) {
  //     // $menu=$menu->getObjMenu();
  //     $abmRol = new AbmMenuRol();
  //     $objRol = $abmRol->buscar(['idmenu' => $menu->getIdMenu()]);
  //     if (count($objRol) > 0) {
  //       $menu = $objRol[0]->getObjMenu();
  //       foreach ($objRol as $rol) {
  //         // verEstructura($buscoM[0]->getIdMenu());exit;
  //         $elRol = $rol->getObjRol();
  //         if ($elRol->getIdRol() == $session->getRolActual()) {
  //           $buscoM = $abmMenu->buscar(['idpadre' => $menu->getIdMenu()]);
  //           if (count($buscoM) > 0) {
  //             $sale .= "<li class='nav-item dropdown'>";
  //             $sale .= "<a class='nav-link dropdown-toggle' href='". $menu->getLink()."'  id='navbarDropdown" . $menu->getIdMenu() . "' role='button' data-bs-toggle='dropdown' aria-expanded='false'>" . $menu->getMeNombre() . "</a>";
  //             $sale .= "<ul  class='dropdown-menu'  aria-labelledby='navbarDropdown" . $menu->getIdMenu() . "'>" . $this->crear_menu($menu->getIdMenu(), $session) . "</ul>"; //LLamada recursiva para generar todos los niveles del menú 
  //           } else {
  //             $sale .= "<li class='nav-item '>";
  //             $sale .= "<a class='nav-link' href='". $menu->getLink() ."' role='button'  aria-expanded='false'>" . $menu->getMeNombre() . "</a>";
  //             // $sale .= "<ul  class=''  aria-labelledby='" . $menu->getIdMenu() . "'></ul>"; //LLamada recursiva para generar todos los niveles del menú 
  //           }
  //           $sale .= "</li>";
  //         }
  //       }
  //     }
  //   }
  //   return $sale;
  // }
}
