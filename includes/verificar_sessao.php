<?php
// verificar_sessao.php
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
