<?php 

require_once 'views/inc/header.php';
require_once 'views/inc/sidebar.php';


if(isset($_GET['view'])){
    $view = $_GET['view'];
    require 'src/views/'.$view.'.php';
}else{
    require 'src/views/home.php';
}


require_once 'views/inc/footer.php';

?>