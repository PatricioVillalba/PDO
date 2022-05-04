<?php
include_once '../configuracion.php';
$objAbmTabla = new AbmTabla();
$datos = data_submitted();
$obj =NULL;
if (isset($datos['id'])){
    $listaTabla = $objAbmTabla->buscar($datos);
    if (count($listaTabla)==1){
        $obj= $listaTabla[0];
    }
}
echo json_encode($obj=['id'=>$obj->getId(),'desc'=>$obj->getDescrip()]);
?>	