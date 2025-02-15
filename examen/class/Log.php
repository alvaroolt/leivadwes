<?php
    require_once('DBAbstractModel.php');
    
    class Log extends DBAbstractModel {
        private static $instancia;

        private $id;
        private $fecha_hora;
        private $usuario;
        private $descripcion;
 
        public static function getInstancia() {
            if (!isset(self::$instancia)) {
                $miClase = __CLASS__;
                self::$instancia = new $miClase;
            }
            return self::$instancia;
        }

        public function __clone() {
            trigger_error('La clonación no es permitida.', E_USER_ERROR);
        }
        public function edit($user_data=array()) {
            
        }
        public function get($user_data=""){
            $this->query = "SELECT * FROM logs ORDER BY fecha_hora DESC";
            $this->get_results_from_query();
            $this->close_connection();
            return $this->rows;
        }
        
        public function set($user_data = array()) {
            foreach ($user_data as $campo=>$valor) {
                $$campo = $valor;
            }
            $this->query = "INSERT INTO logs (fecha_hora, usuario, descripcion) VALUES (:fecha_hora, :usuario, :descripcion)";
            $this->parametros['fecha_hora']=date('Y-m-d H:i:s');
            $this->parametros['usuario']=$user_data["usuario"];
            $this->parametros['descripcion']=$user_data["descripcion"];
            $this->get_results_from_query();
            $this->close_connection();
            $this->mensaje = 'Clave guardada';
        }
        public function delete($id="") {
            $this->query = "DELETE FROM clavefirma WHERE id = :id";
            $this->parametros['id']=$id;
            $this->get_results_from_query();
            $this->close_connection();
            $this->mensaje = 'Log eliminado';
        }
        function __construct() {
            $this->db_name = 'book_example';
        }
        function __destruct() {
            $this->conn = null;
        }
    }
?>