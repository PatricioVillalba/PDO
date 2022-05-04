<?php
include_once '../../configuracion.php';
$control = new LoginControl();
$datos = data_submitted();
$sesion = new Session();

if ($datos['accion'] == 'cerrar') {
    $sesion->cerrar();
    echo json_encode(['respuesta' => 'cerrar']);
}

if ($datos['accion'] == 'iniciar') {
    $sesion = $control->logear();
    if ($sesion) {
        if ($sesion->getObjUsuario()->getUsDeshabilitado() != null) {
            echo json_encode(['respuesta' => $sesion->getObjUsuario()->getUsDeshabilitado()]);
            $sesion->cerrar();
        }elseif(is_null($sesion->getRolActual())){
            echo json_encode(['respuesta' => 'sinRol']);
            $sesion->cerrar();
        } else {
            echo json_encode(['respuesta' => 'activa']);
        }
    } else {
        echo json_encode(['respuesta' => 'error']);
    }
}
