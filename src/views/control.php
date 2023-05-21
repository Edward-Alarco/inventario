<?php
session_start();
if (count($_SESSION) == 0) {
    header('Location: http://localhost/inventario/?view=cerrar');
}

require_once dirname(__FILE__) . "/../controllers/inventario.Controller.php";
require_once dirname(__FILE__) . "/../models/inventario.Models.php";

$e = new inventarioController();
$arr = $e->selectActivosRepuestosController();
?>

<section class="stock py-5">
    <div class="container">
        <h2 class="mb-2">Control</h2>
        <h4><i>Promedio Cantidad de Activos</i></h4>
        <hr>
        <div class="d-flex align-items-center">
            <select class="form-select me-2 d-inline" style="max-width:200px" id="month">
                <option value="01">Enero</option>
                <option value="02">Febrero</option>
                <option value="03">Marzo</option>
                <option value="04">Abril</option>
                <option value="05">Mayo</option>
                <option value="06">Junio</option>
                <option value="07">Julio</option>
                <option value="08">Agosto</option>
                <option value="09">Setiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12" selected>Diciembre</option>
            </select>
            <select class="form-select me-2 d-none" style="max-width:200px" id="type">
                <option value="utiles_de_oficina" selected>Utiles de Oficina</option>
                <option value="impresion">Impresión</option>
                <option value="varios">Varios</option>
                <option value="jardineria">Jardinería</option>
                <option value="libro">Libro</option>
                <option value="limpieza">Limpieza</option>
                <option value="mantenimiento">Mantenimiento</option>
                <option value="pintura">Pintura</option>
                <option value="publicitario">Publicitario</option>
                <option value="topico">Topico</option>
            </select>
            <select class="form-select me-2 d-inline" style="max-width:200px" id="product">
                <?php
                foreach ($arr as $key) {
                    $nombre = $e->selectActivoController($key['id_activo']);
                    echo '<option value="' . $key['id_activo'] . '">' . $nombre[1] . '</option>';
                }
                ?>
            </select>
            <button id="search" class="btn btn-dark px-4 d-flex align-items-center">Buscar&nbsp;&nbsp;<ion-icon name="search-outline"></ion-icon></button>
        </div>

        <div class="row my-5">
            <div class="col-12 col-md-6 col-lg-4">
                <ul class="list-group">
                    <li class="list-group-item active bg-dark" aria-current="true">
                        Fórmulas
                    </li>
                    <li class="list-group-item">
                        C<sub><i>p</i></sub> = Consumo medio diario
                    </li>
                    <li class="list-group-item">
                        E<sub><i>max</i></sub> = Existencia máxima
                    </li>
                    <li class="list-group-item">
                        E<sub><i>min</i></sub> = Existencia mínima
                    </li>
                    <li class="list-group-item">
                        C<sub><i>max</i></sub> = Consumo máximo diario
                    </li>
                    <li class="list-group-item">
                        C<sub><i>min</i></sub> = Consumo mínimo diario
                    </li>
                    <li class="list-group-item">
                        P<sub><i>p</i></sub> = Punto pedido
                    </li>
                    <li class="list-group-item">
                        T<sub><i>r</i></sub> = Tiempo de reposici&oacute;n de inventario
                    </li>
                    <li class="list-group-item">
                        E = Existencia Actual de cada bien
                    </li>
                    <li class="list-group-item">
                        CP = Cantidad de pedido
                    </li>
                </ul>
            </div>
            <div class="col-12 col-md-6 col-lg-8">

                <p>E<sub><i>min</i></sub> = C<sub><i>min</i></sub> * T<sub><i>r</i></sub></p>
                <hr>
                <p id="emin"></p>
                
                <br><br>
                <p>P<sub><i>p</i></sub> = ( C<sub><i>p</i></sub> * T<sub><i>r</i></sub> ) + E<sub><i>min</i></sub></p>
                <hr>
                <p id="pp"></p>
                
                <br><br>
                <p>E<sub><i>max</i></sub> = ( C<sub><i>max</i></sub> * T<sub><i>r</i></sub> ) + E<sub><i>min</i></sub></p>
                <hr>
                <p id="emax"></p>

                <br><br>
                <p>CP = E<sub><i>max</i></sub> - E</p>
                <hr>
                <p id="cp"></p>

            </div>
        </div>
        <br><br><hr><br>
        <div class="row">
            <div class="col-12 col-md-6">
                <div id="graphic"></div>    
            </div>
        </div>
    </div>
</section>


<script src="src/views/resources/js/control.js"></script>