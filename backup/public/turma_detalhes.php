<?php
require_once __DIR__ . '/scripts/php/services/aluno_services.php';
require_once __DIR__ . '/scripts/php/services/turma_services.php';
require_once __DIR__ . '/scripts/php/services/aula_services.php';
require_once __DIR__ . '/scripts/php/helpers/getIdInput.php';

$turma_id = getIdInput_helper();
if (!$turma_id) {
    header("Location: turmas.php");
    exit;
}

$turma = new Turma_services();
$aluno = new Aluno_services();
$alunos = $aluno->buscarAlunosPorTurma($turma_id);
$todos_alunos = $aluno->listarTodos();
$dados_turma = $turma->buscarPorId($turma_id);
$aulaObj = new Aula_services();
$aula_atual = $aulaObj->buscarAulaDoDia($turma_id); // Aula de hoje;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include __DIR__ . './scripts/php/includes/head.php' ?>
    <title><?= htmlspecialchars($dados_turma['nome']) ?></title>
</head>

<body class="has-background-dark has-text-white" style="min-height: 100vh; display: flex; flex-direction: column;">

    <!-- Essa nvabar pode passar por mudanças -->
    <nav class="navbar is-dark is-fixed-top">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item has-text-weight-bold" href="#">Sistema de Chamada Online</a>
            </div>

            <div class="navbar-menu">
                <div class="navbar-end">
                    <a href="./turmas.php" class="navbar-item">
                        Turmas
                    </a>
                    <a href="./lista_alunos.php" class="navbar-item">
                        Alunos
                    </a>
                    <a href="#" class="navbar-item">
                        Sair
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ==========================================MODAL======================================================== -->
    <div class="modal" id="alunoModal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Marcar Presença Avulsa</p>
                <button class="delete" aria-label="close" id="closeModal"></button>
            </header>
            <section class="modal-card-body">
                <form id="alunoForm">
                    <!-- Campo Nome do Aluno -->
                    <div class="field">
                        <label class="label">Nome do Aluno</label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select name="aluno" id="alunoAvulso" required>
                                    <option value="">Selecione um aluno</option>
                                    <?php foreach ($todos_alunos as $aluno): ?>
                                        <option value="<?= htmlspecialchars($aluno["aluno_id"]) ?>">
                                            <?= htmlspecialchars($aluno['aluno_nome']) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Campo Turma do Aluno -->
                    <div class="field">
                        <label class="label">Turma do Aluno</label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select name="turma" id="turmaAluno" required>
                                    <option value="">Selecione a turma</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- Campo Tipo -->
                    <div class="field">
                        <label class="label">Tipo</label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select name="tipo" id="tipoAvulso" required>
                                    <option value="">Selecione o tipo</option>
                                    <option value="normal">Normal</option>
                                    <option value="reposicao">Reposição</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
            <footer class="modal-card-foot is-flex-direction-column">
                <button class="button is-success is-fullwidth mb-2" id="enviarAvulsa">Enviar</button>
                <button class="button is-fullwidth" id="cancelModal">Cancelar</button>
            </footer>
        </div>
    </div>
    <!-- ========================================================FIM MODAL========================================================================= -->


    <main class="section" style="padding-top: 6rem;">
        <div class="container">
            <div id="turma-info" class="is-flex is-justify-content-space-between is-align-items-center mb-4">
                <div>
                    <h2 class="title has-text-white is-4">Turma: <?= ucfirst(htmlspecialchars($dados_turma['nome'])) ?>
                    </h2>
                    <span class="subtitle has-text-grey-light">
                        <?= htmlspecialchars($dados_turma['hora_formatada']) ?>
                    </span>
                    <span class="subtitle has-text-grey-light">
                        | <?= htmlspecialchars($dados_turma['dia_semana']); ?>
                    </span>
                </div>

                <button class="button is-link is-light is-small button-criar-aula">Crair aula para hoje</button>
                <span id="data-aula-atual" style="display: none"></span>
            </div>

            <div class="box has-background-dark has-text-white">

                <h4 class="title is-5 has-text-centered has-text-white">Alunos Matriculados</h4>

                <button class="button is-link is-light is-small is-right modal-open" id="openModal">Lançar Presença
                    Avulsa</button>

                <div class="box is-shadowless has-background-dark">
                    <!-- armazena o dado de id da aula -->
                    <input type="hidden" id="aula-id" value="<?= htmlspecialchars($aula_atual['id'] ?? '') ?>">
                    <input type="hidden" id="turma-id" value="<?= $turma_id ?>">
                    <input type="hidden" id="turma-hora-inicio" value="<?= $dados_turma['hora_inicio'] ?>">
                    <input type="hidden" id="turma-hora-fim" value="<?= $dados_turma['hora_fim'] ?>">

                    <?php foreach ($alunos as $aluno): ?>
                        <div class="columns is-vcentered is-mobile"
                            style="border-bottom: 1px solid rgba(255,255,255,0.1); border-radius: 0;">
                            <div class="column is-6">
                                <a href="aluno_detalhes.php?id=<?= htmlspecialchars($aluno['aluno_id']) ?>">
                                    <p class="has-text-weight-semibold has-text-white">
                                        <?= htmlspecialchars($aluno['aluno_nome']) ?>
                                    </p>
                                </a>
                                <p class="is-size-7 has-text-grey-light presencas-total">Presenças:
                                    <?= htmlspecialchars($aluno['total_presencas']) ?>
                                </p>
                                <p class="is-size-7 has-text-grey-light faltas-total">Faltas:
                                    <?= htmlspecialchars($aluno['total_faltas']) ?>
                                </p>
                            </div>

                            <div class="column is-6 has-text-right btns-column">
                                <!-- adicionar interatividade javascript para marcar presença ou ausencia com AJAX -->
                                <div class="buttons are-small is-right presenca-actions">
                                    <div class="btn-presenca button is-light" data-aluno-id="<?= $aluno['aluno_id'] ?>"
                                        data-presente="1">
                                        ✅Presente
                                    </div>
                                    <div class="btn-presenca button is-light" data-aluno-id="<?= $aluno['aluno_id'] ?>"
                                        data-presente="0">
                                        ❌Ausente
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . './scripts/php/includes/footer.php' ?>
    <script type="module" src="./scripts/javascript/app.js"></script>
</body>

</html>