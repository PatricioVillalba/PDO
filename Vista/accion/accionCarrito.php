<?php
include_once '../../configuracion.php';

$sesion = new Session();
$datos = data_submitted();

if (isset($datos['accion'])) {

    if ($datos['accion'] == 'vaciar') {
       $sesion->vaciar();
    }
    if ($datos['accion'] == 'agregar') {
        $sesion->agregar($datos);
    }

    if ($datos['accion'] == 'incrementar') {
       $sesion->incrementar($datos);
    }

    if ($datos['accion'] == 'disminuir') {
       $sesion->disminuir($datos);
    }

    if ($datos['accion'] == 'borrar') {
       $sesion->borrar($datos);
    }
}
