<?php


header('Content-Type: application/json');
require_once __DIR__ . '/../../services/aula_services.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input) {
            throw new InvalidArgumentException("JSON inválido ou vazio");
        }
    
        $turma_id    = $input['turma_id'] ?? null;
        $hora_inicio = $input['hora_inicio'] ?? null;
        $hora_fim    = $input['hora_fim'] ?? null;

        $service = new Aula_services();
        $resultado = $service->criarAula($turma_id, $hora_inicio, $hora_fim);

        echo json_encode([
            'success' => true,
            'message' => 'Aula criada com sucesso',
            'dados'   => $resultado
        ]);
    } else {
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Método não permitido, use POST']);
    }
} catch (InvalidArgumentException $e) {
    http_response_code(400); // erro de input
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500); // erro inesperado
    echo json_encode(['success' => false, 'error' => 'Erro no servidor: ' . $e->getMessage()]);
}
