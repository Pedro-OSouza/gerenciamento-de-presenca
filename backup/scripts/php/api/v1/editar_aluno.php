<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../services/aluno_services.php';

try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Captura dados do corpo da requisição (PUT não popula $_POST)
        $input = json_decode(file_get_contents("php://input"), true);

        $aluno_nome = $input['alunoNome'] ?? null;
        $aluno_email = $input['alunoEmail'] ?? null;
        $aluno_turma = $input['alunoTurma'] ?? null;
        $aluno_status = $input['alunoStatus'] ?? null;
        $aluno_id = $input['alunoId'] ?? null;

        if ($aluno_nome && $aluno_status && $aluno_id) {
            $aluno = new Aluno_services();
            $aluno->editar($aluno_nome, $aluno_email, $aluno_status, $aluno_turma, $aluno_id);

            echo json_encode([
                "success" => true,
                "message" => "Aluno atualizado com sucesso"
            ]);
        } else {
            http_response_code(400); // Bad Request
            echo json_encode([
                "success" => false,
                "error" => "Dados insuficientes para atualização"
            ]);
        }
    } else {
        http_response_code(405); // Method Not Allowed
        echo json_encode([
            "success" => false,
            "error" => "Método não permitido, use POST"
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erro no servidor: ' . $e->getMessage()
    ]);
}
