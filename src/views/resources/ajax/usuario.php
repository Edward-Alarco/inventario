<?php

    require_once('../../../../src/controllers/ingreso.Controller.php');
    require_once('../../../../src/models/ingreso.Models.php');

    class inventarioAjax{

        public $array;

        public function registrarUsuario(){
            $datos = $this->array;
            $respuesta =  ingresoController::registrarUsuarioController($datos);
            echo json_encode($respuesta);
        }

        public function ingresarUsuario(){
            $datos = $this->array;
            $respuesta =  ingresoController::ingresarUsuarioController($datos);
            echo json_encode($respuesta);
        }

    }

    $e = new inventarioAjax();

    if($_POST['validar'] == "registro_usuario"){
        $e -> array = $_POST;
        $e -> registrarUsuario();
    }

    if($_POST['validar'] == "login_usuario"){
        $e -> array = $_POST;
        $e -> ingresarUsuario();
    }


?>