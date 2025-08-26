<!-- Usasdo para cadastro de aluno -->
<?php
session_start();
require_once __DIR__ . './scripts/php/classes/aluno.php';
require_once __DIR__ . './scripts/php/classes/turma.php';

$turma = new Turma();

$message = null;
if (isset($_SESSION['flash_message'])) {
    $message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_aluno'])) {
    $aluno = new Aluno();

    //  validação / sanitização básica
    $nome = trim($_POST['nome'] ?? '');
    $email = trim(strtolower($_POST['email']) ?? '');
    $turma_id = (int) ($_POST['turma_id'] ?? 0);

    // Exemplo: validar campos mínimos
    if ($nome === '' || $turma_id <= 0) {
        $_SESSION['flash_message'] = "Erro: nome e turma são obrigatórios.";
        header("Location: cadastro_aluno.php");
        exit();
    }

    $aluno_id = $aluno->cadastrar($nome, $email, $turma_id);

    // Armazena a mensagem na sessão (flash) — vai sobreviver ao redirect.
    // Use htmlspecialchars quando for exibir para evitar XSS ao mostrar $nome.
    $_SESSION['flash_message'] = "Aluno " . htmlspecialchars($nome, ENT_QUOTES, 'UTF-8') . " cadastrado com ID: " . (int) $aluno_id;

    // Redireciona (PRG) — $_POST não estará mais presente após o redirect.
    header("Location: cadastro_aluno.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include_once __DIR__ . './scripts/php/includes/head.php' ?>
    <title>Cadastrar Aluno</title>
</head>

<body class="has-background-dark has-text-white" style="min-height: 100vh; display: flex; flex-direction: column;">
    <?php include_once __DIR__.'./scripts/php/includes/navbar.php' ?>
    <main class="section">
        <div class="container">

            <?php include_once __DIR__ . './scripts/php/includes/notify.php';
            notification($message);
            ?>

            <div class="box">
                <h2 class="title is-4 has-text-light">Cadastro de Aluno</h2>
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
            </div>
    </main>

    <script type="module" src="./scripts/javascript/app.js"></script>
</body>

</html>