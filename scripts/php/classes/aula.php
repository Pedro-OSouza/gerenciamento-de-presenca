<?php
require_once __DIR__ . '/Core/Model.php';

class Aula extends Model {

    // Métodos para cadastro modular
    public function cadastrar($turma_id, $data, $hora_inicio, $hora_fim)
    {
        $sql = "INSERT INTO aulas (turma_id, data, hora_inicio, hora_fim) 
                VALUES (?, ?, ?, ?)";
        $this->execute($sql, [$turma_id, $data, $hora_inicio, $hora_fim]);

        return $this->db->getConnection()->lastInsertId();
    }

    public function buscarPorTurma($turma_id)
    {
        $sql = "SELECT id, data FROM aulas 
                WHERE turma_id = ? 
                ORDER BY data";
        return $this->query($sql, [$turma_id]);
    }

    public function buscarUltimaAula($turma_id) {
        $sql = "SELECT id, data 
                FROM aulas 
                WHERE turma_id = ? 
                ORDER BY data DESC
                LIMIT 1";
        return $this->query($sql, [$turma_id], 'single');
    }

    // 2️⃣ Buscar a aula do dia exato
    public function buscarAulaDoDia($turma_id) {
        $hoje = date('Y-m-d');
        $sql = "SELECT id, data 
                FROM aulas 
                WHERE turma_id = ? 
                AND data = ?
                LIMIT 1";
        return $this->query($sql, [$turma_id, $hoje], 'single');
    }
    public function aulaExistente($turma_id, $data)
    {
        $sql = "SELECT id, data FROM aulas WHERE turma_id = ? AND data = ?";
        return $this->query($sql, [$turma_id, $data], 'single');
    }

    /* Usado para criar uma nova aula no exato dia em que for acessado */
    public function criarDiaDaAula($turma_id, $hora_inicio, $hora_fim)
    {
        $hoje = date('Y-m-d');

        // Verifica se já existe uma aula hoje
        $aulaExistente = $this->aulaExistente($turma_id, $hoje);
        if ($aulaExistente) {
            return ['aula_id' => $aulaExistente['id'], 'data' => $aulaExistente['data']];
        }

        // Cria a nova aula
        $aulaId = $this->cadastrar($turma_id, $hoje, $hora_inicio, $hora_fim);

        return ['aula_id' => $aulaId, 'data' => $hoje];
    }
}
?>
