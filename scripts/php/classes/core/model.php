<?php 

require_once __DIR__.'/../../config/database.php';

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

    /**
     * Transações (opcionais)
     */
    protected function beginTransaction(): bool {
        return $this->db->beginTransaction();
    }

    protected function commit(): bool {
        return $this->db->commit();
    }

    protected function rollback(): bool {
        return $this->db->rollback();
    }
}
