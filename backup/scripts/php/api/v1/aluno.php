<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../services/aluno_services.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $id_aluno = $_GET['id'] ?? null;

        if ($id_aluno) {
            $aluno = new Aluno_services();
            $result = $aluno->buscarPorId($id_aluno);

            if ($result) {
                echo json_encode([
                    "success" => true,
                    "result" => $result
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "error" => "Aluno não encontrado"
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "error" => "Parâmetro 'id' não fornecido"
            ]);
        }
    } else {
        http_response_code(405); // Método não permitido
        echo json_encode([
            "success" => false,
            "error" => "Método não permitido, use GET"
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "Erro no servidor: " . $e->getMessage()
    ]);
}