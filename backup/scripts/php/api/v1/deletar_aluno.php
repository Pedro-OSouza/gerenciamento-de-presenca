<?php
    header('Content-Type: application/json');
    require_once __DIR__ . '/../../services/aluno_services.php';

    try {
        if($_SERVER['REQUEST_METHOD'] === "DELETE"){
            $aluno_id = $_GET['id'] ?? null;

            if ($aluno_id){
                $aluno = new Aluno_services();
                $aluno->deletarAluno($aluno_id);
                http_response_code(200);
                echo json_encode(['success' => true]);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID do aluno não fornecido']); 
            }
        } else {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Método não permitido, use DELETE']);
        }

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Erro no servidor: ' . $e->getMessage()
        ]);
    }
?>