<?php

    header('Content-type: application/json');
    require_once __DIR__."/../../classes/presenca.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $aluno_id = $_POST['aluno_id'] ?? null;
        $aula_id = $_POST['aula_id'] ?? null;
        $turma_id = $_POST['turma_id'] ?? null;
        $presente = $_POST['presente'] ?? null;


        if($aluno_id && $aula_id && $presente !== null) {
            $presenca = new Presenca();
            $success = $presenca->marcar($aluno_id, $aula_id, $turma_id, $presente);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['error' => 'Dados incompletos']);
        }
    }

?>