<?php
$title = 'Inicio';
include_once 'includes/head.php';
$objAbmProducto = new AbmProducto();
$listaProducto = $objAbmProducto->buscar(null);
$session = new Session();
$permisos = [1];
// if ($session->activa()) {
    include_once 'includes/navbar.php';
// } else {
//     header('Location: login.php');
//     exit;
// }
?>
<div class="p-5">
    <div class="row d-flex justify-content-center">
        <?php
        if ($session->activa()) { ?>
            <?php
            $idProdEnCarrito = arrayIdProdCarrito($_SESSION["carrito"]);
            foreach ($listaProducto as $producto) { 
                if($producto->getProdeshabilitado() == 1){
            ?>
                <div class="card m-4 p-3 " style="width: 20rem;">
                    <?php $id = md5($producto->getIDProducto());
                    foreach (glob("archivos/Productos/$id/*.*") as $filename) {
                        echo "<img src='$filename'><br> ";
                    }
                    ?>
                    <div class="card-body ">
                        <h5 class="card-title"><?= $producto->getProNombre() ?></h5>
                        <p class="card-text"><?= $producto->getProAutor() ?></p>
                        <h5>$ <?= $producto->getProPrecio() ?></h5>
                        <?php
                        $disabled = in_array($producto->getIDProducto(), $idProdEnCarrito) ? 'disabled' : '';
                        if ($producto->getProCantStock() > 0) {
                            echo ('<p class="text-muted">' . $producto->getProCantStock() . ' Disponibles</p>' .
                                '<button href="#" class="btn btn-success" id="btnAgregar' . $producto->getIDProducto() . '" onclick="AgregarProd(' . $producto->getIDProducto() . ',' . $producto->getProPrecio() . ')"' . $disabled . '>
                            Añadir al Carrito</button>');
                        } else {
                            echo ('<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        SIN STOCK
                        <span class="visually-hidden">unread messages</span>
                        </span>');
                            echo ('<a href="#" class="btn btn-success disabled">Añadir al Carrito</a>');
                        }
                        ?>
                        <a href="productosDetalles.php?idproducto=<?=$producto->getIDProducto()?>" class="btn btn-primary">Ver mas</a>

                    </div>
                </div>
            <?php }} ?>
        <?php
        } else {
        ?>
            <?php foreach ($listaProducto as $producto) { ?>
                <div class="card m-4 p-3 " style="width: 20rem;">
                    <?php $id = md5($producto->getIDProducto());
                    foreach (glob("archivos/Productos/$id/*.*") as $filename) {
                        echo "<img src='$filename'><br> ";
                    }
                    ?>
                    <div class="card-body ">
                        <h5 class="card-title"><?= $producto->getProNombre() ?></h5>
                        <p class="card-text"><?= $producto->getProAutor() ?></p>
                        <h5>$ <?= $producto->getProPrecio() ?></h5>
                        
                        <?php
                        if ($producto->getProCantStock() > 0) {
                            echo ('<p class="text-muted">' . $producto->getProCantStock() . ' Disponibles</p>' .
                                '<a class="btn btn-primary" href="login.php">Añadir al Carrito</a>');
                        } else {
                            echo ('<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        SIN STOCK
                        <span class="visually-hidden">unread messages</span>
                        </span>');
                            echo ('<a href="#" class="btn btn-primary disabled">Añadir al Carrito</a>');
                        }
                        ?>
                    </div>
                </div>
            <?php } ?>
        <?php
        }
        ?>

    </div>
</div>


<?php include_once 'includes/footer.php' ?>