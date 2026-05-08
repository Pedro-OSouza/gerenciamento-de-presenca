<!DOCTYPE html>
<html lang="en">
<head>
    <?php include __DIR__ . '/../includes/head.php' ?>
    <title>Cadastro de Turmas</title>
</head>
<body>
<body class="has-background-dark has-text-white" style="min-height: 100vh; display: flex; flex-direction: column;">
    <?php include_once __DIR__.'/../includes/navbar.php' ?>
    <main class="section">
        <div class="container">

            <div class="box">
                <h2 class="title is-4 has-text-light">Cadastro de Turmas</h2>
                <form method="POST" action="<?= url('/cadastro/turma/post')?>">
                    <div class="field">
                        <label class="label has-text-light">Nome da Turma</label>
                        <div class="control">
                            <input type="text" name="nome" class="input" required>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label has-text-light">Horário de inicio</label>
                        <div class="control">
                            <input type="time" name="start" class="input" required>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label has-text-light">Horário do fim</label>
                        <div class="control">
                            <input type="time" name="end" class="input" required>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label has-text-light">Dia da Semana</label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select name="day">
                                    <option value="" disabled selected>Selecione o dia da semana</option>
                                    <option value="" disabled>Tenho que adicionar isso mais tarde ksks</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label has-text-light">Sala da turma</label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select name="room">
                                    <option value="" disabled selected>Selecione a sala</option>
                                    <option value="" disabled>Tenho que adicionar isso mais tarde ksks</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label has-text-light">Quantidade Máxima de Alunos</label>
                        <div class="control">
                            <input type="number" name="max-alunos" class="input" required pattern="[0-9]*" min="0" max="100">
                        </div>
                    </div>

                    <div class="field is-grouped">
                        <div class="control">
                            <button type="submit" name="register-turma" class="button is-primary">
                                Cadastrar Aluno
                            </button>
                        </div>
                        <div class="control">
                            <a href="?" class="button is-light">Limpar</a>
                        </div>
                    </div>
            </div>
    </main>

    <script type="module" src="./../../app/src_js/app.js"></script>
</body>
</html>