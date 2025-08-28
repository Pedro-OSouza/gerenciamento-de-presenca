<?php 
    header('Content-Type: application/json');
    require_once __DIR__.'./../../classes/aluno.php';

    try {
            if($_SERVER["REQUEST_METHOD"] === "POST"){
                $aluno_nome = $_POST['alunoNome'] ?? null;
                $aluno_email = $_POST['alunoEmail'] ?? null;
                $aluno_turma = $_POST['alunoTurma'] ?? null;
                $aluno_status = $_POST['alunoStatus'] ?? null;
                $aluno_id = $_POST['alunoId'] ?? null;
    
                if($aluno_nome && $aluno_turma && $aluno_status && $aluno_id) {
                    $aluno = new Aluno();
                    $aluno->editar($aluno_nome, $aluno_email, $aluno_turma, $aluno_status, $aluno_id);
                    echo json_encode(["success" => true]);
    
                } else {
                    echo json_encode(["success" => false, "error" => "dados insuficientes"]);
                }
            } else {
                echo json_encode(["success" => false, "error" => "método não permitido"]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Erro no servidor: ' . $e->getMessage()
            ]);
        }
?>