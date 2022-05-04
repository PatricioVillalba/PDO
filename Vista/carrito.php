<?php
$title = 'Inicio';
include_once 'includes/head.php';
$objAbmProducto = new AbmProducto();
$listaProducto = $objAbmProducto->buscar(null);
$session = new Session();
$permisos = [3];
if ($session->activa() && in_array($session->getRolActual(), $permisos)) {
    include_once 'includes/navbar.php';
} else {
    header('Location: login.php');
    exit;
}
?>
<div class="container">
    <div class="row">
        <!--Tabla-->
        <div class="table-responsive mt-5">
            <h2>CARRITO</h2>
            <?php if (!empty($_SESSION['carrito'])) { ?>
                <table class="table table-bordered table-condensed cesta" id="tablacarrito">
                    <thead>
                        <th colspan="2">Producto</th>
                        <th>Eliminar</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </thead>
                    <?php
                    $totalCarrito = 0;
                    foreach ($_SESSION['carrito'] as $prodCarrito) {
                        $producto = $objAbmProducto->buscar($prodCarrito);
                        if (count($producto) == 1) {
                            $proNombre = $producto[0]->getProNombre();
                            $proCantStock = $producto[0]->getProCantStock();
                            $proId = $producto[0]->getIDProducto();
                            $proPrecio = $producto[0]->getProPrecio();
                    ?>

                            <tr id="trCarrito<?= $proId ?>" data-elemento='1'>
                                <td>
                                    <?php $id = md5($proId);
                                    foreach (glob("archivos/Productos/$id/*.*") as $filename) {
                                        echo "<img src='$filename' width='100' height='150'><br> ";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <span><?= $proNombre ?></span>
                                </td>
                                <td>
                                    <button class="btn btn-danger" onclick="borraProdCarrito(<?= $proId ?>)"><i class="fa fa-trash"></i></button>
                                </td>
                                <td class="cantidad">
                                    <?php
                                    $disabledD =  ($prodCarrito['cantProd'] == 1) ? 'disabled' : '';
                                    $disabledI =  ($prodCarrito['cantProd'] == $proCantStock) ? 'disabled' : '';
                                    ?>
                                    <!-- $proCantStock  -->
                                    <button class="input-number-decrement btn btn-danger" onclick="disminuirProd(<?= $proCantStock ?>,<?= $proId ?>,<?= $proPrecio ?>)" id="btnDisminuir<?= $proId ?>" <?= $disabledD ?>>–</button>
                                    <input class="input-number" type="number" value="<?= $prodCarrito['cantProd'] ?>" min="0" max="<?= $proCantStock ?>" id="inputstockCarrito<?= $proId ?>" readonly>
                                    <button class="input-number-increment btn btn-success" onclick="incrementarProd(<?= $proCantStock ?>,<?= $proId ?>,<?= $proPrecio ?>)" id="btnIncrementar<?= $proId ?>" <?= $disabledI ?>>+</button>

                                </td>
                                <td class="" id="total<?= $proId ?>"><?= $prodCarrito['productoprecio'] ?></td>
                            </tr>
                        <?php
                            $totalCarrito = $totalCarrito + $prodCarrito['productoprecio'];
                        }
                    }
                    if ($totalCarrito > 0) {
                        ?>
                        <tr id="trTotalCarrito">
                            <td colspan="4">
                                <div class="d-flex flex-row-reverse bd-highlight">
                                    <b>Total:</b>
                                </div>
                            </td>
                            <td id="idTotalCarrito"> <b>
                                    <?= $totalCarrito ?>
                                </b></td>
                        </tr>

                    <?php
                    }
                    ?>
                </table>
                <?php
                if ($totalCarrito > 0) { ?>
                    <div class="col-12" id="botonesCarrito">
                        <button class="btn btn-danger" onclick="vaciarCarro()">Vaciar</button>
                        <button class="btn btn-success" onclick="ConfirmarCompra()">Finalizar Compra</button>
                    <?php
                }
                    ?>
                    </div>
        </div>
    <?php } else { ?>
        <div class="alert alert-primary" role="alert" id="">
               El carrito esta vacio <i class="far fa-frown"></i> &nbsp<a href="productosListado.php"><b>  ir a comprar</b></a>
        </div>
    <?php } ?>
    <div class=" " id="alertaCarrito">
    </div>
    </div>
</div>
<?php include_once 'includes/footer.php' ?>