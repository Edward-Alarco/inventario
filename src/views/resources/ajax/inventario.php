<?php

    require_once('../../../../src/controllers/inventario.Controller.php');
    require_once('../../../../src/models/inventario.Models.php');

    class inventarioAjax{

        public $name, $quantity, $type, $id_egreso, $delay;

        public function ingresarActivo(){
            $datos = array(
                'name' => $this->name,
                'quantity' => $this->quantity,
                'type' => $this->type,
                'delay' => $this->delay
            );
            //echo json_encode($datos);
            $res =  inventarioController::ingresarActivoController($datos);
        }

        public function retirarActivo(){
            $datos = array(
                'name' => $this->name,
                'quantity' => $this->quantity,
                'type' => $this->type
            );
            //echo json_encode($datos);
            $res =  inventarioController::retirarActivoController($datos);
        }

        public function reponerActivo(){
            $datos = array(
                'type' => $this->type,
                'quantity' => $this->quantity,
                'id' => $this->id_egreso
            );
            //echo json_encode($datos);
            $res =  inventarioController::reponerActivoController($datos);
        }

        public $id_activo, $mes;

        public function controlActivo(){
            $datos = array(
                'id_activo' => $this->id_activo,
                'mes' => $this->mes
            );
            //echo json_encode($datos);
            $res =  inventarioController::controlActivoController($datos);
        }

    }

    $e = new inventarioAjax();

    if($_POST['validar'] == "registrarActivo"){
        $e -> name = $_POST['name'];
        $e -> quantity = $_POST['quantity'];
        $e -> type = $_POST['type'];
        $e -> delay = $_POST['delay'];
        $e -> ingresarActivo();
    }

    if($_POST['validar'] == "egresarActivo"){
        $e -> name = $_POST['name'];
        $e -> quantity = $_POST['quantity'];
        $e -> type = $_POST['type'];
        $e -> retirarActivo();
    }

    if($_POST['validar'] == "reponerActivo"){
        $e -> type = $_POST['id_tipo'];
        $e -> quantity = $_POST['cantidad'];
        $e -> id_egreso = $_POST['id_egreso'];
        $e -> reponerActivo();
    }

    if($_POST['validar'] == "control"){
        $e -> mes = $_POST['mes'];
        $e -> id_activo = $_POST['id_activo'];
        $e -> controlActivo();
    }


?>