<?php
require_once("./includes/verificar_sessao.php");
require_once("./includes/components/mainNavbar.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <!-- Adicionando o link para o Bootstrap -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card p-4" style="width: 600px;">
            <h1 class="text-center mb-4">Bem-vindo ao Sistema!</h1>

            <p class="lead text-center">
                Olá, <?= htmlspecialchars($nomeUsuario); ?>! Você está logado com a empresa de código: <?= htmlspecialchars($codigoEmpresa); ?>.
            </p>

            <div class="d-flex justify-content-center mt-4">
                <a href="logout.php" class="btn btn-danger">Sair</a>
            </div>
        </div>
    </div>

    <!-- Adicionando o script do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
