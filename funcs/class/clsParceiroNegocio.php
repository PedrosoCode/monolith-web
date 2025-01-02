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
}
?>
