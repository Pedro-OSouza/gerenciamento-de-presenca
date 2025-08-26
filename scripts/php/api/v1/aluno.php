<?php
    header('Content-Type: application/json');
    require_once __DIR__.'./../../classes/aluno.php';

        try {
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $id_aluno = $_POST['id'];

                if($id_aluno) {
                    $aluno = new Aluno();
                    $result = $aluno->buscarPorId($id_aluno);
                    echo json_encode(["success" => true, "result" => $result]);
                } else {
                    echo json_encode(["sucess" => false, "error" => "id não fornecido"]);
                }
            }
        } catch (Exception $e) {
            echo json_encode(["success" => false, "error" => "Erro no servidor ". $e->getMessage()]);
        }
?>