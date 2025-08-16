<!-- Usasdo para cadastro de aluno -->

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include_once __DIR__ . './scripts/php/includes/head.php' ?>
    <title>Document</title>
</head>

<body class="has-background-dark has-text-white" style="min-height: 100vh; display: flex; flex-direction: column;">
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
</body>

</html>