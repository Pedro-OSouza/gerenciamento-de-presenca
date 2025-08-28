<?php
class Database {
    private static ?Database $instance = null;
    private PDO $pdo;
    private bool $throwOnError = false;

    private function __construct() {
        $dsn = "mysql:host=localhost;dbname=inforescola;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,       // Exceptions em caso de erro
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Fetch padrão associativo
            PDO::ATTR_EMULATE_PREPARES => false,              // Usa prepared statements nativos
        ];

        try {
            $this->pdo = new PDO($dsn, 'root', '', $options);
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }

    public function setThrowOnError(bool $v): void {
        $this->throwOnError = $v;
    }

    // Transações
    public function beginTransaction(): bool {
        return $this->pdo->beginTransaction();
    }

    public function commit(): bool {
        return $this->pdo->commit();
    }

    public function rollback(): bool {
        return $this->pdo->rollBack();
    }

    public function inTransaction(): bool{
        return $this->pdo->inTransaction();
    }

    /**
     * Execute query para SELECT
     * $returnType = 'all' (array) ou 'single' (linha única)
     */
    public function executeQuery(string $sql, array $params = [], string $returnType = 'all') {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            if (stripos(trim($sql), 'select') === 0) {
                if ($returnType === 'single') {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    return $row !== false ? $row : null;
                }
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            // Para inserts/updates/deletes, mantém compatibilidade
            return [];
        } catch (PDOException $e) {
            $this->handleError($e, $sql, $params);
            return ($returnType === 'single') ? null : [];
        }
    }

    /**
     * Execute NonQuery: INSERT, UPDATE, DELETE
     */
    public function executeNonQuery(string $sql, array $params = []): bool {
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            $this->handleError($e, $sql, $params);
            return false;
        }
    }

    private function handleError(PDOException $e, string $sql = '', array $params = []): void {
        $log = "[DB Error] " . $e->getMessage() . " | SQL: {$sql} | PARAMS: " . json_encode($params);
        error_log($log);
        if ($this->throwOnError) {
            throw $e;
        }
    }
}

?>