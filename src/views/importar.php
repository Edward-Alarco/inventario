<?php

require_once dirname(__FILE__)."/../controllers/excel.Controller.php";
require_once dirname(__FILE__)."/../models/excel.Models.php";

$e = new excelController();

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
$inputFileName = './inventario-nuevo.xlsx';

/**  Identify the type of $inputFileName  **/
$inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
/**  Create a new Reader of the type that has been identified  **/
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
//leo la funcion para obtener desde la 10ma celda para abajo
$reader->setReadFilter( new MyReadFilter() );
/**  Load $inputFileName to a Spreadsheet Object  **/
$spreadsheet = $reader->load($inputFileName);
$spreadsheet->setActiveSheetIndexByName('Data');

$cantidad = $spreadsheet->getActiveSheet()->toArray();

foreach($cantidad as $row){
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

}

?>

<script>
    setTimeout(() => {
        window.location.href = `http://localhost/inventario/?view=home`
    }, 1700);
</script>