<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../services/aluno_services.php'; 

if (isset($_GET['aluno_id'])) {
    $aluno_id = intval($_GET['aluno_id']);
    $service = new Aluno_services(); // instancie seu service
    $turmas = $service->listarTurmasDoAluno($aluno_id);

    echo json_encode($turmas);
    exit;
}

echo json_encode([]);
