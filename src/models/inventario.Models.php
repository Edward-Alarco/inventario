<?php

    require_once "C:/xampp/htdocs/inventario/src/lib/Conexion.php";
    use edward\inventario\lib\Conexion;

    class inventarioModel extends Conexion{

        public static function ingresarActivoModel($array, $time){
            $stmt = Conexion::conectar()->prepare("INSERT INTO ingresos (nombre, cantidad_inicial, cantidad, id_tipo, datetime, delay) VALUES(:nombre, :cantidad_inicial, :cantidad, :id_tipo, :datetime, :delay)");
            $stmt->bindParam(":nombre", $array['name'], PDO::PARAM_STR);
            $stmt->bindParam(":cantidad", $array['quantity'], PDO::PARAM_INT);
            $stmt->bindParam(":cantidad_inicial", $array['quantity'], PDO::PARAM_INT);
            $stmt->bindParam(":id_tipo", $array['type'], PDO::PARAM_INT);
            $stmt->bindParam(":delay", $array['delay'], PDO::PARAM_STR);
            $stmt->bindParam(":datetime", $time, PDO::PARAM_STR);
            $stmt->execute() ? $ret = true : $ret = false;
            return $ret;
        }

        public static function selectReposicionesModel(){
            $stmt = Conexion::conectar()->prepare("SELECT DISTINCT id_activo FROM reposicion ORDER BY id_reposicion DESC");
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt = "";   
        }

        public static function selectDelayTimesInRegisterModel(){
            $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) FROM ingresos WHERE delay=1");
            $stmt->execute();
            return $stmt->fetch();
            $stmt = "";   
        }

        public static function selectActivosTroughtRegisterModel(){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM ingresos WHERE delay>1");
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt = "";   
        }

        //plural
        public static function selectActivosModel(){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM ingresos");
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt = "";   
        }

        //singular
        public static function selectActivoModel($id){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM ingresos WHERE id_ingreso=:id_ingreso");
            $stmt->bindParam(":id_ingreso", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
            $stmt = "";   
        }

        //singular
        public static function selectActivoRepuestoModel($id){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM reposicion WHERE id_activo=:id_activo ORDER BY id_reposicion DESC LIMIT 1");
            $stmt->bindParam(":id_activo", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt = "";   
        }

        //plurar
        public static function selectActivosEgresadosModel(){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM egresos");
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt = "";   
        }

        //plurar
        public static function selectActivosRepuestosModel(){
            $stmt = Conexion::conectar()->prepare("SELECT DISTINCT id_activo FROM reposicion");
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt = "";   
        }

        //singular
        public static function selectActivoEgresadoModel($id){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM egresos WHERE id_egreso=:id_egreso LIMIT 1");
            $stmt->bindParam(":id_egreso", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
            $stmt = "";   
        }

        public static function guardarEgresoModel($array, $cantidad_retirada, $time){
            $stmt = Conexion::conectar()->prepare("INSERT INTO egresos (id_activo, nombre, cantidad_retirada, id_tipo, datetime) VALUES(:id_activo, :nombre, :cantidad_retirada, :id_tipo, :datetime)");
            $stmt->bindParam(":id_activo", $array['id_ingreso'], PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $array['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(":cantidad_retirada", $cantidad_retirada, PDO::PARAM_INT);
            $stmt->bindParam(":id_tipo", $array['id_tipo'], PDO::PARAM_INT);
            $stmt->bindParam(":datetime", $time, PDO::PARAM_STR);
            $stmt->execute() ? $ret = true : $ret = false;
            return $ret;
        }

        public static function eliminarActivoModel($id){
            $stmt = Conexion::conectar()->prepare("DELETE FROM ingresos WHERE id_ingreso=:id_ingreso");
            $stmt->bindParam(":id_ingreso", $id, PDO::PARAM_INT);
            $stmt->execute() ? $ret = true : $ret = false;
            return $ret;
        }

        public static function actualizarCantidadActivoModel($cantidad_sobrante, $id){
            $stmt = Conexion::conectar()->prepare("UPDATE ingresos SET cantidad=:cantidad WHERE id_ingreso=:id_ingreso");
            $stmt->bindParam(":cantidad", $cantidad_sobrante, PDO::PARAM_INT);
            $stmt->bindParam(":id_ingreso", $id, PDO::PARAM_INT);
            $stmt->execute() ? $ret = true : $ret = false;
            return $ret;
        }

        public static function actualizarCantidadActivoEgresadoModel($cantidad_sobrante, $id){
            $stmt = Conexion::conectar()->prepare("UPDATE egresos SET cantidad_retirada=:cantidad_retirada WHERE id_egreso=:id_egreso");
            $stmt->bindParam(":cantidad_retirada", $cantidad_sobrante, PDO::PARAM_INT);
            $stmt->bindParam(":id_egreso", $id, PDO::PARAM_INT);
            $stmt->execute() ? $ret = true : $ret = false;
            return $ret;
        }

        public static function selectTipoActivoModel($id){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM tipos WHERE id_tipo=:id_tipo");
            $stmt->bindParam(":id_tipo", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
            $stmt = "";   
        }

        //plurar
        public static function selectAllTypesModel(){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM tipos");
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt = "";   
        }

        public static function guardarReposicionModel($id, $time, $cantidad_a_reponer){
            $stmt = Conexion::conectar()->prepare("INSERT INTO reposicion (id_activo, cantidad_a_reponer, datetime) VALUES(:id_activo, :cantidad_a_reponer, :datetime)");
            $stmt->bindParam(":id_activo", $id, PDO::PARAM_INT);
            $stmt->bindParam(":cantidad_a_reponer", $cantidad_a_reponer, PDO::PARAM_INT);
            $stmt->bindParam(":datetime", $time, PDO::PARAM_STR);
            $stmt->execute() ? $ret = true : $ret = false;
            return $ret;
        }

        //---------------------------------------------------------------

        public static function selectCmnModel($id){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM egresos WHERE id_activo=:id_activo ORDER BY cantidad_retirada");
            $stmt->bindParam(":id_activo", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt = "";   
        }


        public static function selectActivoRepuestoModel2($id){
            $stmt = Conexion::conectar()->prepare("SELECT cantidad_a_reponer FROM reposicion WHERE id_activo=:id_activo");
            $stmt->bindParam(":id_activo", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt = "";   
        }
        public static function selectActivoEgresadoModel2($id){
            $stmt = Conexion::conectar()->prepare("SELECT cantidad_retirada FROM egresos WHERE id_activo=:id_activo");
            $stmt->bindParam(":id_activo", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt = "";   
        }
    
    }


?>
