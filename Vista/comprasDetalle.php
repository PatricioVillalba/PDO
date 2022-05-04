<?php
$title = 'Compras Detalles';
include_once 'includes/head.php';
$AbmCompra = new AbmCompra();
// $abmCompraEstadoTipo = new AbmCompraEstadoTipo();
// $listaEstadoTipo = $abmCompraEstadoTipo->buscar(null);
$datos = data_submitted();
$listaCompras = $AbmCompra->buscar($datos);
// verEstructura($listaCompras[0]->getColCompraItems());exit;
// verEstructura($listaCompras[0]->getColCompraItems()[0]->getCiCantidad());
// exit;
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
    <h3>Detalles compra Id: <?= $datos['idcompra'] ?> </h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">idProducto</th>
                <th scope="col">Portada</th>
                <th scope="col">Nombre</th>
                <th scope="col">Editorial</th>
                <th scope="col">Precio</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Precio Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $listaCompras = $listaCompras[0]->getColCompraItems();
            // verEstructura($listaCompras->getColCompraItems());exit; 
            foreach ($listaCompras as $compra) { ?>
                <tr>
                    <?php $id = md5($compra->getObjProducto()->getIdProducto()); ?>
                    <td><?= $compra->getObjProducto()->getIdProducto(); ?></td>
                    <td><img src=<?= glob("archivos/Productos/$id/*.*")[0] ?> alt="" width="50" height="70"></td>
                    <td><?= $compra->getObjProducto()->getProNombre(); ?></td>
                    <td><?= $compra->getObjProducto()->getProEditorial(); ?></td>
                    <td><?= $compra->getObjProducto()->getProPrecio(); ?></td>
                    <td><?= $compra->getCiCantidad(); ?></td>
                    <td><?= $compra->getCiPrecioTotal(); ?></td>
                </tr>
            <?php }
            ?>
        </tbody>
    </table>
</div>