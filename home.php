<?php
session_start();

// Verifica se a sessão está iniciada e se as variáveis de sessão existem
if (!isset($_SESSION['usuario']) || !isset($_SESSION['empresa']) || !isset($_SESSION['nome_usuario'])) {
    // Se não estiver logado, redireciona para a página de login
    header('Location: index.php');
    exit();
}

// Pega o nome do usuário e o código da empresa da sessão
$nomeUsuario = $_SESSION['nome_usuario'];
$codigoEmpresa = $_SESSION['empresa'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        h1 {
            text-align: center;
        }

        .welcome-message {
            font-size: 18px;
            margin-top: 20px;
        }

        .logout-button {
            display: block;
            margin-top: 30px;
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .logout-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Bem-vindo ao Sistema!</h1>
        <p class="welcome-message">Olá, <?= htmlspecialchars($nomeUsuario); ?>! Você está logado com a empresa de código: <?= htmlspecialchars($codigoEmpresa); ?>.</p>

        <a href="logout.php" class="logout-button">Sair</a>
    </div>
</body>

</html>
