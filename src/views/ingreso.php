<?php 
session_start();
if(count($_SESSION) == 0){
    header('Location: http://localhost/inventario/?view=cerrar');
}

require_once dirname(__FILE__) . "/../controllers/inventario.Controller.php";
require_once dirname(__FILE__) . "/../models/inventario.Models.php";

$e = new inventarioController();
$tipos = $e->selectAllTypesController();
$ubicaciones = $e->selectAllUbigeoController();
?>

<input type="hidden" name="fecha" value="<?php echo date('d/m/Y'); ?>">

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 mb-5">
                <p>Completa el formulario para registrar el ingreso de un nuevo activo:</p>
                <hr>
                <form class="registro">
                    <input type="hidden" name="validar" value="registrar_activo">
                    <div class="mb-3">
                        <label class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control" name="nombre_producto">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="number" class="form-control" name="cantidad_inicial">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Tipo de Producto</label>
                        <select name="id_tipo" class="form-select">
                            <!-- <option selected>Escoger el tipo del producto a registrar</option> -->
                            <?php 
                            foreach ($tipos as $tipo):
                                echo '<option value="'.$tipo['id_tipo'].'">'.$tipo['tipo'].'</option>';
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Ubigeo</label>
                        <select name="posicion" class="form-select">
                            <!-- <option selected>Escoger la ubicación del producto a registrar</option> -->
                            <?php 
                            foreach ($ubicaciones as $ubicacion):
                                echo '<option value="'.$ubicacion['posicion'].'">'.$ubicacion['posicion'].'</option>';
                            endforeach;
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-50 py-2">Ingresar producto</button>
                </form>
            </div>
            <div class="col-12 col-md-6 mb-5">
                <p class="text-center"><b>QR</b></p>
                <hr>
                <div class="qr_image w-100 d-block" style="aspect-ratio:1/1">

                </div>
            </div>
        </div>
    </div>
</section>