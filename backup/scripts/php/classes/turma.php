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
                        TIME_FORMAT(hora_inicio, '%H:%i'),
                        '-',
                        TIME_FORMAT(hora_fim, '%H:%i')
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
                        TIME_FORMAT(hora_inicio, '%H:%i'),
                        '-',
                        TIME_FORMAT(hora_fim, '%H:%i')
                    ) AS hora_formatada
                FROM turmas
                ORDER BY 
                    FIELD(dia_semana, 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta'), 
                    hora_inicio";

        return $this->query($sql);
    }

    // ===============================
    // CRUD básico de Turmas
    // ===============================

    public function cadastrar($nome, $dia_semana, $hora_inicio, $hora_fim)
    {
        return $this->transaction(function () use ($nome, $dia_semana, $hora_inicio, $hora_fim) {
            $sql = "INSERT INTO turmas (nome, dia_semana, hora_inicio, hora_fim)
                    VALUES (?, ?, ?, ?)";
            $this->execute($sql, [$nome, $dia_semana, $hora_inicio, $hora_fim]);
            return $this->db->getConnection()->lastInsertId();
        });
    }

    public function editar($turma_id, $nome, $dia_semana, $hora_inicio, $hora_fim)
    {
        return $this->transaction(function () use ($turma_id, $nome, $dia_semana, $hora_inicio, $hora_fim) {
            $sql = "UPDATE turmas
                    SET nome = ?, dia_semana = ?, hora_inicio = ?, hora_fim = ?
                    WHERE id = ?";
            return $this->execute($sql, [$nome, $dia_semana, $hora_inicio, $hora_fim, $turma_id]);
        });
    }

    public function deletar($turma_id)
    {
        return $this->transaction(function () use ($turma_id) {
            $sql = "DELETE FROM turmas WHERE id = ?";
            return $this->execute($sql, [$turma_id]);
        });
    }
}
?>