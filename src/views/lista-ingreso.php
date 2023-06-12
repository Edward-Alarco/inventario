<?php require_once dirname(__FILE__).'/../views/inc/session.php'; ?>
<?php 
    require_once dirname(__FILE__) . "/../controllers/inventario.Controller.php";
    require_once dirname(__FILE__) . "/../models/inventario.Models.php";

    $e = new inventarioController();
    $arr = $e -> selectActivosController();
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

<section class="py-5">
    <div class="container">
        <h1>Registro de Recursos</h1>
        <p class="mb-5">Aquí se encuentra un registro de todos los recursos presentes hasta el momento en el inventario.</p>
        <table id="table_id" class="display stripe cell-border hover nowrap">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-left">Nombre del recurso</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Cantidad<br>Inicial</th>
                    <th class="text-center">Quedan<br>dentro:</th>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">PDF - QR</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($arr as $row):
                    $tipo = $e -> selectTipoActivoController($row['id_tipo']);
                    $pdf = $e -> selectPDFActivoController($row['id']);
                ?>
                <tr data-id="<?php echo $row['id']; ?>">

                    <td><?php echo sprintf("%03d", $row['id']); ?></td>
                    <td>
                        <p><?php echo ucwords($row['nombre_producto']); ?></p>
                    </td>
                    <td><?php echo $tipo['tipo']; ?></td>
                    <td><?php echo $row['cantidad_inicial']; ?></td>
                    <td><?php echo $row['cantidad_variable']; ?></td>
                    <td><?php echo $row['datetime']; ?></td>
                    <?php if(!empty($pdf)): ?>
                    <td>
                        <a href="<?php echo $pdf['ruta']; ?>" target="_blank" class="btn btn-primary mx-auto">
                            Visualizar &nbsp;<ion-icon name="document-attach-outline"></ion-icon>
                        </a>
                    </td>
                    <?php else: ?>
                    <td>
                        <form class="generate_pdf_by_table">
                            <input type="hidden" value="<?php echo $row['id']; ?>" name="id_activo">
                            <input type="hidden" value="registrar_pdf" name="validar">
                            <input type="hidden" value='<?php echo reemplazarEspacios($row['nombre_producto']); ?>' name="nombre">
                            <input type="hidden" value='<?php echo $row['cantidad_inicial']; ?>' name="cantidad">
                            <input type="hidden" value='<?php echo $tipo['tipo'] ?>' name="tipo">
                            <input type="hidden" value='<?php echo $row['posicion'] ?>' name="posicion">
                            <input type="hidden" value='<?php echo $row['datetime'] ?>' name="fecha">
                            <button class="btn btn-dark d-flex align-items-center mx-auto" type="submit">
                                Generar &nbsp;<ion-icon name="document-outline"></ion-icon>
                            </button>
                        </form>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
                <?php 
                    function reemplazarEspacios($texto){
                        $caracteresEspeciales = array('"', '(', ')', '/', '´´', '``');
                        $texto = str_replace(' ', '_', $texto);
                        $texto = str_replace($caracteresEspeciales, '', $texto);
                        return $texto;
                    }
                ?>
            </tbody>
        </table>
    </div>
</section>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">QR</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="qr_image w-100 d-block text-center"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(__FILE__).'/../views/inc/datatable-footer.php'; ?>