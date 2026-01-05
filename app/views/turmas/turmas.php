<?php
    // $data['turmas'] vem do controller
    $turmas = $data['turmas'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include __DIR__.'/../includes/head.php' ?> 
    <title>Chamada Digital | Turmas</title>
</head>

<body class="has-background-dark has-text-light" style="min-height: 100vh; display: flex; flex-direction: column;">

    <?php include __DIR__.'/../includes/navbar.php' ?>


    <main class="section" style="padding-top: 5rem;">
        <div class="container">
            <div class="box has-background-dark has-text-centered">
                <h2 class="title is-4" style="margin-bottom: 1rem;">Bem-Vindo, Professor Pedro!</h2>
                <p class="subtitle is-6">Hoje é: <span id="data-hoje"></span> <br />
                    <span id="dia-semana"></span> | <span class="hora-atual" id="hora-atual"></span>
                </p>
            </div>
    
            <div id="turmas-div" class="columns is-multiline is-variable is-4">
                <?php foreach ($turmas as $turma): ?>
                    <div class="column is-one-third">
                        <a href="./turmas/<?= $turma['id'] ?>" class="box has-background-dark is-primary " style="text-decoration: none;">
                            <div class="turma-card">
                                <h3 class="title is-5 "><?= ucfirst(htmlspecialchars($turma['nome'])) ?></h3>
                                <p class="hora-dia-turma"><?= htmlspecialchars($turma['dia_semana']) ?></p>
                                <p class="hora-dia-turma"><?= htmlspecialchars($turma['hora_formatada']) ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>

    </main>

    <?php include __DIR__.'/../includes/footer.php' ?>
    <script type="module" src="./../app/src_js/app.js"></script>
</body>

</html>