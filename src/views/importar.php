<?php

require_once dirname(__FILE__)."/../controllers/excel.Controller.php";
require_once dirname(__FILE__)."/../models/excel.Models.php";
//----------------------------------
require_once dirname(__FILE__) . "/../controllers/inventario.Controller.php";
require_once dirname(__FILE__) . "/../models/inventario.Models.php";

$e = new excelController();
$i = new inventarioController();

class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter {

    public function readCell($columnAddress, $row, $worksheetName = '') {
        // Read title row and rows 20 - 30
        if ($row>2) {
            return true;
        }
        return false;
    }
}

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
$inputFileName = './inventario.xlsx';

/**  Identify the type of $inputFileName  **/
$inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
/**  Create a new Reader of the type that has been identified  **/
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
//leo la funcion para obtener desde la 10ma celda para abajo
$reader->setReadFilter( new MyReadFilter() );
/**  Load $inputFileName to a Spreadsheet Object  **/
$spreadsheet = $reader->load($inputFileName);
$spreadsheet->setActiveSheetIndexByName('Data');

$filas = $spreadsheet->getActiveSheet()->toArray();

$datos = [];

foreach($filas as $fila){
    if(!empty($fila[2])){

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
        if(empty($verificar_ubigeo)){
            //llenar tabla de ubigeo
            $ubigeo = $i->ingresarUbigeoController($posicion);
        }

        $insertandoEnBD = $i->registrarActivoController($datos);
        
        unset($datos);
    }
}

/*foreach($cantidad as $row){
    if(!empty($row[2])){

        $tipo = $row[7];
        $cantidad = $row[3];
        $nombre = $row[2];
        $acopio = $row[8];

        if($tipo == 'Hardware'){
            $id_tipo = 1;
        }elseif($tipo == 'Software'){
            $id_tipo = 2;
        }elseif($tipo == 'Documentación'){
            $id_tipo = 3;
        }elseif($tipo == 'Utensilios'){
            $id_tipo = 4;
        }elseif($tipo == 'Higiene'){
            $id_tipo = 5;
        }

        $insertandoEnBD = $e -> guardarExcelController($nombre, $cantidad, $id_tipo, 1, $acopio);
    }
}*/

?>

<!-- <script>
    setTimeout(() => {
        window.location.href = `http://localhost/inventario/?view=home`
    }, 1700);
</script> -->