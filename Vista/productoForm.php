<?php
$title = 'Inicio';
include_once 'includes/head.php';

$session = new Session();
$permisos = [2];
if ($session->activa() && in_array($session->getRolActual(), $permisos)) {
    include_once 'includes/navbar.php';
} else {
    header('Location: login.php');
    exit;
}
?>

<div class="container">
    <form enctype="multipart/form-data" id="fupForm">
        <div class="form-group">
            <input id="accionId" name="accionId" type="hidden" value="1">
            <label for="">Titulo</label>
            <input type="text" class="form-control" id="pronombre" name="pronombre" placeholder="Titulo" />
        </div>
        <div class="form-group">
            <label for="email">Precio</label>
            <input class="form_input form-control" type="text" name="proprecio" id="proprecio" placeholder="Precio">
        </div>
        <div class="form-group">
            <label for="Autor">Autor</label>
            <input class="form_input form-control" type="text" name="proautor" id="proautor" placeholder="Autor">
        </div>
        <div class="form-group">
            <label for="">A&ntilde;o</label>
            <input class="form_input form-control" type="text" name="proanio" id="proanio" placeholder="Año">
        </div>
        <div class="form-group">
            <label for="">Stock</label>
            <input class="form_input form-control" type="text" name="procantstock" id="procantstock" placeholder="Stock">
        </div>
        <div class="form-group">
            <label for="proeditorial">Editorial</label>
            <input class="form_input form-control" type="text" name="proeditorial" id="proeditorial" placeholder="Editorial">
        </div>
        <div class="form-group">
            <label for="">Detalles</label>
            <textarea class="form-control" name="prodetalle" id="prodetalle" cols="30" rows="2" placeholder="Detalle"></textarea>
        </div>
        <div class="form-group">
            <label class="" for="imagen">subir imagen</label>
            <input class="form-control" type="file" name="unaimagen" id="unaimagen" accept=".png,.PNG,.jpg,.JPG,.jpeg">
        </div>
        <input type="submit" name="submit" class="btn btn-success submitBtn my-3" value="Guardar" />
    </form>
</div>