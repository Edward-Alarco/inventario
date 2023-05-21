<?php 
    session_start();
    if(count($_SESSION) == 0){
        header('Location: http://localhost/inventario/?view=cerrar');
    }

    require_once "C:/xampp/htdocs/inventario/src/controllers/inventario.Controller.php";
    require_once "C:/xampp/htdocs/inventario/src/models/inventario.Models.php";

    $e = new inventarioController();
    $arr = $e -> selectActivosEgresadosController();
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

<section class="py-5">
    <div class="container">
        <h1>Registro de Activos Egresados</h1>
        <p class="mb-5">Aquí se encuentra un registro de todos los activos retirados hasta el momento en el inventario, con su fecha y hora de egreso y la cantidad de stock que se retiró en ese instante.</p>
        <table id="table_id" class="display stripe cell-border hover nowrap">
            <thead>
                <tr>
                    <th>Nombre del Activo</th>
                    <th>Tipo</th>
                    <th>Cantidad Retirada</th>
                    <th>Fecha y Hora de ingreso</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($arr as $row){
                        $tipo = $e -> selectTipoActivoController($row['id_tipo']);

                        echo "<tr>
                            <td>".ucwords($row['nombre'])."</td>
                            <td>".$tipo['tipo']."</td>
                            <td>".$row['cantidad_retirada']."</td>
                            <td>".$row['datetime']."</td>
                        </tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#table_id').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
        });
    });
</script>