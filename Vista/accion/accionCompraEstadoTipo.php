<?php

include_once '../../configuracion.php';
$sesion = new Session();
$datos = data_submitted();
$AbmCompraEstado = new AbmCompraEstado();



if (isset($datos['accion'])) {
    if ($datos['accion'] == 'editar') {
        if ($AbmCompraEstado->cambiarEstadoCompra($datos)) {
            $resp = true;
        }
    }
}