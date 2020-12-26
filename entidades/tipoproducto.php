<?php
    include_once "config.php";

    class Tipoproducto{
        private $idtipoproducto;
        private $nombre;
                
        public function __construct(){

        }

        public function __get($atributo){
            return $this->$atributo;
        }

        public function __set($atributo, $valor){
            $this->$atributo = $valor;
            return $this;
        }

        public function cargarFormulario($request){
            $this->idtipoproducto = isset($request["id"])? $request["id"] : "";
            $this->nombre = isset($request["txtNombre"])? $request["txtNombre"] : "";
        }
    
        public function insertar(){
            //Instancia la clase mysqli con el constructor parametrizado
            $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
            //Arma la query
            $sql = "INSERT INTO tipoproductos (
                        nombre
                    ) VALUES (
                        '" . $this->nombre ."'
                    );";
            //Ejecuta la query
            if (!$mysqli->query($sql)) {
                printf("Error en query: %s\n", $mysqli->error . " " . $sql);
            }
            //Obtiene el id generado por la inserción
            $this->idtipoproducto = $mysqli->insert_id;
            //Cierra la conexión
            $mysqli->close();
        }
    
        public function actualizar(){
    
            $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
            $sql = "UPDATE tipoproductos SET
                    nombre = '".$this->nombre."'
                    WHERE idtipoproducto = " . $this->idtipoproducto;
              
            if (!$mysqli->query($sql)) {
                printf("Error en query: %s\n", $mysqli->error . " " . $sql);
            }
            $mysqli->close();
        }
    
        public function eliminar($idtipoproducto){
            $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
            $sql = "DELETE FROM tipoproductos WHERE idtipoproducto = " . $idtipoproducto;
            //Ejecuta la query
            if (!$mysqli->query($sql)) {
                printf("Error en query: %s\n", $mysqli->error . " " . $sql);
            }
            $mysqli->close();
        }
    
        public function obtenerPorId(){
            $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
            $sql = "SELECT idtipoproducto, 
                            nombre 
                    FROM tipoproductos 
                    WHERE idtipoproducto = " . $this->idtipoproducto;
            if (!$resultado = $mysqli->query($sql)) {
                printf("Error en query: %s\n", $mysqli->error . " " . $sql);
            }
    
            //Convierte el resultado en un array asociativo
            if($fila = $resultado->fetch_assoc()){
                $this->idtipoproducto = $fila["idtipoproducto"];
                $this->nombre = $fila["nombre"];
            }  
            $mysqli->close();
        }

        /*public function obtenerPorNombre($nombre){
            $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
            $sql = "SELECT idtipoproducto, 
                            nombre 
                    FROM tipoproductos 
                    WHERE nombre = '$nombre'";
            if (!$resultado = $mysqli->query($sql)) {
                printf("Error en query: %s\n", $mysqli->error . " " . $sql);
            }
    
            //Convierte el resultado en un array asociativo
            if($fila = $resultado->fetch_assoc()){
                $id = $fila["idtipoproducto"];
                return $id;
            }  
            $mysqli->close();
        }*/
    
        public function obtenerTodos(){
            $aTipoproducto = null;
            $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
            $resultado = $mysqli->query("SELECT
                                            idtipoproducto,
                                            nombre
                                        FROM tipoproductos");    
    
            if($resultado){
                while ($fila = $resultado->fetch_assoc()) {
                    $obj = new Tipoproducto();
                    $obj->idtipoproducto = $fila["idtipoproducto"];
                    $obj->nombre = $fila["nombre"];
                    $aTipoproducto[] = $obj;
                }
                return $aTipoproducto;
            }
        }
    } 

?>