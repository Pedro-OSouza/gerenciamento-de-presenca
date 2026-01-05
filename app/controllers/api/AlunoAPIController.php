<?php

namespace Controllers\API;

use Services\Aluno_services;
use Core\Controller;
use Core\Request;
use Core\Response;

class AlunoAPIController extends Controller{

    public function getAluno(){
        $id = $this->request->input('id');

        if(!$id){
            $this->json([
                'success' => false,
                'error' => "Parâmetro id não informado"
            ], 400);
            return;
        }

        $service = new Aluno_services();
        $result = $service->buscarPorId($id);

        if (!$result) {
            return $this->json([
                "success" => false,
                "error" => "Aluno não encontrado"
            ], 404);
        }

        return $this->json([
            'success' => true,
            'result' => $result
        ]);
    }

    public function editAluno(){
        $id = $this->request->input('id');
        $nome = trim($this->request->input('nome'));
        $email = trim($this->request->input('email'));
        $turma = trim($this->request->input('turma'));
        $status = trim($this->request->input('status'));

        if(!$nome && !$status && !$id){
            $this->json([
                'success' => false,
                'error' => "Parâmetros não foram informados corretamente"
            ], 400);
            return;
        }
        
        $service = new Aluno_services();
        $result = $service->editar($nome, $email, $status, $turma, $id);

        if (!$result) {
            return $this->json([
                "success" => false,
                "error" => "Não foi possível editar o alunos"
            ], 404);
        }

        return $this->json([
            'success' => true,
            'result' => $result
        ]);
    }

    public function filterByStatus() {
        $status = $this->request->input('status');
        $status = trim($status);

        if(!$status){
            $this->json([
                'success' => false,
                'error' => "Parâmetro id não informado"
            ], 400);
            return;
        }

        $service = new Aluno_services();
        $result = $service->listaPorStatus($status);

        return $this->json([
            'success' => true,
            'result' => $result
        ]);
    }

    public function deleteAluno() {
        $id = $this->request->input('id');
        
        if(!$id){
            $this->json([
                'success' => false,
                'error' => "Parâmetro id não informado"
            ], 400);
            return;
        }

        $service = new Aluno_services();
        $result = $service->deletarAluno($id);

        return $this->json([
            'success' => true,
            'result' => $result
        ]);
    }
    
}