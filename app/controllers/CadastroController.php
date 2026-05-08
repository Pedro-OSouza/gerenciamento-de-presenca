<?php
namespace Controllers;
use Core\Controller;
use Services\Aluno_services;
use Services\Turma_services;

class CadastroController extends Controller{
    public function aluno(){
        $turma_serivce = new Turma_services();
        $lista_turmas = $turma_serivce->listarTurmas();

        return $this->view('cadastro/cadastro_aluno', ['turmas' => $lista_turmas]);
    }

    public function turma(){
        
        return $this->view(('cadastro/cadastro_turmas'));
    }

    public function aluno_post(){
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_aluno'])){
            $aluno_service = new Aluno_services();
            $data['nome'] = $_POST['nome'];
            $data['email'] = $_POST['email'];
            $data['turma_id'] = (int) ($_POST['turma_id']);

            // O método cadastrar retorna o id do aluno
            $aluno_id = $aluno_service->cadastrar($data['nome'], $data['email'], $data['turma_id']);

            $this->view('cadastro/aluno_post', ['id' => $aluno_id]);
            $this->redirect('/cadastro/aluno');
            return;
        }

    }
    public function turma_post(){
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register-turma']))
    }
}