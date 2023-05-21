<?php 

    class excelController{

        function __construct(){

        }

        public static function guardarExcelController($nombre, $cantidad, $tipo, $delay, $acopio){

            //$deleteBD = excelModel::vaciarDBModel();
            
            date_default_timezone_set('America/Lima');
            $time = date("Y-m-d H:i:s");

            $respuesta = excelModel::guardarExcelModel($nombre, $cantidad, $tipo, $time, $delay, $acopio);
            //echo json_encode($respuesta);

        }

        public static function tipoController($tipo){
            $respuesta = excelModel::tipoModel($tipo);
            return $respuesta;
        }

    }

?>