<?php
include_once "../configuracion.php";
include_once 'includes/head.php';
$title = 'Login';
$session= new Session();

if ($session->activa()){
    header("Location:inicio.php");
    exit;
}else{
    include_once 'includes/navbar.php';
}
?>

<div class="container d-flex justify-content-center align-items-start text-center mt-20vh">
    <div class="text-center mx-auto" style="max-width:300px">

        <!-- <img class="mb-4" src="img\logo.png" alt="logo" width="72" height="72"> -->
        <h1 class="h3 mb-3 font-weight-normal">Iniciar sesión</h1>

        <!-- <form class="needs-validation" data-toggle="" id="form-login" method="post"> -->
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user p-1"></i></span>
                </div>
                <input type="text" name="usnombre" id="usnombre" placeholder="Username" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <div class="input-group mt-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-lock p-1"></i></span>
                </div>
                <input type="password" name="uspass" id="uspass" placeholder="Password" class="form-control" required>
            </div>
        </div>


        <button class="btn btn-primary btn-block mt-4" id="" onclick="btnLogin()" >Iniciar sesión</button>

        <!-- </form> -->
    </div>
</div>
<?php include_once 'includes/footer.php' ?>




