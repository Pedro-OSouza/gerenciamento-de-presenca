<?php

namespace Controllers\API;

use Services\Aula_services;
use Core\Controller;

class AulaAPIController extends Controller{
    public function criarAula(){
        $id = $this->request->input('id');
        $horaInicio = $this->request->input('horaInicio');
        $horaFim = $this->request->input('horaFim');

        if(!$id && !$horaInicio && !$horaFim){
            $this->json([
                'success' => false,
                'error' => "Parâmetros não foram informados corretamente"
            ], 400);
            return;
        }

        $service = new Aula_services();
        $result = $service->criarAula($id, $horaInicio, $horaFim);

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
}