<?php 
    require_once dirname(__FILE__)."/../controllers/ingreso.Controller.php";
    require_once dirname(__FILE__)."/../models/ingreso.Models.php";
?>
<style>nav{display:none!important}body{min-height:100vh;display:grid;background:#ecf0f199;place-items:center}form{width:100%;max-width:450px;margin:0 auto}</style>

<section class="login w-100">
    <div class="container">
        <form method="POST" class="registro_usuario">
            <div class="alert alert-danger mb-3 desactived" role="alert">
                Completar todos los campos del formulario
            </div>
            <input type="hidden" name="validar" value="registro_usuario">
            <div class="mb-3">
                <h2 class="text-center pb-3 mb-4 border-bottom">Registro</h2>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Nombres</label>
                <input type="text" class="form-control" autocomplete="false" name="nombres">
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="" class="form-label">Ap. Paterno</label>
                    <input type="text" class="form-control" name="apellido_paterno" autocomplete="false">
                </div>
                <div class="col-12 col-md-6">
                    <label for="" class="form-label">Ap. Materno</label>
                    <input type="text" class="form-control" name="apellido_materno" autocomplete="false">
                </div>
            </div>
            <div>
                <label for="" class="form-label d-block">Correo</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" autocomplete="false" id="correo">
                    <span class="input-group-text">@gmail.com</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Clave</label>
                <input type="password" class="form-control" name="clave" autocomplete="false">
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-4 py-2">Registrarme</button>
        </form>
        <p class="text-center mt-4">
            ¿Ya eres usuario?
            <a href="?view=login">Logeate</a>
        </p>
    </div>
</section>