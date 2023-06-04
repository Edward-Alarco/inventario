<?php

    require_once('../../../../src/controllers/ingreso.Controller.php');
    require_once('../../../../src/models/ingreso.Models.php');

    class inventarioAjax{

        public $array;

        public function actualizarUsuario(){
            $datos = $this->array;
            $respuesta =  ingresoController::actualizarUsuarioController($datos);
            echo json_encode($respuesta);
        }

        public function actualizarRolUsuario(){
            $datos = $this->array;
            $respuesta =  ingresoController::actualizarRolController($datos);
            echo json_encode($respuesta);
        }

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

    if($_POST['validar'] == "actualizar_usuario"){
        $e -> array = $_POST;
        $e -> actualizarUsuario();
    }

    if($_POST['validar'] == "actualizar_rol"){
        $e -> array = $_POST;
        $e -> actualizarRolUsuario();
    }


?>