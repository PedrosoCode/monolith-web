<?php
require_once("../../config/Database.php");
require_once("../class/clsStaticCombos.php");

$db = new Database();
$conn = $db->getConnection();

$clsStaticCombos = new stcCombos($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $comboEstados = $clsStaticCombos->carregaComboEstado();

    if (is_array($comboEstados)) {
        header('Content-Type: application/json');
        echo json_encode($comboEstados, JSON_UNESCAPED_UNICODE);
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Erro ao carregar cidades.']);
    }
    exit;
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['error' => 'Método não permitido.']);
}
