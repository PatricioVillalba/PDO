<?php
include_once '../../configuracion.php';
$sesion = new Session();
$datos = data_submitted();
$abmMenu = new AbmMenu();

if (isset($datos['accion'])) {
    if ($datos['accion'] == 'editar') {
        if ($obj = $abmMenu->modificacion($datos)) {
            json($obj);
        }
    }
    if ($datos['accion'] == 'borrar') {
        if ($abmMenu->baja($datos)) {
            $resp = true;
        }
    }
    if ($datos['accion'] == 'nuevo') {
        if ($obj = $abmMenu->alta($datos)) {
            json($obj);
        }
    }

    if ($datos['accion'] == 'consultar') {
        $resultado = $abmMenu->buscar($datos);
        if (count($resultado) == 1) {
            $obj = $resultado[0];

            json($obj);
        }
    }
}

function json($obj)
{

    $idpadre = !empty($obj->getObjMePadre()) ?  $obj->getObjMePadre()->getIdMenu() : null;
    $link = is_null($obj->getLink()) ? '' : $obj->getLink();
    $descripcion = is_null($obj->getMeDescripcion()) ? '' : $obj->getMeDescripcion();
    $nombre = is_null($obj->getMeNombre()) ? '' : $obj->getMeNombre();
    $estado = ($obj->getMeDeshabilitado() == 1) ? '1' : '2';
    echo json_encode(
        $objJson = [
            'idmenu' => $obj->getIdMenu(),
            'menombre' => $nombre,
            'idpadre' =>  $idpadre,
            'link' => $link,
            'estado' => $estado,
            'descripcion' => $descripcion
        ]
    );
}
