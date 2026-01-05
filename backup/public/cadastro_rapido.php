<!-- ! Totalmente temporário -->
<!-- Esse Script deve ser apagado posteiormente -->
<!-- quando o cadastro de todos os alunos e aulas forem realizado eles  -->
<?php
require_once __DIR__ . '/scripts/php/classes/aluno.php';
require_once __DIR__ . '/scripts/php/classes/turma.php';
require_once __DIR__ . '/scripts/php/classes/aula.php';
require_once __DIR__ . '/scripts/php/classes/presenca.php';

// Processamento do Formulário de Aulas
if (isset($_POST['cadastrar_aulas'])) {
    $turmaId = $_POST['turma_id'];
    $datasAulas = explode("\n", $_POST['datas_aulas']);
    $aula = new Aula();

    foreach ($datasAulas as $dataAula) {
        $dataAula = trim($dataAula);
        if (!empty($dataAula)) {
            $aula->cadastrar($turmaId, $dataAula, '14:00:00', '16:00:00'); // Horários padrão
        }
    }
    $mensagem = "Aulas cadastradas com sucesso!";
}

// Processamento do Formulário de Alunos
if (isset($_POST['cadastrar_aluno'])) {
    $aluno = new Aluno();
    $presenca = new Presenca();

    $alunoId = $aluno->cadastrar($_POST['nome'], $_POST['email'], $_POST['turma_id']);

    if ($alunoId && isset($_POST['presencas'])) {
        foreach ($_POST['presencas'] as $aulaId => $status) {
            if ($status !== '') {
                $presenca->marcar($alunoId, $aulaId, $turmaId, $status);
            }
        }
    }
    $mensagem = "Aluno cadastrado com ID: $alunoId";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php include __DIR__ . '/scripts/php/includes/head.php' ?>
    <title>Cadastro Rápido</title>
    <style>
        .box {
            background: var(--bulma-scheme-main-bis);
        }

        textarea {
            min-height: 150px;
        }

        .presenca-item {
            margin-bottom: 1rem;
        }
    </style>
</head>

<body class="has-background-dark has-text-light">
    <?php include __DIR__ . '/scripts/php/includes/navbar.php' ?>

    <main class="section">
        <div class="container">
            <?php if (!empty($mensagem)): ?>
                <div class="notification is-success">
                    <button class="delete"></button>
                    <?= $mensagem ?>
                </div>
            <?php endif; ?>

            <!-- Seção de Cadastro de Aulas -->
            <div class="box mb-6">
                <h2 class="title is-4 has-text-light">Cadastro Rápido de Aulas</h2>
                <form method="POST">
                    <div class="field">
                        <label class="label has-text-light">Turma</label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select name="turma_id" class="is-fullwidth" required>
                                    <option value="">Selecione a turma</option>
                                    <?php
                                    $turma = new Turma();
                                    foreach ($turma->listarTurmas() as $t) {
                                        echo "<option value='{$t['id']}'>{$t['nome']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label has-text-light">Datas das Aulas (uma por linha)</label>
                        <div class="control">
                            <textarea name="datas_aulas" class="textarea" placeholder="Ex:
2023-08-01
2023-08-08
2023-08-15" required></textarea>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <button type="submit" name="cadastrar_aulas" class="button is-primary">
                                Cadastrar Aulas
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Seção de Cadastro de Alunos -->
            <div class="box">
                <h2 class="title is-4 has-text-light">Cadastro Rápido de Aluno</h2>
                <form method="POST">
                    <div class="field">
                        <label class="label has-text-light">Nome</label>
                        <div class="control">
                            <input type="text" name="nome" class="input" required>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label has-text-light">Email</label>
                        <div class="control">
                            <input type="email" name="email" class="input">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label has-text-light">Turma</label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select name="turma_id" required>
                                    <option value="">Selecione a turma</option>
                                    <?php
                                    foreach ($turma->listarTurmas() as $t) {
                                        echo "<option value='{$t['id']}'>{$t['nome']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label has-text-light">Presenças</label>
                        <?php
                        if (isset($_GET['turma_id'])) {
                            $aula = new Aula();
                            $aulas = $aula->buscarPorTurma($_GET['turma_id']);

                            foreach ($aulas as $aula) {
                                echo '
                                <div class="presenca-item">
                                    <p><strong>' . date('d/m/Y', strtotime($aula['data'])) . '</strong></p>
                                    <div class="select">
                                        <select name="presencas[' . $aula['id'] . ']">
                                            <option value="" selected>Não registrar</option>
                                            <option value="1">✅ Presente</option>
                                            <option value="0">❌ Falta</option>
                                        </select>
                                    </div>
                                </div>';
                            }
                        }
                        ?>
                    </div>

                    <div class="field is-grouped">
                        <div class="control">
                            <button type="submit" name="cadastrar_aluno" class="button is-primary">
                                Cadastrar Aluno
                            </button>
                        </div>
                        <div class="control">
                            <a href="?" class="button is-light">Limpar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/scripts/php/includes/footer.php' ?>
</body>

</html>