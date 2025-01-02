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

}
?>
