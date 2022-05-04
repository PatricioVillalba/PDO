<?php
$title = 'Menu';
include_once 'includes/head.php';
$session= new Session();
$permisos=[2,1];

if ($session->activa() && in_array($session->getRolActual(),$permisos)) {
    include_once 'includes/navbar.php';
}else{
    header("Location:login.php");
    exit;
}
$abmMenu = new AbmMenu();
$abmRol = new AbmRol();
$listaMenu = $abmMenu->buscar(null);
$listaRol = $abmRol->buscar(null);
?>


<div class="container">
    <button class="btn btn-success mt-5" type="button" data-bs-toggle="modal" data-bs-target="#modalMenu" onclick="limpiarModal()"> Nuevo </button>
    <table class="table table-striped table-hover">
        <?php
        if (count($listaMenu) > 0) {
            $i = 0; ?>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">ID padre</th>
                    <th scope="col">Link</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col"></th>
                </tr>
            </thead>

            <tbody id="tbodymenu">
                <?php
                $i = 0;
                foreach ($listaMenu as $objMenu) {
                    $idpadre = is_null($objMenu->getObjMePadre()) ? '-' : $objMenu->getObjMePadre()->getIdMenu();
                    $estado = is_null($objMenu->getMeDeshabilitado()) ? 'Habilitado' : $objMenu->getMeDeshabilitado();
                ?>
                    <tr id="trMenu<?= $objMenu->getIdMenu() ?>">
                        <td id="filaidmenu<?= $objMenu->getIdMenu() ?>"><?= $objMenu->getIdMenu() ?></td>
                        <td id="filanombremenu<?= $objMenu->getIdMenu() ?>"><?= $objMenu->getMeNombre() ?></td>
                        <td id="filaidapdremenu<?= $objMenu->getIdMenu() ?>"><?= $idpadre ?></td>
                        <td id="filalinkmenu<?= $objMenu->getIdMenu() ?>"><?= $objMenu->getLink() ?></td>
                        <td id="filaestadomenu<?= $objMenu->getIdMenu() ?>"><?= $estado ?></td>
                        <td id="filadescripcionmenu<?= $objMenu->getIdMenu() ?>"><?= $objMenu->getMeDescripcion() ?></td>
                        <td>
                            <button class="btn btn-danger" onclick="borrarMenu('<?= $objMenu->getIdMenu() ?>')">
                                <i class="bi bi-trash"></i>
                            </button>
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalMenuEdit" onclick="abrirmodaleditarMenu('<?= $objMenu->getIdMenu() ?>')">
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
    <div class="modal fade" id="modalMenu" tabindex="-1" aria-labelledby="modalRolLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRolLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" id="formNuevoMenu">
                        <input id="accion" name="accion" type="hidden" value="nuevo">
                        <label for="exampleInputEmail1" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="menombre" name="menombre" placeholder="Nombre" />
                        <label for="exampleInputEmail1" class="form-label">Padre </label>
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="idpadre" name="idpadre">
                            <option value="<?= null ?>" selected>Seleccione Padre</option>
                            <option value="<?= null ?>">Sin Padre</option>
                            <?php
                            foreach ($listaMenu as $objMenu) { ?>
                                <option value="<?= $objMenu->getIdMenu() ?>"><?= $objMenu->getMeNombre() ?></option>
                            <?php    }
                            ?>
                        </select>
                        <label for="exampleInputEmail1" class="form-label">Link</label>
                        <input type="text" class="form-control" id="linkmenu" name="link" placeholder="link" />
                        <label for="exampleInputEmail1" class="form-label">Descripcion</label>
                        <input type="text" class="form-control" id="medescripcion" name="medescripcion" placeholder="Descripcion" />
                        <label for="exampleInputEmail1" class="form-label">Estado</label>
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="medeshabilitado" name="medeshabilitado" required>
                            <option value="1">Habilitado</option>
                            <option value="2">DesHabilitado</option>
                        </select>
                        <label for="exampleInputEmail1" class="form-label">Roles</label><br>
                        <select class="selectpicker form-select-sm" multiple aria-label=".form-select-sm example" name="roles[]">
                            <?php foreach ($listaRol as $rol) {
                            ?>
                                <option value="<?=$rol->getIdRol()?>"><?= $rol->getRoDescripcion()?></option>
                            <?php
                            }
                            ?>
                        </select>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <input type="submit" name="submit" class="btn btn-primary submitBtn m-1" id="" value="nuevo" />
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalMenuEdit" tabindex="-1" aria-labelledby="modalRolEdit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRolLabel">Editar Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" id="formEditarMenu">
                        <input id="accion" name="accion" type="hidden" value="editar">
                        <input type="text" class="form-control" id="idmenuedit" name="idmenu" placeholder="" readonly/>
                        <label for="exampleInputEmail1" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="menombreedit" name="menombre" placeholder="Nombre" />
                        <label for="exampleInputEmail1" class="form-label">Padre </label>
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="idpadreedit" name="idpadre" required>
                            <option value="<?= null ?>" selected>Seleccione Padre</option>
                            <option value="<?= null ?>">Sin Padre</option>
                            <?php
                            foreach ($listaMenu as $objMenu) { ?>
                                <option value="<?= $objMenu->getIdMenu() ?>"><?= $objMenu->getMeNombre() ?></option>
                            <?php    }
                            ?>
                        </select>
                        <label for="exampleInputEmail1" class="form-label">Link</label>
                        <input type="text" class="form-control" id="linkmenuedit" name="link" placeholder="link" />
                        <label for="exampleInputEmail1" class="form-label">Descripcion</label>
                        <input type="text" class="form-control" id="medescripcionedit" name="medescripcion" placeholder="Descripcion" />
                        <label for="exampleInputEmail1" class="form-label">Estado</label>
                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="medeshabilitadoedit" name="medeshabilitado" required>
                            <option value="1">Habilitado</option>
                            <option value="2">DesHabilitado</option>
                        </select>
                        <label for="exampleInputEmail1" class="form-label">Roles</label><br>
                        <select class="selectpicker form-select-sm" multiple aria-label=".form-select-sm example" name="roles[]" id="rolesedit" required>
                            <?php foreach ($listaRol as $rol) {
                            ?>
                                <option value="<?=$rol->getIdRol()?>"><?= $rol->getRoDescripcion()?></option>
                            <?php
                            }
                            ?>
                        </select>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <input type="submit" name="submit" class="btn btn-primary submitBtn m-1" id="" value="Editar" />
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- fin modal -->
</div>

<?php include_once 'includes/footer.php' ?>