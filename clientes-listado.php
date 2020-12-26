<?php
    include_once "config.php";
    include_once "entidades/cliente.php";

    $pg = "Listado de clientes";
    $msg = "";
    
    $entidadCliente = new Cliente();
    $aClientes = $entidadCliente->obtenerTodos();

    if(isset($_GET["id"]) && $_GET["id"] >= 0 && isset($_GET["do"]) && $_GET["do"] == "eliminar"){
        $entidadCliente->eliminar($_GET["id"]);
        $msg = "Cliente eliminado con exito!";
        /*header("Location: clientes-listado.php");*/
    }

    include_once "menu.php";
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-2">
                <h2 class="text-dark"><?php echo $pg ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <a href="cliente-formulario.php" class="btn bg-primary text-white">Nuevo</a>
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
                        <th>CUIT</th>
                        <th>Nombre</th>
                        <th>Fecha nac.</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach($aClientes as $cliente){ ?>
                    <tr>
                        <td><?php echo $cliente->cuit; ?></td>
                        <td><?php echo strtoupper($cliente->nombre); ?></td>
                        <td><?php echo date("d/m/Y",strtotime($cliente->fecha_nac)); ?></td>
                        <td><?php echo $cliente->telefono; ?></td>
                        <td><?php echo strtoupper($cliente->correo); ?></td>
                        <td><a href="cliente-formulario.php?id=<?php echo $cliente->idcliente ?>"><i class="fas fa-edit"></i></a>
                            <a href="clientes-listado.php?id=<?php echo $cliente->idcliente ?>&do=eliminar"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>  
                    <?php } ?>      
                </table>
            </div>
        </div>
        
    </div>
      
<?php include_once "footer.php"; ?>