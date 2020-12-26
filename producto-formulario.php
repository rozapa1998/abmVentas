<?php
    include_once "config.php";
    include_once "entidades/producto.php";
    include_once "entidades/tipoproducto.php";
  
    $pg = "Edicion de producto";
    $msg = "";
  
    $producto = new Producto();
    $producto->cargarFormulario($_REQUEST);

    $entidadTipoproducto = new Tipoproducto();
    $aTipoproducto = $entidadTipoproducto->obtenerTodos();
  
    if($_POST){
      if(isset($_POST["btnGuardar"])){
        if(isset($_GET["id"]) && $_GET["id"] > 0){
          //Actualizo un producto existente
          if($_FILES["fileImagen"]["error"] === UPLOAD_ERR_OK){
            //si subo nueva imagen, creo el nombre  
            $nombreAleatorio = date("Ymdhmsi");
            $archivo_tmp = $_FILES["fileImagen"]["tmp_name"];
            $nombreArchivo = $_FILES["fileImagen"]["name"];
            $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
            $nombreImagen = $nombreAleatorio . "." . $extension;
            move_uploaded_file($archivo_tmp, "archivos/$nombreImagen");
            //voy a buscar el nombre de la imagen anterior, para eliminarla
            $producto->idproducto = $_GET["id"];
            $producto->obtenerPorId();
            unlink("archivos/" . $producto->imagen);
            //asigno el nombre para la nueva imagen
            $producto->imagen = $nombreImagen;
            $producto->actualizar();
            $msg = "Producto actualizado con exito!";
          } else if(!isset($_FILES["fileImagen"])){
              //si no subo imagen
              $producto->actualizar();
              $msg = "Producto actualizado con exito!";
          }
          
        } else {
          //es nuevo
          if($_FILES["fileImagen"]["error"] === UPLOAD_ERR_OK){
            //si subo imagen, creo el nombre  
            $nombreAleatorio = date("Ymdhmsi");
            $archivo_tmp = $_FILES["fileImagen"]["tmp_name"];
            $nombreArchivo = $_FILES["fileImagen"]["name"];
            $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
            $nombreImagen = $nombreAleatorio . "." . $extension;
            move_uploaded_file($archivo_tmp, "archivos/$nombreImagen");
            //asigno el nombre para la imagen
            $producto->imagen = $nombreImagen;
            $producto->insertar();
            $msg = "Producto agregado con exito!";
          } else if(!isset($_FILES["fileImagen"])){
              $producto->insertar();
              $msg = "Producto agregado con exito!";
          }
          $producto->insertar();
          $msg = "Producto agregado con exito!";
          /*header("Location: producto-formulario.php");*/
        }
      } else if(isset($_POST["btnBorrar"])){
        $producto->eliminar();
      }
      /*header("Location: producto-formulario.php");*/
    }

    if(isset($_GET["id"]) && $_GET["id"] > 0){
        $producto->idproducto = $_GET["id"];
        $producto->obtenerPorId();
    }

    include_once "menu.php";
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mb-2">
                    <h2 class="text-dark">Productos</h1>    
                </div>
            </div>
            <form class="form" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 mb-3">
                        <a href="productos-listado.php" class="btn bg-primary text-white">Listado</a>
                        <a href="producto-formulario.php" class="btn bg-primary text-white">Nuevo</a>
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
                        <label for="txtNombre">Nombre:</label><br>
                        <input class="form-control" type="text" name="txtNombre" id="txtNombre" value="<?php echo $producto->nombre ?>">    
                    </div>
                    <div class="col-6 mb-3">
                        <label for="lstProducto">Tipo de producto</label><br>
                        <select class="form-control" name="lstProducto" id="lstProducto">
                            <option value="" selected disabled>Seleccionar</option>
                            <?php foreach($aTipoproducto as $tipoproducto){ 
                                     if(isset($_GET["id"])){
                                        $vProducto = new Producto();
                                        $vProducto->idproducto = $_GET["id"];
                                        $vProducto->obtenerPorId(); 
                                        if($vProducto->fk_idtipoproducto == $tipoproducto->idtipoproducto){ ?>
                                            <option value="<?php echo $tipoproducto->idtipoproducto ?>" <?php echo " selected" ?>><?php echo $tipoproducto->nombre ?></option>
                                  <?php } else { ?>        
                                            <option value="<?php echo $tipoproducto->idtipoproducto ?>"><?php echo $tipoproducto->nombre ?></option>
                                  <?php } ?>   
                               <?php } else { ?>
                                            <option value="<?php echo $tipoproducto->idtipoproducto ?>"><?php echo $tipoproducto->nombre ?></option>
                                  <?php } ?> 
                            <?php } ?>
                        </select>    
                    </div>
                    <div class="col-6 mb-3">
                        <label for="txtCantidad">Cantidad:</label><br>
                        <input class="form-control" type="text" name="txtCantidad" id="txtCantidad" value="<?php echo $producto->cantidad ?>">    
                    </div>
                    <div class="col-6 mb-3">
                        <label for="txtPrecio">Precio:</label><br>
                        <input class="form-control" type="text" name="txtPrecio" id="txtPrecio" value="<?php echo $producto->precio ?>">    
                    </div>
                    <div class="col-6 mb-3">
                        <label for="fileImagen">Imagen:</label><br>
                        <input class="form-control" type="file" name="fileImagen" id="fileImagen" value="<?php echo $producto->imagen ?>">    
                    </div>
                    <div class="col-12 mb-3">
                        <label for="txtDescripcion">Descripcion:</label><br>
                        <input class="form-control" type="text" name="txtDescripcion" id="txtDescripcion" value="<?php echo $producto->descripcion ?>">    
                    </div>
                </div>
            </form>
        </div>
        <!-- /.container-fluid -->

<?php include_once "footer.php"; ?>