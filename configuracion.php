<?php header('Content-Type: text/html; charset=utf-8');
header ("Cache-Control: no-cache, must-revalidate ");

/////////////////////////////
// CONFIGURACION APP//
/////////////////////////////

$PROYECTO ='PDO';

//variable que almacena el directorio del proyecto
$ROOT =$_SERVER['DOCUMENT_ROOT']."/$PROYECTO/";

include_once($ROOT.'util/funciones.php');


// Variable que define la pagina de autenticacion del proyecto
$INICIO = "productosListado.php";

// variable que define la pagina principal del proyecto (menu principal)
// $INICIO =  "Location:http://" . $_SERVER['HTTP_HOST'] . "/$PROYECTO/inicio.php";



$_SESSION['ROOT']=$ROOT;
// $sesion = new Session();

$GLOBALS['imagenPro']=$ROOT."vista/archivos/"

?>