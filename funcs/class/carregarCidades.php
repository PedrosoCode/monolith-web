<?php
require_once("../../config/Database.php");
require_once("../class/clsStaticCombos.php");

$db = new Database();
$conn = $db->getConnection();

$clsStaticCombos = new stcCombos($conn);

// Se for uma requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe o JSON enviado via fetch
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['codigoEstado'])) {
        $codigoEstado = $input['codigoEstado'];

        // Carrega as cidades do estado selecionado
        $comboCidades = $clsStaticCombos->carregaComboCidade($codigoEstado);

        // Verifica se a variável $comboCidades é um array válido
        if (is_array($comboCidades)) {
            // Retorna as cidades em JSON
            header('Content-Type: application/json');
            echo json_encode($comboCidades, JSON_UNESCAPED_UNICODE); // Usando JSON_UNESCAPED_UNICODE para garantir que caracteres especiais sejam corretamente exibidos
        } else {
            // Se não for um array válido, retorna erro
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Erro ao carregar cidades.']);
        }
        exit;
    } else {
        // Se o código do estado não for enviado
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['error' => 'Código do estado não fornecido.']);
    }
} else {
    // Retorna um erro caso a requisição não seja POST
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['error' => 'Método não permitido.']);
}
?>
