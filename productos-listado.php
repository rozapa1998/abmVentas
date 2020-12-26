<?php
    include_once "config.php";
    include_once "entidades/producto.php";

    $pg = "Listado de productos";
    $msg = "";

    $entidadProducto = new Producto();
    $aProductos = $entidadProducto->obtenerTodos();

    if(isset($_GET["id"]) && $_GET["id"] >= 0 && isset($_GET["do"]) && $_GET["do"] == "eliminar"){
        $vProducto = new Producto();
        $vProducto->idproducto = $_GET["id"];
        $vProducto->obtenerPorId();
        unlink("archivos/" . $vProducto->imagen);
        $vProducto->eliminar($_GET["id"]);
        $msg = "Producto eliminado con exito!";
        /*header("Location: productos-listado.php");*/
    }

    include_once "menu.php";
?>
        <!-- Begin Page Content -->
        <div class="container-fluid ">
            <div class="row">
                <div class="col-12 mb-2">
                    <h2 class="text-dark"><?php echo $pg ?></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <a href="producto-formulario.php" class="btn bg-primary text-white">Nuevo</a>
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
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Descripcion</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                        <?php foreach($aProductos as $producto){ ?>
                        <tr>
                            <td><?php echo strtoupper($producto->nombre); ?></td>
                            <td><?php echo $producto->cantidad; ?></td>
                            <td><?php echo "$ " .number_format($producto->precio,2,",","."); ?></td>
                            <td><?php echo strtoupper($producto->descripcion); ?></td>
                            <td><img class="img-fluid img-thumbnail border shadow" src="archivos/<?php echo $producto->imagen?>" style="width=100%;height:50px"></td>
                            <td><a href="producto-formulario.php?id=<?php echo $producto->idproducto ?>"><i class="fas fa-edit"></i></a>
                                <a href="productos-listado.php?id=<?php echo $producto->idproducto ?>&do=eliminar"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>  
                        <?php } ?>      
                    </table>
                </div>
            </div>
        </div>

<?php include_once "footer.php"; ?>