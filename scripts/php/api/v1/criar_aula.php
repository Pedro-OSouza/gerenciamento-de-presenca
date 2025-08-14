<?php

    header('Content-type: application/json');
    require_once __DIR__.'/../../classes/aula.php';

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $turma_id = $_POST['turma_id'] ?? null;
        $hora_inicio = $_POST['hora_inicio'] ?? null;
        $hora_fim = $_POST['hora_fim'] ?? null;

        if($turma_id && $hora_inicio && $hora_fim){
            $aula = new Aula();
            $success = $aula->criarDiaDaAula($turma_id, $hora_inicio, $hora_fim);
            echo json_encode(['success' => true, 'dados' => $success]);
        } else {
            echo json_encode(['error' => 'Dados insuficientes']);
        }
    }

?>