<?php

use function PHPSTORM_META\type;

class Database {
    private static $instance = null;
    private $conn;

    private function __construct(){
        $this->conn = new mysqli(
            hostname: 'localhost',
            username: 'root',
            password: '',
            database: 'inforescola'
        );

        if($this->conn->connect_error){
            die("Erro de conexão".$this->conn->connect_error);
        };
    }

    public static function getInstance() {
        if(!self::$instance){
            self::$instance = new Database();
        };

        return self::$instance;
    }

    public function getConnection(): mysqli {
        return $this->conn;
    }

    public function executeQuery($sql, $params = [], $returnType = 'all') {
        try {
            $stmt = $this->conn->prepare($sql);

            if(!$stmt){
                throw new Exception("Prepare failed:".$this->conn->error);
            };

            if (!empty($params)){
                $types = '';
                $values = [];

                foreach($params as $param){
                    if(is_int($param)){
                        $types .= 'i';
                    } elseif (is_double($param)){
                        $types .= 'd';
                    } else {
                        $types .= 's';
                    }
                    $values[] = $param;
                };

                $stmt->bind_param($types, ...$values);
            };

            if (!$stmt->execute()){
                throw new Exception('Execute failed:'.$stmt->error);
            }

            $result = $stmt->get_result();

            if($returnType === 'single'){
                return $result ? $result->fetch_assoc() : null;
            }

            $data = [];

            if($result){
                while($row = $result->fetch_assoc()){
                    $data[] = $row;
                }

                return $data;
            }
        } catch (Exception $e) {
            error_log("[DB Error] ".$e->getMessage(). "\nQuery: ".$sql);
            return ($returnType === 'single') ? null : [];
        }
    }
}
?>