<?php 
$title = 'Inicio';
include_once 'includes/head.php';
$session = new Session();

if ($session->activa()){
    header("Location:productosListado.php");
    exit;
}else{
    include_once 'includes/navbar.php';
}
?>


