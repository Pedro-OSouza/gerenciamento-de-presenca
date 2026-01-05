<?php
require_once './scripts/php/classes/aluno.php';

$aluno = new Aluno();
$alunos = $aluno->listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include __DIR__ . './scripts/php/includes/head.php' ?>
    <title>Lista de alunos</title>
</head>

<body class="has-background-dark has-text-white" style="min-height: 100vh; display: flex; flex-direction: column;">
    <?php include __DIR__ . './scripts/php/includes/navbar.php' ?>

    <main class="section" style="padding-top: 5rem">
        <div class="container">
            <h2 class="title has-text-white is-3">📚Lista de Alunos</h2>

            <!-- Filtragem -->
            <div class="field has-addons mb-5" style="max-width: 350px;">
                <div class="control is-expanded">
                    <div class="select is-fullwidth is-dark">
                        <select id="filtro-status">
                            <option value="todos">Todos os alunos</option>
                            <option value="ativo">Ativos</option>
                            <option value="inativo">Inativos</option>
                            <option value="concluido">Concluídos</option>
                        </select>
                    </div>
                </div>
                <div class="control">
                    <button id="btn-filtrar" class="button is-info">
                        <span class="icon"><i class="fas fa-filter"></i></span>
                        <span>Filtrar</span>
                    </button>
                </div>
            </div>



            <table class="table is-striped is-hoverable is-fullwidth">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Turma</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="tabela-lista-alunos">
                
                </tbody>
            </table>
        </div>
    </main>

    <script type="module" src="./scripts/javascript/app.js"></script>
</body>
</html>