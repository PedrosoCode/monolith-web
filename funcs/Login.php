<?php
require_once __DIR__ . '/../config/Database.php';

class Login {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function validateLogin($codigoEmpresa, $usuario, $senha) {
        try {
            $sql = "CALL sp_valida_login(:codigo_empresa, :usuario)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':codigo_empresa', $codigoEmpresa, PDO::PARAM_INT);
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && password_verify($senha, $result['senha'])) {
                return ['status' => 'success', 'message' => 'Login realizado com sucesso!'];
            } else {
                return ['status' => 'error', 'message' => 'Credenciais inválidas.'];
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Erro ao validar login: ' . $e->getMessage()];
        }
    }
}
?>
