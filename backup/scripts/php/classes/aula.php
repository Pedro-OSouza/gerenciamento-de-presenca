<?php
require_once __DIR__ . '/Core/Model.php';

class Aula extends Model {

    /**
     * Cadastrar nova aula
     */
    public function cadastrar($turma_id, $data, $hora_inicio, $hora_fim) {
        return $this->transaction(function() use ($turma_id, $data, $hora_inicio, $hora_fim) {
            $sql = "INSERT INTO aulas (turma_id, data, hora_inicio, hora_fim) 
                    VALUES (?, ?, ?, ?)";
            $this->execute($sql, [$turma_id, $data, $hora_inicio, $hora_fim]);

            return $this->db->getConnection()->lastInsertId();
        });
    }

    /**
     * Buscar todas as aulas de uma turma
     */
    public function buscarAulasPorTurma($turma_id) {
        $sql = "SELECT id, data, hora_inicio, hora_fim 
                FROM aulas 
                WHERE turma_id = ? 
                ORDER BY data";
        return $this->query($sql, [$turma_id]);
    }

    /**
     * Buscar última aula de uma turma
     */
    public function buscarUltimaAula($turma_id) {
        $sql = "SELECT id, data, hora_inicio, hora_fim
                FROM aulas 
                WHERE turma_id = ? 
                ORDER BY data DESC
                LIMIT 1";
        return $this->query($sql, [$turma_id], 'single');
    }

    /**
     * Buscar aula por data
     */
    public function buscarPorData($turma_id, $data) {
        $sql = "SELECT id, data, hora_inicio, hora_fim
                FROM aulas 
                WHERE turma_id = ? AND data = ?
                LIMIT 1";
        return $this->query($sql, [$turma_id, $data], 'single');
    }

    /**
     * Buscar aula do dia atual
     */
    public function buscarAulaDoDia($turma_id) {
        return $this->buscarPorData($turma_id, date('Y-m-d'));
    }

    /**
     * Criar aula do dia (se não existir ainda)
     */
    public function criarDiaDaAula($turma_id, $hora_inicio, $hora_fim) {
        $hoje = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        $dataFormatada = $hoje->format('Y-m-d');


        // Verifica se já existe uma aula hoje
        $aulaExistente = $this->buscarPorData($turma_id, $dataFormatada);
        if ($aulaExistente) {
            return [
                'aula_id' => $aulaExistente['id'],
                'data' => $aulaExistente['data']
            ];
        }

        // Cria a nova aula
        $aulaId = $this->cadastrar($turma_id, $dataFormatada, $hora_inicio, $hora_fim);

        return ['aula_id' => $aulaId, 'data' => $dataFormatada];
    }
}
