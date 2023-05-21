<?php
session_start();
if (count($_SESSION) == 0) {
    header('Location: http://localhost/inventario/?view=cerrar');
}

require_once dirname(__FILE__) . "/../controllers/inventario.Controller.php";
require_once dirname(__FILE__) . "/../models/inventario.Models.php";

$e = new inventarioController();
$arr = $e->selectReposicionesController();
?>


<section class="tiempo py-5">
    <div class="container">
        <h2>Tiempos y Σs</h2>
        <hr><br>
        <p>- Demoras en tiempos de reposición</p>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Fecha Ingreso</th>
                    <th scope="col">Fecha Final de Reposición</th>
                    <th scope="col">Demora (en días)</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <br><hr><br>
        <p>- Demoras en el ingreso de productos</p>
        <ul class="datos">
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <br><br><hr><br>
        <div class="row">
            <div class="col-12 col-md-6">
                <div id="graphic1"></div>
            </div>
            <div class="col-12 col-md-6">
                <div id="graphic2"></div>
            </div>
        </div>
    </div>
</section>

<?php 
$arr = $e->selectDelayTimesInRegisterController();
?>

<!-- <script src="src/views/resources/js/tiempos.js"></script> -->