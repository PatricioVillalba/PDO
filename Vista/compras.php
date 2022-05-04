<?php
$title = 'Inicio';
include_once 'includes/head.php';
include_once 'includes/navbar.php';
$AbmCompra = new AbmCompra();
$abmCompraEstado = new AbmCompraEstado();
$abmCompraEstadoTipo = new AbmCompraEstadoTipo();
$listaEstadoTipo = $abmCompraEstadoTipo->buscar(null);
$listaCompras = $AbmCompra->buscar(null);
$session = new Session();
if (!$session->activa()) {
    header('Location: login.php');
    exit;
}
// verEstructura($listaCompras);exit;
?>

<div class="container">
    <table class="table table-striped table-hover">
        <?php
        if (count($listaCompras) > 0) {
            $i = 0; ?>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Estado</th>
                </tr>
            </thead>

            <tbody id="tbodyCompra">
                <?php
                $i = 0;
                foreach ($listaCompras as $objCompra) {
                    $idTipoEstado["idcompra"] = $objCompra->getIdCompra();
                    $ObjCompraEstado = $abmCompraEstado->buscar($idTipoEstado);
                    $estado = '-';
                    if (!empty($ObjCompraEstado)) {
                        $estado = $ObjCompraEstado[0]->getObjCompraEstTipo()->getCetDescripcion();
                    }

                ?>
                    <tr id="trcompra<?= $objCompra->getIdCompra() ?>">
                        <td><?= $objCompra->getIdCompra() ?></td>
                        <td id="tablaidprod<?= $objCompra->getIdCompra() ?>"><?= $objCompra->getCoFecha() ?></td>
                        <td id="tablaautorprod<?= $objCompra->getIdCompra() ?>"><?= $objCompra->getObjUsuario()->getUsNombre() ?></td>
                        <td><a class="btn btn-sm btn-success" href="comprasDetalle.php?idcompra=<?=$objCompra->getIdCompra()?>"><i class="fa fa-eye"></i></a></td>
                        <td id="tablaeditorialprod<?= $objCompra->getIdCompra() ?>">
                            <select class="form-select form-select-sm" aria-label="" onchange="cambiarEstado(this.value,<?=$ObjCompraEstado[0]->getIdCompraEstado()?>,<?=$objCompra->getIdCompra()?>)">
                                <option selected><?= $estado ?></option>
                                <?php foreach ($listaEstadoTipo as $estadoTipo) {
                                    ?>
                                    <option value="<?= $estadoTipo->getIdCompraEstTipo() ?>"><?=  $estadoTipo->getCetDescripcion() ?></option>
                                <?php } ?>
                            </select>
                        </td>

                    </tr>

            <?php
                    $i = $i + 1;
                }
            }
            ?>
            </tbody>
    </table>

<?php include_once 'includes/footer.php' ?>
