<?php
header('Content-Type: application/json');
require_once __DIR__ . "/../../classes/presenca.php";

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $aluno_id = $_POST['aluno_id'] ?? null;
        $aula_id = $_POST['aula_id'] ?? null;
        $turma_id = $_POST['turma_id'] ?? null;
        $presente = $_POST['presente'] ?? null;

        if ($aluno_id && $aula_id && $presente !== null) {
            $presenca = new Presenca();
            $success = $presenca->marcar($aluno_id, $aula_id, $turma_id, $presente ? 1 : 0);

            echo json_encode([
                'success' => $success,
                'status' => $success ? 'success' : 'fail'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'Dados incompletos'
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
