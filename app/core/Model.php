<?php 

namespace Core;
use Config\Database;
use Exception;

require_once __DIR__.'/../config/Database.php';

abstract class Model {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * query - para SELECTs
     * $returnType = 'all' | 'single'
     */
    protected function query(string $sql, array $params = [], string $returnType = 'all') {
        return $this->db->executeQuery($sql, $params, $returnType);
    }

    /**
     * execute - para INSERT, UPDATE, DELETE
     * Retorna true/false
     */
    protected function execute(string $sql, array $params = []): bool {
        return $this->db->executeNonQuery($sql, $params);
    }
    
    protected function transaction(callable $fn) {
        $conn = $this->db->getConnection();
        $started = false;

        if (!$this->db->inTransaction()) {
            $conn->beginTransaction();
            $started = true;
        }

        try {
            $result = $fn();
            if ($started) $conn->commit();
            return $result;
        } catch (Exception $e) {
            if ($started) $conn->rollBack();
            throw $e;
        }
    }
}
