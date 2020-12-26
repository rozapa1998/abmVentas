<?php
    include_once "config.php";
    include_once "entidades/tipoproducto.php";

    $pg = "Listado de tipo de productos";
    $msg = "";

    $entidadTipoproducto = new Tipoproducto();
    $aTipoproductos = $entidadTipoproducto->obtenerTodos();

    if(isset($_GET["id"]) && $_GET["id"] >= 0 && isset($_GET["do"]) && $_GET["do"] == "eliminar"){
        $entidadTipoproducto->eliminar($_GET["id"]);
        $msg = "Tipo de producto eliminado con exito!";
        /*header("Location: tipoproductos-listado.php");*/
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
                <a href="tipoproducto-formulario.php" class="btn bg-primary text-white">Nuevo</a>
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
                        <th>Acciones</th>
                    </tr>
                    <?php foreach($aTipoproductos as $tipoproducto){ ?>
                    <tr>
                        <td><?php echo mb_strtoupper($tipoproducto->nombre,"UTF-8"); ?></td>
                        <td><a href="tipoproducto-formulario.php?id=<?php echo $tipoproducto->idtipoproducto ?>"><i class="fas fa-edit"></i></a>
                            <a href="tipoproductos-listado.php?id=<?php echo $tipoproducto->idtipoproducto ?>&do=eliminar"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>  
                    <?php } ?>      
                </table>
            </div>
        </div>
    </div>

<?php include_once "footer.php"; ?>