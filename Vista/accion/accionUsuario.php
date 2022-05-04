<?php
include_once '../../configuracion.php';
$datos = data_submitted();
$resp = false;
$objTrans = new AbmUsuario();
$obj = new Usuario();
$datos['idrol'] = !array_key_exists('rol', $_SESSION) ?  null : $_SESSION['rol'];

if (isset($datos['accion'])) {
    if ($datos['accion'] == 'editar') {
        if ($obj=$objTrans->modificacion($datos)) {
            $resp = true;
            echo json_encode(['id' => $obj->getIdUsuario(),'UsNombre' => $obj->getUsNombre(),'UsMail' => $obj->getUsMail(),'UsPass'=>$obj->getUsPass(),'fecha'=>date("Y-m-d h:i:sa"), 'estado' => $obj->getUsDeshabilitado()]);
        }

    }
    if ($datos['accion'] == 'borrar') {
        if ($objTrans->baja($datos)) {
            $resp = true;
        }
    }
    if ($datos['accion'] == 'nuevo') {
        if ($obj = $objTrans->alta($datos)) {
            $resp = true;
        }
    }
    if ($datos['accion'] == 'buscar') {
        $obj = $objTrans->buscarAjax($datos);
        $out = array_values($obj);
        echo json_encode($out);       
    }
  
    if ($datos['accion'] == 'consultar') {

        $resultado = $objTrans->buscar($datos);
        if (count($resultado) == 1) {
            $obj = $resultado[0];
            if(is_null($obj->getUsDeshabilitado())) $estado=1;
            else $estado=2;
            echo json_encode(
                $objJson = [
                    'UsNombre' => $obj->getUsNombre(),
                    'UsPass' => $obj->getUsPass(),
                    'UsMail' => $obj->getUsMail(),
                    'colRoles' => $obj->getColRoles(),
                    'estado' => $estado,
                ]
            );
        }
    }
}
