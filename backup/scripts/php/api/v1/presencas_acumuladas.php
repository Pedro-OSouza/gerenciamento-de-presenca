<?php
header('Content-Type: application/json');
require_once __DIR__ . "/../../services/presenca_services.php";

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $aluno_id = $_GET['aluno_id'] ?? null;

        if ($aluno_id) {
            $presenca = new Presenca_services();
            $presencas = $presenca->buscarPresencasAcumuladas($aluno_id);
            $faltas = $presenca->buscarFaltasAcumuladas($aluno_id);
            $repo_feitas = $presenca->buscarReposicoesFeitas($aluno_id);
            $repo_devidas = $presenca->bucarReposicoesDevidas($aluno_id);

            echo json_encode([
                'success' => true,
                'message' => 'Dados encontrados com sucesso',
                'data' => [
                    'presencas' => $presencas['total_presencas'] ?? 0,
                    'faltas' => $faltas['faltas'] ?? 0,
                    'reposicoes_feitas' => $repo_feitas ?? 0,
                    'reposicoes_devidas' => $repo_devidas ?? 0
                ]
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'ID de aluno não informado'
            ]);
        }
    } else {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'error' => 'Método não permitido, use GET'
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erro no servidor: ' . $e->getMessage()
    ]);
}
