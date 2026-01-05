<?php
namespace Services;
use Models\Presenca;
use InvalidArgumentException;

class Presenca_services{
    protected $presencaClass;

    public function __construct() {
        $this->presencaClass = new Presenca();
    }

    public function marcar($aluno_id, $aula_id, $turma_id, $presente, $tipo = 'normal'){
        if(!$aluno_id || !$turma_id || !$aula_id){
            throw new InvalidArgumentException("Informe aluno_id, turma_id, aula_id e presença");
        }

        if($presente != 0 && $presente != 1){
            throw new InvalidArgumentException("informe a presença corretamente");
        }

        return $this->presencaClass->marcar(
            $aluno_id,
            $aula_id,
            $turma_id,
            $presente ? 1 : 0,
            $tipo
        );
    }

    public function buscarPresencasAcumuladas($aluno_id){
        if (!$aluno_id) {
            throw new InvalidArgumentException("Informe o aluno id");
        }
        
        return $this->presencaClass->buscarPresencasAcumuladas($aluno_id);
    }

    public function buscarFaltasAcumuladas($aluno_id){
        if (!$aluno_id) {
            throw new InvalidArgumentException("Informe o aluno id");
        }
        $faltas = $this->presencaClass->buscarFaltasAcumuladas($aluno_id);
        return $faltas['faltas'] ?? 0;
    }

    public function buscarReposicoesFeitas($aluno_id) {
        if (!$aluno_id) {
            throw new InvalidArgumentException("Informe o aluno id");
        }
        $reposicoes_feitas = $this->presencaClass->buscarFaltasAcumuladas($aluno_id);
        return $reposicoes_feitas['reposicoes_feitas'] ?? 0;
    }

    public function bucarReposicoesDevidas($aluno_id){
        if (!$aluno_id) {
            throw new InvalidArgumentException("Informe o aluno id");
        }
        $reposicoes_devidas = $this->presencaClass->buscarFaltasAcumuladas($aluno_id);
        return $reposicoes_devidas['reposicoes_devidas'] ?? 0;
    }

    public function buscarHistoricoPresencas($aluno_id){
        if (!$aluno_id) {
            throw new InvalidArgumentException("Informe o aluno id");
        }

        return $this->presencaClass->buscarHistoricoPresencas($aluno_id);
    }

    public function totalFaltas($aluno_id){
        if (!$aluno_id) {
            throw new InvalidArgumentException("Informe o aluno id");
        }
        
    }
}

?>