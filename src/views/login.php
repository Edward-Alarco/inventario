<?php 
    require_once dirname(__FILE__)."/../controllers/ingreso.Controller.php";
    require_once dirname(__FILE__)."/../models/ingreso.Models.php";
?>
<style>nav{display:none!important}body{min-height:100vh;display:grid;background:#ecf0f199;place-items:center}form{width:100%;max-width:450px;margin:0 auto}</style>

<section class="login w-100">
    <div class="container">
        <form method="POST" class="login_usuario">
            <input type="hidden" name="validar" value="login_usuario">
            <div class="mb-3">
                <h2 class="text-center pb-3 mb-4 border-bottom">Ingreso</h2>
            </div>
            <div>
                <label for="" class="form-label d-block">Correo</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" autocomplete="false" id="correo">
                    <span class="input-group-text">@gmail.com</span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Clave</label>
                <input type="password" class="form-control" name="clave">
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-4 py-2">Ingresar</button>
        </form>
        <p class="text-center mt-4">
            ¿Aún no eres usuario?
            <a href="?view=registro">Registrate</a>
        </p>
    </div>
</section>