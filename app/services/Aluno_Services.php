<?php
    /* require_once __DIR__ . '/../classes/aluno.php';
    require_once __DIR__ . '/../classes/turma.php'; */
    namespace Services;
    use Models\Aluno;
    use Models\Turma;
    use Helpers\Validador;
    use Exception;
    require_once __DIR__ . '/../helpers/validator.php';
    
    class Aluno_services{
        protected $aluno;
        protected $turma;
        public function __construct(){
            $this->aluno = new Aluno();
            $this->turma = new Turma();
        }

        public function listarTodos(){
            return $this->aluno->listarTodos();
        }

        public function listaPorStatus($status) {
            $statusPermitidos = ['todos', 'ativo', 'inativo', 'concluido'];

            if(!in_array($status, $statusPermitidos)){
                //throw new Exception("Status inválidos: $status");
                return [
                    'success' => false,
                    'error' => "Status inválidos: " . $status
                ];
            }

            return $this->aluno->listarPorStatus($status);
        }

        public function buscarPorId($aluno_id){
            return $this->validarIdAluno($aluno_id);
        }

        
        public function buscarAlunosPorTurma($turma_id): mixed{
            Validador::id($turma_id, $this->turma, "Turma");
            return $this->aluno->buscarAlunosPorTurma(turma_id: $turma_id);
        }

        public function validarIdAluno($aluno_id){
            return Validador::id($aluno_id, $this->aluno, "Aluno");
        }

        public function validarIdTurma($turma_id, $nullable = false) {
            if($nullable) {
                return $turma_id;
            }
            return Validador::id($turma_id, $this->turma, "Turma");
        }

        public function validarNomeAluno($nome) {
            return Validador::texto($nome, "Nome");
        }

        public function validarEmailAluno($email = null, $nullable = false) {
            return Validador::email($email, $nullable);
        }

        public function cadastrar($nome, $email = null, $turma_id = null){
            $this->validarNomeAluno($nome);
            $this->validarEmailAluno($email, true);
            $this->validarIdTurma($turma_id, true);

            return $this->aluno->cadastrar(
                $nome, $email, $turma_id);
        }

        public function editar($nome, $email = null, $status, $turma_id = null, $alunoId){
            $this->validarNomeAluno($nome);            
            $this->validarEmailAluno($email, true);            
            $this->validarIdAluno($alunoId);
            $this->validarIdTurma($turma_id, true);

            return $this->aluno->editar(
                $nome, $email, $status, $turma_id, $alunoId);
        }

        public function deletarAluno($id){
            $this->validarIdAluno($id);
            return $this->aluno->deletarAluno($id);
        }

        public function listarTurmasDoAluno($aluno_id){
            return $this->aluno->listarTurmasDoAluno($aluno_id);
        }

    }
?>