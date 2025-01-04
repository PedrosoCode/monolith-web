<?php
require_once(__DIR__ . "/../../config/Database.php");


class stcCombos
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function carregaComboPais()
    {
        try {
            $sql = "CALL sp_stc_combo_pais();";
            $sQuery = $this->conn->query($sql);
            return $sQuery->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar países: " . $e->getMessage();
            return [];
        }
    }

    public function carregaComboEstado()
    {
        try {
            $sql = "CALL sp_stc_combo_estado();";
            $sQuery = $this->conn->query($sql);
            return $sQuery->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar Estados: " . $e->getMessage();
            return [];
        }
    }

    public function carregaComboCidade($iCodigoEstado)
    {
        try {

            if ($iCodigoEstado == -1) {
                $sql = "CALL sp_stc_combo_cidade(-1);";
            } else {
                $sql = "CALL sp_stc_combo_cidade(:codigo_estado);";
            }

            $sQuery = $this->conn->prepare($sql);

            if ($iCodigoEstado != -1) {
                $sQuery->bindParam(':codigo_estado', $iCodigoEstado, PDO::PARAM_INT);
            }

            // Executa a consulta
            $sQuery->execute();

            $resultados = $sQuery->fetchAll(PDO::FETCH_ASSOC);

            return $resultados;
        } catch (PDOException $e) {
            echo "Erro ao buscar Cidades: " . $e->getMessage();
            return [];
        }
    }

    public function carregaComboTipoParceiroNegocio()
    {
        try {
            $sql = "CALL sp_stc_combo_tipo_parceiro();";
            $sQuery = $this->conn->query($sql);
            return $sQuery->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao prencher combo tipo parceiro: " . $e->getMessage();
            return [];
        }
    }
}
