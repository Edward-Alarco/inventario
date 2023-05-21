<?php

    require_once "C:/xampp/htdocs/inventario/src/lib/Conexion.php";
    use edward\inventario\lib\Conexion;

    class ingresoModel extends Conexion{

        //plural
        public static function selectUsersModel(){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios");
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt = "";   
        }

        //singular
        public static function selectUserModel($correo){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE correo=:correo");
            $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
            $stmt = "";   
        }

        public static function registrarUsuarioModel($rol, $nombres, $paterno, $materno, $correo, $clave){
            $stmt = Conexion::conectar()->prepare("INSERT INTO usuarios (id_rol, nombres, apellido_paterno, apellido_materno, correo, clave) VALUES (:id_rol, :nombres, :apellido_paterno, :apellido_materno, :correo, :clave)");
            $stmt->bindParam(":id_rol", $rol, PDO::PARAM_INT);
            $stmt->bindParam(":nombres", $nombres, PDO::PARAM_STR);
            $stmt->bindParam(":apellido_paterno", $paterno, PDO::PARAM_STR);
            $stmt->bindParam(":apellido_materno", $materno, PDO::PARAM_STR);
            $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
            $stmt->bindParam(":clave", $clave, PDO::PARAM_STR);
            $stmt->execute();
            $stmt = "";   
        }
    
    }


?>