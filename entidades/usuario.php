<?php
    include_once "config.php";

    class Usuario{
        private $idusuario;
        private $usuario;
        private $clave;
        private $nombre;
        private $apellido;
        private $correo;

        public function __construct(){

        }
    
        public function __get($atributo) {
            return $this->$atributo;
        }
    
        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
            return $this;
        }

        public function encriptarClave($clave){
            $claveEncriptada = password_hash($clave, PASSWORD_DEFAULT);
            return $claveEncriptada;
        }

        public function verificarClave($claveIngresada, $claveEnBBDD){
            return password_verify($claveIngresada, $claveEnBBDD);
        }

        public function insertar(){
            //Instancia la clase mysqli con el constructor parametrizado
            $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
            //Arma la query
            $sql = "INSERT INTO usuarios (
                        usuario, 
                        clave, 
                        nombre, 
                        apellido, 
                        correo
                    ) VALUES (
                        '" . $this->usuario ."', 
                        '" . $this->clave ."', 
                        '" . $this->nombre ."', 
                        '" . $this->apellido ."', 
                        '" . $this->correo ."'
                    );";
            //Ejecuta la query
            if (!$mysqli->query($sql)) {
                printf("Error en query: %s\n", $mysqli->error . " " . $sql);
            }
            //Obtiene el id generado por la inserción
            $this->idusuario = $mysqli->insert_id;
            //Cierra la conexión
            $mysqli->close();
        }

        public function obtenerPorUsuario(){
            $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
            $sql = "SELECT idusuario, 
                            usuario, 
                            clave, 
                            nombre, 
                            apellido, 
                            correo 
                    FROM usuarios 
                    WHERE usuario = '$this->usuario'"; 
            if (!$resultado = $mysqli->query($sql)) {
                printf("Error en query: %s\n", $mysqli->error . " " . $sql);
                $msg = "error";
                return $msg;
            }
    
            //Convierte el resultado en un array asociativo
            if($fila = $resultado->fetch_assoc()){
                $this->idusuario = $fila["idusuario"];
                $this->usuario = $fila["usuario"];
                $this->clave = $fila["clave"];
                $this->nombre = $fila["nombre"];
                $this->apellido = $fila["apellido"];
                $this->correo = $fila["correo"];
                $msg = "exito";
                return $msg;
            }  
            $mysqli->close();
        }

    }    

?>