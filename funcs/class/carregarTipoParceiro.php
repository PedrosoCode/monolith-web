<?php
require_once("../../config/Database.php");
require_once("../class/clsStaticCombos.php");

$db = new Database();
$conn = $db->getConnection();

$clsStaticCombos = new stcCombos($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $comboParceiros = $clsStaticCombos->carregaComboTipoParceiroNegocio();

    if (is_array($comboParceiros)) {
        header('Content-Type: application/json');
        echo json_encode($comboParceiros, JSON_UNESCAPED_UNICODE);
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Erro ao preenhcer combo tipo parceiro.']);
    }
    exit;
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['error' => 'Método não permitido.']);
}
