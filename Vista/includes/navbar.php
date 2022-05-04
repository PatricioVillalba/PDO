<?php
include_once "../configuracion.php";
$session = new Session();
$control = new NavbarControl();

?>
<style>
    .dropdown-hover-all .dropdown-menu,
    .dropdown-hover>.dropdown-menu.dropend {
        margin-left: -1px !important
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h5> <a class="navbar-brand" href="<?= $INICIO ?>">Libreria</a></h5>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                    </ul>
                </li> -->
                <!-- <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= $INICIO ?>">Libros</a>
                </li> -->
                <?php
                if ($session->activa()) { //COMIENZA MENU PRIVADO (SOLO USUARIOS LOGUEADOS)
                    $roles = $control->rolesUsuario($session);
                    $rolActual = $control->rolActual($session);
                    $usuarioNombre = $control->NombreUsuario($session);
                    $menuRol = $control->menuRol($session); //TRAE TODOS LOS MENUES DEL ROL ACTUAL

                    foreach ($menuRol as $menuRol) {
                        $menu = $menuRol->getObjMenu(); //GUARDO EL OBJETO MENU EN UNA VARIABLE MENU
                        
                        //SI ES EL ROL ACTUAL Y ES UN OBJETO MENU PADRE
                        if ($menuRol->getObjRol()->getIdRol() == $rolActual->getIdRol() && !$menu->getObjMePadre()) {
                            $subMenues = $control->subMenues($menu); //BUSUCO TODOS LOS HIJOS DE ESE MENU

                            if (!$subMenues) { //SI NO HAY SUBMENUES
                                echo (' <li class="nav-item">
                                            <a class="nav-link" href="'.$menu->getLink().'">' . $menu->getMeNombre() . '</a>
                                         </li>'
                                    );
                            } else {
                                echo ('<li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . $menu->getMeNombre() . '</a>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">');
                                foreach ($subMenues as $subMenu) {
                                    echo (' <li>
                                                <a class="dropdown-item" href="'.$subMenu->getLink().'">' . $subMenu->getMeNombre() . '</a>
                                            </li>'
                                        );
                                }
                                    echo ('</ul>
                                    </li>');
                            }
                        }
                    }
                    ?>
                   
                    
                    <?php

                    if ($rolActual->getRoDescripcion() == 'Cliente') {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="carrito.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
                        </li>
                    <?php } ?>
                    <?php
                    if ($rolActual->getRoDescripcion() == 'Administrador') {
                    ?>


                    <?php } ?>
                    <!-- </ul> -->
                    <?php
                    if ($rolActual->getRoDescripcion() == 'Deposito') {
                    ?>
                        <li class="nav-item">
                        </li>
                    <?php } ?>
            </ul>

            <div class="dropdown dropstart">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <!-- <strong class="px-2"style="color:black"><?= $usuarioNombre ?></strong> -->
                    <!-- <i class="fas fa-user" style="color:black"></i> -->
                    <img src="https://cdn-icons-png.flaticon.com/512/1946/1946429.png" alt="" width="32" height="32" class="rounded-circle me-2">
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow " aria-labelledby="dropdownUser1">
                    <li class=""><a class="dropdown-item disabled"><b><?= $usuarioNombre ?></b></a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <?php
                    foreach ($roles as $rol) { ?>
                        <?php $active = ($rolActual->getIdRol() == $rol->getIdRol()) ? 'active' : ''; ?>
                        <button class="dropdown-item <?= $active ?>" onclick="cambiarRol(<?= $rol->getIdRol() ?>)">
                            <?php echo ($rol->getRoDescripcion()) ?>
                        </button>
                    <?php
                    }
                    ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class=""><button class="dropdown-item" onclick="cerrarSesion()" role="button" id="btnCerrar">Cerrar sesion</button></li>
                </ul>
            </div>
            <?php
                    if ($rolActual->getRoDescripcion() == 'Administrador') {
                        // echo ('menu Administrador');
                    }
                    if ($rolActual->getRoDescripcion() == 'Cliente') {
                        // echo ('menu cliente');
                    }
                    if ($rolActual->getRoDescripcion() == 'Deposito') {
                        // echo ('menu Deposito');
                    }
            ?><?php } else { ?>
            </ul>
            <a class="btn btn-success" href="login.php">iniciar Session</a>
        </div>
    <?php } ?>
    </div>
    </div>
</nav>

<?php include_once 'includes/footer.php' ?>
