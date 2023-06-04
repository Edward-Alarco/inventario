<?php 
session_start();
if(count($_SESSION) == 0){
    header('Location: http://localhost/inventario/?view=cerrar');
}

if($_SESSION['rol'] == 3):
?>
<style>
    .disabled-for-user{display:none !important;}
</style>
<?php endif;?>