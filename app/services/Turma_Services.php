<?php
    namespace Services;
    use Models\Turma;
    use Models\Aula;
    use Helpers\Validador;

    class Turma_services{
        protected $turma;
        protected $aula;

        public function __construct(){
            $this->turma = new Turma();
            $this->aula = new Aula();
        }

        public function buscarPorId($id): mixed {
            return $this->validarIdTurma(id: $id);
        }

        public function validarIdTurma($id): mixed {
            return Validador::id(id: $id,  repo: $this->turma, entidade: "Turma" );
        }

        public function listarTurmas(): mixed{
            return $this->turma->listarTurmas();
        }

        public function validarDiaSemana($dia_semana){
            return Validador::diaSemana($dia_semana);
        }

        public function validarHora($hora_inicio, $hora_fim) {
            return validarHora_helper($hora_inicio, $hora_fim);
        }

        public function validarNome($nome){
            return validarTexto_helper($nome);
        }
        public function cadastrar($nome, $dia_semana, $hora_inicio, $hora_fim) {
            $this->validarNome($nome);
            $this->validarDiaSemana($dia_semana);
            $this->validarHora($hora_inicio, $hora_fim);

            return $this->turma->cadastrar($nome, $dia_semana, $hora_inicio, $hora_fim);
        }

        public function editar($turma_id, $nome, $dia_semana, $hora_inicio, $hora_fim){
            $this->validarIdTurma($turma_id);
            $this->validarNome($nome);
            $this->validarDiaSemana($dia_semana);
            $this->validarHora($hora_inicio, $hora_fim);

            return $this->turma->editar($turma_id, $nome, $dia_semana, $hora_inicio, $hora_fim);
        }

        public function deletar($turma_id){
            $this->validarIdTurma($turma_id);

            return $this->turma->deletar($turma_id);
        }
    }

?>