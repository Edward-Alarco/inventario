<?php require_once dirname(__FILE__).'/../views/inc/session.php'; ?>
<?php 
    require_once dirname(__FILE__) . "/../controllers/inventario.Controller.php";
    require_once dirname(__FILE__) . "/../models/inventario.Models.php";

    $e = new inventarioController();
    $arr = $e -> selectActivosController();
    $arrI = $e->selectAllTypesController();
?>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <h1>Egreso</h1>
                <p>Completa el formulario para registrar el egreso del activo seleccionado:</p>
                <hr>
                <form class="egreso">
                    <div class="alert alert-danger mb-3 desactived" role="alert">
                        Completar todos los campos del formulario
                    </div>
                    <div class="mb-3">
                        <label for="type_product" class="form-label">Tipo de Producto</label>
                        <select class="form-select" aria-label="Default select example" id="type_product">
                            <option selected>Escoger el tipo del producto a egresar</option>
                            <?php 
                            foreach ($arrI as $key) {
                                echo '<option value="'.$key['id_tipo'].'">'.$key['tipo'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name_product" class="form-label">Nombre del Producto</label>
                        <select class="form-select" aria-label="Default select example" id="name_product" disabled>
                            <option selected>Escoger el producto a egresar</option>
                        </select>
                    </div>
                    <div class="input-group mb-5">
                        <label for="quantity" class="form-label w-100">Cantidad a retirar</label>
                        <input type="number" class="form-control rounded-start" id="quantity" max="" disabled>
                        <button class="btn btn-primary px-5 rounded-end" type="button" id="quantity_all" disabled>Todo</button>
                        <div id="quantityHelp" class="form-text w-100"></div>
                    </div>

                    <button type="submit" class="btn btn-primary w-50 py-2">Egresar producto</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
    echo '<div id="options">';
    foreach($arr as $option){
        echo '<p class="id'.$option['id'].' tipo-'.$option['id_tipo'].'" data-cantidad="'.$option['cantidad_variable'].'">'.ucwords($option['nombre_producto']).'</p>';
    }
    echo '</div>';
?>