<?php
header('Content-Type: application/json');
require_once __DIR__ . "/../../services/presenca_services.php";

try {
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input) {
            throw new InvalidArgumentException("JSON inválido ou vazio");
        }

        $aluno_id = $input['aluno_id'] ?? null;
        $aula_id  = $input['aula_id']  ?? null;
        $turma_id = $input['turma_id'] ?? null;
        $presente = $input['presente'] ?? null;
        $tipo = $input['tipo'] ?? null;

        if ($aluno_id && $aula_id && !is_null($presente) ) {
            $presenca = new Presenca_services();
            $success = $presenca->marcar(
                $aluno_id,
                $aula_id,
                $turma_id,
                $presente ? 1 : 0,
                $tipo
            );

            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Presença registrada' : 'Falha ao registrar presença'
            ]);
        } else {
            http_response_code(400); // Bad Request
            echo json_encode([
                'success' => false,
                'error' => 'Dados incompletos'
            ]);
        }
    } else {
        http_response_code(405); // Method Not Allowed
        echo json_encode([
            'success' => false,
            'error' => 'Método não permitido, use PUT'
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erro no servidor: ' . $e->getMessage()
    ]);
}
