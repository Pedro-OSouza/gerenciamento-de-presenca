<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/core/model.php';

class Aluno extends Model
{

    public function listarTodos()
    {
        $sql = "SELECT
                    a.id AS aluno_id,
                    a.nome AS aluno_nome,
                    t.nome AS turma_nome
                    FROM alunos a
                    LEFT JOIN matriculas m ON a.id = m.aluno_id
                    LEFT JOIN turmas t ON m.turma_id = t.id
                    WHERE a.ativo = 1";

        return $this->query($sql);
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT
                a.*,
                t.nome AS turma_nome,
                m.data_matricula
                FROM alunos a
                LEFT JOIN matriculas m ON a.id = m.aluno_id
                LEFT JOIN turmas t ON m.turma_id = t.id
                WHERE a.id = ?";

        return $this->query($sql, [$id], 'single');
    }

    public function buscarFaltasAcumuladas($aluno_id)
    {
        $sql = "SELECT faltas, reposicoes_devidas, reposicoes_feitas
                FROM faltas_acumuladas
                WHERE aluno_id = ?";

        return $this->query($sql, [$aluno_id], 'single');
    }

    public function buscarHistoricoPresencas($aluno_id)
    {
        $sql = "SELECT 
                p.id,
                p.presenca,
                p.tipo,
                a.data AS data_aula,
                a.hora_inicio,
                a.hora_fim,
                t.nome AS turma_nome,
                CASE 
                    WHEN p.tipo = 'reposicao' THEN 'Reposição'
                    WHEN p.presenca = 1 THEN 'Presente'
                    ELSE 'Falta'
                END AS status
                FROM presencas p
                JOIN aulas a ON p.aula_id = a.id
                JOIN turmas t ON p.turma_id = t.id
                WHERE p.aluno_id = ?
                ORDER BY a.data DESC, a.hora_inicio DESC";

        return $this->query($sql, [$aluno_id]);
    }

    // Métodos NOVOS para cadastro rápido
    /* Todo:
    Assim que o método de inserção rápida e massiva for desnecessário, 
    a permanência dos métodos cadastrar e matricular deve ser reavaliada.
    para entendermos se será necessário remover os métodos, modificar ou apenas usa-los como já estão */
    public function cadastrar($nome, $email = null, $turma_id = null)
    {
        $sql = "INSERT INTO alunos (nome, email) VALUES (?, ?)";
        $this->query($sql, [$nome, $email]);

        $alunoId = $this->db->getConnection()->insert_id;

        if ($alunoId && $turma_id) {
            $this->matricular($alunoId, $turma_id);
        }

        return $alunoId;
    }

    private function matricular($alunoId, $turmaId)
    {
        $sql = "INSERT INTO matriculas (aluno_id, turma_id) VALUES (?, ?)";
        return $this->query($sql, [$alunoId, $turmaId]);
    }
}
?>