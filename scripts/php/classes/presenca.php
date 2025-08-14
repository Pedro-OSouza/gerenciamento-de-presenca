<?php
require_once __DIR__ . '/Core/Model.php';

class Presenca extends Model {
    // Método existente
    public function buscarHistorico($aluno_id) {
        $sql = "SELECT p.*, a.data, t.nome AS turma_nome
                FROM presencas p
                JOIN aulas a ON p.aula_id = a.id
                JOIN turmas t ON a.turma_id = t.id
                WHERE p.aluno_id = ?
                ORDER BY a.data DESC";
        return $this->query($sql, [$aluno_id]);
    }

    // Métodos NOVOS para cadastro rápido
    public function marcar($aluno_id, $aula_id, $turma_id, $presente) {
        $sql = "INSERT INTO presencas (aluno_id, aula_id, turma_id, presenca) 
                VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE presenca = ?";
        return $this->query($sql, [$aluno_id, $aula_id, $turma_id, $presente, $presente]);
    }

    public function contarPresencas($aluno_id) {
        $sql = "SELECT COUNT(*) AS total FROM presencas 
                WHERE aluno_id = ? AND presente = 1";
        $result = $this->query($sql, [$aluno_id], 'single');
        return $result['total'] ?? 0;
    }
}
?>