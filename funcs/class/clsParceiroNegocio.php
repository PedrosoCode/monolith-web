<?php
require_once __DIR__ . '/../../config/Database.php';

class clsParceiroNegocio {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getParceiros() {
        try {
            $sql = "CALL sp_select_parceiro_negocio()";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar empresas: " . $e->getMessage();
            return [];
        }
    }
    public function excluirParceiro($codigo, $codigo_empresa) {
        try {
            $sql = "CALL sp_delete_parceiro_negocio(:codigo, :codigo_empresa)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
            $stmt->bindParam(':codigo_empresa', $codigo_empresa, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erro ao excluir parceiro: " . $e->getMessage();
            return false;
        }
    }
    public function inserirParceiroNegocio($iCodigo_empresa, $sNome_fantasia, $sRazao_social) {
        try {
            $sql = "CALL sp_insert_parceiro_negocio(:codigo_empresa, :nome_fantasia, :razao_social)";
            $sQuery = $this->conn->prepare($sql);
            $sQuery->bindParam(':codigo_empresa'    , $iCodigo_empresa  ,  PDO::PARAM_INT);
            $sQuery->bindParam(':nome_fantasia'     , $sNome_fantasia   ,  PDO::PARAM_STR);
            $sQuery->bindParam(':razao_social'      , $sRazao_social    ,  PDO::PARAM_STR);
            $sQuery->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erro ao inserir parceiro: " . $e->getMessage();
            return false;
        }
    }
    public function atualizarParceiroNegocio($iCodigo, $iCodigo_empresa, $sNome_fantasia, $sRazao_social) {
        try {
            $sql = "CALL sp_update_parceiro_negocio(:codigo, :codigo_empresa, :nome_fantasia, :razao_social)";
            $sQuery = $this->conn->prepare($sql);
            $sQuery->bindParam(':codigo'            , $iCodigo          ,  PDO::PARAM_INT);
            $sQuery->bindParam(':codigo_empresa'    , $iCodigo_empresa  ,  PDO::PARAM_INT);
            $sQuery->bindParam(':nome_fantasia'     , $sNome_fantasia   ,  PDO::PARAM_STR);
            $sQuery->bindParam(':razao_social'      , $sRazao_social    ,  PDO::PARAM_STR);
            $sQuery->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erro ao atualizar parceiro: " . $e->getMessage();
            return false;
        }
    }

    public function carregaDadosParceiroPorID($iCodigo, $iCodigo_empresa) {
        try {
            $sql = "CALL sp_select_dados_parceiro_negocio(:codigo_parceiro, :codigo_empresa)";
            $sQuery = $this->conn->prepare($sql);
            $sQuery->bindParam(':codigo_parceiro', $iCodigo, PDO::PARAM_INT);
            $sQuery->bindParam(':codigo_empresa', $iCodigo_empresa, PDO::PARAM_INT);
            $sQuery->execute();
    
            $result = $sQuery->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                return $result; 
            } else {
                return [];
            }
        } catch (PDOException $e) {
            echo "Erro ao carregar dados do parceiro de negócio: " . $e->getMessage();
            return false; 
        }
    }
    

}
?>
