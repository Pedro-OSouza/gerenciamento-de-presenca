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

            <table class="table is-striped is-hoverable is-fullwidth">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Turma</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td><?= htmlspecialchars($aluno['aluno_id']) ?></td>
                            <td><?= htmlspecialchars($aluno['aluno_nome']) ?></td>
                            <td><?= htmlspecialchars($aluno['turma_nome']) ?></td>
                            <td class="has-text-centered" style="white-space: nowrap; width: 1%;">
                                <a class="button is-small is-info is-light" href="./aluno_detalhes.php?id=<?= $aluno['aluno_id'] ?>">Editar</a>
                                <a class="button is-small is-danger is-light" href="#">Remover</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>