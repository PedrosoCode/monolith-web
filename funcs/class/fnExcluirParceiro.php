<?php
require_once("../../config/Database.php");
require_once("../class/clsParceiroNegocio.php");

if (isset($_GET['codigo']) && isset($_GET['codigo_empresa'])) {
    $codigo = $_GET['codigo'];
    $codigo_empresa = $_GET['codigo_empresa'];

    // Conexão com o banco
    $db = new Database();
    $conn = $db->getConnection();

    // Instanciando a classe de parceiro
    $parceiroClass = new clsParceiroNegocio($conn);

    // Chamando o método de exclusão
    $excluido = $parceiroClass->excluirParceiro($codigo, $codigo_empresa);

    if ($excluido) {
        header("Location: /monolithweb/pages/listaParceiroNegocio.php"); // Redireciona de volta para a lista
        exit();
    } else {
        echo "Erro ao excluir o parceiro.";
    }
} else {
    echo "Parâmetros não recebidos corretamente.";
}
?>
