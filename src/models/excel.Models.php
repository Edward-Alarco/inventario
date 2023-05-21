<?php

    require_once "C:/xampp/htdocs/inventario/src/lib/Conexion.php";
    use edward\inventario\lib\Conexion;

    class excelModel extends Conexion{

        public static function guardarExcelModel($nombre, $cantidad, $tipo, $time, $delay, $acopio){
            $stmt = Conexion::conectar()->prepare("INSERT INTO ingresos (nombre, cantidad_inicial, cantidad, id_tipo, datetime, delay, posicion) VALUES(:nombre, :cantidad_inicial, :cantidad, :id_tipo, :datetime, :delay, :posicion)");
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(":cantidad_inicial", $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(":id_tipo", $tipo, PDO::PARAM_INT);
            $stmt->bindParam(":delay", $delay, PDO::PARAM_STR);
            $stmt->bindParam(":datetime", $time, PDO::PARAM_STR);
            $stmt->bindParam(":posicion", $acopio, PDO::PARAM_STR);
            $stmt->execute() ? $ret = true : $ret = false;
            return $ret;
        }

        public static function vaciarDBModel(){
            $stmt = Conexion::conectar()->prepare("DELETE FROM ingresos");
            $stmt->execute();
            return $stmt->fetch();
            $stmt = "";   
        }

        public static function tipoModel($t){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM tipos WHERE tipo=:tipo");
            $stmt->bindParam(":tipo", $t, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
            $stmt = "";   
        }
    
    }


?>