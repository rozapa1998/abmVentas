<?php 
  $pg = "Inicio";
  include_once "menu.php"; 
?>
  <!-- Begin Page Content -->
  <div class="container-fluid">
    
  </div>
  <!-- /.container-fluid -->
<?php include_once "footer.php"; ?>
      


$venta = new Venta();
$facturacionMensual = $venta->obtenerFacturacionMensual(date('m'));
$facturacionAnual = $venta->obtenerFacturacionAnual(date('Y'));
