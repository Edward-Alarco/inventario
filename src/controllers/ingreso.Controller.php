<?php 

    class ingresoController{

        public static function ingresarUsuarioController($datos){

            // verificar si el correo del usuario existe en la bd
            $user = ingresoModel::selectUserModel($datos['correo']);
            if($user){
                $claveBD = $user['clave'];
                if(md5($datos['clave']) == $claveBD){

                    session_start();
                    $_SESSION["nombres"] = $user['nombres'];
                    $_SESSION["correo"] = $user['correo'];
                    $_SESSION["rol"] = $user['id_rol'];
                    $_SESSION["id"] = $user['id_usuario'];

                    $respuesta = true;

                }else{
                    $respuesta = "clave_incorrecta";
                }
            }else{
                $respuesta = false;
            }
            return $respuesta;

        }

        public static function registrarUsuarioController($datos){
            $datos['id_rol'] = 3;
            $datos['clave'] = md5($datos['clave']);

            // validar si el usuario existe
            $validar = ingresoModel::selectUserModel($datos['correo']);
            if($validar){
                $respuesta = false;
            }else{
                $user = ingresoModel::registrarUsuarioModel($datos['id_rol'], $datos['nombres'], $datos['apellido_paterno'], $datos['apellido_materno'], $datos['correo'], $datos['clave']);
                $respuesta = true;
            }

            return $respuesta;
        }

    }

?>