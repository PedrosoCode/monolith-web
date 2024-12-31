<?php
session_start(); // Inicia a sessão

require_once __DIR__ . '/config/Database.php';
require_once './funcs/Empresas.php';
require_once './LoginHandler.php'; // Inclui o arquivo de manipulação do login

// Cria a instância da classe Database e obtém a conexão
$db = new Database();
$conn = $db->getConnection();

// Cria a instância da classe Empresas e obtém as empresas
$empresasClass = new Empresas($conn);
$empresas = $empresasClass->getEmpresas();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Chama a função handleLogin para processar o login
    $response = handleLogin($conn);

    // Verifica o status da resposta e executa o redirecionamento ou exibe mensagem de erro
    if ($response['status'] === 'success') {
        // Define as variáveis de sessão
        $_SESSION['usuario'] = $_POST['usuario'];  // Salva o nome de usuário
        $_SESSION['empresa'] = $_POST['empresa'];  // Salva o código da empresa
        $_SESSION['nome_usuario'] = $response['nome_usuario'];  // Salva o nome do usuário

        // Redireciona para a página inicial ou dashboard
        header('Location: home.php');
        exit();
    } else {
        $errorMessage = $response['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Adicionando o link para o Bootstrap -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card p-4" style="width: 400px;">
            <h1 class="text-center mb-4">Sistema de Login</h1>

            <?php if (!empty($errorMessage)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label for="empresa" class="form-label">Escolha uma empresa:</label>
                    <select name="empresa" id="empresa" class="form-select" required>
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
                </div>

                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuário:</label>
                    <input type="text" id="usuario" name="usuario" class="form-control" required placeholder="Digite seu usuário">
                </div>

                <div class="mb-3">
                    <label for="senha" class="form-label">Senha:</label>
                    <input type="password" id="senha" name="senha" class="form-control" required placeholder="Digite sua senha">
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>

    <!-- Adicionando o script do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
