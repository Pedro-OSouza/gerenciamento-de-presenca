<?php

namespace Controllers;

use Core\Controller;
use Models\Turma;
use Services\Aluno_services;
use Services\Turma_services;
use Services\Aula_services;

    class TurmasController extends Controller{
        public function index() {
            
            $turma = new Turma_services;
            $turmas = $turma->listarTurmas();
            
            $data = ['turmas' => $turmas];
            
            return $this->view('turmas/turmas', $data);
        }

        public function show($id){
            $turmaService = new Turma_services();
            $alunoService = new Aluno_services();
            $aulaService = new Aula_services();

            $turma = $turmaService->buscarPorId($id);
            if(!$turma){
                header("Location: /turmas");
                exit;
            }

            

            $data = [
                'turma_id' => $id,
                'dados_turma' => $turma,
                'alunos' => $alunoService->buscarAlunosPorTurma($id),
                'todos_alunos' => $alunoService->listaPorStatus('ativo'),
                'aula_atual' => $aulaService->buscarAulaDoDia($id)
            ];

            
            return $this->view('turmas/turma_detalhes', $data);
        }
    }