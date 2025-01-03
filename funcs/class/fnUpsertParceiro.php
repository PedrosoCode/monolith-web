<?php
require_once("../../config/Database.php");
require_once("../class/clsParceiroNegocio.php");

$db = new Database();
$conn = $db->getConnection();

$iCodigo                    = isset($_GET['codigo'])                    ? $_GET['codigo']                       :  0;
$iCodigoEmpresa             = isset($_GET['codigo_empresa'])            ? $_GET['codigo_empresa']               :  0;
$sNome_fantasia             = isset($_GET['sNome_fantasia'])            ? $_GET['sNome_fantasia']               : '';
$sRazao_social              = isset($_GET['sRazao_social'])             ? $_GET['sRazao_social']                : '';
$sTipo_parceiro             = isset($_GET['sTipo_parceiro'])            ? $_GET['sTipo_parceiro']               : '';
$sDocumento                 = isset($_GET['sDocumento'])                ? $_GET['sDocumento']                   : '';
$sEmail                     = isset($_GET['sEmail'])                    ? $_GET['sEmail']                       : '';
$sTelefone                  = isset($_GET['sTelefone'])                 ? $_GET['sTelefone']                    : '';
$sBairro                    = isset($_GET['sBairro'])                   ? $_GET['sBairro']                      : '';
$sLogradouro                = isset($_GET['sLogradouro'])               ? $_GET['sLogradouro']                  : '';
$sNumero                    = isset($_GET['sNumero'])                   ? $_GET['sNumero']                      : '';
$sComplemento               = isset($_GET['sComplemento'])              ? $_GET['sComplemento']                 : '';
$iCodigo_cidade             = isset($_GET['iCodigo_cidade'])            ? $_GET['iCodigo_cidade']               :  0;
$iCodigoEstado              = isset($_GET['iCodigoEstado'])             ? $_GET['iCodigoEstado']                :  0;
$sCep                       = isset($_GET['sCep'])                      ? $_GET['sCep']                         : '';
$sFocal_point               = isset($_GET['sFocal_point'])              ? $_GET['sFocal_point']                 : '';
$dtpData_cadastro           = isset($_GET['dtpData_cadastro'])          ? $_GET['dtpData_cadastro']             : '';
$dtpData_ultima_alteracao   = isset($_GET['dtpData_ultima_alteracao'])  ? $_GET['dtpData_ultima_alteracao']     : '';

$parceiroClass = new clsParceiroNegocio($conn);

try {
    if ($iCodigo == 0) {

        $inserido = $parceiroClass->inserirParceiroNegocio($iCodigoEmpresa, $sNome_fantasia, $sRazao_social);

        if ($inserido) {
            // Gerar o script para mostrar o pop-up e redirecionar após
            echo "<script type='text/javascript'>
                    alert('Parceiro inserido com sucesso!');
                    window.location.href = '/monolithweb/pages/listaParceiroNegocio.php';
                  </script>";
            exit();  // Interrompe a execução para que o script JavaScript seja executado
        } else {
            echo "<script type='text/javascript'>
                    alert('Erro ao inserir Parceiro!');
                    window.location.href = '/monolithweb/pages/listaParceiroNegocio.php';
                  </script>";
            exit();
        }
    } else {

        $atualizado = $parceiroClass->atualizarParceiroNegocio($iCodigo, $iCodigoEmpresa, $sNome_fantasia, $sRazao_social);

        if ($atualizado) {
            // Gerar o script para mostrar o pop-up e redirecionar após
            echo "<script type='text/javascript'>
                    alert('Parceiro atualizado com sucesso!');
                    window.location.href = '/monolithweb/pages/listaParceiroNegocio.php';
                  </script>";
            exit();  // Interrompe a execução para que o script JavaScript seja executado
        } else {
            echo "<script type='text/javascript'>
                    alert('Erro ao atualizar Parceiro!');
                    window.location.href = '/monolithweb/pages/listaParceiroNegocio.php';
                  </script>";
            exit();
        }

    }
} catch (Exception $e) {
    echo "<script type='text/javascript'>
            alert('Ocorreu um erro: " . $e->getMessage() . "');
            window.location.href = '/monolithweb/pages/listaParceiroNegocio.php';
          </script>";
    exit();
}
?>





