<?php
include_once 'includes/head.php';
$objAbmRol = new AbmRol();
$session = new Session();
$listaRol = $objAbmRol->buscar(null);
$permisos = [1];
if ($session->activa() && in_array($session->getRolActual(), $permisos)) {
    include_once 'includes/navbar.php';
} else {
    header('Location: login.php');
    exit;
}
?>

<div class="container">
    <button class="btn btn-success mt-5" type="button" data-bs-toggle="modal" data-bs-target="#modalRol" onclick="nuevoRol()"> Nuevo </button>
    <table class="table table-striped table-hover">
        <?php
        if (count($listaRol) > 0) {
            $i = 0; ?>
            <thead class="">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Descripcion</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="tbodyrol">
                <?php
                $i = 0;
                foreach ($listaRol as $objRol) {
                    // print_r($objRol->getIdRol());exit;
                ?>
                    <tr id="trRol<?= $objRol->getIdRol() ?>">
                        <td id="tablaidrol<?= $objRol->getIdRol() ?>"><?= $objRol->getIdRol() ?></td>
                        <td id="tabladescrol<?= $objRol->getIdRol() ?>"><?= $objRol->getRoDescripcion() ?></td>
                        <td>
                            <button class="btn btn-danger" onclick="borrarol('<?= $objRol->getIdRol() ?>')">
                                <i class="bi bi-trash"></i>
                            </button>
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalRol" onclick="abrirmodaleditarRol('<?= $objRol->getIdRol() ?>')">
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
    <div class="modal fade" id="modalRol" tabindex="-1" aria-labelledby="modalRolLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRolLabel">Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label id="labeluserrol" for="exampleInputEmail1" class="form-label">ID</label>
                    <input type="text" class="form-control" id="inputrolid" aria-describedby="emailHelp" readonly>
                    <label for="exampleInputEmail1" class="form-label">Descripcion</label>
                    <input type="text" class="form-control" id="inputroldescripcion" aria-describedby="emailHelp">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="" id="editarrol">Editar</button>
                    <button type="button" class="btn btn-primary" onclick="cargarrolNuevo()" id="crearrol">Crear</button>
                </div>
            </div>
        </div>
    </div>
    <!-- fin modal -->
</div>

<?php include_once 'includes/footer.php' ?>