<?php
include_once 'includes/head.php';
$session = new Session();
$objAbmCompra = new AbmCompra();

$datos = data_submitted();
$objCompra = $objAbmCompra->buscar($datos);
$objCompra = $objCompra[0];
// verEstructura($objCompra->getColCompraItems());

$permisos = [3]; // 3 = cliente

if ($session->activa() && in_array($session->getRolActual(), $permisos)) {
    include_once 'includes/navbar.php';
} else {
    header('Location: login.php');
    exit;
}

?>

<div class="container">
    <h1>Mi compra</h1>
    <h3>Detalles:</h3>
    <table class="table table-striped table-hover">
        <thead>
        </thead>
        <tbody>
            <tr>
                <th scope="row">Cod compra</th>
                <td><?= $objCompra->getIdCompra() ?></td>
            </tr>
            <tr>
                <th scope="row">Fecha Y hora</th>
                <td><?= $objCompra->getCoFecha() ?></td>
            </tr>
            <tr>
                <th scope="row">Estado</th>
                <td><?= $objCompra->getestadoActual() ?></td>
            </tr>
        </tbody>
    </table>
    <h3>Items:</h3>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nombre</th>
                <th scope="col">Autor</th>
                <th scope="col">Precio</th>
                <th scope="col">Unidad/es</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($objCompra->getColCompraItems() as $objItem) {
                $producto = $objItem->getObjProducto();
            ?>
                <tr>
                    <td><?=$producto->getIDProducto()?></td>
                    <td><?= $producto->getProNombre() ?></td>
                    <td><?= $producto->getProAutor() ?></td>
                    <td>$ <?= $producto->getProPrecio() ?></td>
                    <td><?= $objItem->getCiCantidad() ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>