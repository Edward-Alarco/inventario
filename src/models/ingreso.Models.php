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

        //plural
        public static function selectUsersModels(){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE id_rol != 1");
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

        public static function selectUserModelById($id){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE id_usuario=:id_usuario");
            $stmt->bindParam(":id_usuario", $id, PDO::PARAM_INT);
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

        public static function actualizarUsuarioModel($arr, $id){
            $stmt = Conexion::conectar()->prepare("UPDATE usuarios SET nombres=:nombres, apellido_paterno=:apellido_paterno, apellido_materno=:apellido_materno, correo=:correo WHERE id_usuario=:id_usuario");
            $stmt->bindParam(":id_usuario", $id, PDO::PARAM_INT);
            $stmt->bindParam(":nombres", $arr['nombres'], PDO::PARAM_STR);
            $stmt->bindParam(":apellido_paterno", $arr['apellido_paterno'], PDO::PARAM_STR);
            $stmt->bindParam(":apellido_materno", $arr['apellido_materno'], PDO::PARAM_STR);
            $stmt->bindParam(":correo", $arr['correo'], PDO::PARAM_STR);
            $stmt->execute() ? $ret = true : $ret = false;
            return $ret;
        }

        public static function actualizarUsuarioModelWithPass($arr, $id){
            $stmt = Conexion::conectar()->prepare("UPDATE usuarios SET nombres=:nombres, apellido_paterno=:apellido_paterno, apellido_materno=:apellido_materno, correo=:correo, clave=:clave WHERE id_usuario=:id_usuario");
            $stmt->bindParam(":id_usuario", $id, PDO::PARAM_INT);
            $stmt->bindParam(":nombres", $arr['nombres'], PDO::PARAM_STR);
            $stmt->bindParam(":apellido_paterno", $arr['apellido_paterno'], PDO::PARAM_STR);
            $stmt->bindParam(":apellido_materno", $arr['apellido_materno'], PDO::PARAM_STR);
            $stmt->bindParam(":correo", $arr['correo'], PDO::PARAM_STR);
            $stmt->bindParam(":clave", $arr['clave_nueva'], PDO::PARAM_STR);
            $stmt->execute() ? $ret = true : $ret = false;
            return $ret;
        }

        public static function actualizarRolModel($id, $rol){
            $stmt = Conexion::conectar()->prepare("UPDATE usuarios SET id_rol=:id_rol WHERE id_usuario=:id_usuario");
            $stmt->bindParam(":id_usuario", $id, PDO::PARAM_INT);
            $stmt->bindParam(":id_rol", $rol, PDO::PARAM_INT);
            $stmt->execute() ? $ret = true : $ret = false;
            return $ret;
        }
    
    }


?>