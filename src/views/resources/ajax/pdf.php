<?php
    ob_start();
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $tipo = $_POST['tipo'];
    $fecha = $_POST['fecha'];
    $posicion = $_POST['posicion'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><title><?php echo $nombre; ?></title>
</head>
<style>*{margin: 0;padding: 0;box-sizing: border-box;}body{padding:2rem;}img{width:100%;height:auto;aspect-ratio:1/1;/*margin-top:120px;*/}</style>
<body>
  <h1><?php echo $nombre; ?></h1>
  <p>Cantidad: <?php echo $cantidad; ?></p>
  <p>Tipo de Producto: <?php echo $tipo; ?></p>
  <p>Fecha: <?php echo $fecha; ?></p>
  <p>Ubigeo: <?php echo $posicion; ?></p>
</body>
</html>
<?php $html = ob_get_clean(); ?>
<?php
    
    require_once('../dompdf/autoload.inc.php');
    // // reference the Dompdf namespace
    use Dompdf\Dompdf;
    use Dompdf\Options;
    // echo $html;
    // instantiate and use the dompdf class
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->setTempDir('temp');
    
    //tamaño custom del pdf
    //$customPaper = array(0,0,720,720);
    
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->set_paper($customPaper);
    $dompdf->render();
    ob_end_clean();
    //Guardalo en una variable
    $output = $dompdf->output();
    $nombreArchivo = $nombre.'.pdf';
    $path = "../../../pdfs/".$nombreArchivo;
    if(file_put_contents( $path , $output)){
        $data = array(
            'state' => 'ok',
            'url' => $path,
            'name' => $nombreArchivo
        );
        echo json_encode($data);
    }
            
?>