<?php

namespace Controllers;

use Core\Controller;
use Services\Aluno_services;
use Services\Presenca_services;
use Services\Turma_services;

class AlunoController extends Controller{
    public function index($id){

        $aluno_service = new Aluno_services();
        $presenca_service = new Presenca_services();
        $turma_service = new Turma_services();

        $turma_lista = $turma_service->listarTurmas();
        $aluno = $aluno_service->buscarPorId($id);
        $presencas = $presenca_service->buscarHistoricoPresencas($id);
        $total_presencas = $presenca_service->buscarPresencasAcumuladas($id);
        $total_faltas = $presenca_service->buscarFaltasAcumuladas($id);
        $repo_devidas = $presenca_service->bucarReposicoesDevidas($id);
        $repo_feitas = $presenca_service->buscarReposicoesFeitas($id);

        $this->view('aluno/aluno_detalhes', [
            'turmas' => $turma_lista,
            'aluno' => $aluno,
            'presencas' => $presencas,
            'total_presencas' => $total_presencas,
            'total_faltas' => $total_faltas,
            'repo_devidas' => $repo_devidas,
            'repo_feitas' => $repo_feitas

        ]);
    }

    public function lista(){
        $aluno_service = new Aluno_services();
        $lista = $aluno_service->listarTodos();

        $this->view('aluno/lista_alunos', ['alunos' => $lista]);
    }

}