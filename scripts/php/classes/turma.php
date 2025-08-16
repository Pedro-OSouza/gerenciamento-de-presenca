<?php
require_once __DIR__ . '/core/model.php';

class Turma extends Model
{
    public function buscarPorId($turma_id)
    {
        $sql = "SELECT
                    id, 
                    nome, 
                    dia_semana,
                    hora_inicio,
                    hora_fim,
                    CONCAT(
                        DATE_FORMAT(hora_inicio, '%H:%i'),
                        '-',
                        DATE_FORMAT(hora_fim, '%H:%i')
                    ) AS hora_formatada
                FROM turmas
                WHERE id = ?";

        return $this->query($sql, [$turma_id], 'single');
    }

    public function listarTurmas()
    {
        $sql = "SELECT
                    id, 
                    nome,
                    dia_semana,
                    hora_inicio,
                    hora_fim,
                    CONCAT(
                        DATE_FORMAT(hora_inicio, '%H:%i'),
                        '-',
                        DATE_FORMAT(hora_fim, '%H:%i')
                    ) AS hora_formatada
                FROM turmas
                ORDER BY 
                    FIELD(dia_semana, 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta'), hora_inicio";

        return $this->query($sql);
    }

    public function buscarAlunosPorTurma($turma_id)
    {
        $sql = "SELECT
                    a.id AS aluno_id,
                    a.nome AS aluno_nome,
                    IFNULL((
                        SELECT COUNT(*)
                        FROM presencas p 
                        JOIN aulas au ON p.aula_id = au.id
                        WHERE p.aluno_id = a.id
                        AND au.turma_id = ? 
                        AND p.presenca = 1
                    ), 0) AS total_presencas,
                    IFNULL((
                        SELECT COUNT(*)
                        FROM presencas p 
                        JOIN aulas au ON p.aula_id = au.id
                        WHERE p.aluno_id = a.id 
                        AND au.turma_id = ?
                        AND p.presenca = 0
                    ), 0) AS total_faltas
                FROM alunos a
                JOIN matriculas m ON a.id = m.aluno_id 
                WHERE m.turma_id = ?
                AND a.ativo = 1
                ORDER BY a.nome";

        return $this->query($sql, [$turma_id, $turma_id, $turma_id]);
    }

    // Método para buscar todas as aulas de uma turma
    public function buscarAulas($turmaId)
    {
        $sql = "SELECT id, data, 
                    TIME_FORMAT(hora_inicio, '%H:%i') AS hora_inicio,
                    TIME_FORMAT(hora_fim, '%H:%i') AS hora_fim
                FROM aulas 
                WHERE turma_id = ? 
                ORDER BY data";

        return $this->query($sql, [$turmaId]);
    }
}
?>