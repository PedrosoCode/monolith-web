<?php
require_once("../../config/Database.php");
require_once("../class/clsParceiroNegocio.php");

$db = new Database();
$conn = $db->getConnection();
$parceiroClass = new clsParceiroNegocio($conn);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        $iCodigo = isset($input['iCodigo']) ? $input['iCodigo'] : 0;
        $iCodigoEmpresa = isset($input['iCodigoEmpresa']) ? $input['iCodigoEmpresa'] : 0;

        $dadosParceiro = $parceiroClass->carregaDadosParceiroPorID($iCodigo, $iCodigoEmpresa);

        if ($dadosParceiro && is_array($dadosParceiro)) {
            header('Content-Type: application/json');
            echo json_encode($dadosParceiro, JSON_UNESCAPED_UNICODE);
        } else {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['error' => 'Nenhum dado encontrado para o parceiro.']);
        }
        exit;
    } else {
        header('HTTP/1.1 405 Method Not Allowed');
        echo json_encode(['error' => 'Método não permitido.']);
    }
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
