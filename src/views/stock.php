<?php require_once dirname(__FILE__).'/../views/inc/session.php'; ?>
<?php
require_once dirname(__FILE__) . "/../controllers/inventario.Controller.php";
require_once dirname(__FILE__) . "/../models/inventario.Models.php";

$e = new inventarioController();
$arrA = $e->selectAllTypesController();
$arrI = $e->selectActivosController();
$arrE = $e->selectActivosEgresadosController();
?>

<section class="stock py-5">
    <div class="container">
        <h2 class="mb-2">Stock</h2>
        <h4><i>Stock Promedio</i></h4>
        <hr>
        <select class="form-select me-2 d-inline" style="max-width:200px" id="month">
            <option selected>Escoge el mes</option>
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
            <option value="12">Diciembre</option>
        </select>
        <select class="form-select me-2 d-inline" style="max-width:200px" id="type">
            <?php 
                foreach ($arrA as $key) {
                    echo '<option value="'.eliminar_acentos(strtolower($key['tipo'])).'">'.$key['tipo'].'</option>';
                }
            ?>
        </select>
        <table class="table my-5">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">S<sub><i>i</i></sub></th>
                    <th scope="col">S<sub><i>f</i></sub></th>
                    <th scope="col">S<sub><i>prom</i></sub></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <br><hr><br>
        <div class="row">
            <div class="col-12 col-md-6">
                <div id="graphic1" class="w-100"></div>
            </div>
            <div class="col-12 col-md-6">
                <div id="graphic2" class="w-100"></div>
            </div>
        </div>
    </div>
</section>

<div class="d-none invisible" id="data">
    <ul id="ingresos">
        <?php
        foreach ($arrI as $key) {
            $tipo = $e->selectTipoActivoController($key['id_tipo']);
            $month = 'month-' . explode('-', $key['datetime'])[1];
            $name = eliminar_acentos(strbasic($key['nombre']));
            echo '<li data-nombre="'.$key['nombre'].'" data-tipo="' . strbasic($tipo['tipo']) . '" class="' . $month . ' bien-'.$key['id_ingreso'].'">' . $key['cantidad'] . '</li>';
        }
        ?>
    </ul>
    <ul id="egresos">
        <?php
        foreach ($arrE as $key) {
            $tipo = $e->selectTipoActivoController($key['id_tipo']);
            $month = 'month-' . explode('-', $key['datetime'])[1];
            $name = eliminar_acentos(strbasic($key['nombre']));
            echo '<li data-nombre="'.$key['nombre'].'" data-tipo="' . strbasic($tipo['tipo']) . '" class="' . $month . ' bien-'.$key['id_activo'].'">' . $key['cantidad_retirada'] . '</li>';
        }
        ?>
    </ul>
</div>

<?php
function strbasic($str)
{
    return str_replace(' ', '_', strtolower($str));
}
function eliminar_acentos($cadena)
{
    //Reemplazamos la A y a
    $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $cadena
    );
    //Reemplazamos la E y e
    $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $cadena
    );
    //Reemplazamos la I y i
    $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $cadena
    );
    //Reemplazamos la O y o
    $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $cadena
    );
    //Reemplazamos la U y u
    $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $cadena
    );
    //Reemplazamos la N, n, C y c
    $cadena = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç'),
        array('N', 'n', 'C', 'c'),
        $cadena
    );

    return $cadena;
}
?>

<script src="src/views/resources/js/stock.js"></script>