<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once __DIR__ . '/../includes/head.php' ?>
    <title>Aluno Cadastrado!</title>
</head>
<body>
    <h1>Aluno cadastrado com id <?= $id ?></h1>

    <script>
        setTimeout(()=>{
            window.location = "http://localhost/projetos/chamada_digital/public/cadastro/aluno"
        }, 1000)
    </script>
</body>
</html>