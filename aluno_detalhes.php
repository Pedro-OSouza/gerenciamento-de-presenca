<?php
    include_once __DIR__.'./scripts/php/classes/aluno.php';
    include_once __DIR__.'./scripts/php/classes/turma.php';

    $id_aluno = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    $aluno = new Aluno();
    $dados_aluno = $aluno->buscarPorId($id_aluno) ?? [];
    $faltas_aluno = $aluno->buscarFaltasAcumuladas($id_aluno) ?? ['reposicoes_devidas' => 0, 'reposicoes_feitas' => 0]; 
    $presencas_aluno = $aluno->buscarHistoricoPresencas($id_aluno) ?? [];

    /* calcula as presenças e faltas */
    /* Esse passo é importante pois as presenças e faltas são um array contendo valores binarios de 1 e 0, 
    portanto devem ser contados. */
    $total_presencas = count(array_filter($presencas_aluno, fn($p) => $p['presenca'] == 1 ));
    $total_faltas = count(array_filter($presencas_aluno, fn($p) => $p['presenca'] == 0));

    $turmas = new Turma();
    $listaTurmas = $turmas->listarTurmas();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <?php include __DIR__ . './scripts/php/includes/head.php' ?>
    <title>Aluno: <?= htmlspecialchars($dados_aluno['nome']) ?> </title>
</head>

<body class="has-background-dark has-text-light">
    <?php include __DIR__ . './scripts/php/includes/navbar.php' ?>

    <main class="section mt-5">
        <div class="container">
            <h2 class="title is-4 has-text-centered">Informações do Aluno</h2>

            <div class="is-centered mt-5 pt-5">
                <div class="field is-flex is-align-items-center">
                    <label for="nome-aluno" class="mr-3">Nome:</label>
                    <input type="text" name="nome" id="nome-aluno" placeholder="Nome do Aluno" class="input inpt mr-3">
                    <span class="icon is-small mr-6">
                        <i class="fas fa-pen"></i>
                    </span>

                    <label for="email" class="mr-3">Email:</label>
                    <input type="email" name="email" id="email-aluno" placeholder="Email" class="input inpt mr-3">
                    <span class="icon is-small mr-6">
                        <i class="fas fa-pen"></i>
                    </span>

                    <label for="turmas" class="mr-3">Turma:</label>
                    <select name="turma" id="turma-aluno" class="select input mr-4">
                        <option value="" disabled>Turma do aluno</option>
                        <?php 
                            foreach ($listaTurmas as $turma):
                        ?>
                            <option value="<?= htmlspecialchars($turma['id']) ?>"><?= htmlspecialchars($turma['nome']) ?></option>
                        <?php endforeach ?>
                    </select>
                    <span class="icon is-small mr-6">
                        <i class="fas fa-pen"></i>
                    </span>

                    <label for="status" class="mr-3">Status: </label>
                    <select name="status" id="status-aluno" class="select input mr-4">
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                        <option value="concluido">Concluiu</option>
                    </select>
                    <span class="icon is-small mr-6">
                        <i class="fas fa-pen"></i>
                    </span>

                </div>

                <div class="field is-flex is-flex-wrap-wrap is-align-items-center  mb-5 mt-4 pt-4">
                    <div class="mr-4">
                        <span class="has-text-grey-light has-text-weight-semibold">Presenças:</span>
                        <span class="has-text-white"><?= htmlspecialchars($total_presencas) ?></span>
                    </div>
                    <div class="mr-4">
                        <span class="has-text-grey-light has-text-weight-semibold">Faltas:</span>
                        <span class="has-text-white"><?= htmlspecialchars($total_faltas) ?></span>
                    </div>
                    <div class="mr-4">
                        <span class="has-text-grey-light has-text-weight-semibold">Reposições necessárias:</span>
                        <span class="has-text-white"><?= htmlspecialchars($faltas_aluno['reposicoes_devidas']) ?></span>
                    </div>
                    <div class="mr-4">
                        <span class="has-text-grey-light has-text-weight-semibold">Reposições feitas:</span>
                        <span class="has-text-white"><?= htmlspecialchars($faltas_aluno['reposicoes_feitas']) ?></span>
                    </div>
                </div>

                <div class="field is-grouped mt-6">
                    <p class="control">
                        <button class="button is-primary" id="salvar-mudancas-aluno" disabled="true">Salvar Mudanças</button>
                    </p>
                    <p class="control">
                        <button class="button is-light" id="descartar-mudancas-aluno" disabled="true">Descartar Mudanças</button>
                    </p>
                </div>

            </div>
            
            <!-- Tabela de histórico -->
            <div class="mt-6">
                <h3 class="title is-5 has-text-centered">Histórico de Presenças</h3>
                <table class="table is-fullwidth is-striped">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Turma</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($presencas_aluno as $registro): ?>
                            <tr>
                                <td>
                                    <?= date('d/m/Y', strtotime($registro['data_aula'])) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($registro['turma_nome']) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($registro['status']) ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>

                </table>

            </div>
        </div>
    </main>

    <?php include __DIR__ . './scripts/php/includes/footer.php' ?>
    <script type="module" src="./scripts/javascript/app.js"></script>
</body>

</html>