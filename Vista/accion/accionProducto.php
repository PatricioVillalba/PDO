<?php
include_once '../../configuracion.php';
$abmProducto = new AbmProducto();
$datos = data_submitted();
$sesion = new Session();
$obj = NULL;


if (isset($datos['accion'])) {

    if ($datos['accion'] == 'nuevo') {
        $datos['proimagen'] = null;
        if ($obj = $abmProducto->alta($datos)) {
            json($obj);
        }
    }
    if ($datos['accion'] == 'editarEstado') {
        if ($abmProducto->modificacionEstado($datos)) {
            $resp = true;
        }
    }

    if ($datos['accion'] == 'borrar') {
        if ($abmProducto->baja($datos)) {
            $resp = true;
        }
    }

    if ($datos['accion'] == 'editar') {
        $datos['proimagen'] = null;
        if ($obj = $abmProducto->modificacion($datos)) {
            json($obj);
        }
    }

    if ($datos['accion'] == 'consultar') {

        $resultado = $abmProducto->buscar($datos);
        if (count($resultado) == 1) {
            $obj = $resultado[0];
            json($obj);
        }
    }
}

function json($obj)
{
    echo json_encode(
        $objJson = [
            'idproducto' => $obj->getIDProducto(),
            'pronombre' => $obj->getProNombre(),
            'proautor' => $obj->getProAutor(),
            'prodetalle' => $obj->getProDetalle(),
            'procantstock' => $obj->getProCantStock(),
            'proprecio' => $obj->getProPrecio(),
            'proeditorial' => $obj->getProEditorial(),
            'proanio' => $obj->getProAnio(),
            'prodetalle' => $obj->getProDetalle(),
            'prodes' => $obj->getProdeshabilitado(),
        ]
    );
}
