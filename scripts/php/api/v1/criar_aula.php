<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../classes/aula.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $turma_id = $_POST['turma_id'] ?? null;
        $hora_inicio = $_POST['hora_inicio'] ?? null;
        $hora_fim = $_POST['hora_fim'] ?? null;

        if ($turma_id && $hora_inicio && $hora_fim) {
            $aula = new Aula();
            $resultado = $aula->criarDiaDaAula($turma_id, $hora_inicio, $hora_fim);

            echo json_encode([
                'success' => true,
                'dados' => $resultado
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'Dados insuficientes'
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
