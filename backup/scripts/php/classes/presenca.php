<?php
require_once __DIR__ . '/Core/Model.php';

class Presenca extends Model {

    /**
     * Buscar histórico de presenças de um aluno
     */
    public function buscarHistorico($aluno_id) {
        $sql = "SELECT p.*, a.data, t.nome AS turma_nome
                FROM presencas p
                JOIN aulas a ON p.aula_id = a.id
                JOIN turmas t ON a.turma_id = t.id
                WHERE p.aluno_id = ?
                ORDER BY a.data DESC";
        return $this->query($sql, [$aluno_id]);
    }

    /**
     * Marca presença ou falta
     * $presenca = 1 para presença, 0 para falta
     */
    public function marcarPresencaOuFalta($aluno_id, $aula_id, $turma_id, int $presenca, $tipo = "normal") {
        return $this->transaction(function() use ($aluno_id, $aula_id, $turma_id, $tipo, $presenca) {
            // Marca na tabela presencas
            $sql = "INSERT INTO presencas (aluno_id, aula_id, turma_id, tipo, presenca)
                    VALUES (?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE presenca = ?";
            $this->execute($sql, [$aluno_id, $aula_id, $turma_id, $tipo, $presenca, $presenca ]);


            if($tipo === 'reposicao') {
                $sqlReposicao = 'INSERT INTO faltas_acumuladas (aluno_id, faltas, reposicoes_devidas)
                                    VALUES (?, , 1)
                                    ON DUPLICATE KEY UPDATE reposicoes_devidas = reposicoes_devidas - 1, reposicoes_feitas = reposicoes_feitas + 1';
                $this->execute($sqlReposicao, [$aluno_id]);
                return 'reposicao marcada com sucesso';
            }

            // Se for falta, atualiza faltas_acumuladas
            if ($presenca === 0) {
                $sqlFaltas = "INSERT INTO faltas_acumuladas (aluno_id, faltas, reposicoes_devidas)
                            VALUES (?, 1, 1)
                            ON DUPLICATE KEY UPDATE faltas = faltas + 1, reposicoes_devidas = reposicoes_devidas + 1";
                $this->execute($sqlFaltas, [$aluno_id, $turma_id]);
                return 'falta marcada com sucesso';
            }

            return true;
        });
    }

    /**
     * Função central para decidir se marca presença ou falta
     */
    public function marcar($aluno_id, $aula_id, $turma_id, bool $presente, $tipo) {
        return $this->marcarPresencaOuFalta($aluno_id, $aula_id, $turma_id, $presente ? 1 : 0, $tipo);
    }

    /**
     * Contar presenças de um aluno
     */
    public function contarPresencas($aluno_id) {
        $sql = "SELECT COUNT(*) AS total
                FROM presencas
                WHERE aluno_id = ? AND presenca = 1";
        $result = $this->query($sql, [$aluno_id], 'single');
        return $result['total'] ?? 0;
    }

    public function buscarFaltasAcumuladas($aluno_id) {
        $sql = "SELECT faltas, reposicoes_devidas, reposicoes_feitas
                FROM faltas_acumuladas
                WHERE aluno_id = ?";
        return $this->query($sql, [$aluno_id], 'single');
    }

    public function buscarPresencasAcumuladas($aluno_id) {
        $sql = "SELECT IFNULL((SELECT COUNT(*) 
                            FROM presencas p 
                            JOIN aulas au ON p.aula_id = au.id
                            WHERE p.aluno_id = ? AND p.presenca = 1), 0) AS total_presencas";
        $resultado = $this->query($sql, [$aluno_id], 'single');
        return (int) ($resultado['total_presencas'] ?? 0);
    }

    public function buscarHistoricoPresencas($aluno_id) {
        $sql = "SELECT p.id, p.presenca, p.tipo, a.data AS data_aula, a.hora_inicio, a.hora_fim,
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
}
?>
