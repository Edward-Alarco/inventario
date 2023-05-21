<?php 
session_start();
if(count($_SESSION) == 0){
    header('Location: http://localhost/inventario/?view=cerrar');
}

require_once dirname(__FILE__) . "/../controllers/inventario.Controller.php";
require_once dirname(__FILE__) . "/../models/inventario.Models.php";

$e = new inventarioController();
$arrI = $e->selectAllTypesController();
?>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <h1>Registro</h1>
                <p>Completa el formulario para registrar el ingreso de un nuevo activo:</p>
                <hr>
                <form class="registro">
                    <div class="alert alert-danger mb-3 desactived" role="alert">
                        Completar todos los campos del formulario
                    </div>
                    <div class="mb-3">
                        <label for="name_product" class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control" id="name_product">
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="quantity">
                    </div>
                    <div class="mb-4">
                        <label for="type_product" class="form-label">Tipo de Producto</label>
                        <select class="form-select" aria-label="Default select example" id="type_product">
                            <option selected>Escoger el tipo del producto a registrar</option>
                            <?php 
                            foreach ($arrI as $key) {
                                echo '<option value="'.$key['id_tipo'].'">'.$key['tipo'].'</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-50 py-2">Ingresar producto</button>
                </form>
            </div>
        </div>
    </div>
</section>