<?php
require_once __DIR__ . '/Core/Model.php';

class Aula extends Model {
    // Métodos para cadastro rápido
    public function cadastrar($turma_id, $data, $hora_inicio, $hora_fim) {
        $sql = "INSERT INTO aulas (turma_id, data, hora_inicio, hora_fim) 
                VALUES (?, ?, ?, ?)";
        return $this->query($sql, [$turma_id, $data, $hora_inicio, $hora_fim]);
    }

    public function buscarPorTurma($turma_id) {
        $sql = "SELECT id, data FROM aulas 
                WHERE turma_id = ? 
                ORDER BY data";
        return $this->query($sql, [$turma_id]);
    }

    public function aulaExistente($turma_id, $data){
        $sql = "SELECT id, data FROM aulas WHERE turma_id = ? AND data = ?";
        return $aulaExistente = $this->query($sql, [$turma_id, $data], 'single');
    }

    public function criarDiaDaAula($turma_id, $hora_inicio, $hora_fim){
        $hoje = date('Y-m-d');

        $id = $this->db->getConnection()->insert_id;

        $aulaExistente = $this->aulaExistente($turma_id, $hoje);
        if($aulaExistente) {
            return ['aula_id' => $id, 'data' => $aulaExistente['data']];
        }
        
        $horario_inicio = $hora_inicio;
        $horario_fim = $hora_fim;

        $this->cadastrar($turma_id, $hoje, $horario_inicio, $horario_fim);
        

        return ['aula_id' => $id, 'data' => $hoje, ];

    }

    
}
?>