<?php 

    class ingresoController{

        public static function ingresarUsuarioController($datos){

            // verificar si el correo del usuario existe en la bd
            $user = ingresoModel::selectUserModel($datos['correo']);
            if($user){
                $claveBD = $user['clave'];
                if(md5($datos['clave']) == $claveBD){

                    session_start();
                    $_SESSION["id"] = $user['id_usuario'];
                    $_SESSION["rol"] = $user['id_rol'];
                    $_SESSION["nombres"] = $user['nombres'];
                    $_SESSION["paterno"] = $user['apellido_paterno'];
                    $_SESSION["materno"] = $user['apellido_materno'];
                    $_SESSION["correo"] = $user['correo'];
                    $_SESSION["clave"] = $user['clave'];

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

        public static function actualizarUsuarioController($datos){
            $user = ingresoModel::selectUserModelById(intval($datos['id_usuario']));
            if($user){
                $claveBD = $user['clave'];
                if(md5($datos['clave']) == $claveBD){

                    if(isset($datos['clave_nueva'])){
                        //actualizar con todo y clave nueva
                        $datos['clave_nueva'] = md5($datos['clave_nueva']);
                        $respuesta = ingresoModel::actualizarUsuarioModelWithPass($datos, intval($datos['id_usuario']));
                    }else{
                        //actualizar solo los datos, no la clave
                        $respuesta = ingresoModel::actualizarUsuarioModel($datos, intval($datos['id_usuario']));
                    }

                }else{
                    $respuesta = "clave_incorrecta";
                }
            }else{
                $respuesta = false;
            }
            return $respuesta;
        }

    }

?>