<?php require_once dirname(__FILE__).'/../views/inc/session.php'; ?>

<section class="importar pt-5 pb-3">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-6">
                <form action="?view=importar" method="POST" enctype="multipart/form-data">
                    <!-- <form action="http://localhost/inventario/?view=importar" method="POST"> -->
                    <label for="formFile" class="form-label">Importar excel</label>
                    <div class="input-group mb-3">
                        <input class="form-control" type="file" id="formFile" name="archivo" accept=".xls, .xlsx">
                        <button class="btn btn-primary" type="submit" id="button-addon1">Subir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="w-100">
    <div class="container">
        <?php

        require_once dirname(__FILE__) . "/../controllers/excel.Controller.php";
        require_once dirname(__FILE__) . "/../models/excel.Models.php";
        //----------------------------------
        require_once dirname(__FILE__) . "/../controllers/inventario.Controller.php";
        require_once dirname(__FILE__) . "/../models/inventario.Models.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_FILES["archivo"])) {
                $nombreArchivo = "inventario.xlsx";
                $rutaArchivo = $_FILES["archivo"]["tmp_name"];
                $tipoArchivo = $_FILES["archivo"]["type"];
                $tamañoArchivo = $_FILES["archivo"]["size"];

                move_uploaded_file($rutaArchivo, "src/excel/" . $nombreArchivo);

                $e = new excelController();
                $i = new inventarioController();

                class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
                {

                    public function readCell($columnAddress, $row, $worksheetName = '')
                    {
                        // Read title row and rows 20 - 30
                        if ($row > 2) {
                            return true;
                        }
                        return false;
                    }
                }

                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                $inputFileName = './src/excel/inventario.xlsx';

                //Identify the type of $inputFileName
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                //Create a new Reader of the type that has been identified
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                //leo la funcion para obtener desde la 10ma celda para abajo
                $reader->setReadFilter(new MyReadFilter());
                //Load $inputFileName to a Spreadsheet Object
                $spreadsheet = $reader->load($inputFileName);
                $spreadsheet->setActiveSheetIndexByName('Data');

                $filas = $spreadsheet->getActiveSheet()->toArray();

                $datos = [];

                foreach ($filas as $fila) {
                    if (!empty($fila[2])) {

                        $nombre = $fila[1]; //nombre_producto
                        $stock = intval($fila[2]); //stock
                        $und = $fila[3]; //und
                        $costo = $fila[4]; //costo
                        $posicion = $fila[6]; //posicion
                        $tipo = $fila[5]; //tipo

                        // obtener el id del tipo ingresante
                        $id_tipo = $e->tipoController($tipo)['id_tipo'];

                        $datos['nombre_producto'] = $nombre;
                        $datos['cantidad_inicial'] = $stock;
                        $datos['id_tipo'] = $id_tipo;
                        $datos['delay'] = 1;
                        $datos['posicion'] = $posicion;
                        $datos['ruta_pdf'] = '';


                        //verificar si el ubigeo ya se encuentra en la bd
                        $verificar_ubigeo = $i->verificarUbigeoController($posicion);
                        if (empty($verificar_ubigeo)) {
                            //llenar tabla de ubigeo
                            $ubigeo = $i->ingresarUbigeoController($posicion);
                        }

                        $insertandoEnBD = $i->registrarActivoController($datos);

                        unset($datos);
                    }
                }

                header('Location: http://localhost/inventario/?view=home');

            } else {
                echo "No se ha seleccionado ningún archivo.";
            }
        }
        ?>
    </div>
</section>