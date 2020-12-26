<?php
    include_once "config.php";
    include_once "entidades/tipoproducto.php";

    $pg = "Edicion de tipo de producto";
    $msg = "";
    
    $tipoproducto = new Tipoproducto();
    $tipoproducto->cargarFormulario($_REQUEST);

    if($_POST){
        if(isset($_POST["btnGuardar"])){
        if(isset($_GET["id"]) && $_GET["id"] > 0){
            //Actualizo un tipoproducto existente
            $tipoproducto->actualizar();
            $msg = "Tipo de producto actualizado con exito!";
            /*header("Location: tipoproducto-formulario.php");*/
        } else {
            //es nuevo
            $tipoproducto->insertar();
            $msg = "Tipo de producto agregado con exito!";
            /*header("Location: tipoproducto-formulario.php");*/
        }
        } else if(isset($_POST["btnBorrar"])){
        $tipoproducto->eliminar();
        }
    }

    if(isset($_GET["id"]) && $_GET["id"] > 0){
        $tipoproducto->idtipoproducto = $_GET["id"];
        $tipoproducto->obtenerPorId();
    }

    include_once "menu.php";
?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mb-2">
                    <h2 class="text-dark"><?php echo $pg ?></h2>    
                </div>
            </div>
            <form class="form" method="post">
                <div class="row">
                    <div class="col-12 mb-3">
                        <a href="tipoproductos-listado.php" class="btn bg-primary text-white">Listado</a>
                        <a href="tipoproducto-formulario.php" class="btn bg-primary text-white">Nuevo</a>
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
                        <input class="form-control" type="text" name="txtNombre" id="txtNombre" value="<?php echo $tipoproducto->nombre ?>">    
                    </div>
                </div>
            </form>    
        </div>
        <!-- /.container-fluid -->

<?php include_once "footer.php"; ?>