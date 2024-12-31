<?php
session_start(); // Inicia a sessão

require_once __DIR__ . '/config/Database.php';
require_once './funcs/Empresas.php';

// Cria a instância da classe Database e obtém a conexão
$db = new Database();
$conn = $db->getConnection();

// Cria a instância da classe Empresas e obtém as empresas
$empresasClass = new Empresas($conn);
$empresas = $empresasClass->getEmpresas();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigoEmpresa = isset($_POST['empresa']) ? intval($_POST['empresa']) : null;
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;
    $senha = isset($_POST['senha']) ? $_POST['senha'] : null;

    if ($codigoEmpresa && $usuario && $senha) {
        require_once './funcs/Login.php';
        $loginClass = new Login($conn);

        $response = $loginClass->validateLogin($codigoEmpresa, $usuario, $senha);
        // var_dump($response);
        if ($response['status'] === 'success') {
            // Define as variáveis de sessão
            $_SESSION['usuario'] = $usuario;  // Salva o nome de usuário
            $_SESSION['empresa'] = $codigoEmpresa;  // Salva o código da empresa
            $_SESSION['nome_usuario'] = $response['nome_usuario'];  // Salva o nome do usuário

            // Redireciona para a página inicial ou dashboard
            header('Location: home.php');
            exit();
        } else {
            $errorMessage = $response['message'];
        }
    } else {
        $errorMessage = 'Por favor, preencha todos os campos.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f9f9f9;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center;">Sistema de Login</h1>

    <?php if (!empty($errorMessage)) : ?>
        <p class="error"><?= htmlspecialchars($errorMessage); ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="empresa">Escolha uma empresa:</label>
        <select name="empresa" id="empresa" required>
            <?php
            if (!empty($empresas)) {
                foreach ($empresas as $empresa) {
                    echo '<option value="' . htmlspecialchars($empresa['codigo']) . '">' .
                        htmlspecialchars($empresa['nome_fantasia']) .
                        ' (' . htmlspecialchars($empresa['razao_social']) . ')</option>';
                }
            } else {
                echo '<option value="">Nenhuma empresa encontrada</option>';
            }
            ?>
        </select>

        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" required placeholder="Digite seu usuário">

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required placeholder="Digite sua senha">

        <input type="submit" value="Login">
    </form>
</body>

</html>
