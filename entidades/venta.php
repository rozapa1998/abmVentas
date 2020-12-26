<?php

    include_once "config.php";
    include_once "entidades/producto.php";

    class Venta{
        private $idventa;
        private $fecha;
        private $cantidad;
        private $preciounitario;
        private $total;
        private $fk_idcliente;
        private $fk_idproducto;
        
        public function __construct(){
            $this->preciounitario = 0.0;
            $this->cantidad = 0;
        }

        public function __get($atributo){
            return $this->$atributo;
        }

        public function __set($atributo, $valor){
            $this->$atributo = $valor;
            return $this;
        }

        public function cargarFormulario($request){
            $this->idventa = isset($request["id"])? $request["id"] : "";
            $this->fk_idcliente = isset($request["lstCliente"])? $request["lstCliente"] : "";
            $this->fk_idproducto = isset($request["lstProducto"])? $request["lstProducto"] : "";
            $this->fecha = isset($request["txtFecha"])? $request["txtFecha"] : "";
            $this->cantidad = isset($request["txtCantidad"])? $request["txtCantidad"]: "";
            $this->preciounitario = isset($request["txtPrecioUnitario"])? $request["txtPrecioUnitario"]: "";
            $this->total = isset($request["txtTotal"])? $request["txtTotal"] : "";
        }
            
        public function insertar(){
            //Instancia la clase mysqli con el constructor parametrizado
            $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
            //Arma la query
            $sql = "INSERT INTO ventas (
                        fk_idcliente,
                        fk_idproducto,
                        fecha, 
                        cantidad, 
                        preciounitario, 
                        total
                    ) VALUES (
                        '" . $this->fk_idcliente ."',
                        '" . $this->fk_idproducto ."',
                        '" . $this->fecha ."', 
                        '" . $this->cantidad ."', 
                        '" . $this->preciounitario ."', 
                        '" . $this->total ."'
                    );";
            //Ejecuta la query
            if (!$mysqli->query($sql)) {
                printf("Error en query: %s\n", $mysqli->error . " " . $sql);
            }
            //Obtiene el id generado por la inserción
            $this->idventa = $mysqli->insert_id;
            //Cierra la conexión
            $mysqli->close();
        }
    
        public function actualizar(){
    
            $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
            $sql = "UPDATE ventas SET
                        fk_idcliente = '".$this->fk_idcliente."',
                        fk_idproducto = '".$this->fk_idproducto."',
                        fecha = '".$this->fecha."',
                        cantidad = '".$this->cantidad."',
                        preciounitario = '".$this->preciounitario."',
                        total = '".$this->total."'
                    WHERE idventa = " . $this->idventa;
              
            if (!$mysqli->query($sql)) {
                printf("Error en query: %s\n", $mysqli->error . " " . $sql);
            }
            $mysqli->close();
        }
    
        public function eliminar(){
            $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
            $sql = "DELETE FROM ventas WHERE idventa = " . $this->idventa;
            //Ejecuta la query
            if (!$mysqli->query($sql)) {
                printf("Error en query: %s\n", $mysqli->error . " " . $sql);
            }
            $mysqli->close();
        }
    
        public function obtenerPorId(){
            $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
            $sql = "SELECT idventa,
                           fk_idcliente,
                           fk_idproducto, 
                           fecha, 
                           cantidad, 
                           preciounitario, 
                           total
                    FROM ventas 
                    WHERE idventa = " . $this->idventa;
            if (!$resultado = $mysqli->query($sql)) {
                printf("Error en query: %s\n", $mysqli->error . " " . $sql);
            }
    
            //Convierte el resultado en un array asociativo
            if($fila = $resultado->fetch_assoc()){
                $this->idventa = $fila["idventa"];
                $this->fk_idcliente = $fila["fk_idcliente"];
                $this->fk_idproducto = $fila["fk_idproducto"];
                $this->fecha = $fila["fecha"];
                $this->cantidad = $fila["cantidad"];
                $this->preciounitario = $fila["preciounitario"];
                $this->total = $fila["total"];
            }  
            $mysqli->close();
    
        }
    
      public function obtenerTodos(){
            $aVentas = null;
            $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
            $resultado = $mysqli->query("SELECT
                                            idventa,
                                            fk_idcliente,
                                            fk_idproducto,
                                            cantidad,
                                            fecha,
                                            preciounitario,
                                            total
                                         FROM ventas");
    
            if($resultado){
                while ($fila = $resultado->fetch_assoc()) {
                    $obj = new Venta();
                    $obj->idventa = $fila["idventa"];
                    $obj->fk_idcliente = $fila["fk_idcliente"];
                    $obj->fk_idproducto = $fila["fk_idproducto"];
                    $obj->cantidad = $fila["cantidad"];
                    $obj->fecha = $fila["fecha"];
                    $obj->preciounitario = $fila["preciounitario"];
                    $obj->total = $fila["total"];
                    $aVentas[] = $obj;
    
                }
                return $aVentas;
            }
        }
    } 

?>