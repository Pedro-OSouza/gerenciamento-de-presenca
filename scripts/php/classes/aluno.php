<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/core/model.php';

class Aluno extends Model {
    public function listarTodos(){
        $sql = "SELECT
                    a.id AS aluno_id,
                    a.nome AS aluno_nome,
                    t.nome AS turma_nome
                FROM alunos a
                LEFT JOIN matriculas m ON a.id = m.aluno_id
                LEFT JOIN turmas t ON m.turma_id = t.id
                WHERE a.status = 'ativo'";
        return $this->query($sql);
    }

    public function buscarPorId($id){
        $sql = "SELECT
                    a.*,
                    t.nome AS turma_nome,
                    t.id AS turma_id,
                    m.data_matricula
                FROM alunos a
                LEFT JOIN matriculas m ON a.id = m.aluno_id
                LEFT JOIN turmas t ON m.turma_id = t.id
                WHERE a.id = ?";
        return $this->query($sql, [$id], 'single');
    }

    public function buscarFaltasAcumuladas($aluno_id){
        $sql = "SELECT faltas, reposicoes_devidas, reposicoes_feitas
                FROM faltas_acumuladas
                WHERE aluno_id = ?";
        return $this->query($sql, [$aluno_id], 'single');
    }

    public function buscarPresencasAcumuladas($aluno_id){
        $sql = "SELECT IFNULL((
                    SELECT COUNT(*)
                    FROM presencas p 
                    JOIN aulas au ON p.aula_id = au.id
                    WHERE p.aluno_id = ?
                    AND p.presenca = 1
                ), 0) AS total_presencas";
        return $this->query($sql, [$aluno_id], 'single');
    }

    public function buscarHistoricoPresencas($aluno_id){
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
    public function cadastrar($nome, $email = null, $turma_id = null)
    {
        try {
            $sql = "INSERT INTO alunos (nome, email) VALUES (?, ?)";
            $this->execute($sql, [$nome, $email]);
            $alunoId = $this->db->getConnection()->lastInsertId();
            if ($alunoId && $turma_id) {
                $this->matricular($alunoId, $turma_id);
            }
        } catch (Exception $e) {
            $this->db->getConnection()->rollBack();
            throw $e;
        }
        return $alunoId;
    }

    private function matricular($alunoId, $turmaId){
        $sql = "INSERT INTO matriculas (aluno_id, turma_id) VALUES (?, ?)";
        return $this->execute($sql, [$alunoId, $turmaId]);
    }

    public function editar($nome, $email, $turma = null, $status, $alunoId){
        try {
            $this->db->getConnection()->beginTransaction();
            $sql = "UPDATE alunos 
            SET 
            nome = ?,
            email = ?,
            status = ?
            WHERE id = ?";
            $this->execute($sql, [$nome, $email, $status, $alunoId]);
            if ($turma) {
                $this->mudar_turma($alunoId, $turma);
            }
            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
        
    
    }

    public function verificarMatricula($aluno_id, $turma_id = null){
        if ($turma_id){
            $sqlVerificar = "SELECT id FROM matriculas WHERE aluno_id = ? AND turma_id = ?";
            $matriculaExistente = $this->query($sqlVerificar, [$aluno_id, $turma_id], 'single');
        } else {
            $sqlVerificar = "SELECT id FROM matriculas WHERE aluno_id = ?";
            $matriculaExistente = $this->query($sqlVerificar, [$aluno_id]);
        }
        return $matriculaExistente;
    }

    public function mudar_turma($aluno_id, $nova_turma_id) {
        try {
            $db = $this->db;
            $hasActiveTransaction = $db->inTransaction();
            if(!$hasActiveTransaction){
                $db->beginTransaction();
            }
            /* verificar se há turma */
            $verificacao = $this->verificarMatricula($aluno_id);
            /* mudar turma */
            if($verificacao){
                $sqlUpdate = "UPDATE matriculas
                        SET
                        turma_id = ?
                        WHERE aluno_id = ?";
                $this->execute($sqlUpdate, [$nova_turma_id, $aluno_id]);
            } else {
                $this->matricular($aluno_id, $nova_turma_id);
            }
            if(!$hasActiveTransaction){
                $db->commit();
            }
            return true;
            
        } catch (Exception $e) {
            if (!$hasActiveTransaction) {
                $db->rollback();
            }
            throw $e;
        }
    }

    public function matricularEmTurma($aluno_id, $turma_id){
        try {
            $this->db->getConnection()->beginTransaction();
            $verificacao = $this->verificarMatricula($aluno_id, $turma_id);
            if ($verificacao){
                throw new Exception("Aluno já matriculado nesta turma");
            }
            $this->matricular($aluno_id, $turma_id);
            $this->db->getConnection()->beginTransaction();
        } catch (Exception $e) {
            $this->db->getConnection()->rollBack();
            throw $e;
        }
        
    }
}
?>
