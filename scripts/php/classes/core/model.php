<?php 

    require_once __DIR__.'/../../config/database.php';
    abstract class Model {
        protected $db;
    
        public function __construct() {
            $this->db = Database::getInstance();
        }
    
        protected function query($sql, $params = [], $returnType = 'all') {
            return $this->db->executeQuery($sql, $params, $returnType);
        }
    }
?>