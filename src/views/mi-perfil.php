<?php require_once dirname(__FILE__) . '/../views/inc/session.php'; ?>

<section class="mi-perfil py-4">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <form class="actualizar_usuario">
                    <input type="hidden" name="validar" value="actualizar_usuario">
                    <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id']; ?>">
                    <div class="mb-3">
                        <label for="" class="form-label">Nombres</label>
                        <input type="text" class="form-control" autocomplete="false" name="nombres" value="<?php echo $_SESSION['nombres']; ?>">
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="" class="form-label">Ap. Paterno</label>
                            <input type="text" class="form-control" name="apellido_paterno" autocomplete="false" value="<?php echo $_SESSION['paterno']; ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="" class="form-label">Ap. Materno</label>
                            <input type="text" class="form-control" name="apellido_materno" autocomplete="false" value="<?php echo $_SESSION['materno']; ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label d-block">Correo</label>
                        <input type="text" class="form-control" autocomplete="false" name="correo" value="<?php echo $_SESSION['correo']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Clave Actual <span style="color:red;">*</span></label>
                        <input type="password" class="form-control" name="clave" autocomplete="false" value="">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Clave Nueva <small style="color:#000">(Opcional)</small></label>
                        <input type="password" class="form-control" id="clave_nueva" autocomplete="false" value="">
                        <small style="color:rgba(0,0,0,0.7)">Dejar vacio el campo si no se quiere actualizar la contraseña</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-4 py-2">Actualizar Usuario</button>
                </form>
            </div>
            <div class="col-12 col-md-6">

            </div>
        </div>
    </div>
</section>