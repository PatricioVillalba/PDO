<?php 
include_once '../configuracion.php';

$obj = new Tabla();
$obj->setear('',' test objeto Tabla');

if($obj->insertar()){
    echo "<br> El registro se inserto correctamente";
    verEstructura($obj);
}else 
    echo "<br>".$obj->getmensajeoperacion();

$obj->setDescript("nuevo valor para la variable instancia del objeto");

if($obj->modificar()){
    echo "<br> El registro se actualizo correctamente";
    verEstructura($obj);
}else
        echo "<br>".$obj->getmensajeoperacion();

        
if($obj->eliminar())
     echo "<br> El registro se elimino correctamente";
else
    echo "<br>".$obj->getmensajeoperacion();

?>