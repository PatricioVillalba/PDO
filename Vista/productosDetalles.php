<?php
$title = 'Inicio';
include_once 'includes/head.php';
include_once 'includes/navbar.php';
$session = new Session();
$objAbmProducto = new AbmProducto();
$datos = data_submitted();
$objProducto = $objAbmProducto->buscar($datos)[0];
?>


<div class="container">
    <div class="row mt-5">
        <div class="col-4">
            <?php $id = md5($objProducto->getIDProducto()); ?>
            <img src="<?= glob("archivos/Productos/$id/*.*")[0] ?>" alt="" style="  border: 2px solid black;" width="400" height="500">
        </div>
        <div class="col-8">
            <h2><?= $objProducto->getProNombre() ?></h2>
            <h4><?= $objProducto->getProAutor() ?></h4>
            <h4 class="">Editorial:<?= $objProducto->getProEditorial() ?></h4>
            <h4 class="">Año:<?= $objProducto->getProAnio() ?></h4>
            <h4 class="mt-3">Detalles:</h4>
            <h5 class="fw-light"><?= $objProducto->getProDetalle() ?></h5>
            <h2 class="my-4">$<?= $objProducto->getProPrecio() ?></h2>
            <a href="productosListado.php" class="btn btn-primary">Volver al listado</a>
        </div>
    </div>
</div>
<?php include_once 'includes/footer.php' ?>
