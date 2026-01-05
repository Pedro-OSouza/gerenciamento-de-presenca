<?php
    header('Content-Type: application/json');
    require_once __DIR__ . '/../../services/aluno_services.php';
    
    try {
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $status = $_GET['status'] ?? "todos";

            if ($status){
                $aluno = new Aluno_services();
                $result = $aluno->listaPorStatus($status);

                if($result){
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
                    "error" => "Parâmetro 'status' não fornecido"
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

?>