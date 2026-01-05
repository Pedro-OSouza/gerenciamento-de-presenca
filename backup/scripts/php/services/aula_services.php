<?php

require_once __DIR__ . '/../classes/aula.php';
require_once __DIR__ . '/../classes/turma.php';
require_once __DIR__ . '/../helpers/validator.php';

class Aula_services {
    protected $aula;
    protected $turma;

    public function __construct() {
        $this->aula = new Aula();
        $this->turma = new Turma();
    }

    public function criarAula($turma_id, $hora_inicio, $hora_fim){
        Validador::hora($hora_inicio, $hora_fim);
        return $this->aula->criarDiaDaAula($turma_id, $hora_inicio, $hora_fim);
    }

    public function buscarAulasPorTurma($turma_id): mixed {
        Validador::id($turma_id, $this->turma, 'Turma');
        return $this->aula->buscarAulasPorTurma(turma_id: $turma_id);
    }

    public function buscarAulaDoDia($turma_id) {
        $result = $this->aula->buscarAulaDoDia($turma_id);
        /* if(!$result) {
            throw new InvalidArgumentException("Aula não encontrada");
        } */

        return $result;
    }
}

?>