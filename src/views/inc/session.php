<?php 
session_start();
if(count($_SESSION) == 0){
    header('Location: http://localhost/inventario/?view=cerrar');
}
?>