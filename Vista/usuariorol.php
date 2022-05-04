<?php
$title = 'Inicio';
include_once 'includes/head.php';
// include_once 'includes/navbar.php';
$objAbmUsuario = new AbmUsuario();
$listaUsuarioRol = $objAbmUsuario->buscar(null);
$objAbmRol = new AbmRol();
$listaRol = $objAbmRol->buscar(null);
$session = new Session();
$permisos = [1];
if ($session->activa() && in_array($session->getRolActual(), $permisos)) {
    include_once 'includes/navbar.php';
} else {
    header('Location: login.php');
    exit;
}
?>

 
<div class="container">
    <!-- <button class="btn btn-success mt-5" type="button" data-bs-toggle="modal" data-bs-target="#modalUserRol" onclick="nuevoUser()"> Nuevo </button> -->
    <table class="table table-striped table-hover">
        <?php
        if (count($listaUsuarioRol) > 0) {
            $i = 0; ?>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">rol</th>
                </tr>
            </thead>

            <tbody id="tbodyuser">
                <?php
                $i = 0;
                foreach ($listaUsuarioRol as $objUsuariorol) {
                    $idUsuario=$objUsuariorol->getIdUsuario();
                    $nombreUser=$objUsuariorol->getUsNombre();
                    ?>  
                    <tr id="trUserRol<?= $idUsuario ?>">
                        <td><?= $idUsuario ?></td>
                        <td id="tablaiduseRol<?= $idUsuario ?>"><?= $nombreUser ?></td>
                        <td id="tabladescuseRol<?= $idUsuario ?>">
                            <?php 
                                $roles=$objUsuariorol->getColRoles(); 
                                foreach ($roles as $key => $rol) {
                                    echo ($rol->getRoDescripcion()).'  ';
                                }
                                 
                            ?>
                        </td>
                        <td>
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalUserRol" onclick="abrirmodaleditarUsuarioRol('<?= $idUsuario ?>')">
                                <i class="bi bi-pencil"></i>
                            </button>
                        </td>
                    </tr>

            <?php
                    $i = $i + 1;
                }
            }
            ?>
            </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="modalUserRol" tabindex="-1" aria-labelledby="modalUserRolLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUserRolLabel">Usuario Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label id="labeluserid" for="" class="form-label">ID</label>
                    <input type="text" class="form-control" id="inputusid" aria-describedby="emailHelp" readonly>
                    <label for="" class="form-label" >NOMBRE</label>
                    <input type="text" class="form-control" id="inputusnombre" aria-describedby="emailHelp" readonly>
                    <!-- <label for="" class="form-label">CONTRASEÑA</label>
                    <input type="text" class="form-control" id="inputuspass" aria-describedby="emailHelp" readonly> -->
                    <label for="" class="form-label" >MAIL</label>
                    <input type="text" class="form-control" id="inputusmail" aria-describedby="emailHelp" readonly>
                    <!-- <label for="" class="form-label" >ESTADO</label>
                    <input type="text" class="form-control" id="inputdeshabilitado" aria-describedby="emailHelp" readonly> -->
                    <!-- <select class="form-select" aria-label="Default select example" id="inputdeshabilitado" readonly>
                        <option value="1">Habilitado</option>
                        <option value="2">Deshabilitado</option>
                    </select> -->
                    <label for="" class="form-label" >ROLES</label>
                    <?php
                    foreach ($listaRol as $rol) {
                        $idRol=$rol->getIdRol();
                        $check='';
                    ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="<?=$idRol?>" id="checkRoles<?= $idRol ?>" <?= $check?>>
                        <label class="form-check-label" for="idRoles">
                            <?php print_r($rol->getRoDescripcion()) ?>
                        </label>
                    </div>
                    <?php    
                        }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="" id="editarusuarioRol">Editar</button>
                    <!-- <button type="button" class="btn btn-primary" onclick="cargarUsNuevo()" id="crearus">Crear</button> -->
                </div>
            </div>
        </div>
    </div>
    <!-- fin modal -->
</div>

<?php include_once 'includes/footer.php' ?>