<?php
namespace Models;
use Core\Model;
use Exception;

class Aluno extends Model {

    public function listarTodos() {
        $sql = "SELECT a.id AS aluno_id, a.nome AS aluno_nome, t.nome AS turma_nome
                FROM alunos a
                LEFT JOIN matriculas m ON a.id = m.aluno_id
                LEFT JOIN turmas t ON m.turma_id = t.id
                WHERE a.status = 'ativo'";
        return $this->query($sql);
    }

    public function listarPorStatus($status) {
        if ($status === 'todos') {
            $sql = "SELECT a.id AS aluno_id, a.nome AS aluno_nome, t.nome AS turma_nome, a.status
                    FROM alunos a
                    LEFT JOIN matriculas m ON a.id = m.aluno_id
                    LEFT JOIN turmas t ON m.turma_id = t.id";
            return $this->query($sql);
        }

        $sql = "SELECT a.id AS aluno_id, a.nome AS aluno_nome, t.nome AS turma_nome
                FROM alunos a
                LEFT JOIN matriculas m ON a.id = m.aluno_id
                LEFT JOIN turmas t ON m.turma_id = t.id
                WHERE a.status = ?";
        return $this->query($sql, [$status]);
    }
    

    public function buscarPorId($id) {
        $sql = "SELECT a.*, t.nome AS turma_nome, t.id AS turma_id, m.data_matricula
                FROM alunos a
                LEFT JOIN matriculas m ON a.id = m.aluno_id
                LEFT JOIN turmas t ON m.turma_id = t.id
                WHERE a.id = ?";
        return $this->query($sql, [$id], 'single');
    }

    public function buscarAlunosPorTurma($turma_id)
    {
        $sql = "SELECT
        a.id AS aluno_id,
        a.nome AS aluno_nome,

        (SELECT COUNT(*) 
        FROM presencas p 
        WHERE p.aluno_id = a.id
        AND p.presenca = 1) AS total_presencas,

        (SELECT COUNT(*) 
        FROM presencas p 
        WHERE p.aluno_id = a.id
        AND p.presenca = 0) AS total_faltas

        FROM alunos a
        JOIN matriculas m ON a.id = m.aluno_id 
        WHERE m.turma_id = ?
        AND a.status = 'ativo'
        ORDER BY a.nome";

        return $this->query($sql, [$turma_id]);
    }

    /* ============================
    Cadastro / Edição / Matrícula
    ============================ */

    public function cadastrar($nome, $email = null, $turma_id = null) {
        return $this->transaction(function() use ($nome, $email, $turma_id) {
            $sql = "INSERT INTO alunos (nome, email) VALUES (?, ?)";
            $this->execute($sql, [$nome, $email]);
            $alunoId = $this->db->getConnection()->lastInsertId();

            if ($alunoId && $turma_id) {
                $this->matricular($alunoId, $turma_id);
            }

            return $alunoId;
        });
    }

    public function editar($nome, $email, $status, $turma_id = null, $alunoId) {
        return $this->transaction(function() use ($nome, $email, $status, $turma_id, $alunoId) {
            $sql = "UPDATE alunos SET nome = ?, email = ?, status = ? WHERE id = ?";
            $this->execute($sql, [$nome, $email, $status, $alunoId]);

            if ($turma_id) {
                $this->mudarTurma($alunoId, $turma_id);
            }

            return true;
        });
    }

    private function matricular($aluno_id, $turma_id) {
        $sql = "INSERT INTO matriculas (aluno_id, turma_id) VALUES (?, ?)";
        return $this->execute($sql, [$aluno_id, $turma_id]);
    }

    public function mudarTurma($aluno_id, $nova_turma_id) {
        return $this->transaction(function() use ($aluno_id, $nova_turma_id) {
            $matricula = $this->verificarMatricula($aluno_id);

            if ($matricula) {
                $sql = "UPDATE matriculas SET turma_id = ? WHERE aluno_id = ?";
                $this->execute($sql, [$nova_turma_id, $aluno_id]);
            } else {
                $this->matricular($aluno_id, $nova_turma_id);
            }

            return true;
        });
    }

    public function matricularEmTurma($aluno_id, $turma_id) {
        return $this->transaction(function() use ($aluno_id, $turma_id) {
            if ($this->verificarMatricula($aluno_id, $turma_id)) {
                throw new Exception("Aluno já matriculado nesta turma");
            }
            return $this->matricular($aluno_id, $turma_id);
        });
    }

    public function verificarMatricula($aluno_id, $turma_id = null) {
        $sql = $turma_id 
            ? "SELECT id FROM matriculas WHERE aluno_id = ? AND turma_id = ?"
            : "SELECT id FROM matriculas WHERE aluno_id = ?";
        $params = $turma_id ? [$aluno_id, $turma_id] : [$aluno_id];
        return $this->query($sql, $params, 'single');
    }

    public function listarTurmasDoAluno($aluno_id) {
        $sql = "SELECT t.id AS turma_id, t.nome AS turma_nome
        FROM matriculas m
        INNER JOIN turmas t ON m.turma_id = t.id
        WHERE m.aluno_id = ?";
        return $this->query($sql, [$aluno_id]); // Retorna todas as turmas do aluno
    }
    

    /* ============================
    Exclusão
    ============================ */

    public function deletarMatricula($aluno_id, $turma_id) {
        $sql = "DELETE FROM matriculas WHERE aluno_id = ? AND turma_id = ?";
        return $this->execute($sql, [$aluno_id, $turma_id]);
    }

    public function deletarAluno($aluno_id) {
        return $this->transaction(function() use ($aluno_id) {
            $this->deletarMatricula($aluno_id, null); // deletar todas as matrículas
            $sql = "DELETE FROM alunos WHERE id = ?";
            return $this->execute($sql, [$aluno_id]);
        });
    }
}
?>
