<?php
$title = 'Inicio';
include_once 'includes/head.php';
$objAbmProducto = new AbmProducto();
$listaProducto = $objAbmProducto->buscar(null);
$session = new Session();
$permisos = [1,2];
if ($session->activa() && in_array($session->getRolActual(), $permisos)) {
    include_once 'includes/navbar.php';
} else {
    header('Location: login.php');
    exit;
}
?>
<div class="container">
    <button class="btn btn-success mt-5" type="button" data-bs-toggle="modal" data-bs-target="#modalprod" onclick="limpiarFormulario()"> Nuevo </button>
    <table class="table table-striped table-hover">
        <?php
        if (count($listaProducto) > 0) {
            $i = 0; ?>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Autor</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Editorial</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>

            <tbody id="tbodyprod">
                <?php
                $i = 0;
                foreach ($listaProducto as $objProducto) {
                    $autor = substr($objProducto->getProAutor(), 0, 20) . "...";
                    $proNombre = substr($objProducto->getProNombre(), 0, 20) . "...";
                    $estado = $objProducto->getProdeshabilitado() == 1 ? 'habilitado' : 'deshabilitado';
                    $estadoValor = $objProducto->getProdeshabilitado() == 1 ? '0' : '1';
                    $estadoOpuesto = $objProducto->getProdeshabilitado() == 1 ? 'deshabilitado' : 'habilitado';
                ?>
                    <tr id="trprod<?= $objProducto->getIDProducto() ?>">
                        <td><?= $objProducto->getIDProducto() ?></td>
                        <td id="tablaidprod<?= $objProducto->getIDProducto() ?>"><?= $proNombre ?></td>
                        <td id="tablaautorprod<?= $objProducto->getIDProducto() ?>"><?= $autor ?></td>
                        <td id="tablastockprod<?= $objProducto->getIDProducto() ?>"><?= $objProducto->getProCantStock() ?></td>
                        <td id="tablaeditorialprod<?= $objProducto->getIDProducto() ?>"><?= $objProducto->getProEditorial() ?></td>
                        <td id="tablahabilitadoprod<?= $objProducto->getIDProducto() ?>">
                            <select class="form-select form-select-sm" aria-label="" onchange="cambiarEstadoProducto(this.value,<?= $objProducto->getIDProducto() ?>)">
                                <option selected><?= $estado  ?></option>
                                <option value="<?= $estadoValor ?>"><?= $estadoOpuesto ?></option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-danger" onclick="borraProd('<?= $objProducto->getIDProducto() ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                </svg>
                            </button>
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalprod2" onclick="abrirmodaleditarprod('<?= $objProducto->getIDProducto() ?>')">
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
    <div class="modal fade" id="modalprod" tabindex="-1" aria-labelledby="modalprodLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalprodLabel">Producto Nuevo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form enctype="multipart/form-data" id="fupForm">
                            <div class="form-group">
                                <input id="accion" name="accion" type="hidden" value="nuevo">
                                <label for="">Titulo</label>
                                <input type="text" class="form-control" id="pronombre" name="pronombre" placeholder="Titulo" required />
                            </div>
                            <div class="form-group">
                                <label for="email">Precio</label>
                                <input class="form_input form-control" type="text" name="proprecio" id="proprecio" placeholder="Precio" required>
                            </div>
                            <div class="form-group">
                                <label for="Autor">Autor</label>
                                <input class="form_input form-control" type="text" name="proautor" id="proautor" placeholder="Autor" required>
                            </div>
                            <div class="form-group">
                                <label for="">A&ntilde;o</label>
                                <input class="form_input form-control" type="text" name="proanio" id="proanio" placeholder="Año" required>
                            </div>
                            <div class="form-group">
                                <label for="">Stock</label>
                                <input class="form_input form-control" type="text" name="procantstock" id="procantstock" placeholder="Stock" required>
                            </div>
                            <div class="form-group">
                                <label for="proeditorial">Editorial</label>
                                <input class="form_input form-control" type="text" name="proeditorial" id="proeditorial" placeholder="Editorial" required>
                            </div>
                            <div class="form-group">
                                <label for="">Detalles</label>
                                <textarea class="form-control" name="prodetalle" id="prodetalle" cols="30" rows="2" placeholder="Detalle"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="" for="imagen">subir imagen</label>
                                <input class="form-control" type="file" name="unaimagen" id="unaimagen" accept=".png,.PNG,.jpg,.JPG,.jpeg" required>
                            </div>
                            <div class="d-flex flex-row-reverse bd-highlight mt-3 ">
                                <input type="submit" name="submit" class="btn btn-success submitBtn m-1" id="btnGuardarProd" value="Guardar" />
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalprod2" tabindex="-1" aria-labelledby="modalprodLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalprodLabel">Editar producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form enctype="multipart/form-data" id="fupForm2">
                            <div class="form-group">
                                <label for="">Id</label>
                                <input type="text" class="form-control" id="idproductoedit" name="idproducto" placeholder="Id" readonly />
                            </div>
                            <div class="form-group">
                                <input id="accion" name="accion" type="hidden" value="editar">
                                <input id="idprodeshabilitadoedit" name="prodeshabilitado" type="hidden">
                                <label for="">Titulo</label>
                                <input type="text" class="form-control" id="pronombreedit" name="pronombre" placeholder="Titulo" />
                            </div>
                            <div class="form-group">
                                <label for="email">Precio</label>
                                <input class="form_input form-control" type="text" name="proprecio" id="proprecioedit" placeholder="Precio">
                            </div>
                            <div class="form-group">
                                <label for="Autor">Autor</label>
                                <input class="form_input form-control" type="text" name="proautor" id="proautoredit" placeholder="Autor">
                            </div>
                            <div class="form-group">
                                <label for="">A&ntilde;o</label>
                                <input class="form_input form-control" type="text" name="proanio" id="proanioedit" placeholder="Año">
                            </div>
                            <div class="form-group">
                                <label for="">Stock</label>
                                <input class="form_input form-control" type="text" name="procantstock" id="procantstockedit" placeholder="Stock">
                            </div>
                            <div class="form-group">
                                <label for="proeditorial">Editorial</label>
                                <input class="form_input form-control" type="text" name="proeditorial" id="proeditorialedit" placeholder="Editorial">
                            </div>
                            <div class="form-group">
                                <label for="">Detalles</label>
                                <textarea class="form-control" name="prodetalle" id="prodetalleedit" cols="30" rows="2" placeholder="Detalle"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Mantener Foto
                                </label>
                                <input class="form-check-input" type="checkbox" value="1" id="idmantenerfotoInput" name="mantenerfotoInput" checked>
                            </div>
                            <div class="form-group">
                                <label class="" for="imagen">subir imagen</label>
                                <input class="form-control" type="file" name="unaimagen" id="unaimagenedit" accept=".png,.PNG,.jpg,.JPG,.jpeg" disabled>
                            </div>
                            <div class="d-flex flex-row-reverse bd-highlight mt-3 ">
                                <input type="submit" name="submit" class="btn btn-primary submitBtn m-1" id="btnEditarProd" value="editar" />
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- fin modal -->
</div>

<?php include_once 'includes/footer.php' ?>