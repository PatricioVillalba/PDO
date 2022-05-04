<?php
include_once '../../configuracion.php';
$datos = data_submitted();
//verEstructura($datos);
$resp = false;
$objTrans = new AbmUsuarioRol();
$obj =  new UsuarioRol();

if (isset($datos['accion'])) {
    if ($datos['accion'] == 'editar') {
        if ($obj =$objTrans->modificacion($datos)) {
            $resp = true;
        }
    }
    if ($datos['accion'] == 'borrar') {
        if ($objTrans->baja($datos)) {
            $resp = true;
        }
        echo $resp;
    }
    if ($datos['accion'] == 'nuevo') {

        if ($obj = $objTrans->alta($datos)) {
            echo json_encode(
                $objJson = [
                    'rol' => $obj->getObjRol()->getRoDescripcion(),
                ]
            );
        }
        // verEstructura();
    }
    if ($datos['accion'] == 'consultar') {

        $resultados = $objTrans->buscar($datos);

        $objUsuario = new AbmUsuario();
        $resultadoObjUsuario = $objUsuario->buscar($datos);
        if (count($resultadoObjUsuario) > 0) {
            $objUsuario = $resultadoObjUsuario[0];
            $roles = [];
            foreach ($resultados as $resultado) {
                array_push($roles, $resultado->getObjRol()->getIdRol());
            }

            echo json_encode(
                $objJson = [
                    'UsNombre' => $objUsuario->getUsNombre(),
                    'UsPass' => $objUsuario->getUsPass(),
                    'UsMail' => $objUsuario->getUsMail(),
                    'roles' => $roles
                ]
            );
        } 
    } else {
        // $obj = $objTrans->buscar($datos);
        // verEstructura($obj);
        // echo json_encode($objJson = ['rolDesc' => $obj[0]->getObjRol()->getRoDescripcion()]);
    }
}
