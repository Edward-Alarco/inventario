<?php require_once dirname(__FILE__).'/../views/inc/session.php'; ?>
<?php 
require_once dirname(__FILE__)."/../controllers/inventario.Controller.php";
require_once dirname(__FILE__)."/../models/inventario.Models.php";

$e = new inventarioController();
?>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <h1>Reposición</h1>
                <p>Completa el formulario para reponer el activo retirado previamente:</p>
                <hr>
                <form class="reposicion">
                    <div class="alert alert-danger mb-3 desactived" role="alert">Completar todos los campos del formulario</div>

                    <div class="mb-3">
                        <label for="type_product" class="form-label">Tipo de Producto</label>
                        <select class="form-select" aria-label="Default select example" id="type_product">
                            <option value="" selected>Escoge el tipo de producto a reponer</option>
                        <?php
                            $arr = $e -> selectAllTypesController();
                            foreach($arr as $row){ echo "<option value=".$row[0].">".$row[1]."</option>"; }
                        ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="product" class="form-label">Producto a reponer</label>
                        <select class="form-select" aria-label="Default select example" id="product" disabled>
                            <option value="" selected>Escoge el producto a reponer</option>
                        <?php
                            $arr = $e -> selectActivosEgresadosController();
                            foreach($arr as $row){
                                if($row['cantidad_retirada'] != 0){
                                    echo '<option data-cantidad="'.$row['cantidad_retirada'].'" value="'.$row['id_egreso'].'" class="option disabled tipo-'.$row['id_tipo'].'">'.$row['nombre'].'</option>';
                                }
                            }
                        ?>
                        </select>
                    </div>

                    <div class="input-group mb-5">
                        <label for="quantity" class="form-label w-100">Cantidad a retirar</label>
                        <input type="number" class="form-control rounded-start" id="quantity" max="" disabled>
                        <button class="btn btn-primary px-5 rounded-end" type="button" id="quantity_all" disabled>Todo</button>
                        <div id="quantityHelp" class="form-text w-100"></div>
                    </div>

                    <button type="submit" class="btn btn-primary w-50 py-2">Reponer producto</button>
                </form>
            </div>
        </div>
    </div>
</section>