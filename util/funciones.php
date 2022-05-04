<?php
function data_submitted()
{
  $_AAux = array();
  if (!empty($_POST))
    $_AAux = $_POST;
  else
            if (!empty($_GET)) {
    $_AAux = $_GET;
  }
  if (count($_AAux)) {
    foreach ($_AAux as $indice => $valor) {
      if ($valor == "")
        $_AAux[$indice] = 'null';
    }
  }
  return $_AAux;
}


function verEstructura($e)
{
  echo "<pre>";
  print_r($e);
  echo "</pre>";
}

function arrayIdProdCarrito($arreglos)
{
  $arrayReturn = [];
  foreach ($arreglos as $arreglo) {
    array_push($arrayReturn, $arreglo['idproducto']);
  }
  return $arrayReturn;
}

// spl_autoload_register (function ($class_name){
//     //echo "class ".$class_name ;
//     $directorys = array(
//         $_SESSION['ROOT'].'Modelo/',
//         $_SESSION['ROOT'].'Modelo/conector/',
//         $_SESSION['ROOT'].'Control/',
//         $GLOBALS['ROOT'].'util/class/',
//     );
//     //print_object($directorys) ;
//     foreach($directorys as $directory){
//         if(file_exists($directory.$class_name . '.php')){
//             // echo "se incluyo".$directory.$class_name . '.php';
//             require_once($directory.$class_name . '.php');
//             return;
//         }
//     }
// })

/* Funcion para poner a disponibilidad los objetos dentro del proyecto */

spl_autoload_register(function ($clase) {
  $directorios = array(
    $GLOBALS['ROOT'] . 'Modelo/conector/',
    $GLOBALS['ROOT'] . 'Modelo/',
    $GLOBALS['ROOT'] . 'Control/',
  );



  foreach ($directorios as $directorio) {
    // echo "aqui se incluye" . $directorio . $clase . ".php<br>";

    if (file_exists($directorio . $clase . ".php")) {
      // echo "aqui se incluye" . $directorio . $clase . ".php";
      require_once($directorio . $clase . ".php");

      include_once($directorio . $clase . ".php");
      return;
    }
  }
});
