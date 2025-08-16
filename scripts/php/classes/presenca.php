<?php
require_once __DIR__ . '/Core/Model.php';

class Presenca extends Model {

    public function buscarHistorico($aluno_id) {
        $sql = "SELECT p.*, a.data, t.nome AS turma_nome
                FROM presencas p
                JOIN aulas a ON p.aula_id = a.id
                JOIN turmas t ON a.turma_id = t.id
                WHERE p.aluno_id = ?
                ORDER BY a.data DESC";
        return $this->query($sql, [$aluno_id]);
    }

    // Marca falta: presenca = 0 e atualiza faltas_acumuladas
    public function marcarFalta($aluno_id, $aula_id, $turma_id) {
        try {
            $this->beginTransaction();

            // 1️⃣ Marca na tabela presencas
            $sqlPresenca = "INSERT INTO presencas (aluno_id, aula_id, turma_id, presenca)
                            VALUES (?, ?, ?, 0)
                            ON DUPLICATE KEY UPDATE presenca = 0";
            $this->execute($sqlPresenca, [$aluno_id, $aula_id, $turma_id]);

            // 2️⃣ Atualiza faltas_acumuladas
            $sqlFaltas = "INSERT INTO faltas_acumuladas (aluno_id, turma_id, faltas)
                          VALUES (?, ?, 1)
                          ON DUPLICATE KEY UPDATE faltas = faltas + 1";
            $this->execute($sqlFaltas, [$aluno_id, $turma_id]);

            $this->commit();
            return true;
        } catch (Exception $e) {
            $this->rollback();
            error_log("Erro ao marcar falta: " . $e->getMessage());
            return false;
        }
    }

    // Marca presença normal
    public function marcarPresenca($aluno_id, $aula_id, $turma_id) {
        $sql = "INSERT INTO presencas (aluno_id, aula_id, turma_id, presenca)
                VALUES (?, ?, ?, 1)
                ON DUPLICATE KEY UPDATE presenca = 1";
        return $this->execute($sql, [$aluno_id, $aula_id, $turma_id]);
    }

    // Função central para decidir se marca presença ou falta
    public function marcar($aluno_id, $aula_id, $turma_id, $presente) {
        if ($presente) {
            return $this->marcarPresenca($aluno_id, $aula_id, $turma_id);
        } else {
            return $this->marcarFalta($aluno_id, $aula_id, $turma_id);
        }
    }

    public function contarPresencas($aluno_id) {
        $sql = "SELECT COUNT(*) AS total
                FROM presencas
                WHERE aluno_id = ? AND presenca = 1";
        $result = $this->query($sql, [$aluno_id], 'single');
        return $result['total'] ?? 0;
    }
}
?>
