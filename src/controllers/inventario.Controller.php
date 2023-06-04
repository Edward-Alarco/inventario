<?php 

    class inventarioController{

        public static function registrarPDFController($datos){
            $respuesta = inventarioModel::registrarRutaPDFModel($datos['id_activo'], $datos['ruta']);
            return $respuesta;
        }

        public static function registrarActivoController($datos){

            date_default_timezone_set('America/Lima');
            $datetime = date("Y-m-d H:i:s");
            $datos['datetime'] = $datetime;

            // validar si el activo ya se encuentra en la bd
            $activos_bd = inventarioModel::selectActivosModel();
            $activos_validar = [];
            if(!empty($activos_bd)){
                foreach($activos_bd as $activo){
                    array_push( $activos_validar, strtolower($activo['nombre_producto']) );
                }
            }

            //validar la cantidad de activos que se encuentran en el mismo ubigeo
            $disponibilidad = inventarioModel::disponibilidadModel(intval($datos['posicion']));

            if(in_array( strtolower($datos['nombre_producto']), $activos_validar )){
                $respuesta = 'activo_repetido';
            }else{

                /*if(count($disponibilidad) > 5){
                    $respuesta = 'ubigeo_lleno';
                }else{*/

                    //ingresar el activo
                    $ingresando = inventarioModel::registrarActivoModel($datos);
                    //obtener el id del activo ingresado recientemente
                    $IDactivo = inventarioModel::seleccionarUltimaId()['id'];
                    //listar en la tabla pdf
                    if($datos['ruta_pdf'] != ''){
                        $ruta = inventarioModel::registrarRutaPDFModel($IDactivo, $datos['ruta_pdf']);
                    }

                    if($ingresando){
                        $respuesta = $datos;
                    }

                /*}*/
            }

            return $respuesta;

        }

        public static function selectDelayTimesInRegisterController(){
            //cantidad de activos registrados mediante el modulo de importar excel
            $qty = inventarioModel::selectDelayTimesInRegisterModel()[0];

            //todos los activos registrados mediante el modulo de ingresar bienes de forma manual
            $activos = inventarioModel::selectActivosTroughtRegisterModel();
            
            echo '<div id="delays" class="d-none">
                <p class="cantidad_activos_registrados_excel">'.$qty.'</p>
                <p class="cantidad_activos_registrados_manual">'.count($activos).'</p>';

            $delay = 0;
            foreach ($activos as $key) {
                $delay += $key['delay'];
            }
            echo '<p class="promedio_activos_registrados_manual">'.floatval($delay/count($activos)).'</p>';

            echo '</div>';
        }

        public static function selectReposicionesController(){
            $respuesta = inventarioModel::selectReposicionesModel();
            echo '<div id="times" class="d-none">';
            if($respuesta){
                foreach ($respuesta as $key) {
                    $a = inventarioModel::selectActivoRepuestoModel($key['id_activo']);
                    foreach ($a as $k) {
                        
                        $activo = inventarioModel::selectActivoModel($key['id_activo']);
                        if($activo['cantidad_inicial'] == $activo['cantidad_variable']){

                            // ---------- tiempos de reposicion ---------------
                            $fecha1 = new DateTime($k['datetime']);
                            $fecha2 = new DateTime($activo['datetime']);
                            $diff = $fecha2->diff($fecha1);
                            $Tr = $diff->days;
                            // ---------- tiempos de reposicion ---------------

                            // if($Tr != 0){
                                echo '<p>'.$activo['nombre_producto'].'||'.$k['datetime'].'||'.$activo['datetime'].'||'.$key['id_activo'].'||'.$Tr.'</p>';
                                // nombre activo || tiempo de reposicion || tiempo inicial en el que se ingreso el activo || id del activo || tiempo de reposicion (diferencia de fechas)
                            // }
                        }
                    }
                }
            }
            echo '</div>';
            //echo json_encode($respuesta);
        }

        public static function retirarActivoController($datos){
            date_default_timezone_set('America/Lima');
            $time = date("Y-m-d H:i:s");

            $id_producto = $datos['name'];

            $cantidad_retirada = $datos['quantity'];

            $arrProductoSeleccionado = inventarioModel::selectActivoModel(intval($id_producto));
            if($arrProductoSeleccionado){
                $save_egreso = inventarioModel::guardarEgresoModel($arrProductoSeleccionado, $cantidad_retirada, $time);
                $cantidad_sobrante = intval($arrProductoSeleccionado['cantidad_variable']) - intval($cantidad_retirada);

                if($cantidad_sobrante <= 0){ //si es que ya no existe stock, eliminamos el producto
                    //$respuesta1 = inventarioModel::eliminarActivoModel($id_producto);

                    $respuesta1 = inventarioModel::actualizarCantidadActivoModel($cantidad_sobrante, $id_producto);
                    echo json_encode($respuesta1);
                }else{
                    $respuesta2 = inventarioModel::actualizarCantidadActivoModel($cantidad_sobrante, $id_producto);
                    echo json_encode($respuesta2);
                }

            }
        }

        public static function reponerActivoController($datos){
            date_default_timezone_set('America/Lima');
            $time = date("Y-m-d H:i:s");

            $cantidad_a_retirar = $datos['quantity'];
            $id_tipo = $datos['type'];

            $egreso = inventarioModel::selectActivoEgresadoModel($datos['id']);
            if($egreso){
                //select * el id_ingreso del activo
                $ingreso = inventarioModel::selectActivoModel($egreso['id_activo']);

                //actualizar las cantidades en la tabla de ingresos y egresos
                $nueva_cantidad_para_ingreso = $ingreso['cantidad_variable'] + $cantidad_a_retirar;
                $nueva_cantidad_para_egreso = $egreso['cantidad_retirada'] - $cantidad_a_retirar;

                $actualizarCantidadIngreso = inventarioModel::actualizarCantidadActivoModel($nueva_cantidad_para_ingreso, $egreso['id_activo']);
                $actualizarCantidadEgreso = inventarioModel::actualizarCantidadActivoEgresadoModel($nueva_cantidad_para_egreso, $datos['id']);

                //insertar en la tabla reposicion para guardar la fecha de la repo
                $respuesta = inventarioModel::guardarReposicionModel($egreso['id_activo'], $time, $cantidad_a_retirar);
                echo json_encode($respuesta);
            }
        }

        public static function selectActivosController(){
            $respuesta = inventarioModel::selectActivosModel();
            return $respuesta;
        }

        public static function selectActivosRepuestosController(){
            $respuesta = inventarioModel::selectActivosRepuestosModel();
            return $respuesta;
        }

        public static function selectActivosEgresadosController(){
            $respuesta = inventarioModel::selectActivosEgresadosModel();
            return $respuesta;
        }

        public static function selectTipoActivoController($id){
            $respuesta = inventarioModel::selectTipoActivoModel($id);
            return $respuesta;
        }

        public static function selectPDFActivoController($id){
            $respuesta = inventarioModel::selectPDFActivoModel($id);
            return $respuesta;
        }

        public static function selectAllTypesController(){
            $respuesta = inventarioModel::selectAllTypesModel();
            return $respuesta;
        }

        public static function selectAllUbigeoController(){
            $respuesta = inventarioModel::selectAllUbigeoModel();
            return $respuesta;
        }

        public static function selectActivoController($id){
            $respuesta = inventarioModel::selectActivoModel($id);
            return $respuesta;
        }

        public static function ingresarUbigeoController($posicion){
            $respuesta = inventarioModel::ingresarUbigeoModel($posicion, 2);
            return $respuesta;
        }

        public static function verificarUbigeoController($posicion){
            $respuesta = inventarioModel::verificarUbigeoModel($posicion);
            return $respuesta;
        }

        //metrica control
        public static function controlActivoController($datos){
            $mes = $datos['mes'];
            $id = $datos['id_activo'];

            $ingreso_registro = inventarioModel::selectActivoModel($id);
            $reposicion_registro = inventarioModel::selectActivoRepuestoModel($id)[0];
            // echo json_encode($id);
            $primer_registro = inventarioModel::selectCmnModel($id)[0];
            $segundo_registro = inventarioModel::selectCmnModel($id)[1];

            $Cmin = $primer_registro['cantidad_retirada'];
            $Cmax = $segundo_registro['cantidad_retirada'];
            $E = $ingreso_registro['cantidad'];
            $Cp = ($Cmin + $Cmax)/2;

            // ---------- tiempos de reposicion ---------------
            $fecha1 = new DateTime($primer_registro['datetime']); //fecha de retiro del activo
            $fecha2 = new DateTime($reposicion_registro['datetime']); //fecha de reposicion del activo
            $diff = $fecha2->diff($fecha1);
            $Tr = $diff->days;
            // ---------- tiempos de reposicion ---------------

            $Emin = $Cmin * $Tr;
            $Pp = ($Cp * $Tr) + $Emin;
            $Emax = ($Cmax * $Tr) + $Emin;
            $CP = $Emax - $E;

            $estadistica_reposicion = array();
            $estadistica_egreso = array();

            $l = inventarioModel::selectActivoRepuestoModel2($id);
            foreach ($l as $key) {
                array_push($estadistica_reposicion, $key);
            }

            $m = inventarioModel::selectActivoEgresadoModel2($id);
            foreach ($m as $key) {
                array_push($estadistica_egreso, $key);
            }


            $arr = [
                'Emin'=>$Emin,
                'Emax'=> $Emax,
                'Pp'=> $Pp,
                'CP'=> $CP,
                'estadistica_reposicion'=> $estadistica_reposicion,
                'estadistica_egreso'=> $estadistica_egreso,
            ];
            
            echo json_encode($arr);
        }

    }

?>