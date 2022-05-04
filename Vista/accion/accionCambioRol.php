<?php
include_once '../../configuracion.php';
$session= new Session();
$datos = data_submitted();
$session->cambioRol($datos);

