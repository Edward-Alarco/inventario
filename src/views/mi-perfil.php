<?php require_once dirname(__FILE__) . '/../views/inc/session.php'; ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

<?php 
    require_once dirname(__FILE__) . "/../controllers/ingreso.Controller.php";
    require_once dirname(__FILE__) . "/../models/ingreso.Models.php";

    $e = new ingresoController();
    $users = $e -> selectUsersController();
?>

<section class="mi-perfil py-5">
    <div class="container">
        <div class="row">
            <?php if($_SESSION['rol'] != 1): ?>
            <div class="col-12 col-lg-6">
            <?php else: ?>
            <div class="col-12 col-lg-4">
            <?php endif; ?>
                <form class="actualizar_usuario">
                    <input type="hidden" name="validar" value="actualizar_usuario">
                    <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id']; ?>">
                    <div class="mb-2">
                        <label for="" class="form-label">Nombres</label>
                        <input type="text" class="form-control" autocomplete="false" name="nombres" value="<?php echo $_SESSION['nombres']; ?>">
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 col-md-6">
                            <label for="" class="form-label">Ap. Paterno</label>
                            <input type="text" class="form-control" name="apellido_paterno" autocomplete="false" value="<?php echo $_SESSION['paterno']; ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="" class="form-label">Ap. Materno</label>
                            <input type="text" class="form-control" name="apellido_materno" autocomplete="false" value="<?php echo $_SESSION['materno']; ?>">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label d-block">Correo</label>
                        <input type="text" class="form-control" autocomplete="false" name="correo" value="<?php echo $_SESSION['correo']; ?>">
                    </div>
                    <div class="mb-2">
                        <label for="exampleInputPassword1" class="form-label">Clave Actual <span style="color:red;">*</span></label>
                        <input type="password" class="form-control" name="clave" autocomplete="false" value="">
                    </div>
                    <div class="mb-2">
                        <label for="exampleInputPassword1" class="form-label">Clave Nueva <small style="color:#000">(Opcional)</small></label>
                        <input type="password" class="form-control" id="clave_nueva" autocomplete="false" value="">
                        <small style="color:rgba(0,0,0,0.7)">Dejar vacio el campo si no se quiere actualizar la contraseña</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3 py-2">Actualizar Usuario</button>
                </form>
            </div>
            <?php if($_SESSION['rol'] == 1): ?>
            <div class="col-12 col-lg-8 mt-4 mt-lg-0">
                <table id="table_id" class="display stripe cell-border hover nowrap">
                    <thead>
                        <tr>
                            <th class="text-left">Nombre</th>
                            <th class="text-center">Correo</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user): ?>
                        <tr>
                            <td><?php echo $user['nombres'].' '.$user['apellido_paterno'].' '.$user['apellido_materno'] ?></td>
                            <td><?php echo $user['correo'] ?></td>
                            <td class="text-center">
                                <form class="actualizar_rol_usuario text-center">
                                    <input type="hidden" name="id_usuario" value="<?php echo $user['id_usuario'] ?>">
                                    <input type="hidden" name="validar" value="actualizar_rol">
                                    
                                    <?php if($user['id_rol'] == 2): ?>
                                    <!-- involucrado -->
                                    <input type="hidden" name="id_rol" value="3">
                                    <button type="submit" class="btn btn-primary w-100">Cambiar a Usuario Común</button>
                                    <?php else: ?>
                                    <!-- usuario comun -->
                                    <input type="hidden" name="id_rol" value="2">
                                    <button type="submit" class="btn btn-success w-100">Cambiar a Involucrado</button>
                                    <?php endif; ?>

                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once dirname(__FILE__) . '/../views/inc/datatable-footer.php'; ?>