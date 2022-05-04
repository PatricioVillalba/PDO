<?php

include_once '../../configuracion.php';
$sesion = new Session();
$datos = data_submitted();
// $carrito = $_SESSION['carrito'];
// $idUsuario = $_SESSION['idusuario'];
$AbmCompra = new AbmCompra();



if (isset($datos['accion'])) {
    if ($datos['accion'] == 'confirmar') {
        $resp=$AbmCompra->confirmarCompra();
        echo json_encode(
            $objJson = [
                'idcompra' => $resp
            ]
        );
    }
}