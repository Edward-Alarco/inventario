<?php require_once dirname(__FILE__).'/../views/inc/session.php'; ?>
<?php 
    require_once dirname(__FILE__) . "/../controllers/inventario.Controller.php";
    require_once dirname(__FILE__) . "/../models/inventario.Models.php";

    $e = new inventarioController();
    $arr = $e -> selectActivosController();
?>

<a href="?view=importar" class="btn btn-success btn-lg import"><ion-icon name="cloud-upload-outline"></ion-icon></a>

<section class="py-5">
    <div class="container">
        <h2>Procedimientos</h2><hr>
        <div class="row mt-4 mb-5" style="row-gap:24px">
            <div class="col-12 col-sm-12 col-md-6">
                <div class="card">
                    <h5 class="card-header">Ingresos</h5>
                    <div class="card-body">
                        <h5 class="card-title">Cantidad de ingresos de bienes registrados</h5>
                        <p class="card-text">Se registrá la cantidad, activo, fecha, hora y otros datos de suma relevancia para su guardado</p>
                        <a href="?view=ingreso" class="btn btn-primary">Ingresar Nuevo Activo</a>
                        <a href="?view=reposicion" class="btn btn-danger">Reposición</a>
                        <a href="?view=lista-ingreso" class="btn btn-success">Ver todos</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-6">
                <div class="card">
                    <h5 class="card-header">Salidas</h5>
                    <div class="card-body">
                        <h5 class="card-title">Cantidad de egresos de bienes registrados</h5>
                        <p class="card-text">Se registrá la cantidad, activo, fecha, hora y otros datos de suma relevancia para su guardado</p>
                        <a href="?view=egreso" class="btn btn-primary">Egresar Activo</a>
                        <a href="?view=lista-egreso" class="btn btn-success">Ver todos</a>
                    </div>
                </div>
            </div>
        </div>

        <h2>Métricas</h2><hr>
        <div class="row mt-4 mb-5" style="row-gap:24px">
            <div class="col-12 col-sm-6 col-md-6">
                <div class="card">
                    <h5 class="card-header">Stock</h5>
                    <div class="card-body">
                        <h5 class="card-title">Métrica Stock Promedio</h5>
                        <a href="?view=stock" class="btn btn-primary">Ingresar</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 d-none">
                <div class="card">
                    <h5 class="card-header">Control</h5>
                    <div class="card-body">
                        <h5 class="card-title">Promedio Cantidad de Activos</h5>
                        <a href="?view=control" class="btn btn-primary">Ingresar</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-6">
                <div class="card">
                    <h5 class="card-header">Tiempo</h5>
                    <div class="card-body">
                        <h5 class="card-title">Σ del tiempo registrado y su promedio</h5>
                        <a href="?view=tiempo" class="btn btn-primary">Ingresar</a>
                    </div>
                </div>
            </div>
        </div>

        <h2>Estadisticas</h2><hr>
        <div class="row mt-4 justify-content-center">
            <div class="col-12 col-sm-12 col-md-6">
                <figure class="highcharts-figure w-100">
                    <div id="containerDonut" class="w-100"></div>
                    <p class="highcharts-description text-center w-100"></p>
                </figure>
            </div>
            <div class="col-12 col-sm-12 col-md-6">
                <div id="containerBars"></div>
            </div>
        </div>
    </div>
</section>


<?php
    echo '<div id="stats1">';
    foreach($arr as $row){
        $tipo = $e -> selectTipoActivoController($row['id_tipo']);
        echo '<p class="tipo-'.$row['id_tipo'].' '.strtolower($tipo['tipo']).'">'.$tipo['tipo'].'</p>';
    }
    echo '</div>';

    echo '<div id="stats2">';
    foreach($arr as $row){
        echo '<p data-cantidad="'.$row['cantidad'].'">'.ucwords($row['nombre']).'</p>';
    }
    echo '</div>';
?>