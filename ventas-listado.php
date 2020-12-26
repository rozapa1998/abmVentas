<?php
    $pg = "Listado de ventas";
    $msg = "";
    include_once "entidades/venta.php";
    include_once "entidades/cliente.php";
    include_once "entidades/producto.php";

    $entidadVenta = new Venta();
    $aVentas = $entidadVenta->obtenerTodos();

    if(isset($_GET["id"]) && $_GET["id"] >= 0 && isset($_GET["do"]) && $_GET["do"] == "eliminar"){
        $entidadVenta->idventa = $_GET["id"];
        $entidadVenta->eliminar();
        $msg = "Venta eliminada con exito!";
        /*header("Location: ventas-listado.php");*/
    }

    include_once "menu.php";
?>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-2">
                <h2 class="text-dark"><?php echo $pg ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <a href="venta-formulario.php" class="btn bg-primary text-white">Nuevo</a>
                <?php 
                    if($msg != ""){ ?>
                        <div class="alert alert-success" role="alert">
                          <?php echo $msg; ?>
                        </div>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-hover border">
                    <tr>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Fecha</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach($aVentas as $venta){ ?>
                    <tr>
                        <td><?php $cliente = new Cliente();
                                  $cliente->idcliente = $venta->fk_idcliente;  
                                  $cliente->obtenerPorId();
                                  echo strtoupper($cliente->nombre); ?></td>
                        <td><?php $producto = new Producto();
                                  $producto->idproducto = $venta->fk_idproducto;  
                                  $producto->obtenerPorId();
                                  echo mb_strtoupper($producto->nombre,"UTF-8"); ?></td>
                        <td><?php echo date("d/m/Y",strtotime($venta->fecha)); ?></td>
                        <td><?php echo $venta->cantidad; ?></td>
                        <td><?php echo "$ " .number_format($venta->preciounitario,2,",","."); ?></td>
                        <td><?php echo "$ " .number_format($venta->total,2,",","."); ?></td>
                        <td><a href="venta-formulario.php?id=<?php echo $venta->idventa ?>"><i class="fas fa-edit"></i></a>
                            <a href="ventas-listado.php?id=<?php echo $venta->idventa ?>&do=eliminar"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>  
                    <?php } ?>      
                </table>
            </div>
        </div>        
    </div>

<?php include_once "footer.php"; ?>