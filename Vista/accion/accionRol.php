<?php
include_once '../../configuracion.php';
$datos = data_submitted();
//verEstructura($datos);
$resp = false;
$abmRol = new AbmRol();
$obj = NULL;


if (isset($datos['accion'])) {
    if ($datos['accion'] == 'cambio') {
        if ($abmRol->modificacion($datos)) {
            $resp = true;
        }
    }
    if ($datos['accion'] == 'cambiarRol') {
        if ($abmRol->cambiarRol($datos)) {
            $resp = true;
        }
    }
    if ($datos['accion'] == 'editar') {
        if ($abmRol->modificacion($datos)) {
            $resp = true;
        }
    }
    if ($datos['accion'] == 'borrar') {
        if ($abmRol->baja($datos)) {
            $resp = true;
        }
    }
    if ($datos['accion'] == 'nuevo') {

        if ($obj = $abmRol->alta($datos)) {
            $resp = true;
        }
    }
    if ($datos['accion'] == 'consultar') {

        $resultado = $abmRol->buscar($datos);
        if (count($resultado) == 1) {
            $obj = $resultado[0];
            echo json_encode(
                $objJson = [
                    'IdRol' => $obj->getIdRol(),
                    'RoDescripcion' => $obj->getRoDescripcion(),
                ]
            );
        }
    }else{
        echo json_encode(['id' => $obj]);
    }
}
