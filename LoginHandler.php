<?php
require_once './funcs/Login.php'; // Inclua a classe Login

function handleLogin($conn) {
    // Pega os valores enviados pelo POST
    $codigoEmpresa = isset($_POST['empresa']) ? intval($_POST['empresa']) : null;
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;
    $senha = isset($_POST['senha']) ? $_POST['senha'] : null;

    // Verifica se todos os campos foram preenchidos
    if ($codigoEmpresa && $usuario && $senha) {
        $loginClass = new Login($conn);

        // Valida o login
        $response = $loginClass->validateLogin($codigoEmpresa, $usuario, $senha);

        // Retorna a resposta
        return $response;
    } else {
        return [
            'status' => 'error',
            'message' => 'Por favor, preencha todos os campos.'
        ];
    }
}
?>
