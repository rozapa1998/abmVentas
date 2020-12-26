<?php

  include_once "config.php";
  include_once "entidades/cliente.php";

  $pg = "Edicion de cliente";

  $cliente = new Cliente();
  $cliente->cargarFormulario($_REQUEST);
  $msg = "";

  if($_POST){
    if(isset($_POST["btnGuardar"])){
      if(isset($_GET["id"]) && $_GET["id"] > 0){
        //Actualizo un cliente existente
        $cliente->actualizar();
        $msg = "Cliente actualizado con exito!";
        /*header("Location: cliente-formulario.php");*/
      } else {
        //es nuevo
        $cliente->insertar();
        $msg = "Cliente agregado con exito!";
        /*header("Location: cliente-formulario.php");*/

      }
    } else if(isset($_POST["btnBorrar"])){
      $cliente->eliminar();
    }
  }

  if(isset($_GET["id"]) && $_GET["id"] > 0){
    $cliente->idcliente = $_GET["id"];
    $cliente->obtenerPorId();
  }

  include_once "menu.php";  
?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mb-2">
                    <h2 class="text-dark"><?php echo $pg ?></h2>    
                </div>
            </div>
            <form class="form" method="POST">
              <div class="row">
                  <div class="col-12 mb-3">
                      <a href="clientes-listado.php" class="btn bg-primary text-white">Listado</a>
                      <a href="cliente-formulario.php" class="btn bg-primary text-white">Nuevo</a>
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
                          <input class="form-control" type="text" name="txtNombre" id="txtNombre" value="<?php echo $cliente->nombre ?>">    
                      </div>
                      <div class="col-6 mb-3">
                          <label for="txtCuit">CUIT</label><br>
                          <input class="form-control" type="number" name="txtCuit" id="txtCuit" value="<?php echo $cliente->cuit ?>">   
                      </div>
                      <div class="col-6 mb-3">
                          <label for="txtFechaNac">Fecha de nacimiento:</label><br>
                          <input class="form-control" type="date" name="txtFechaNac" id="txtFechaNac" value="<?php echo $cliente->fecha_nac ?>">    
                      </div>
                      <div class="col-6 mb-3">
                          <label for="txtTelefono">Telefono:</label><br>
                          <input class="form-control" type="tel" name="txtTelefono" id="txtTelefono" value="<?php echo $cliente->telefono ?>">    
                      </div>
                      <div class="col-6 mb-3">
                          <label for="txtCorreo">Correo:</label><br>
                          <input class="form-control" type="email" name="txtCorreo" id="txtCorreo" value="<?php echo $cliente->correo ?>">    
                      </div>
              </div>
            </form>
        </div>
        <!-- /.container-fluid -->

<?php include_once "footer.php"; ?>  
