<?php
header('Content-Type: application/json');
require_once __DIR__ . "/../../classes/aluno.php";

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $aluno_id = $_POST['aluno_id'] ?? null;

        if ($aluno_id) {
            $aluno = new Aluno();
            $presencas = $aluno->buscarPresencasAcumuladas($aluno_id);
            $faltas = $aluno->buscarFaltasAcumuladas($aluno_id);

            $response = [
                'success' => true,
                'status' => 'success',
                'data' => [
                    'presencas' => $presencas['total_presencas'] ?? 0,
                    'faltas' => $faltas['faltas'] ?? 0,
                    'reposicoes_feitas' => $faltas['reposicoes_feitas'] ?? 0,
                    'reposicoes_devidas' => $faltas['reposicoes_devidas'] ?? 0
                ]
            ];

            echo json_encode($response);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'ID de aluno não informado'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Método não permitido'
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erro no servidor: ' . $e->getMessage()
    ]);
}
?>
