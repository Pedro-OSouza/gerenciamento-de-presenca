<?php

namespace Controllers\Api;

use Core\Controller;
use Services\Presenca_services;

class PresencasAPIController extends Controller{
    public function setPresenca(){
        $idAluno = $this->request->input('idAluno');
        $idAula = $this->request->input('idAula');
        $idTurma = $this->request->input('idTurma');
        $presenca = $this->request->input('presenca');
        $tipo = $this->request->input('tipo');

        if(!$idAluno || !$idAula || !$idTurma || $presenca == null){
            $this->json([
                'success' => false,
                'error' => "Parâmetros não foram informados corretamente. Parâmetros enviados: $idAluno, $idAula, $idTurma, $presenca, $tipo"
            ], 400);
            return;
        }

        $service = new Presenca_services();
        $result = $service->marcar($idAluno, $idAula, $idTurma, $presenca, $tipo);

        return $this->json([
            'success' => true,
            'result' => $result
        ]);
    }

    public function getHistory(){
        $id = $this->request->input('id');

        if(!$id){
            $this->json([
                'success' => false,
                'error' => "Parâmetros não foram informados corretamente."
            ], 400);
            return;
        }

        $service = new Presenca_services();
        $presencas = $service->buscarPresencasAcumuladas($id);
        $faltas = $service->buscarFaltasAcumuladas($id);
        $repo_feitas = $service->buscarReposicoesFeitas($id);
        $repo_devidas = $service->bucarReposicoesDevidas($id);

        return $this->json([
            'success' => true,
            'result' => [
                'presencas' => $presencas,
                'faltas' => $faltas,
                'repo_feitas' => $repo_feitas,
                'repo_devidas' => $repo_devidas
            ]
        ]);

    }
}