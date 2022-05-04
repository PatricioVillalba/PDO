<?php
include_once "../configuracion.php";
$sesion = new Session();
$control = new NavbarControl();
$menu = new AbmMenu();
$menurol = new AbmMenuRol();
exit;
$datos['idrol'] = !array_key_exists('rol', $_SESSION) ?  null : $_SESSION['rol'];
if (!is_null($datos['idrol'])) {  //si no tiene rol no entra aca
    $menue = '';
    $padres = $menurol->listarPadres($datos);

    if ($sesion->activa()) {
        $roles = $control->rolesUsuario($sesion);
        $rolActual = $control->rolActual($sesion);
?>

        <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-4">Rol</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                <?php
                foreach ($padres as $padre) {
                    if ($padre->getObjRol()->getIdRol() == $_SESSION['rol']) {
                        $padre = $padre->getObjMenu();
                        $menue .= '<li>';
                        $menue .=  '<a href="#submenu' . $padre->getIdMenu() . '" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">';
                        $menue .= '<i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">' . $padre->getMeNombre() . '</span></a>';
                        $menue .= '<ul class="collapse nav flex-column ms-1" id="submenu' . $padre->getIdMenu() . '" data-bs-parent="#menu' . $padre->getIdMenu() . '">' . $menurol->crear_menu($datos) . '</ul>'; //LLamada recursiva para generar todos los niveles del menú   
                        $menue .= '</li>';
                    }
                }
                echo ($menue);
                ?>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong>mdo</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="#">New project...</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Sign out</a></li>
                </ul>
            </div>
        </div>

<?php
    }
};
?>