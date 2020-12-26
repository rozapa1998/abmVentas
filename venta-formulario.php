<?php
    include_once "entidades/venta.php";
    include_once "entidades/cliente.php";
    include_once "entidades/producto.php";

    $pg = "Edicion de venta";
    $msg = "";
    include_once "menu.php";

    $venta = new Venta();
    $venta->cargarFormulario($_REQUEST);

    $entidadCliente = new Cliente();
    $aClientes = $entidadCliente->obtenerTodos();

    $entidadProducto = new Producto();
    $aProductos = $entidadProducto->obtenerTodos();

    if($_POST){
        if(isset($_POST["btnGuardar"])){
          $producto = new Producto();
          $producto->idproducto = $venta->fk_idproducto;
          $producto->obtenerPorId();
          $venta->preciounitario = $producto->precio;
          $venta->total = $venta->preciounitario * $venta->cantidad; 
          if(isset($_GET["id"]) && $_GET["id"] > 0){
            //Actualizo un venta existente
            //antes recupero la cantidad antes ingresada, para ver actualizar el stock del producto
            $entidadVenta = new Venta();
            $entidadVenta->idventa = $_GET["id"];
            $entidadVenta->obtenerPorId();
            if($entidadVenta->cantidad > $venta->cantidad){
                //si estoy queriendo actualizar con menor cantidad
                $producto->cantidad += ($entidadVenta->cantidad - $venta->cantidad);
                $producto->actualizar(); 
            } else if($entidadVenta->cantidad < $venta->cantidad){
                //si estoy queriendo actualizar con mayor cantidad
                $producto->cantidad -= ($venta->cantidad - $entidadVenta->cantidad);
                $producto->actualizar();
            }    
            $venta->actualizar();
            $msg = "Venta actualizada con exito!";
          } else {
            //es nuevo
            $venta->insertar();
            $msg = "Venta agregada con exito!";
            //descuento stock en producto
            $producto->cantidad -= $venta->cantidad; 
            $producto->actualizar();
          }
        } else if(isset($_POST["btnBorrar"])){
          $venta->eliminar();
        }

    }

    if(isset($_GET["id"]) && $_GET["id"] >= 0){
        $venta->idventa = $_GET["id"];
        $venta->obtenerPorId();
    }

    if(isset($_GET["do"]) && $_GET["do"] == "buscarProducto"){
        $idproducto = $_GET["id"];
        $producto = new Producto();
        $producto->idproducto = $idproducto;
        $producto->obtenerPorId();
        echo json_encode($producto->precio);
        exit;
    }

?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <form class="form" method="post">
                <div class="row">
                    <div class="col-12 mb-2">
                        <h2 class="text-dark"><?php echo $pg ?></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <a href="ventas-listado.php" class="btn bg-primary text-white">Listado</a>
                        <a href="venta-formulario.php" class="btn bg-primary text-white">Nuevo</a>
                        <button class="btn bg-success text-white" type="submit" id="btnGuardar" name="btnGuardar">Guardar</button>
                        <a href="" class="btn bg-danger text-white" id="btnBorrar" name="btnBorrar">Borrar</a>
                        <?php 
                            if($msg != ""){ ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo $msg; ?>
                                </div>
                        <?php } ?>    
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="lstCliente">Cliente:</label>
                        <select class="form-control" name="lstCliente" id="lstCliente">
                            <option value="" selected disabled>Seleccionar</option>
                            <?php foreach($aClientes as $cliente){ 
                                     if(isset($_GET["id"])){
                                        $vVenta = new Venta();
                                        $vVenta->idventa = $_GET["id"];
                                        $vVenta->obtenerPorId(); 
                                        if($vVenta->fk_idcliente == $cliente->idcliente){ ?>
                                            <option value="<?php echo $cliente->idcliente ?>" <?php echo " selected" ?>><?php echo mb_strtoupper($cliente->nombre,"UTF-8") ?></option>
                                  <?php } else { ?>        
                                            <option value="<?php echo $cliente->idcliente ?>"><?php echo mb_strtoupper($cliente->nombre,"UTF-8") ?></option>
                                  <?php } ?>   
                               <?php } else { ?>
                                            <option value="<?php echo $cliente->idcliente ?>"><?php echo mb_strtoupper($cliente->nombre,"UTF-8") ?></option>  
                               <?php } ?>      
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="lstProducto">Producto:</label>
                        <select onchange="fBuscarPrecioUnitario();" class="form-control" name="lstProducto" id="lstProducto">
                            <option value="" selected disabled>Seleccionar</option>
                            <?php foreach($aProductos as $producto){ 
                                     if(isset($_GET["id"])){
                                        $vVenta = new Venta();
                                        $vVenta->idventa = $_GET["id"];
                                        $vVenta->obtenerPorId(); 
                                        if($vVenta->fk_idproducto == $producto->idproducto){ ?>
                                            <option value="<?php echo $producto->idproducto ?>" <?php echo " selected" ?>><?php echo mb_strtoupper($producto->nombre,"UTF-8") ?></option>
                                  <?php } else { ?>        
                                            <option value="<?php echo $producto->idproducto ?>"><?php echo mb_strtoupper($producto->nombre,"UTF-8") ?></option>
                                  <?php } ?>   
                               <?php } else { ?>
                                            <option value="<?php echo $producto->idproducto ?>"><?php echo mb_strtoupper($producto->nombre,"UTF-8") ?></option> 
                               <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="txtFecha">Fecha:</label>
                        <input type="date" name="txtFecha" id="txtFecha" class="form-control" value="<?php echo $venta->fecha ?>">
                    </div>
                    <div class="col-6 mb-3">
                        <label for="txtCantidad">Cantidad:</label>
                        <input type="number" name="txtCantidad" id="txtCantidad" class="form-control" value="<?php echo $venta->cantidad ?>">
                    </div>
                    <div class="col-6 mb-3">
                        <label for="txtPrecioUnitario">Precio unitario:</label>
                        <input type="number" name="txtPrecioUnitario" id="txtPrecioUnitario" class="form-control" value="<?php echo $venta->preciounitario?>">
                    </div>
                    <!--<div class="col-6 mb-3">
                        <label for="txtTotal">Total:</label>
                        <input type="number" name="txtTotal" id="txtTotal" class="form-control" value="<?php /*echo $venta->total*/ ?>">
                    </div>-->
                </div>
            </form>
            <script>
                function fBuscarPrecioUnitario(){
                    idproducto = $("#lstProducto").val();
                    $.ajax({
                        type: "GET",
                        url: "venta-formulario.php?do=buscarProducto",
                        data: { id:idproducto },
                        async: true,
                        dataType: "json",
                        success: function(respuesta){
                            $("#txtPrecioUnitario").val(respuesta);
                        }
                    });
                }
            </script>
        </div>

<?php include_once "footer.php"; ?>