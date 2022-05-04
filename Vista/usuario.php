<?php
$title = 'Inicio';
include_once 'includes/head.php';
$session = new Session();

$objAbmUsuario = new AbmUsuario();
$listaUsuario = $objAbmUsuario->buscar(null);
$permisos = [1];
if ($session->activa() && in_array($session->getRolActual(), $permisos)) {
    include_once 'includes/navbar.php';
} else {
    header('Location: login.php');
    exit;
}
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Usuarios</h1>
            <form class="row g-3">
                <div class="col-10">
                <input type="text" class="form-control" id="buscarUsuarioAjax" aria-describedby="" placeholder="Buscar Usuario" onchange="">

                </div>
                <div class="col-2 d-flex justify-content-end">
                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#modalUser" onclick="nuevoUser()"> Nuevo </button>                </div>
            </form>
        </div>

    </div>
    <table class="table table-striped table-hover" id="tablaUsuario">
        <?php
        if (count($listaUsuario) > 0) {
            $i = 0; ?>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Contraseña</th>
                    <th scope="col">Mail</th>
                    <th scope="col">Deshabilitado</th>
                    <th scope="col">botones</th>
                </tr>
            </thead>

            <tbody id="tbodyuser">
                <?php
                $i = 0;
                foreach ($listaUsuario as $objUsuario) {
                    // print_r($objUsuario->getIdUsuario());exit;
                ?>
                    <tr id="trUser<?= $objUsuario->getIdUsuario() ?>">
                        <td><?= $objUsuario->getIdUsuario() ?></td>
                        <td id="tablaiduser<?= $objUsuario->getIdUsuario() ?>"><?= $objUsuario->getUsNombre() ?></td>
                        <td id="tablapassuser<?= $objUsuario->getIdUsuario() ?>"><?= substr($objUsuario->getUsPass(), 0, 5) . '...' ?></td>
                        <td id="tablamailuser<?= $objUsuario->getIdUsuario() ?>"><?= $objUsuario->getUsMail() ?></td>
                        <td id="tablaestadouser<?= $objUsuario->getIdUsuario() ?>"><?= $objUsuario->getUsDeshabilitado() ?></td>
                        <td>
                            <button class="btn btn-danger" onclick="borraus('<?= $objUsuario->getIdUsuario() ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                </svg>
                            </button>
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalUser" onclick="abrirmodaleditarUser('<?= $objUsuario->getIdUsuario() ?>')">
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
    <div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="modalUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUserLabel">Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label id="labeluserid" for="exampleInputEmail1" class="form-label">ID</label>
                    <input type="text" class="form-control" id="inputusid" aria-describedby="emailHelp" readonly>
                    <label for="exampleInputEmail1" class="form-label">NOMBRE</label>
                    <input type="text" class="form-control" id="inputusnombre" aria-describedby="emailHelp" required>
                    <label for="exampleInputEmail1" class="form-label">CONTRASEÑA</label>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Contraseña" aria-label="Recipient's username" aria-describedby="button-addon2" id="inputuspass" required>
                        <button class="btn btn-sm btn-primary" type="button" id="button-addon2">
                            <i class="fa fa-eye" id="iconoOjo" onmousedown="mouseDown()" onmouseup="mouseUp()"></i>
                        </button>
                    </div>
                    <label for="exampleInputEmail1" class="form-label" required>MAIL</label>
                    <input type="text" class="form-control" id="inputusmail" aria-describedby="emailHelp">
                    <label for="exampleInputEmail1" class="form-label">ESTADO</label>
                    <select class="form-select" aria-label="Default select example" id="inputdeshabilitado">
                        <option value="1">Habilitado</option>
                        <option value="2">Deshabilitado</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="" id="editarus">Editar</button>
                    <button type="button" class="btn btn-primary" onclick="cargarUsNuevo()" id="crearus">Crear</button>
                </div>
            </div>
        </div>
    </div>
    <!-- fin modal -->
</div>
<?php include_once 'includes/footer.php' ?>