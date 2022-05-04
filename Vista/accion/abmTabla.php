<?php 
include_once '../../configuracion.php';
$datos = data_submitted();
//verEstructura($datos);
$resp = false;
$objTrans = new AbmTabla();

// print_r('en el if este');

if (isset($datos['accion'])){
    if($datos['accion']=='editar'){
        if($objTrans->modificacion($datos)){
            $resp = true;
        }
    }
    if($datos['accion']=='borrar'){
        if($objTrans->baja($datos)){
            $resp =true;
        }
        
    }
    if($datos['accion']=='nuevo'){
        if($obj=$objTrans->alta($datos)){
            $resp =true;
        }
        
    }
    if($resp){
        $mensaje = "La accion ".$datos['accion']." se realizo correctamente.";
    }else {
        $mensaje = "La accion ".$datos['accion']." no pudo concretarse.";
    }
    
}


echo json_encode(['id'=>$obj]);
?>



