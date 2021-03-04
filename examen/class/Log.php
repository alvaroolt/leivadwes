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
        // public function getLogById($user_data=""){
        //     $this->query = "SELECT titulo FROM logs WHERE id=:id";
        //     $this->parametros['id']= $user_data;
        //     $this->get_results_from_query();
        //     $this->close_connection();
        //     return $this->rows;
        // }

        // PUEDE QUE ME HAGA FALTA PARA LOS VOTOS EN TEATRO
        // public function getNumRepro($user_data=""){
        //     $this->query = "SELECT numero_reproducciones FROM logs WHERE id=:id ";
        //     $this->parametros['id']= $user_data;
        //     $this->get_results_from_query();
        //     $this->close_connection();
        //     return $this->rows;
        // }
        // public function aumentarReproducciones($user_data=array()){
        //     $this->query = "UPDATE logs SET numero_reproducciones=:numero_reproducciones WHERE id=:id";
        //     $this->parametros['id']= $user_data["id"];
        //     $this->parametros['numero_reproducciones']= $user_data["numero_reproducciones"];
        //     $this->get_results_from_query();
        //     $this->close_connection();
        // }
        
        public function set($user_data = array()) {
            foreach ($user_data as $campo=>$valor) {
                $$campo = $valor;
            }
            $this->query = "INSERT INTO logs (fecha_hora, usuario, descripcion) VALUES (:fecha_hora, :usuario, :descripcion)";
            $this->parametros['fecha_hora']=date('jS \of F Y h:i:s A');
            $this->parametros['usuario']=$usuario;
            $this->parametros['descripcion']=$descripcion;
            $this->get_results_from_query();
            $this->close_connection();
            $this->mensaje = 'Clave guardada';
        }
        public function delete($id="") {
            $this->query = "DELETE FROM clavefirma WHERE id = :id";
            $this->parametros['id']=$id;
            $this->get_results_from_query();
            $this->close_connection();
            $this->mensaje = 'Clave firma eliminada';
        }
        function __construct() {
            $this->db_name = 'book_example';
        }
        function __destruct() {
            $this->conn = null;
        }
    }
?>